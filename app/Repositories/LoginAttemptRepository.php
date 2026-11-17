<?php
declare(strict_types=1);

namespace App\Repositories;

use PDO;
use Throwable;

final class LoginAttemptRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function isBlocked(string $email, string $ip): bool
    {
        if (!$this->ensureTable()) {
            return false;
        }

        $this->pdo->exec("DELETE FROM tentativas_login WHERE atualizado_em < (NOW() - INTERVAL 1 HOUR)");
        $statement = $this->pdo->prepare('SELECT tentativas, atualizado_em FROM tentativas_login WHERE chave = ?');

        foreach ($this->keys($email, $ip) as $key) {
            $statement->execute([$key]);
            $row = $statement->fetch();
            if (!$row) {
                continue;
            }
            $updatedAt = strtotime((string) $row['atualizado_em']);
            if ($updatedAt !== false && (time() - $updatedAt) < 900 && (int) $row['tentativas'] >= 5) {
                return true;
            }
        }

        return false;
    }

    public function registerFailure(string $email, string $ip): void
    {
        if (!$this->ensureTable()) {
            return;
        }

        $select = $this->pdo->prepare('SELECT tentativas, primeira_tentativa, atualizado_em FROM tentativas_login WHERE chave = ?');
        $insert = $this->pdo->prepare('INSERT INTO tentativas_login (chave, tentativas, primeira_tentativa, atualizado_em) VALUES (?, 1, NOW(), NOW())');
        $update = $this->pdo->prepare('UPDATE tentativas_login SET tentativas = ?, primeira_tentativa = ?, atualizado_em = NOW() WHERE chave = ?');

        foreach ($this->keys($email, $ip) as $key) {
            $select->execute([$key]);
            $row = $select->fetch();
            if (!$row) {
                $insert->execute([$key]);
                continue;
            }

            $updatedAt = strtotime((string) $row['atualizado_em']);
            $firstAttempt = strtotime((string) $row['primeira_tentativa']);
            $now = time();

            if ($updatedAt === false || ($now - $updatedAt) >= 900) {
                $update->execute([1, date('Y-m-d H:i:s'), $key]);
                continue;
            }

            $firstAttemptValue = $firstAttempt !== false && ($now - $firstAttempt) < 900
                ? (string) $row['primeira_tentativa']
                : date('Y-m-d H:i:s');
            $update->execute([min(20, ((int) $row['tentativas']) + 1), $firstAttemptValue, $key]);
        }
    }

    public function clear(string $email, string $ip): void
    {
        if (!$this->ensureTable()) {
            return;
        }
        $keys = $this->keys($email, $ip);
        $statement = $this->pdo->prepare('DELETE FROM tentativas_login WHERE chave = ? OR chave = ?');
        $statement->execute($keys);
    }

    private function ensureTable(): bool
    {
        try {
            $this->pdo->exec(<<<SQL
                CREATE TABLE IF NOT EXISTS tentativas_login (
                    chave CHAR(64) NOT NULL,
                    tentativas INT UNSIGNED NOT NULL DEFAULT 0,
                    primeira_tentativa DATETIME NOT NULL,
                    atualizado_em DATETIME NOT NULL,
                    PRIMARY KEY (chave),
                    KEY idx_tentativas_atualizado (atualizado_em)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            SQL);
            return true;
        } catch (Throwable $exception) {
            return false;
        }
    }

    private function keys(string $email, string $ip): array
    {
        return [
            hash('sha256', 'email|' . strtolower(trim($email))),
            hash('sha256', 'ip|' . $ip),
        ];
    }
}
