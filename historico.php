<?php
declare(strict_types=1);

require __DIR__ . '/app/bootstrap.php';

\App\Core\PageRenderer::render('historico', 'Histórico de consultas', true);
