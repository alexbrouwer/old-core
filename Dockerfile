FROM php:7.2-alpine

ARG HOST_UID=${HOST_UID:-4000}
ARG HOST_USER=${HOST_USER:-nodummy}
RUN if [ "${HOST_USER}" -ne "root" ]; then adduser -D -u ${HOST_UID} ${HOST_USER} ;fi

RUN apk update \
    && apk add --no-cache \
        unzip

RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apk del --purge $PHPIZE_DEPS

USER ${HOST_USER}

WORKDIR /opt/project
