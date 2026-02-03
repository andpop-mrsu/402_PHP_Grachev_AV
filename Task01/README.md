# Task01 — Арифметическая прогрессия

Консольная игра на PHP. Игроку показывается арифметическая прогрессия из 10 чисел, в которой одно число заменено на `..`. Нужно определить пропущенное число. В случае ошибки выводится правильная прогрессия и верный ответ. История игр хранится в локальной SQLite‑базе.

## Запуск локально
1. Перейти в каталог проекта: `Task01/progression`
2. Установить зависимости: `composer install`
3. Варианты запуска.
`php bin/progression`
`./vendor/bin/progression` (Windows: `.\vendor\bin\progression.bat`)

## Запуск глобально (через Packagist)
1. Установить пакет глобально: `composer global require artemaaaaaaaaaaaaaaaaaaa/progression`
При конфликте зависимостей можно установить разово так: `composer global require artemaaaaaaaaaaaaaaaaaaa/progression -W`
2. Узнать путь к глобальному `bin`:
`composer global config bin-dir --absolute`
3. Добавить этот путь в `PATH`
4. Запускать командой: `progression`

## Правила игры
1. Вы видите прогрессию из 10 чисел.
2. Одно число заменено на `..`.
3. Введите пропущенное число.

## История игр
История сохраняется в файл базы данных:
`data/progression.sqlite`

## Packagist
Пакет: `artemaaaaaaaaaaaaaaaaaaa/progression`
Ссылка: https://packagist.org/packages/artemaaaaaaaaaaaaaaaaaaa/progression
