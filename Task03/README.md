# Task03 - SPA на Slim + SQLite

## Что реализовано
- Single Page Application для игры "Арифметическая прогрессия".
- Backend на Slim (REST API + SQLite).
- Frontend на `index.html` + `app.js`, обмен JSON через `fetch`.

## Структура
- `Task03/public` - корень сайта (`index.php`, `index.html`, `app.js`, `styles.css`).
- `Task03/db` - база данных SQLite (`progression.sqlite` создается автоматически).

## Установка зависимостей
Перейдите в каталог `Task03` и установите Slim:

```bash
composer install
```

## Запуск
1. Перейдите в каталог `Task03`.
2. Запустите сервер:

```bash
php -S localhost:3000 -t public
```

3. Откройте в браузере:
- `http://localhost:3000/`

## REST API
- `GET /games` - JSON с данными всех игр.
- `GET /games/{id}` - JSON с ходами игры `id`.
- `POST /games` - старт новой игры.
  - JSON: `{ "player_name": "Антон" }`
  - Ответ: `{ "id": 1 }`
- `POST /step/{id}` - ход в игре.
  - JSON: `{ "answer": "42" }`

## Примечание
- В `Task03/public` только один PHP-файл: `index.php`.
- Таблицы `games` и `steps` создаются автоматически при первом запуске.
