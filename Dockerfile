FROM php:8.1.1-fpm-buster

ENV ACCEPT_EULA=Y

# Copy composer.lock and composer.json
COPY src/composer.lock src/composer.json /var/www/

# Set working directory
WORKDIR /var/www

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install apt-utils libxml2-dev gnupg apt-transport-https \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    freetds-dev \
    default-mysql-client default-libmysqlclient-dev \
    libpng-dev libjpeg62-turbo-dev jpegoptim optipng pngquant gifsicle \
    libfreetype6-dev \
    locales locales-all \
    vim \
    git \
    curl wget \
    zip unzip libzip-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql pdo_dblib intl bcmath zip

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY src/ /var/www

# Copy existing application directory permissions
COPY --chown=www:www src /var/www

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
