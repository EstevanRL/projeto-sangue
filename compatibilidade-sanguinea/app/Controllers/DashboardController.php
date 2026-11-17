<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\JsonResponse;
use App\Core\SessionManager;
use App\Services\HistoryService;
use Throwable;

final class DashboardController
{
    public function __construct(private HistoryService $history)
    {
    }

    public function summary(): void
    {
        $user = SessionManager::currentUser();
        if (!$user) {
            JsonResponse::error('Sua sessão terminou. Entre novamente para continuar.', 401);
        }

        try {
            JsonResponse::success([
                'user' => $user,
                'history' => $this->history->list((int) $user['id'], 5),
            ]);
        } catch (Throwable $exception) {
            JsonResponse::error('Não foi possível carregar os dados iniciais.', 503);
        }
    }
}
