<?php
declare(strict_types=1);

require_once __DIR__ . '/Core/ClassLoader.php';

\App\Core\ClassLoader::register();
\App\Core\SecurityHeaders::apply();
\App\Core\SessionManager::start();
