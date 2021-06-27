<?php

declare(strict_types=1);

use Laminas\Mvc\Application;

chdir(dirname(__DIR__));

include __DIR__ . '/../vendor/autoload.php';

$appConfig = require __DIR__ . '/../config/application.config.php';

Application::init($appConfig)->run();
