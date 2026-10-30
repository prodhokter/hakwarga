FROM dunglas/frankenphp:1-php8.3-alpine

# Install required PHP extensions for Laravel + PostgreSQL
RUN install-php-extensions \
    pdo_pgsql \
    pgsql \
    intl \
    zip \
    gd \
    bcmath \
    opcache

WORKDIR /app

# Copy all application code
COPY . /app

# Ensure proper permissions for Laravel cache and storage
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache \
    && chmod -R 775 /app/storage /app/bootstrap/cache

ENV SERVER_NAME=":80"
ENV SERVER_ROOT="public/"
ENV APP_ENV=production
ENV APP_DEBUG=false

EXPOSE 80

CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]
