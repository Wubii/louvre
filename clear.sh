#!/bin/sh

rm -fr var/cache
rm -fr var/logs
rm -fr var/sessions
rm -fr web/media/cache


mkdir var/cache
mkdir var/logs
mkdir var/sessions

chmod 777 var/cache
chmod 777 var/logs
chmod 777 var/sessions

php bin/console cache:clear
php bin/console cache:clear --env=prod

#php bin/console assets:install web
php bin/console assets:install --symlink web

chown -R www-data:www-data var/cache
chown -R www-data:www-data var/logs
chown -R www-data:www-data var/sessions
chown -R www-data:www-data web
