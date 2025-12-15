install: setup

setup:
	composer install
	#cp -n .env.example .env
	php artisan key:gen --ansi
	php artisan migrate
	#php artisan db:seed
	npm ci
	npm run build
	make ide-helper
	
validate:
	composer validate	

lint:
	composer exec --verbose phpcs -- --standard=PSR12 src public

start:
	php artisan serve --host=0.0.0.0
	
migrate:
	php artisan migrate

console:
	php artisan tinker
	
test:
	php artisan test
	
test-coverage:
	XDEBUG_MODE=coverage php artisan test --coverage-clover build/logs/clover.xml
	
ide-helper:
	php artisan ide-helper:eloquent
	php artisan ide-helper:gen
	php artisan ide-helper:meta
	php artisan ide-helper:mod -n