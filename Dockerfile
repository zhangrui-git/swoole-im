FROM composer/composer as composer
FROM phpswoole/swoole:4.8-php7.4-alpine
LABEL authors="Zhang Rui"
COPY --from=composer /usr/bin/composer /usr/bin/composer
EXPOSE 8080/tcp
WORKDIR /app
ADD . .
RUN composer require
ENTRYPOINT ["php", "im", "server"]