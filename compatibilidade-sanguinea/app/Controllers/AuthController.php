<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\JsonResponse;
use App\Core\Request;
use App\Core\SessionManager;
use App\Services\AuthService;

final class AuthController
{
    public function __construct(private AuthService $service)
    {
    }

    public function login(): void
    {
        $input = Request::json();
        $result = $this->service->login(
            (string) ($input['email'] ?? ''),
            (string) ($input['senha'] ?? ''),
            (string) ($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0')
        );

        if (!$result['success']) {
            JsonResponse::error($result['message'], (int) $result['status']);
        }
        JsonResponse::success(['redirect' => $result['redirect']], $result['message']);
    }

    public function register(): void
    {
        $result = $this->service->register(Request::json());
        if (!$result['success']) {
            JsonResponse::error($result['message'], (int) $result['status']);
        }
        JsonResponse::success(['redirect' => $result['redirect']], $result['message']);
    }

    public function logout(): void
    {
        SessionManager::logout();
        JsonResponse::success(['redirect' => '/compatibilidade-sanguinea/index.php'], 'Você saiu da sua conta.');
    }
}
