FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
      libpng-dev \
      libzip-dev \
      libicu-dev \
      libzip4 \
      # We want to get some files from web anyway
      wget \
      # Text editor, quite niche
      joe \
      # ZIP is too popular to not have it
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

# Point to mounted directory
WORKDIR /app

# Make everything as `application` user for security
RUN addgroup --gid 1000 application
RUN adduser --ingroup application --shell /bin/bash application
USER application

# Nice bash prompt because why not
RUN wget "https://raw.githubusercontent.com/sebastianluczak/linux-helpers/main/bash/.bashrc" -O ~/.bashrc

# Expose and keep it running
EXPOSE 9000
CMD ["php-fpm"]