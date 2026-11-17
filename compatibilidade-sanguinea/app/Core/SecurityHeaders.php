<?php
declare(strict_types=1);

namespace App\Core;

final class SecurityHeaders
{
    private static string $nonce = '';

    public static function apply(): void
    {
        if (getenv('APP_ENV') === 'production') {
            ini_set('display_errors', '0');
            ini_set('display_startup_errors', '0');
            ini_set('log_errors', '1');
        }

        $https = !empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off';
        self::$nonce = base64_encode(random_bytes(18));

        if (function_exists('header_remove')) {
            header_remove('X-Powered-By');
        }

        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: DENY');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=(), usb=()');
        header('Cross-Origin-Opener-Policy: same-origin');
        header('Cross-Origin-Resource-Policy: same-origin');
        header('X-Permitted-Cross-Domain-Policies: none');
        header('Cache-Control: no-store, max-age=0');
        header('Pragma: no-cache');
        header("Content-Security-Policy: default-src 'self'; script-src 'self' 'nonce-" . self::$nonce . "'; style-src 'self'; img-src 'self' data:; font-src 'self'; connect-src 'self'; object-src 'none'; base-uri 'self'; form-action 'self'; frame-ancestors 'none'");

        if ($https) {
            header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
        }
    }

    public static function nonce(): string
    {
        return self::$nonce;
    }
}
