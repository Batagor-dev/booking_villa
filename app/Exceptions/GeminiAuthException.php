<?php

namespace App\Exceptions;

class GeminiAuthException extends GeminiTranslationException
{
    // Thrown when API key is missing, invalid, expired, or unauthorized (400/401/403)
}
