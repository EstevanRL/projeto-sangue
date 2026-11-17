<?php
declare(strict_types=1);

namespace App\Models;

final class SystemAccount
{
    public static function data(): array
    {
        return [
            'id' => -1,
            'nome' => 'IFSP',
            'email' => 'ifsp@gmail.com',
            'senha' => '$argon2id$v=19$m=65536,t=4,p=1$WWJyeEZIZEZqMWIuZGF5RA$B8MfMZm9YmW/rcr+d4HjIcqVWER0RKbPsTpGaMNmF5U',
            'tipo_sanguineo' => 'O+',
        ];
    }

    public static function matches(string $email, string $password): bool
    {
        $account = self::data();
        return hash_equals($account['email'], $email) && password_verify($password, $account['senha']);
    }
}
