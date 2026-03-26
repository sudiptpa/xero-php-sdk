<?php

declare(strict_types=1);

namespace Sujip\Xero\Auth;

final class Pkce
{
    public static function verifier(int $length = 64): string
    {
        $length = max(43, min(128, $length));

        return rtrim(strtr(base64_encode(random_bytes($length)), '+/', '-_'), '=');
    }

    public static function challenge(string $verifier): string
    {
        return rtrim(strtr(base64_encode(hash('sha256', $verifier, true)), '+/', '-_'), '=');
    }
}
