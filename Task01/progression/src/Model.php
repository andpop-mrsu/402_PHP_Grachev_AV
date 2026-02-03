<?php

declare(strict_types=1);

namespace artemaaaaaaaaaaaaaaaaaaa\progression\Model;

use PDO;

function getDatabasePath(string $projectRoot): string
{
    return $projectRoot . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'progression.sqlite';
}

function connectDatabase(string $dbPath): PDO
{
    $dir = dirname($dbPath);
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS games (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            player_name TEXT NOT NULL,
            played_at TEXT NOT NULL,
            shown_progression TEXT NOT NULL,
            full_progression TEXT NOT NULL,
            missing_value INTEGER NOT NULL,
            answer TEXT NOT NULL,
            is_win INTEGER NOT NULL
        )'
    );

    return $pdo;
}

function createRound(int $length): array
{
    $start = random_int(1, 20);
    $step = random_int(1, 10);
    $progression = [];

    for ($i = 0; $i < $length; $i++) {
        $progression[] = $start + $step * $i;
    }

    $missingIndex = random_int(0, $length - 1);
    $missingValue = $progression[$missingIndex];

    $shown = $progression;
    $shown[$missingIndex] = '..';

    return [
        'start' => $start,
        'step' => $step,
        'length' => $length,
        'missing_index' => $missingIndex,
        'missing_value' => $missingValue,
        'shown_progression' => implode(' ', $shown),
        'full_progression' => implode(' ', $progression),
    ];
}

function saveGame(PDO $pdo, array $data): void
{
    $stmt = $pdo->prepare(
        'INSERT INTO games (player_name, played_at, shown_progression, full_progression, missing_value, answer, is_win)
         VALUES (:player_name, :played_at, :shown_progression, :full_progression, :missing_value, :answer, :is_win)'
    );

    $stmt->execute([
        ':player_name' => $data['player_name'],
        ':played_at' => $data['played_at'],
        ':shown_progression' => $data['shown_progression'],
        ':full_progression' => $data['full_progression'],
        ':missing_value' => $data['missing_value'],
        ':answer' => $data['answer'],
        ':is_win' => $data['is_win'],
    ]);
}

function fetchHistory(PDO $pdo, int $limit = 20): array
{
    $stmt = $pdo->prepare(
        'SELECT player_name, played_at, shown_progression, full_progression, missing_value, answer, is_win
         FROM games
         ORDER BY id DESC
         LIMIT :limit'
    );
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
}
