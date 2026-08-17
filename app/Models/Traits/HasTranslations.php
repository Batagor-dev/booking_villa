<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
            return \App\Models\PropertyTranslation::class;
        }
        if ($class === 'Facilities') {
            return \App\Models\FacilityTranslation::class;
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

        return $modelClass::updateOrCreate(
            [
                $foreignKey => $this->getKey(),
                'locale'    => $locale,
            ],
            $attributes
        );
    }
}
