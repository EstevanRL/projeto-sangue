<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\DatabaseConnection;
use App\Repositories\HistoryRepository;

final class HistoryService
{
    public function list(int $userId, int $limit = 50): array
    {
        $pdo = DatabaseConnection::get();
        if (!$pdo) {
            return [];
        }
        return (new HistoryRepository($pdo))->listForUser($userId, $limit);
    }

    public function add(int $userId, string $type1, string $type2, string $pregnant, string $source): void
    {
        $pdo = DatabaseConnection::get();
        if (!$pdo) {
            return;
        }
        (new HistoryRepository($pdo))->add($userId, $type1, $type2, $pregnant, $source);
    }

    public function delete(int $userId): int
    {
        $pdo = DatabaseConnection::get();
        if (!$pdo) {
            return 0;
        }
        return (new HistoryRepository($pdo))->deleteForUser($userId);
    }
}
