FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
      libpng-dev \
      libzip-dev \
      libicu-dev \
      libzip4 \
      wget \
      zip

# Add install-php-extensions script
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

# Install required PHP extensions
RUN install-php-extensions xdebug opcache yaml http

# Install composer
RUN install-php-extensions @composer

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Nice bash prompt
RUN wget "https://gist.githubusercontent.com/zachbrowne/8bc414c9f30192067831fafebd14255c/raw/322a762de6300c6afff4469c9c73b4dd8449d394/The%2520Ultimate%2520Bad%2520Ass%2520.bashrc%2520File" -O ~/.bashrc

# Point to mounted directory
WORKDIR /app

# Expose and keep it running
EXPOSE 9000
CMD ["php-fpm"]