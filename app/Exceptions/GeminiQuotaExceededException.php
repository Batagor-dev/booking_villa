<?php

namespace App\Exceptions;

class GeminiQuotaExceededException extends GeminiTranslationException
{
    // Thrown on 429 Too Many Requests, Resource Exhausted, Token quota limits
}
