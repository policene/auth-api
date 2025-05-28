FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql

COPY . /var/www/html/

EXPOSE 8000
CMD ["php", "-S", "0.0.0.0:8000", "-t", "/var/www/html"]