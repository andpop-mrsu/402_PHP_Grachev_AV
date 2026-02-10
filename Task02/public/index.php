<?php

declare(strict_types=1);

$projectRoot = dirname(__DIR__);
require $projectRoot . '/src/model.php';

$view = $projectRoot . '/templates/home.php';
$pageTitle = 'Главная';

require $projectRoot . '/templates/layout.php';
