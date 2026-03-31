.PHONY: install serve test help

help:
	@echo "Доступные команды:"
	@echo "  make install - Установить приложение"
	@echo "  make serve   - Запустить сервер разработки"
	@echo "  make test    - Запустить тесты"

install:
	composer install
	cp -n .env.example .env
	php artisan key:generate --no-interaction
	touch database/database.sqlite
	php artisan migrate --force --no-interaction

serve:
	php artisan serve

test:
	php artisan test
