<?php
declare(strict_types=1);

require dirname(__DIR__, 2) . '/app/bootstrap.php';

$controller = new \App\Controllers\HistoryController(new \App\Services\HistoryService());
\App\Core\ApiKernel::get([$controller, 'list']);
