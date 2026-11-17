<?php
declare(strict_types=1);

namespace App\Core;

final class JsonResponse
{
    public static function success(array $data = [], string $message = 'Operação realizada.', int $status = 200): void
    {
        self::send(['success' => true, 'message' => $message, 'data' => $data], $status);
    }

    public static function error(string $message, int $status = 400, array $data = []): void
    {
        self::send(['success' => false, 'message' => $message, 'data' => $data], $status);
    }

    public static function send(array $payload, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE);
        exit;
    }
}
