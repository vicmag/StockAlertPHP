FROM php:8.2-cli

# Instala solo lo absolutamente esencial primero
RUN apt-get update && apt-get install -y \
    python3 \
    python3-venv \
    && rm -rf /var/lib/apt/lists/*

# Configura un entorno virtual Python
RUN python3 -m venv /opt/venv
ENV PATH="/opt/venv/bin:$PATH"

# Instala pip en el entorno virtual
RUN /opt/venv/bin/python -m pip install --upgrade pip

# Ahora instala las dependencias de Python
RUN pip install requests

# Resto de instalaciones (PHP, Composer, etc.)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    && rm -rf /var/lib/apt/lists/*

RUN pecl install xdebug \
  && docker-php-ext-enable xdebug


RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

RUN composer global require phpunit/phpunit:^10.0

WORKDIR /workspace
EXPOSE 9000
CMD ["php", "-a"]