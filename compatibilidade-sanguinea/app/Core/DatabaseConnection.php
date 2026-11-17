<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use Throwable;

final class DatabaseConnection
{
    private static ?PDO $connection = null;
    private static bool $attempted = false;
    private static bool $fallback = false;

    public static function get(): ?PDO
    {
        if (self::$attempted) {
            return self::$connection;
        }

        self::$attempted = true;
        $host = getenv('DB_HOST') ?: '127.0.0.1';
        $database = getenv('DB_NAME') ?: 'administrador_compatibilidade_sanguinea';
        $username = getenv('DB_USER') ?: 'administrador_a5';
        $password = getenv('DB_PASS') ?: '}XX*Ns17t~pdh0P+';
        $dsn = "mysql:host={$host};dbname={$database};charset=utf8mb4";

        try {
            self::$connection = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (Throwable $exception) {
            self::$connection = null;
            self::$fallback = true;
        }

        return self::$connection;
    }

    public static function isFallback(): bool
    {
        self::get();
        return self::$fallback;
    }
}
