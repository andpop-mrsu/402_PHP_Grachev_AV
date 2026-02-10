<?php

declare(strict_types=1);

$projectRoot = dirname(__DIR__);
require $projectRoot . '/src/model.php';

use function progression\Model\connectDatabase;
use function progression\Model\fetchHistory;
use function progression\Model\getDatabasePath;

$pdo = connectDatabase(getDatabasePath($projectRoot));
$rows = fetchHistory($pdo);

$view = $projectRoot . '/templates/history.php';
$pageTitle = 'История';

require $projectRoot . '/templates/layout.php';
