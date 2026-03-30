.PHONY: install serve test help

help:
	@echo "Available commands:"
	@echo "  make install - Install the application"
	@echo "  make serve   - Start development server"
	@echo "  make test    - Run tests"

install:
	composer install
	cp .env.example .env
	php artisan key:generate
	touch database/database.sqlite
	php artisan migrate --force
	npm install
	npm run build

serve:
	php artisan serve

test:
	php artisan test
