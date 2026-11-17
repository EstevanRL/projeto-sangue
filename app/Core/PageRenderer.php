<?php
declare(strict_types=1);

namespace App\Core;

final class PageRenderer
{
    public static function render(string $view, string $title, bool $requiresLogin = false): void
    {
        $allowedViews = ['home', 'dashboard', 'consulta', 'explorar', 'historico', 'login', 'cadastro', 'quiz', 'info', 'projeto'];
        if (!in_array($view, $allowedViews, true)) {
            http_response_code(404);
            exit('Página não encontrada.');
        }

        if ($requiresLogin && SessionManager::currentUser() === null) {
            header('Location: /compatibilidade-sanguinea/auth/login.php');
            exit;
        }

        $pageTitle = $title;
        $isLoggedIn = SessionManager::isAuthenticated();
        $csrfToken = SessionManager::csrfToken();
        require dirname(__DIR__, 2) . '/views/layout/header.php';
        require dirname(__DIR__, 2) . '/views/pages/' . $view . '.php';
        require dirname(__DIR__, 2) . '/views/layout/footer.php';
    }
}
