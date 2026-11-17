<?php
declare(strict_types=1);

namespace App\Core;

use App\Models\SystemAccount;
use App\Repositories\UserRepository;

final class SessionManager
{
    public static function start(): void
    {
        if (session_status() !== PHP_SESSION_NONE) {
            return;
        }

        $https = !empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off';
        ini_set('session.use_only_cookies', '1');
        ini_set('session.use_strict_mode', '1');
        ini_set('session.use_trans_sid', '0');
        ini_set('session.cookie_httponly', '1');
        ini_set('session.cookie_secure', $https ? '1' : '0');

        session_name($https ? '__Host-compatibilidade_session' : 'compatibilidade_session');
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'secure' => $https,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        session_start();

        $lastActivity = (int) ($_SESSION['ultima_atividade'] ?? 0);
        if ($lastActivity > 0 && (time() - $lastActivity) > 7200) {
            $_SESSION = [];
            session_regenerate_id(true);
        }
        $_SESSION['ultima_atividade'] = time();
    }

    public static function isAuthenticated(): bool
    {
        return isset($_SESSION['usuario_id']);
    }

    public static function isSystemAccount(): bool
    {
        return !empty($_SESSION['usuario_sistema_fallback']) && (int) ($_SESSION['usuario_id'] ?? 0) === -1;
    }

    public static function userId(): ?int
    {
        return self::isAuthenticated() ? (int) $_SESSION['usuario_id'] : null;
    }

    public static function currentUser(): ?array
    {
        if (!self::isAuthenticated()) {
            return null;
        }

        if (self::isSystemAccount()) {
            $account = SystemAccount::data();
            unset($account['senha']);
            return $account;
        }

        $pdo = DatabaseConnection::get();
        if (!$pdo) {
            self::logout();
            return null;
        }

        $user = (new UserRepository($pdo))->findById((int) $_SESSION['usuario_id']);
        if (!$user) {
            self::logout();
        }
        return $user;
    }

    public static function login(int $userId, bool $systemAccount = false): void
    {
        session_regenerate_id(true);
        $_SESSION['usuario_id'] = $userId;
        $_SESSION['usuario_sistema_fallback'] = $systemAccount;
        $_SESSION['ultima_atividade'] = time();
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    public static function logout(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            return;
        }

        $params = session_get_cookie_params();
        setcookie(session_name(), '', [
            'expires' => time() - 3600,
            'path' => $params['path'] ?: '/',
            'domain' => $params['domain'] ?? '',
            'secure' => (bool) ($params['secure'] ?? false),
            'httponly' => (bool) ($params['httponly'] ?? true),
            'samesite' => $params['samesite'] ?? 'Lax',
        ]);
        $_SESSION = [];
        session_destroy();
    }

    public static function csrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return (string) $_SESSION['csrf_token'];
    }

    public static function validateCsrf(?string $token): bool
    {
        return is_string($token)
            && $token !== ''
            && isset($_SESSION['csrf_token'])
            && hash_equals((string) $_SESSION['csrf_token'], $token);
    }
}
