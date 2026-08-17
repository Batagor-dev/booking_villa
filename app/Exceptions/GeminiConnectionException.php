<?php

namespace App\Exceptions;

class GeminiConnectionException extends GeminiTranslationException
{
    // Thrown on network timeouts, DNS failure, host unreachable, SSL handshake failure
}
