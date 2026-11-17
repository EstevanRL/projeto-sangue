<?php
declare(strict_types=1);

namespace App\Core;

use Throwable;

final class ApiKernel
{
    public static function post(callable $action): void
    {
        if (Request::method() !== 'POST') {
            header('Allow: POST');
            JsonResponse::error('Método não permitido.', 405);
        }

        if (!SessionManager::validateCsrf(Request::csrfToken())) {
            JsonResponse::error('A sessão do formulário expirou. Atualize a página e tente novamente.', 403);
        }

        try {
            $action();
        } catch (Throwable $exception) {
            JsonResponse::error('Ocorreu um erro inesperado. Tente novamente.', 500);
        }
    }

    public static function get(callable $action): void
    {
        if (Request::method() !== 'GET') {
            header('Allow: GET');
            JsonResponse::error('Método não permitido.', 405);
        }
        try {
            $action();
        } catch (Throwable $exception) {
            JsonResponse::error('Ocorreu um erro inesperado. Tente novamente.', 500);
        }
    }
}
