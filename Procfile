web: vendor/bin/heroku-php-apache2 -d memory_limit=512M public/
release: php artisan migrate --force && php artisan storage:link || true