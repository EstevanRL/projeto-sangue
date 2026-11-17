<?php
declare(strict_types=1);

namespace App\Core;

final class Request
{
    private static ?array $inputCache = null;
    public static function method(): string
    {
        return strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'));
    }

    public static function json(): array
    {
        if (self::$inputCache !== null) {
            return self::$inputCache;
        }
        $raw = file_get_contents('php://input');
        if (!is_string($raw) || trim($raw) === '') {
            self::$inputCache = $_POST;
            return self::$inputCache;
        }
        $decoded = json_decode($raw, true);
        self::$inputCache = is_array($decoded) ? $decoded : [];
        return self::$inputCache;
    }

    public static function csrfToken(): ?string
    {
        $headers = function_exists('getallheaders') ? getallheaders() : [];
        foreach ($headers as $name => $value) {
            if (strtolower((string) $name) === 'x-csrf-token') {
                return (string) $value;
            }
        }
        $serverToken = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
        if (is_string($serverToken)) {
            return $serverToken;
        }
        $input = self::json();
        return isset($input['_csrf']) ? (string) $input['_csrf'] : null;
    }
}
