# Usar la imagen oficial de PHP 8
FROM php:8.2-cli

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpcre3-dev \
    && docker-php-ext-install zip mbstring pdo_mysql

# Establecer el directorio de trabajo
WORKDIR /workspace

USER codespace

# Instalar Phalcon
RUN pecl install phalcon \
    && docker-php-ext-enable phalcon

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar dependencias de Composer
RUN composer install

# Exponer el puerto 8080 (opcional, si usas un servidor web)
EXPOSE 8080

# Comando por defecto (opcional)
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]