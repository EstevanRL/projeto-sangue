<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\JsonResponse;
use App\Core\Request;
use App\Core\SessionManager;
use App\Services\ConsultationService;
use InvalidArgumentException;
use Throwable;

final class ConsultationController
{
    public function __construct(private ConsultationService $service)
    {
    }

    public function compare(): void
    {
        $user = SessionManager::currentUser();
        if (!$user) {
            JsonResponse::error('Sua sessão terminou. Entre novamente para continuar.', 401);
        }

        try {
            $result = $this->service->compare($user, Request::json());
            JsonResponse::success(['result' => $result], 'Consulta realizada.');
        } catch (InvalidArgumentException $exception) {
            JsonResponse::error($exception->getMessage(), 422);
        } catch (Throwable $exception) {
            JsonResponse::error('Não foi possível realizar a consulta. Verifique a conexão e tente novamente.', 503);
        }
    }

    public function explore(): void
    {
        $user = SessionManager::currentUser();
        if (!$user) {
            JsonResponse::error('Sua sessão terminou. Entre novamente para continuar.', 401);
        }

        try {
            $result = $this->service->explore($user, Request::json());
            JsonResponse::success(['result' => $result], 'Combinação calculada.');
        } catch (InvalidArgumentException $exception) {
            JsonResponse::error($exception->getMessage(), 422);
        } catch (Throwable $exception) {
            JsonResponse::error('Não foi possível calcular essa combinação. Tente novamente.', 503);
        }
    }
}
