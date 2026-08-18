<?php

namespace App\Models\Traits;

use App\Models\DestinationTranslation;
use App\Models\FacilityTranslation;
use App\Models\PropertyTranslation;
use App\Services\GeminiTranslationService;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

trait HasTranslations
{
    /**
     * Get the class name of the translation model.
     */
    public function getTranslationModelClass(): string
    {
        if (property_exists($this, 'translationModel') && !empty($this->translationModel)) {
            return $this->translationModel;
        }

        $class = class_basename($this);
        
        // Handle plural/singular naming convention
        if ($class === 'Properties') {
            return PropertyTranslation::class;
        }
        if ($class === 'Facilities') {
            return FacilityTranslation::class;
        }

        return 'App\\Models\\' . $class . 'Translation';
    }

    /**
     * Get the foreign key for the translation table.
     */
    public function getTranslationForeignKey(): string
    {
        if (property_exists($this, 'translationForeignKey') && !empty($this->translationForeignKey)) {
            return $this->translationForeignKey;
        }

        $class = class_basename($this);
        if ($class === 'Properties') {
            return 'property_id';
        }
        if ($class === 'Facilities') {
            return 'facility_id';
        }

        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $class)) . '_id';
    }

    /**
     * Relationship to all translations.
     */
    public function translations(): HasMany
    {
        return $this->hasMany($this->getTranslationModelClass(), $this->getTranslationForeignKey());
    }

    /**
     * Relationship to active locale translation.
     */
    public function translation(): HasOne
    {
        return $this->hasOne($this->getTranslationModelClass(), $this->getTranslationForeignKey())
            ->where('locale', app()->getLocale());
    }

    /**
     * Get translation for a specific locale (or active locale), with fallback.
     */
    public function getTranslation(?string $locale = null, bool $useFallback = true)
    {
        $locale = $locale ?: app()->getLocale();
        $fallbackLocale = config('localization.fallback_locale', 'id');

        // 1. If translations relation is eager loaded, find in collection to avoid N+1 queries
        if ($this->relationLoaded('translations')) {
            $trans = $this->translations->firstWhere('locale', $locale);
            if ($trans) {
                return $trans;
            }

            if ($useFallback && $locale !== $fallbackLocale) {
                return $this->translations->firstWhere('locale', $fallbackLocale);
            }

            return null;
        }

        // 2. If single translation relation is loaded and matches locale
        if ($this->relationLoaded('translation') && $this->translation && $this->translation->locale === $locale) {
            return $this->translation;
        }

        // 3. Fallback to direct relation query
        $trans = $this->translations()->where('locale', $locale)->first();
        if ($trans) {
            return $trans;
        }

        if ($useFallback && $locale !== $fallbackLocale) {
            return $this->translations()->where('locale', $fallbackLocale)->first();
        }

        return null;
    }

    /**
     * Get translated value of a specific attribute.
     */
    public function translate(string $attribute, ?string $locale = null, bool $useFallback = true): mixed
    {
        $trans = $this->getTranslation($locale, $useFallback);

        if ($trans && !empty($trans->{$attribute})) {
            return $trans->{$attribute};
        }

        // Return direct attribute on the model as ultimate fallback if exists
        return $this->getAttributeFromArray($attribute) ?? null;
    }

    /**
     * Helper to set/update a translation for a given locale.
     */
    public function updateTranslation(string $locale, array $attributes): mixed
    {
        $foreignKey = $this->getTranslationForeignKey();
        $modelClass = $this->getTranslationModelClass();

        // If translation table supports slug and name is provided, auto generate slug
        if (isset($attributes['name']) && !isset($attributes['slug']) && in_array($modelClass, [PropertyTranslation::class, DestinationTranslation::class])) {
            $attributes['slug'] = Str::slug($attributes['name']);
        }

        return $modelClass::updateOrCreate(
            [
                $foreignKey => $this->getKey(),
                'locale'    => $locale,
            ],
            $attributes
        );
    }

    /**
     * Auto translate and save translations for all supported locales using Gemini AI.
     *
     * @param array<string, mixed> $sourceAttributes Key-value pairs in Indonesian/source locale
     * @param string $sourceLocale Default 'id'
     */
    public function autoTranslateAndSave(array $sourceAttributes, string $sourceLocale = 'id'): void
    {
        // 1. Save source locale translation first
        $this->updateTranslation($sourceLocale, $sourceAttributes);

        // 2. Get supported target locales (e.g., ['en'])
        $supportedLocales = config('localization.supported_locales', ['id', 'en']);
        $targetLocales = array_diff($supportedLocales, [$sourceLocale]);

        if (empty($targetLocales)) {
            return;
        }

        // Filter text-only fields that have content to translate
        $translatableFields = array_filter($sourceAttributes, function ($value) {
            return is_string($value) && trim($value) !== '';
        });

        if (empty($translatableFields)) {
            foreach ($targetLocales as $targetLocale) {
                $this->updateTranslation($targetLocale, $sourceAttributes);
            }
            return;
        }

        /** @var GeminiTranslationService $translator */
        $translator = app(GeminiTranslationService::class);

        foreach ($targetLocales as $targetLocale) {
            $targetAttributes = $sourceAttributes;

            if ($translator->isConfigured()) {
                try {
                    $result = $translator->translateBatch($translatableFields, $targetLocale, $sourceLocale);
                    if ($result['success'] && !empty($result['data'])) {
                        $targetAttributes = array_merge($sourceAttributes, $result['data']);
                    } else {
                        Log::warning("Gemini translation fallback for {$targetLocale}: " . ($result['error'] ?? 'Unknown error'));
                    }
                } catch (Throwable $e) {
                    Log::warning("Gemini translation exception for {$targetLocale}: " . $e->getMessage());
                }
            }

            // Save translation for target locale (translated or graceful fallback)
            $this->updateTranslation($targetLocale, $targetAttributes);
        }
    }
}
