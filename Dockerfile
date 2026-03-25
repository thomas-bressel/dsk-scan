FROM php:8.4-apache-bookworm

# Mettre à jour les paquets système pour corriger les vulnérabilités connues
RUN apt-get update && apt-get upgrade -y && rm -rf /var/lib/apt/lists/*

# Extensions nécessaires
RUN docker-php-ext-install fileinfo

# Activer mod_rewrite
RUN a2enmod rewrite

# Copier le projet dans le dossier web Apache
COPY . /var/www/html/

# Droits sur le dossier d'upload
RUN mkdir -p /var/www/html/files \
    && chown -R www-data:www-data /var/www/html/files \
    && chmod 755 /var/www/html/files

# Configuration Apache : autoriser .htaccess
RUN echo '<Directory /var/www/html>\n\
    Options FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/dsk-viewer.conf \
    && a2enconf dsk-viewer

EXPOSE 80
