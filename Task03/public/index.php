<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$dbDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'db';
$dbPath = $dbDir . DIRECTORY_SEPARATOR . 'progression.sqlite';
if (!is_dir($dbDir)) {
    mkdir($dbDir, 0777, true);
}

$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$pdo->exec(
    'CREATE TABLE IF NOT EXISTS games (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        player_name TEXT NOT NULL,
        started_at TEXT NOT NULL,
        finished_at TEXT,
        shown_progression TEXT NOT NULL,
        full_progression TEXT NOT NULL,
        missing_index INTEGER NOT NULL,
        missing_value INTEGER NOT NULL,
        status TEXT NOT NULL
    )'
);

$pdo->exec(
    'CREATE TABLE IF NOT EXISTS steps (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        game_id INTEGER NOT NULL,
        step_number INTEGER NOT NULL,
        answer TEXT NOT NULL,
        is_correct INTEGER NOT NULL,
        created_at TEXT NOT NULL,
        FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE
    )'
);

$respondJson = static function (Response $response, array $data, int $status = 200): Response {
    $response->getBody()->write((string) json_encode($data, JSON_UNESCAPED_UNICODE));
    return $response
        ->withHeader('Content-Type', 'application/json; charset=utf-8')
        ->withStatus($status);
};

$readJson = static function (Request $request): array {
    $raw = (string) $request->getBody();
    if ($raw === '') {
        return [];
    }

    $decoded = json_decode($raw, true);
    return is_array($decoded) ? $decoded : [];
};

$createRound = static function (int $length = 10): array {
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
        'shown_progression' => implode(' ', $shown),
        'full_progression' => implode(' ', $progression),
        'missing_index' => $missingIndex,
        'missing_value' => $missingValue,
    ];
};

$app->get('/', static function (Request $request, Response $response): Response {
    $file = __DIR__ . '/index.html';
    $response->getBody()->write((string) file_get_contents($file));
    return $response->withHeader('Content-Type', 'text/html; charset=utf-8');
});

$app->get('/games', static function (Request $request, Response $response) use ($pdo, $respondJson): Response {
    $stmt = $pdo->query(
        'SELECT id, player_name, started_at, finished_at, shown_progression, full_progression, missing_value, status
         FROM games
         ORDER BY id DESC'
    );

    return $respondJson($response, ['games' => $stmt->fetchAll() ?: []]);
});

$app->get('/games/{id}', static function (Request $request, Response $response, array $args) use ($pdo, $respondJson): Response {
    $gameId = (int) ($args['id'] ?? 0);

    $existsStmt = $pdo->prepare('SELECT 1 FROM games WHERE id = :id');
    $existsStmt->execute([':id' => $gameId]);
    if (!$existsStmt->fetchColumn()) {
        return $respondJson($response, ['error' => 'Игра не найдена'], 404);
    }

    $stepStmt = $pdo->prepare(
        'SELECT step_number, answer, is_correct, created_at
         FROM steps
         WHERE game_id = :id
         ORDER BY step_number ASC, id ASC'
    );
    $stepStmt->execute([':id' => $gameId]);

    return $respondJson($response, ['id' => $gameId, 'steps' => $stepStmt->fetchAll() ?: []]);
});

$app->post('/games', static function (Request $request, Response $response) use ($pdo, $respondJson, $readJson, $createRound): Response {
    $payload = $readJson($request);
    $playerName = trim((string) ($payload['player_name'] ?? ''));

    if ($playerName === '') {
        return $respondJson($response, ['error' => 'Поле player_name обязательно'], 400);
    }

    $round = $createRound(10);

    $stmt = $pdo->prepare(
        'INSERT INTO games (player_name, started_at, shown_progression, full_progression, missing_index, missing_value, status)
         VALUES (:player_name, :started_at, :shown_progression, :full_progression, :missing_index, :missing_value, :status)'
    );

    $stmt->execute([
        ':player_name' => substr($playerName, 0, 100),
        ':started_at' => date('Y-m-d H:i:s'),
        ':shown_progression' => $round['shown_progression'],
        ':full_progression' => $round['full_progression'],
        ':missing_index' => $round['missing_index'],
        ':missing_value' => $round['missing_value'],
        ':status' => 'active',
    ]);

    $gameId = (int) $pdo->lastInsertId();

    return $respondJson($response, ['id' => $gameId], 201);
});

$app->post('/step/{id}', static function (Request $request, Response $response, array $args) use ($pdo, $respondJson, $readJson): Response {
    $gameId = (int) ($args['id'] ?? 0);

    $gameStmt = $pdo->prepare(
        'SELECT id, player_name, started_at, finished_at, shown_progression, full_progression, missing_index, missing_value, status
         FROM games WHERE id = :id'
    );
    $gameStmt->execute([':id' => $gameId]);
    $game = $gameStmt->fetch();

    if (!$game) {
        return $respondJson($response, ['error' => 'Игра не найдена'], 404);
    }

    if ($game['status'] !== 'active') {
        return $respondJson($response, ['error' => 'Игра уже завершена'], 409);
    }

    $payload = $readJson($request);
    $answerRaw = trim((string) ($payload['answer'] ?? ''));
    if ($answerRaw === '') {
        return $respondJson($response, ['error' => 'Поле answer обязательно'], 400);
    }

    $isCorrect = ((string) $game['missing_value']) === $answerRaw;

    $countStmt = $pdo->prepare('SELECT COUNT(*) FROM steps WHERE game_id = :game_id');
    $countStmt->execute([':game_id' => $gameId]);
    $stepNumber = (int) $countStmt->fetchColumn() + 1;

    $insertStep = $pdo->prepare(
        'INSERT INTO steps (game_id, step_number, answer, is_correct, created_at)
         VALUES (:game_id, :step_number, :answer, :is_correct, :created_at)'
    );

    $insertStep->execute([
        ':game_id' => $gameId,
        ':step_number' => $stepNumber,
        ':answer' => substr($answerRaw, 0, 50),
        ':is_correct' => $isCorrect ? 1 : 0,
        ':created_at' => date('Y-m-d H:i:s'),
    ]);

    if ($isCorrect) {
        $updateGame = $pdo->prepare(
            'UPDATE games SET status = :status, finished_at = :finished_at WHERE id = :id'
        );
        $updateGame->execute([
            ':status' => 'won',
            ':finished_at' => date('Y-m-d H:i:s'),
            ':id' => $gameId,
        ]);

        $game['status'] = 'won';
        $game['finished_at'] = date('Y-m-d H:i:s');
    }

    return $respondJson($response, [
        'game' => $game,
        'step' => [
            'step_number' => $stepNumber,
            'answer' => substr($answerRaw, 0, 50),
            'is_correct' => $isCorrect,
            'created_at' => date('Y-m-d H:i:s'),
        ],
    ], 201);
});

$app->run();
