<?php

namespace App\Services;

class GoogleMapsService
{
    /**
     * Resolve any Google Maps URL (short, full, query, or iframe) into a structured embed package.
     *
     * @param string|null $url
     * @return array
     */
    public function resolve(?string $url): array
    {
        if (empty($url)) {
            return [
                'success' => false,
                'message' => 'URL Kosong',
            ];
        }

        $url = trim($url);

        // Input MUST contain an iframe HTML tag
        if (!str_contains($url, '<iframe')) {
            return [
                'success' => false,
                'message' => 'Format lokasi tidak valid. Input Google Maps wajib menggunakan kode Embed Tag <iframe>...</iframe>, link biasa tidak bisa digunakan.',
            ];
        }

        preg_match('/src=["\']([^"\']+)["\']/i', $url, $m);
        $embedUrl = $m[1] ?? '';

        $lat = null;
        $lng = null;
        $this->extractCoordinates($embedUrl ?: $url, $lat, $lng);

        return [
            'success' => true,
            'iframe' => $url,
            'embed_url' => $embedUrl,
            'direct_url' => $embedUrl,
            'place_name' => null,
            'lat' => $lat,
            'lng' => $lng,
        ];
    }

    /**
     * Helper to return iframe markup if valid iframe tag is provided.
     *
     * @param string|null $url
     * @return string|null
     */
    public function formatToIframe(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }
        $trimmed = trim($url);
        if (!str_contains($trimmed, '<iframe')) {
            return null;
        }
        
        // Ensure iframe takes 100% width and 100% height
        if (preg_match('/width=["\']\d+%?["\']/i', $trimmed)) {
            $trimmed = preg_replace('/width=["\']\d+%?["\']/i', 'width="100%"', $trimmed);
        }
        if (preg_match('/height=["\']\d+%?["\']/i', $trimmed)) {
            $trimmed = preg_replace('/height=["\']\d+%?["\']/i', 'height="100%"', $trimmed);
        }

        return $trimmed;
    }

    /**
     * Expand shortened Google Maps URLs using get_headers.
     */
    private function expandUrl(string $url): string
    {
        if (!str_contains($url, 'goo.gl') && !str_contains($url, 'maps.app.goo.gl')) {
            return $url;
        }

        try {
            $headers = @get_headers($url, 1);
            if (isset($headers['Location'])) {
                return is_array($headers['Location']) ? end($headers['Location']) : $headers['Location'];
            }
        } catch (\Exception $e) {
            // Fail silently
        }

        return $url;
    }

    /**
     * Extract coordinates from maps URL.
     */
    private function extractCoordinates(string $url, ?string &$lat, ?string &$lng): void
    {
        if (preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+)/', $url, $matches)) {
            $lat = $matches[1];
            $lng = $matches[2];
            return;
        }

        if (preg_match('/!3d(-?\d+\.\d+)!4d(-?\d+\.\d+)/', $url, $matches)) {
            $lat = $matches[1];
            $lng = $matches[2];
        }
    }

    /**
     * Extract place name from maps URL.
     */
    private function extractPlaceName(string $url): string
    {
        if (preg_match('/maps\/place\/([^\/@]+)/', $url, $matches)) {
            return urldecode(str_replace('+', ' ', $matches[1]));
        }
        return '';
    }
}
