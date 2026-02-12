FROM php:8.4-cli

RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip curl \
    libicu-dev libzip-dev \
  && docker-php-ext-install intl zip pdo_mysql \
  && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

RUN curl -sS https://get.symfony.com/cli/installer | bash \
  && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

WORKDIR /var/www/html