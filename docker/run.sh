#! /bin/bash

until (mysql -h mysql_container -P 3306 -u${MYSQL_USER} -p${MYSQL_PASSWORD}  ${MYSQL_DATABASE}) ; do
  >&2 echo "MySQL is unavailable - waiting for it..."
  sleep 7
done

 php artisan key:generate
 php artisan optimize && php artisan config:clear && php artisan cache:clear

echo "Migration Started";
 php artisan migrate
 echo "Seeding started"
 php artisan db:seed
 echo "Server starting"

 sudo chown -R $USER:www-data storage
 sudo chown -R $USER:www-data bootstrap/cache

 chmod -R 777 storage
 chmod -R 777 bootstrap/cache


