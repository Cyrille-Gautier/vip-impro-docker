# Install VIP Impro Docker
https://www.vip-impro.fr

## Installation du projet
Via une ligne de commande sous linux
    git clone https://https://github.com/Cyrille-Gautier/vip-impro-docker vip-impro-docker
    cd vip-impro-docker
    make install

## Informations sur le projet
Le projet en mode dev est disponible à l'url : https://vip-impro.valeur-et-capital.localhost

## 1./ Importer

/docker/
/Makefile
/docker-compose.yml
/src/data

## 2./ Modifier fichiers

-- wp-config
define('DB_PASSWORD', 'root');
define('DB_HOST', 'host.docker.internal');

-- Makefile

docker-compose exec --user www-data php bash -c 'php wp-installer/install.php dev https://vip-impro.valeur-et-capital.localhost'
ou
docker-compose exec --user www-data php bash -c 'php installer/install.php install dev https://vip-impro.valeur-et-capital.localhost vip-impro'

remplacer les
docker-compose exec php bash
par
docker-compose exec --user www-data php bash

-- docker-compose.yml
labels:
- traefik.frontend.rule=Host:vip-impro.valeur-et-capital.localhost

-- wp-installer/install.php
retirer les lignes 1560-1576

-- docker/local/php/Dockerfile
Changer version de php pour matcher avec la prod
FROM wordpress:php7.4-apache
Définir user par défaut
remplacer
RUN usermod -u 1000 www-data
par
RUN usermod --uid=1000 www-data && \
groupmod --gid=1000 www-data && \
chown -R www-data:www-data /var/www/

## 3./ Lancer

make install

## 4./ Cas de too many redirects

Voir si le WP-config  correspond à
if (php_sapi_name() !== 'cli') {
$_SERVER['HTTP_HOST'] = $_SERVER['HTTP_X_FORWARDED_HOST'] ?? $_SERVER['HTTP_HOST'];
$_SERVER['REQUEST_SCHEME'] = $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? $_SERVER['REQUEST_SCHEME'];

    if ($_SERVER['REQUEST_SCHEME'] === 'https') {
        $_SERVER['HTTPS'] = 'on';
    }
}
if (!$environnement && php_sapi_name() !== 'cli') {

    $environnement = 'production';
    $url = ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? $_SERVER['REQUEST_SCHEME']) . '://' . ($_SERVER['HTTP_X_FORWARDED_HOST'] ?? $_SERVER['HTTP_HOST']);
    if (strpos($url, 'staging-') !== false || strpos($url, '.qualif') !== false) {
        $environnement = 'qualif';
    }

    if (strpos($url, '.local') !== false || strpos($url, '.localhost') !== false) {
        $environnement = 'dev';
    }
}


## 5./ Tools
git submodule update --init --remote --recursive
git submodule foreach --recursive git checkout master 