FROM php:8.1.3-fpm-buster
ARG TIMEZONE
COPY php.ini /usr/local/etc/php/conf.d/docker-php-config.ini
RUN apt-get update && apt-get install -y \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    acl \
    mcrypt \
    libmcrypt-dev \
    libreadline-dev \
    tzdata \
    nodejs \
    npm \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc
RUN docker-php-ext-configure gd --with-jpeg --with-freetype
RUN docker-php-ext-install \
    pdo pdo_mysql zip xsl gd intl opcache exif mbstring calendar soap
RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis
# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /usr/share/nginx/html
