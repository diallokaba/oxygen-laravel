# 1. Utiliser une image PHP officielle avec la version correcte et Composer
FROM php:8.1-fpm

# 2. Installer des dépendances système pour que Laravel fonctionne bien
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl gd

# 3. Installer Composer pour la gestion des dépendances PHP
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4. Définir le répertoire de travail dans le conteneur
WORKDIR /var/www/html

# 5. Copier le fichier composer.json et installer les dépendances Laravel
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

# 6. Copier tout le projet dans le conteneur et finaliser l'installation Composer
COPY . .
RUN composer dump-autoload --optimize


# 7. Configurer les permissions pour le stockage et le cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 8. Exposer le port que l’application Laravel utilise
EXPOSE 8000

# 9. Commande de démarrage pour PHP-FPM
CMD ["php-fpm"]
