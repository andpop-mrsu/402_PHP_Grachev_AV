<?php

declare(strict_types=1);

namespace artemaaaaaaaaaaaaaaaaaaa\progression\Controller;

use PDO;

use function artemaaaaaaaaaaaaaaaaaaa\progression\Model\connectDatabase;
use function artemaaaaaaaaaaaaaaaaaaa\progression\Model\createRound;
use function artemaaaaaaaaaaaaaaaaaaa\progression\Model\fetchHistory;
use function artemaaaaaaaaaaaaaaaaaaa\progression\Model\getDatabasePath;
use function artemaaaaaaaaaaaaaaaaaaa\progression\Model\saveGame;
use function artemaaaaaaaaaaaaaaaaaaa\progression\View\askAnswer;
use function artemaaaaaaaaaaaaaaaaaaa\progression\View\askPlayerName;
use function artemaaaaaaaaaaaaaaaaaaa\progression\View\promptMenu;
use function artemaaaaaaaaaaaaaaaaaaa\progression\View\showCorrect;
use function artemaaaaaaaaaaaaaaaaaaa\progression\View\showHistory;
use function artemaaaaaaaaaaaaaaaaaaa\progression\View\showQuestion;
use function artemaaaaaaaaaaaaaaaaaaa\progression\View\showWelcome;
use function artemaaaaaaaaaaaaaaaaaaa\progression\View\showWrong;

function startGame(array $argv = []): void
{
    $projectRoot = dirname(__DIR__);
    $dbPath = getDatabasePath($projectRoot);
    $pdo = connectDatabase($dbPath);

    showWelcome();
    $playerName = askPlayerName();

    while (true) {
        $choice = promptMenu();
        if ($choice === '1') {
            playRound($pdo, $playerName);
            continue;
        }

        if ($choice === '2') {
            $history = fetchHistory($pdo);
            showHistory($history);
            continue;
        }

        if ($choice === '0' || $choice === '') {
            break;
        }
    }
}

function playRound(PDO $pdo, string $playerName): void
{
    $round = createRound(10);
    showQuestion($round['shown_progression']);

    $answer = askAnswer();
    $isWin = trim($answer) === (string) $round['missing_value'];

    if ($isWin) {
        showCorrect();
    } else {
        showWrong($round['full_progression'], (string) $round['missing_value']);
    }

    saveGame($pdo, [
        'player_name' => $playerName,
        'played_at' => date('Y-m-d H:i:s'),
        'shown_progression' => $round['shown_progression'],
        'full_progression' => $round['full_progression'],
        'missing_value' => $round['missing_value'],
        'answer' => $answer,
        'is_win' => $isWin ? 1 : 0,
    ]);
}
