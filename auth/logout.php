<?php
declare(strict_types=1);

require dirname(__DIR__) . '/app/bootstrap.php';

if (\App\Core\Request::method() !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Método não permitido.');
}

$token = (string) ($_POST['csrf_token'] ?? '');
if (!\App\Core\SessionManager::validateCsrf($token)) {
    http_response_code(403);
    exit('Requisição inválida.');
}

\App\Core\SessionManager::logout();
header('Location: /compatibilidade-sanguinea/index.php');
exit;
