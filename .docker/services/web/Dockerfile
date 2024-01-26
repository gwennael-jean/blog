FROM php:8.1-apache

ENV COMPOSER_ALLOW_SUPERUSER=1

ARG USER_ID
ARG GROUP_ID

ARG GRAV_VERSION=1.7.0

EXPOSE 80

RUN apt-get update
RUN apt-get install -y \
        zlib1g-dev \
        libicu-dev \
        libzip4 \
        git-core \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        g++ \
        unzip \
        cron

RUN if [ ${USER_ID:-0} -ne 0 ] && [ ${GROUP_ID:-0} -ne 0 ]; then \
    userdel -f www-data &&\
    if getent group www-data ; then groupdel www-data; fi &&\
    groupadd -g ${GROUP_ID} www-data &&\
    useradd -l -u ${USER_ID} -g www-data www-data &&\
    install -d -m 0755 -o www-data -g www-data /home/www-data &&\
    chown --changes --silent --no-dereference --recursive --from=33:33 ${USER_ID}:${GROUP_ID} \
        /home/www-data \
;fi

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN pecl install apcu xdebug

RUN docker-php-ext-configure gd --enable-gd --with-jpeg --with-freetype
RUN docker-php-ext-configure intl
RUN docker-php-ext-install zip gd intl opcache
RUN docker-php-ext-enable apcu xdebug

RUN rm -rf /var/lib/apt/lists/*

COPY conf/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY conf/apache.conf /etc/apache2/conf-available/app.conf
COPY conf/php.ini /usr/local/etc/php/conf.d/app.ini

RUN a2enmod rewrite remoteip && a2enconf app

USER www-data

WORKDIR /home/www-data/app

COPY --from=composer:2.6.6 /usr/bin/composer /usr/local/bin/composer

RUN curl -o /home/www-data/grav.zip -SL https://getgrav.org/download/core/grav/${GRAV_VERSION} && \
       unzip /home/www-data/grav.zip -d /home/www-data && \
       mv -T /home/www-data/grav /home/www-data/app && \
       rm /home/www-data/grav.zip

#RUN (crontab -l; echo "* * * * * /usr/local/bin/php /home/www-data/app/bin/grav scheduler 1>> /dev/null 2>&1") | crontab -

#CMD ["sh", "-c", "cron && apache2-foreground"]