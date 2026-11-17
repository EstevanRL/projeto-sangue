<?php
declare(strict_types=1);

require dirname(__DIR__, 2) . '/app/bootstrap.php';

$controller = new \App\Controllers\ConsultationController(new \App\Services\ConsultationService(new \App\Services\HistoryService(), new \App\Services\BloodCompatibilityService()));
\App\Core\ApiKernel::post([$controller, 'compare']);
