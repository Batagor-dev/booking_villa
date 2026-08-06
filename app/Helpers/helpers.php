<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('settings')) {
    function settings()
    {
        static $cachedSettings = null;

        if ($cachedSettings !== null) {
            return $cachedSettings;
        }

        $cachedSettings = Cache::remember('app_settings', 86400, function () {
            try {
                $all = Setting::all()->keyBy('key');

                $getValue = function (string $key, mixed $default = null) use ($all) {
                    $row = $all->get($key);
                    if (!$row) return $default;

                    return $row->serialize ? json_decode($row->value, true) : $row->value;
                };

                $keyword = $getValue('keyword');
                if (is_array($keyword)) {
                    $keyword = implode(',', $keyword);
                }

                return [
                    'title'       => $getValue('title'),
                    'keyword'     => $keyword,
                    'description' => $getValue('description'),
                    'author'      => $getValue('author'),
                    'favicon'     => $getValue('favicon'),
                ];
            } catch (\Throwable $e) {
                return [
                    'title'       => null,
                    'keyword'     => null,
                    'description' => null,
                    'author'      => null,
                    'favicon'     => null,
                ];
            }
        });

        return $cachedSettings;
    }
}

if (!function_exists('format_rupiah')) {
    function format_rupiah($value, $prefix = 'Rp ') {
        if (is_null($value) || $value === '') {
            return $prefix . '0';
        }
        $numericValue = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        if (!is_numeric($numericValue)) {
            return $prefix . '0';
        }
        return $prefix . number_format((float)$numericValue, 0, ',', '.');
    }
}

if (!function_exists('parse_rupiah')) {
    function parse_rupiah($value) {
        if (empty($value)) {
            return 0;
        }
        // Remove everything except numbers
        $clean = preg_replace('/[^\d]/', '', $value);
        return $clean !== '' ? (int)$clean : 0;
    }
}