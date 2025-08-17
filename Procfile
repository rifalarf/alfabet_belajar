web: vendor/bin/heroku-php-apache2 -d memory_limit=256M -d max_execution_time=120 public/
release: php artisan migrate --force && php artisan storage:link || true