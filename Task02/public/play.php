<?php

declare(strict_types=1);

$projectRoot = dirname(__DIR__);
require $projectRoot . '/src/model.php';

use function progression\Model\connectDatabase;
use function progression\Model\createRound;
use function progression\Model\getDatabasePath;
use function progression\Model\saveGame;

$pdo = connectDatabase(getDatabasePath($projectRoot));

$errors = [];
$result = null;
$playerName = '';
$showNextLink = false;

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $playerName = trim((string) ($_POST['player_name'] ?? ''));
    if ($playerName === '') {
        $playerName = 'Игрок';
    }

    $answer = trim((string) ($_POST['answer'] ?? ''));
    $shown = trim((string) ($_POST['shown_progression'] ?? ''));
    $full = trim((string) ($_POST['full_progression'] ?? ''));
    $missing = (int) ($_POST['missing_value'] ?? 0);

    if ($answer === '') {
        $errors[] = 'Введите ответ.';
        $round = [
            'shown_progression' => $shown,
            'full_progression' => $full,
            'missing_value' => $missing,
        ];
    } else {
        $isWin = $answer === (string) $missing;
        $result = [
            'is_win' => $isWin,
            'full_progression' => $full,
            'missing_value' => $missing,
        ];

        saveGame($pdo, [
            'player_name' => $playerName,
            'played_at' => date('Y-m-d H:i:s'),
            'shown_progression' => $shown,
            'full_progression' => $full,
            'missing_value' => $missing,
            'answer' => $answer,
            'is_win' => $isWin ? 1 : 0,
        ]);

        $round = [
            'shown_progression' => $shown,
            'full_progression' => $full,
            'missing_value' => $missing,
        ];
        $showNextLink = true;
    }
} else {
    $round = createRound(10);
}

$view = $projectRoot . '/templates/play.php';
$pageTitle = 'Играть';

require $projectRoot . '/templates/layout.php';
