FROM php:8.2-cli

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip unzip curl git \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instala Node.js (para Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Define diretório de trabalho
WORKDIR /var/www

# Copia os arquivos
COPY . .
COPY .env .env
COPY  package.json pnpm-lock.yaml ./

RUN npm i -g npm@latest; \
 # Install pnpm
 npm install -g pnpm; \
 pnpm --version; \
 pnpm setup; \
 mkdir -p /usr/local/share/pnpm &&\
 export PNPM_HOME="/usr/local/share/pnpm" &&\
 export PATH="$PNPM_HOME:$PATH"; 

# Instala dependências PHP e JS
RUN composer install
RUN npm install && npm run dev

# Permissões
RUN chown -R www-data:www-data /var/www
RUN chmod -R 775 /var/www/storage
#RUN php artisan serve --host 0.0.0.0


CMD ["php", "artisan", "serve", "--host=127.0.0.1", "--port=8000"]
