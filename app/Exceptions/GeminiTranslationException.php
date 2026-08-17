<?php

namespace App\Exceptions;

use Exception;

class GeminiTranslationException extends Exception
{
    /**
     * Optional additional details from Gemini API response.
     */
    protected array $details = [];

    public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = null, array $details = [])
    {
        parent::__construct($message, $code, $previous);
        $this->details = $details;
    }

    public function getDetails(): array
    {
        return $this->details;
    }
}
