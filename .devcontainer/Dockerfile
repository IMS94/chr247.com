FROM php:7.2-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    curl \
    libpq-dev

# Install Git/Curl
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring 

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Remaining Dependencies
RUN apt-get update && apt-get install -y \
    zip \
    unzip
