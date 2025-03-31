# Переменные
COMPOSE = docker-compose
EXEC_PHP = docker exec -it laravel-app
EXEC_DB = docker exec -it mysql-db mysql -u root -p

# Запуск Sail (Laravel в Docker)
up:
	$(COMPOSE) up -d

down:
	$(COMPOSE) down

build:
	$(COMPOSE) build --no-cache

restart: down up

# Работа с PHP и Composer
composer-install:
	$(EXEC_PHP) composer install

composer-update:
	$(EXEC_PHP) composer update

artisan:
	$(EXEC_PHP) php artisan

migrate:
	$(EXEC_PHP) php artisan migrate --seed

rollback:
	$(EXEC_PHP) php artisan migrate:rollback

tinker:
	$(EXEC_PHP) php artisan tinker

# Работа с NPM и Vite
npm-install:
	$(EXEC_PHP) npm install

npm-build:
	$(EXEC_PHP) npm run build

npm-dev:
	$(EXEC_PHP) npm run dev

# Работа с базой данных
db:
	$(EXEC_DB)

db-seed:
	$(EXEC_PHP) php artisan db:seed

# Очистка кэша
cache-clear:
	$(EXEC_PHP) php artisan cache:clear

config-clear:
	$(EXEC_PHP) php artisan config:clear

route-clear:
	$(EXEC_PHP) php artisan route:clear

view-clear:
	$(EXEC_PHP) php artisan view:clear

# Логи
logs:
	$(COMPOSE) logs -f

# Очистка и пересборка
reset: down build up composer-install migrate
