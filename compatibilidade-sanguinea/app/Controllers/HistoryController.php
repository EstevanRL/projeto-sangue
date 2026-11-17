<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\JsonResponse;
use App\Core\SessionManager;
use App\Services\HistoryService;
use Throwable;

final class HistoryController
{
    public function __construct(private HistoryService $service)
    {
    }

    public function list(): void
    {
        $user = SessionManager::currentUser();
        if (!$user) {
            JsonResponse::error('Sua sessão terminou. Entre novamente para continuar.', 401);
        }

        try {
            JsonResponse::success(['items' => $this->service->list((int) $user['id'], 100)]);
        } catch (Throwable $exception) {
            JsonResponse::error('Não foi possível carregar o histórico.', 503);
        }
    }

    public function delete(): void
    {
        $user = SessionManager::currentUser();
        if (!$user) {
            JsonResponse::error('Sua sessão terminou. Entre novamente para continuar.', 401);
        }

        try {
            $deleted = $this->service->delete((int) $user['id']);
            JsonResponse::success(['deleted' => $deleted], $deleted > 0 ? 'Histórico apagado.' : 'Seu histórico já estava vazio.');
        } catch (Throwable $exception) {
            JsonResponse::error('Não foi possível apagar o histórico.', 503);
        }
    }
}
