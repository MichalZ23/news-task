#!/usr/bin/env sh
set -e

if [ ! -d "vendor" ]; then
  echo "vendor missing – running composer install"
  composer install --no-interaction --no-progress --prefer-dist
fi

/usr/local/bin/wait_for_it.sh "${MYSQL_HOST:-db}" 3306 -- echo "DB port ready"

MAX_TRIES=25
i=0

until php /var/www/html/docker/app/init_admin.php; do
    i=$((i+1))
    echo "Database not ready, attempt $i..."
    if [ "$i" -ge "$MAX_TRIES" ]; then
        echo "Database failed to respond after $MAX_TRIES attempts"
        exit 1
    fi
    sleep 2
done

exec "$@"
