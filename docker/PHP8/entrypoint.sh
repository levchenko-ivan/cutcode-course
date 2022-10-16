#!/bin/bash

set -e;

#if [ ! -f /var/www/cutcode.local/node_modules/axios/lib/axios.js ]; then
#    cd "/var/www/cutcode.local";
#    npm i;
#    export NODE_OPTIONS=--openssl-legacy-provider;
#    npm run dev;
#fi

#if [ ! -f /var/www/cutcode.local/.env ]; then
#  cp "/var/www/cutcode.local/.env.example" "/var/www/cutcode.local/.env";
#fi

#if [ ! -f /var/www/cutcode.local/.env.testing ]; then
#  cp "/var/www/cutcode.local/.env.testing.example" "/var/www/cutcode.local/.env.testing";
#fi

#if [ ! -f /var/www/cutcode.local/vendor/autoload.php ]; then
#    php -d memory_limit=-1 /usr/local/bin/composer install --working-dir=/var/www/cutcode.local 2>&1 || true;
#    cd "/var/www/cutcode.local";
#    yes | php artisan key:generate;
#    yes | php artisan key:generate --env=testing;
#    php artisan migrate:refresh --seed;
#    php artisan storage:link;
#    php artisan optimize;
#fi

php-fpm;

tail -f /home/entrypoints.sh;
