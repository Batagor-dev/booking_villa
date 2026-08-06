<?php

namespace App\Services;

class GenerateCodeService
{
    /**
     * Generate initials code from name string.
     *
     * Aturan Pembuatan Kode:
     * 1. Jika >= 3 Kata : Ambil huruf ke-1 dari kata 1, kata 2, dan kata 3 ("Villa Azure Sanctuary" => "VAS")
     * 2. Jika == 2 Kata : Ambil huruf ke-1 kata ke-1 + 2 huruf pertama kata ke-2 ("Villa Seminyak" => "VSE")
     * 3. Jika == 1 Kata : Ambil 3 huruf pertama dari kata tersebut ("Seminyak" => "SEM")
     *
     * @param string|null $name
     * @return string
     */
    public function generate(?string $name): string
    {
        if (empty($name)) {
            return '';
        }

        $cleanText = preg_replace('/[^a-zA-Z0-9\s]/', '', $name);
        $words = array_values(array_filter(explode(' ', trim($cleanText))));
        $wordCount = count($words);

        $codeResult = match (true) {
            $wordCount >= 3 => substr($words[0], 0, 1) . substr($words[1], 0, 1) . substr($words[2], 0, 1),
            $wordCount === 2 => substr($words[0], 0, 1) . (strlen($words[1]) >= 2 ? substr($words[1], 0, 2) : $words[1]),
            $wordCount === 1 => substr($words[0], 0, 3),
            default => '',
        };

        return strtoupper($codeResult);
    }
}
