# Usar la imagen oficial de PHP 8
FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    git \
    libpcre3-dev \
    lsb-release \
    ca-certificates \
    apt-transport-https \
    software-properties-common \
    && rm -rf /var/lib/apt/lists/*

# Add Phalcon Repository
RUN curl -fsSL https://packagecloud.io/gpg.key | gpg --dearmor -o /usr/share/keyrings/phalcon-keyring.gpg \
    && echo "deb [signed-by=/usr/share/keyrings/phalcon-keyring.gpg] https://packagecloud.io/phalcon/stable/ubuntu $(lsb_release -cs) main" \
    | tee /etc/apt/sources.list.d/phalcon.list

# Install PHP extensions and Phalcon
RUN apt-get update && apt-get install -y php8.2-phalcon

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHPUnit globally
RUN composer global require phpunit/phpunit:^10.0 --prefer-dist --no-progress --no-suggest

# Set working directory
WORKDIR /workspace

# Expose ports (if needed)
EXPOSE 9000

# Set default command
CMD [ "php", "-a" ]