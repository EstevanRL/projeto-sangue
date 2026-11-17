<?php
declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class HistoryRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    private function ensureTable(): void
    {
        $this->pdo->exec(<<<SQL
            CREATE TABLE IF NOT EXISTS consultas (
                id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                usuario_id INT UNSIGNED NOT NULL,
                tipo1 ENUM('A+','A-','B+','B-','AB+','AB-','O+','O-') NOT NULL,
                tipo2 ENUM('A+','A-','B+','B-','AB+','AB-','O+','O-') NOT NULL,
                gestante ENUM('tipo1','tipo2','usuario','outra') NOT NULL,
                origem ENUM('consulta','explorar') NOT NULL,
                criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id),
                KEY idx_consultas_usuario (usuario_id),
                CONSTRAINT fk_consultas_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        SQL);
    }

    public function add(int $userId, string $type1, string $type2, string $pregnant, string $source): void
    {
        if ($userId < 1) {
            return;
        }
        $this->ensureTable();
        $statement = $this->pdo->prepare('INSERT INTO consultas (usuario_id, tipo1, tipo2, gestante, origem) VALUES (?, ?, ?, ?, ?)');
        $statement->execute([$userId, $type1, $type2, $pregnant, $source]);
    }

    public function listForUser(int $userId, int $limit = 50): array
    {
        if ($userId < 1) {
            return [];
        }
        $this->ensureTable();
        $limit = max(1, min($limit, 200));
        $statement = $this->pdo->prepare("SELECT id, tipo1, tipo2, gestante, origem, criado_em FROM consultas WHERE usuario_id = ? ORDER BY criado_em DESC, id DESC LIMIT {$limit}");
        $statement->execute([$userId]);
        return $statement->fetchAll();
    }

    public function deleteForUser(int $userId): int
    {
        if ($userId < 1) {
            return 0;
        }
        $this->ensureTable();
        $statement = $this->pdo->prepare('DELETE FROM consultas WHERE usuario_id = ?');
        $statement->execute([$userId]);
        return $statement->rowCount();
    }
}
