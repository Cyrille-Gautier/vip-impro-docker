#!/bin/bash

ln -snf /usr/share/zoneinfo/Europe/Paris /etc/localtime && echo 'Europe/Paris' > /etc/timezone

#php /var/www/bin/console assets:install src && chown www-data: -R /var/www/src &

# update certificates
chmod 644 /usr/local/share/ca-certificates/ca.crt && update-ca-certificates

#On start Apache
source /etc/apache2/envvars
exec apache2 -D FOREGROUND
