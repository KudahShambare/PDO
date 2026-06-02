FROM php:8.2-apache

# Install zip, unzip and PDO MySQL
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN composer install --no-dev --no-interaction --prefer-dist

# Point Apache to customers.php as the default file
RUN echo "DirectoryIndex customers.php" >> /etc/apache2/apache2.conf
RUN echo '<Directory /var/www/html/api>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

# Set document root to /api folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/api
RUN sed -i 's|/var/www/html|${APACHE_DOCUMENT_ROOT}|g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80