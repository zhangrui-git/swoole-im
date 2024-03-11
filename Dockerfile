FROM composer/composer as composer
ONBUILD RUN install
FROM phpswoole/swoole:4.8-php7.4-alpine
LABEL authors="Zhang Rui"
COPY --from=composer /usr/bin/composer /usr/bin/composer
ADD . /app/
WORKDIR /app/
RUN composer install
EXPOSE 8080/tcp
ENTRYPOINT ["php", "im", "server"]