# Арифметическая прогрессия — Laravel

Веб-приложение на фреймворке Laravel. Реализация игры «Арифметическая прогрессия».

Игроку показывается ряд из 10 чисел, образующий арифметическую прогрессию со случайным шагом. Одно из чисел заменено точками (`..`). Игрок должен угадать пропущенное число за 3 попытки.

## Установка

**Linux / macOS:**
```bash
make install
```

**Windows (без make):**
```bash
composer install
copy .env.example .env
php artisan key:generate --no-interaction
php artisan migrate --force --no-interaction
```

Команды выполняют:
- установку PHP-зависимостей через Composer
- копирование `.env.example` в `.env`
- генерацию ключа приложения
- создание файла базы данных SQLite и миграцию

## Запуск

**Linux / macOS:**
```bash
make serve
```

**Windows:**
```bash
php artisan serve
```

Приложение будет доступно по адресу: http://localhost:8000

## База данных

SQLite-база данных хранится в `database/database.sqlite`.

В базе сохраняется информация об именах игроков, датах и результатах всех игр, предлагавшихся прогрессиях и пропущенных числах.

## Тесты

**Linux / macOS:**
```bash
make test
```

**Windows:**
```bash
php artisan test
```

## Требования

- PHP >= 8.3
- Composer
- SQLite
