<?php
declare(strict_types=1);

require dirname(__DIR__, 2) . '/app/bootstrap.php';

$controller = new \App\Controllers\AuthController(new \App\Services\AuthService());
\App\Core\ApiKernel::post([$controller, 'logout']);
