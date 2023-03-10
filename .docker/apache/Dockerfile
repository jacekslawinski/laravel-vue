FROM php:8.1.10-apache
COPY ./apache.conf /etc/apache2/sites-enabled/000-default.conf

ARG user
ARG uid

RUN a2enmod rewrite
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user
RUN apt-get update && apt-get install -y \
    bash \
    git \
    zip \
    software-properties-common \
    npm \
 && pecl install xdebug-3.1.5
RUN docker-php-ext-install mysqli pdo_mysql && docker-php-ext-enable pdo_mysql mysqli xdebug
RUN npm install npm@latest -g && \
    npm install n -g && \
    n latest
COPY ./xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
WORKDIR /home/project
USER $user
ENTRYPOINT ["/home/project/bin/build.sh"]
