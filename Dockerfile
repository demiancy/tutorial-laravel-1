FROM php:8.1.3-apache-buster

ARG USER=docker
ARG USER_UID=1000
ARG USER_GID=$USER_UID

RUN apt-get update && apt-get install -y \
    git zip apt-utils zlib1g-dev libpng-dev libzip-dev default-mysql-client

RUN docker-php-ext-install mysqli pdo pdo_mysql gd zip

#INSTALL COMPOSER
RUN set -xe \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === '906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php --install-dir=/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

#Instala Node Js
RUN set -xe \
    && apt-get install -y curl software-properties-common \
    && curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - \
    && apt-get install -y nodejs \ 
    && npm install -g npm

#APACHE CONFIG
ENV APACHE_DOCUMENT_ROOT /home/${USER}
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

### SETUP CURRENT USER ###
RUN useradd -m ${USER} --uid=${USER_UID} | chpasswd
USER ${USER_UID}:${USER_GID}
WORKDIR /home/${USER}

CMD php artisan serve --port=80 --host=0.0.0.0

