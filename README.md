<p>NPM</p>
<code>docker-compose run --rm --service-ports npm-cutcode-shop run dev --host</code><br>
<code>docker-compose run --rm npm-cutcode-shop install</code>
Пересобрать контейнер:<br>
docker-compose up -d --force-recreate --no-deps --build service_name
