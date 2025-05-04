# Usa a imagem oficial do PHP com FPM
FROM php:8.2-fpm

# Instala dependências, incluindo libpq-dev para Postgres
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
  && docker-php-ext-install pdo pdo_mysql pdo_pgsql gd

# Define o diretório de trabalho
WORKDIR /var/www

# Copia os arquivos do Laravel
COPY . .

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instala as dependências do Laravel
RUN composer install --no-dev --optimize-autoloader

# Ajusta permissões
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
 && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Expõe porta 10000
EXPOSE 10000

# Comando de start
CMD php artisan serve --host=0.0.0.0 --port=10000
