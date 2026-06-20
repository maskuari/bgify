FROM php:8.3-cli-bookworm

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    nodejs \
    npm \
    python3 \
    python3-pip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libgomp1 \
    libglib2.0-0 \
    libgl1 \
    && docker-php-ext-install zip mbstring xml pdo pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN rm -f public/hot

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN npm ci && npm run build

RUN python3 -m pip install --break-system-packages "rembg[cpu]" pillow onnxruntime

RUN cp .env.example .env \
    && php artisan key:generate --force \
    && mkdir -p storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && php artisan storage:link || true \
    && chmod -R 777 storage bootstrap/cache

ENV APP_ENV=production
ENV APP_DEBUG=false
ENV APP_URL=https://maskuari-bgify.hf.space
ENV ASSET_URL=https://maskuari-bgify.hf.space
ENV BGIFY_PYTHON_BINARY=python3
ENV BGIFY_PROCESS_TIMEOUT=120

EXPOSE 7860

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=7860"]

