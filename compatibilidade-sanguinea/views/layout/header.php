<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="description" content="Site educativo sobre tipos sanguíneos, compatibilidade, genética, gestação e doação de sangue.">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
    <script nonce="<?= htmlspecialchars(\App\Core\SecurityHeaders::nonce(), ENT_QUOTES, 'UTF-8') ?>">
        (function () {
            try {
                const theme = localStorage.getItem('site-theme') || 'light';
                document.documentElement.dataset.theme = theme === 'dark' ? 'dark' : 'light';
            } catch (error) {
                document.documentElement.dataset.theme = 'light';
            }
        })();
    </script>
    <link rel="stylesheet" href="/compatibilidade-sanguinea/assets/css/style.css">
</head>
<body>
<header class="topbar">
    <div class="topbar-inner">
        <a class="brand" href="/compatibilidade-sanguinea/index.php">Compatibilidade Sanguínea</a>
        <nav class="nav" aria-label="Navegação principal">
            <a href="/compatibilidade-sanguinea/quiz.php">Quiz de genética</a>
            <?php if ($isLoggedIn): ?>
                <a href="/compatibilidade-sanguinea/dashboard.php">Início</a>
                <a href="/compatibilidade-sanguinea/consulta.php">Consulta</a>
                <a href="/compatibilidade-sanguinea/explorar.php">Explorar</a>
                <a href="/compatibilidade-sanguinea/historico.php">Histórico</a>
                <a href="/compatibilidade-sanguinea/info.php">Entenda</a>
                <a href="/compatibilidade-sanguinea/projeto.php">Projeto</a>
                <form class="nav-logout-form" data-ajax-logout action="/compatibilidade-sanguinea/api/auth/logout.php" method="post">
                    <button class="nav-link-button" type="submit">Sair</button>
                </form>
            <?php else: ?>
                <a href="/compatibilidade-sanguinea/info.php">Entenda</a>
                <a href="/compatibilidade-sanguinea/projeto.php">Projeto</a>
                <a href="/compatibilidade-sanguinea/auth/login.php">Entrar</a>
                <a class="nav-button" href="/compatibilidade-sanguinea/auth/cadastro.php">Cadastrar</a>
            <?php endif; ?>
            <button type="button" class="theme-toggle" id="themeToggle" aria-label="Trocar tema" title="Trocar tema">
                <span id="themeIcon" aria-hidden="true">☾</span>
                <span id="themeLabel">Tema escuro</span>
            </button>
        </nav>
    </div>
</header>
<main class="container">
