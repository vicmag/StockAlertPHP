# Use an official PHP 8.2 development image from Microsoft Dev Containers
FROM mcr.microsoft.com/devcontainers/php:8.2

# Install system dependencies required for Phalcon
RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    git \
    libpcre3-dev \
    libssl-dev \
    libxml2-dev \
    libsqlite3-dev \
    pkg-config \
    build-essential \
    re2c \
    && rm -rf /var/lib/apt/lists/*

# Install Phalcon via PECL
RUN pecl channel-update pecl.php.net \
    && pecl install phalcon \
    && echo "extension=phalcon.so" > /usr/local/etc/php/conf.d/30-phalcon.ini

# Install Composer manually
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHPUnit globally
RUN composer global require phpunit/phpunit:^10.0 --prefer-dist --no-progress --no-suggest

# Set working directory
WORKDIR /workspace

# Expose ports (if needed)
EXPOSE 9000

# Set default command
CMD [ "php", "-a" ]