<?php
declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class UserRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function findByEmail(string $email): ?array
    {
        $statement = $this->pdo->prepare('SELECT id, nome, email, senha, tipo_sanguineo FROM usuarios WHERE email = ? LIMIT 1');
        $statement->execute([$email]);
        return $statement->fetch() ?: null;
    }

    public function findById(int $id): ?array
    {
        $statement = $this->pdo->prepare('SELECT id, nome, email, tipo_sanguineo FROM usuarios WHERE id = ? LIMIT 1');
        $statement->execute([$id]);
        return $statement->fetch() ?: null;
    }

    public function emailExists(string $email): bool
    {
        return $this->findByEmail($email) !== null;
    }

    public function create(string $name, string $email, string $passwordHash, string $bloodType): int
    {
        $statement = $this->pdo->prepare('INSERT INTO usuarios (nome, email, senha, tipo_sanguineo) VALUES (?, ?, ?, ?)');
        $statement->execute([$name, $email, $passwordHash, $bloodType]);
        return (int) $this->pdo->lastInsertId();
    }

    public function updatePassword(int $id, string $passwordHash): void
    {
        $statement = $this->pdo->prepare('UPDATE usuarios SET senha = ? WHERE id = ?');
        $statement->execute([$passwordHash, $id]);
    }
}
