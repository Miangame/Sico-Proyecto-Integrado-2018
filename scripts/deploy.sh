php bin/console cache:clear --env=prod
php bin/console doctrine:schema:update -f
php bin/console cache:warmup --env=prod
php bin/console asset:install
npm install
chmod 777 var/cache/* -R
chmod 777 web/img/photos/ -R