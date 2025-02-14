# Usar la imagen oficial de PHP 8
FROM php:8.2-cli

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install zip mbstring pdo_mysql

# Establecer el directorio de trabajo
WORKDIR /workspace

USER codespace

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN groupadd --gid $USER_GID $USERNAME \
    && useradd --uid $USER_UID --gid $USER_GID -m $USERNAME \
    && apt-get update \
    && apt-get install -y sudo \
    && echo $USERNAME ALL=\(root\) NOPASSWD:ALL > /etc/sudoers.d/$USERNAME \
    && chmod 0440 /etc/sudoers.d/$USERNAME

# Cambiar al usuario no root
USER $USERNAME

# Instalar dependencias de Composer
RUN composer install

# Exponer el puerto 8080 (opcional, si usas un servidor web)
EXPOSE 8080

# Comando por defecto (opcional)
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]