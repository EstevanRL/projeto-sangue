<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\DatabaseConnection;
use App\Core\SessionManager;
use App\Models\SystemAccount;
use App\Repositories\LoginAttemptRepository;
use App\Repositories\UserRepository;
use Throwable;

final class AuthService
{
    private const BLOOD_TYPES = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];

    public function login(string $email, string $password, string $ip): array
    {
        $email = strtolower(trim($email));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) > 256) {
            return ['success' => false, 'message' => 'E-mail ou senha incorretos.', 'status' => 422];
        }

        $pdo = DatabaseConnection::get();
        $attempts = $pdo ? new LoginAttemptRepository($pdo) : null;

        if ($attempts && $attempts->isBlocked($email, $ip)) {
            return ['success' => false, 'message' => 'Muitas tentativas de entrada. Aguarde alguns minutos e tente novamente.', 'status' => 429];
        }

        if (SystemAccount::matches($email, $password)) {
            SessionManager::login(-1, true);
            $attempts?->clear($email, $ip);
            return ['success' => true, 'message' => 'Entrada realizada.', 'redirect' => '/compatibilidade-sanguinea/dashboard.php'];
        }

        if (!$pdo) {
            return ['success' => false, 'message' => 'O banco de dados está indisponível. Tente novamente mais tarde.', 'status' => 503];
        }

        try {
            $users = new UserRepository($pdo);
            $user = $users->findByEmail($email);
            if (!$user || !password_verify($password, (string) $user['senha'])) {
                $attempts?->registerFailure($email, $ip);
                return ['success' => false, 'message' => 'E-mail ou senha incorretos.', 'status' => 401];
            }

            SessionManager::login((int) $user['id']);
            if (password_needs_rehash((string) $user['senha'], defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_DEFAULT)) {
                $users->updatePassword((int) $user['id'], password_hash($password, defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_DEFAULT));
            }
            $attempts?->clear($email, $ip);
            return ['success' => true, 'message' => 'Entrada realizada.', 'redirect' => '/compatibilidade-sanguinea/dashboard.php'];
        } catch (Throwable $exception) {
            return ['success' => false, 'message' => 'Não foi possível concluir a entrada. Verifique a conexão com o banco de dados.', 'status' => 503];
        }
    }

    public function register(array $input): array
    {
        $name = trim((string) ($input['nome'] ?? ''));
        $email = strtolower(trim((string) ($input['email'] ?? '')));
        $password = (string) ($input['senha'] ?? '');
        $bloodType = (string) ($input['tipo_sanguineo'] ?? '');

        if (strlen($name) < 2 || strlen($name) > 100) {
            return ['success' => false, 'message' => 'Informe um nome válido.', 'status' => 422];
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $email === SystemAccount::data()['email']) {
            return ['success' => false, 'message' => 'Informe um e-mail válido.', 'status' => 422];
        }
        if (strlen($password) < 8 || strlen($password) > 256) {
            return ['success' => false, 'message' => 'A senha deve ter entre 8 e 256 caracteres.', 'status' => 422];
        }
        if (!in_array($bloodType, self::BLOOD_TYPES, true)) {
            return ['success' => false, 'message' => 'Selecione um tipo sanguíneo válido.', 'status' => 422];
        }

        $pdo = DatabaseConnection::get();
        if (!$pdo) {
            return ['success' => false, 'message' => 'O cadastro está temporariamente indisponível porque o banco de dados não está conectado.', 'status' => 503];
        }

        try {
            $users = new UserRepository($pdo);
            if ($users->emailExists($email)) {
                return ['success' => false, 'message' => 'Este e-mail já está cadastrado.', 'status' => 409];
            }
            $hash = password_hash($password, defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_DEFAULT);
            $userId = $users->create($name, $email, $hash, $bloodType);
            SessionManager::login($userId);
            return ['success' => true, 'message' => 'Cadastro realizado.', 'redirect' => '/compatibilidade-sanguinea/dashboard.php'];
        } catch (Throwable $exception) {
            return ['success' => false, 'message' => 'Não foi possível concluir o cadastro. Tente novamente.', 'status' => 503];
        }
    }
}
