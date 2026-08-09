# syntax=docker/dockerfile:1

# =============================================================================
# Stage 1 — frontend assets
#
# Tailwind scans resources/**, so the Blade templates must be present at build
# time or every utility class is purged out of the stylesheet.
# =============================================================================
FROM node:22-alpine AS assets

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY vite.config.js tailwind.config.js postcss.config.js ./
COPY resources ./resources

RUN npm run build


# =============================================================================
# Stage 2 — PHP dependencies
#
# Kept separate so a change to application code does not re-resolve Composer.
# --no-dev drops PHPUnit, Pint, Sail and Collision from the runtime image.
# =============================================================================
FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
        --no-dev \
        --no-scripts \
        --no-autoloader \
        --prefer-dist \
        --no-interaction

COPY . .
RUN composer dump-autoload --optimize --no-dev


# =============================================================================
# Stage 3 — runtime
#
# php:8.3-apache with mod_php. Apache rather than nginx+fpm because this is a
# single-container app and the repo is already Apache-shaped (.htaccess files).
# =============================================================================
FROM php:8.3-apache AS runtime

# libpng/libjpeg/freetype back GD; libzip backs ext-zip.
RUN apt-get update && apt-get install -y --no-install-recommends \
        libzip-dev \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_mysql \
        zip \
        gd \
        opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# GD is needed for the server-side print-file rendering the DIY designer will
# do; the rest are Laravel's own requirements plus MySQL connectivity.

RUN a2enmod rewrite headers

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY docker/php/php.ini /usr/local/etc/php/conf.d/99-astee.ini

WORKDIR /var/www/html

# Application code, then the artefacts from the earlier stages.
COPY --chown=www-data:www-data . .
COPY --from=vendor --chown=www-data:www-data /app/vendor ./vendor
COPY --from=assets --chown=www-data:www-data /app/public/build ./public/build

# .dockerignore strips the contents of these directories so host runtime state
# never leaks into the image — which also strips the .gitignore files that keep
# them in version control, so they must be recreated. Laravel aborts with
# "Please provide a valid cache path" if storage/framework/views is missing.
RUN mkdir -p \
        storage/app/public \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R ug+rwX storage bootstrap/cache

COPY docker/entrypoint.sh /usr/local/bin/entrypoint
# Strip CR bytes before making it executable. This repo is developed on Windows,
# and a CRLF shell script fails inside the container with an opaque
# "bash\r: no such file or directory" or "$'\r': command not found". Normalising
# here makes the build independent of the host's line endings and git config.
RUN sed -i 's/\r$//' /usr/local/bin/entrypoint \
    && chmod +x /usr/local/bin/entrypoint

EXPOSE 80

# /up is Laravel's health endpoint, registered in bootstrap/app.php.
HEALTHCHECK --interval=30s --timeout=5s --start-period=20s --retries=3 \
    CMD curl -fsS http://localhost/up || exit 1

ENTRYPOINT ["entrypoint"]
CMD ["apache2-foreground"]
