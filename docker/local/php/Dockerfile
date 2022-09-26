FROM wordpress:php7.4-apache

RUN a2enmod rewrite

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN apt-get update && apt-get install -y default-mysql-client git libzip-dev zip unzip
RUN docker-php-ext-install mysqli
RUN docker-php-ext-enable mysqli
RUN docker-php-ext-install pdo_mysql

# composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY docker/local/php/qualifintra.crt /usr/local/share/ca-certificates/ca.crt
COPY docker/api.pure-gestion.valeur-et-capital.conf /etc/apache2/sites-available/000-default.conf
COPY docker/custom.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker/local/php/entrypoint.sh /usr/bin/entrypoint.sh

#CLEANING
RUN apt-get autoclean && apt-get autoremove && rm -rf /var/lib/apt/lists/*

RUN usermod --uid=1000 www-data && \
    groupmod --gid=1000 www-data && \
    chown -R www-data:www-data /var/www/
RUN chmod +x /usr/bin/entrypoint.sh

CMD ["/usr/bin/entrypoint.sh"]
