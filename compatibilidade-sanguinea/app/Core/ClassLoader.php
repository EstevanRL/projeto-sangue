<?php
declare(strict_types=1);

namespace App\Core;

final class ClassLoader
{
    public static function register(): void
    {
        spl_autoload_register([self::class, 'load']);
    }

    public static function load(string $className): void
    {
        $prefix = 'App\\';
        if (strncmp($className, $prefix, strlen($prefix)) !== 0) {
            return;
        }

        $relativeName = substr($className, strlen($prefix));
        $file = __DIR__ . '/../' . str_replace('\\', '/', $relativeName) . '.php';
        if (is_file($file)) {
            require $file;
        }
    }
}
