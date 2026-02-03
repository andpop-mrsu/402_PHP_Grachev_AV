<?php

declare(strict_types=1);

namespace artemaaaaaaaaaaaaaaaaaaa\progression\View;

use function cli\line;
use function cli\prompt;

function showWelcome(): void
{
    line('Добро пожаловать в игру "Арифметическая прогрессия"!');
    line('Вы увидите прогрессию из 10 чисел с пропуском.');
    line('Ваша задача — определить пропущенное число.');
    line('');
}

function askPlayerName(): string
{
    $name = trim((string) prompt('Введите ваше имя'));
    if ($name === '') {
        $name = 'Игрок';
    }
    line("Привет, {$name}!");
    return $name;
}

function promptMenu(): string
{
    line('');
    line('Выберите действие:');
    line('1) Играть');
    line('2) История');
    line('0) Выход');

    return trim((string) prompt('Ваш выбор'));
}

function showQuestion(string $progression): void
{
    line('');
    line('Вопрос:');
    line($progression);
}

function askAnswer(): string
{
    return trim((string) prompt('Ваш ответ'));
}

function showCorrect(): void
{
    line('Верно!');
}

function showWrong(string $fullProgression, string $missingValue): void
{
    line('Неверный ответ.');
    line("Правильная прогрессия: {$fullProgression}");
    line("Пропущенное число: {$missingValue}");
}

function showHistory(array $rows): void
{
    line('');
    line('История игр:');

    if ($rows === []) {
        line('Пока нет сыгранных игр.');
        return;
    }

    $dateWidth = 19;
    $playerWidth = 16;
    $resultWidth = 10;
    $progressHeader = 'Прогрессия (с пропуском) / Пропущенное';
    $header = padCell('Дата', $dateWidth)
        . '  '
        . padCell('Игрок', $playerWidth)
        . '  '
        . padCell('Результат', $resultWidth)
        . '  '
        . $progressHeader;
    line($header);
    $progressWidth = mb_strwidth($progressHeader);
    line(
        str_repeat('-', $dateWidth)
        . '  '
        . str_repeat('-', $playerWidth)
        . '  '
        . str_repeat('-', $resultWidth)
        . '  '
        . str_repeat('-', $progressWidth)
    );
    foreach ($rows as $row) {
        $result = ((int) $row['is_win'] === 1) ? 'победа' : 'поражение';
        $playerName = (string) $row['player_name'];
        $lineText = padCell((string) $row['played_at'], $dateWidth)
            . '  '
            . padCell($playerName, $playerWidth)
            . '  '
            . padCell($result, $resultWidth)
            . '  '
            . (string) $row['shown_progression']
            . ' / '
            . (string) $row['missing_value'];
        line($lineText);
    }
}

function padCell(string $text, int $width): string
{
    $text = trimToWidth($text, $width);
    $pad = $width - mb_strwidth($text);
    if ($pad > 0) {
        $text .= str_repeat(' ', $pad);
    }

    return $text;
}

function trimToWidth(string $text, int $width): string
{
    if (mb_strwidth($text) <= $width) {
        return $text;
    }

    $ellipsis = '…';
    $maxWidth = max(0, $width - mb_strwidth($ellipsis));
    $cut = '';
    $len = mb_strlen($text);
    for ($i = 1; $i <= $len; $i += 1) {
        $candidate = mb_substr($text, 0, $i);
        if (mb_strwidth($candidate) > $maxWidth) {
            $cut = mb_substr($text, 0, $i - 1);
            break;
        }
    }

    if ($cut === '') {
        $cut = mb_substr($text, 0, $maxWidth);
    }

    return $cut . $ellipsis;
}
