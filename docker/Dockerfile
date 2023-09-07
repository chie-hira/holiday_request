FROM laravelsail/php8.2

# gd拡張機能を有効にする
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd
