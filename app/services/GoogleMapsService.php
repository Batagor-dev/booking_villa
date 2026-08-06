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

        // If it's already an iframe HTML tag
        if (str_contains($url, '<iframe')) {
            preg_match('/src=["\']([^"\']+)["\']/i', $url, $m);
            $embedUrl = $m[1] ?? '';
            return [
                'success' => true,
                'iframe' => $url,
                'embed_url' => $embedUrl,
                'direct_url' => $embedUrl,
                'place_name' => null,
                'lat' => null,
                'lng' => null,
            ];
        }

        $fullUrl = $this->expandUrl($url);
        $placeName = $this->extractPlaceName($fullUrl);
        
        $lat = null;
        $lng = null;
        $this->extractCoordinates($fullUrl, $lat, $lng);

        // Build query string for Google Maps embed with RED MARKER PIN using clean match expression
        $query = match (true) {
            (bool)($placeName && $lat && $lng) => urlencode($placeName) . "@{$lat},{$lng}",
            (bool)$placeName => urlencode($placeName),
            (bool)($lat && $lng) => "{$lat},{$lng}",
            default => urlencode($fullUrl),
        };

        $embedSrc = "https://maps.google.com/maps?q={$query}&t=&z=15&ie=UTF8&iwloc=&output=embed";
        $iframeHtml = '<iframe src="' . $embedSrc . '" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>';

        return [
            'success' => true,
            'iframe' => $iframeHtml,
            'embed_url' => $embedSrc,
            'direct_url' => $fullUrl,
            'place_name' => $placeName ?: null,
            'lat' => $lat,
            'lng' => $lng,
        ];
    }

    /**
     * Helper to directly convert a link to iframe markup.
     *
     * @param string|null $url
     * @return string|null
     */
    public function formatToIframe(?string $url): ?string
    {
        $resolved = $this->resolve($url);
        return $resolved['success'] ? $resolved['iframe'] : null;
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
