FROM composer/composer as composer
FROM phpswoole/swoole:4.8-php7.4-alpine
LABEL authors="Zhang Rui"
COPY --from=composer /usr/bin/composer /usr/bin/composer
EXPOSE 8080/tcp
VOLUME /app
WORKDIR /app
ENTRYPOINT ["php", "im", "server"]