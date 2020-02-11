ARG TARGET_PHP_VERSION=7.4
FROM php:${TARGET_PHP_VERSION}-cli-alpine

ARG SERVICE_DIR="./.docker/workspace"

###########################################################################
# non-root user:
###########################################################################

ARG APP_USER=app
ARG APP_GROUP=app
ARG APP_USER_ID=1000
ARG APP_GROUP_ID=1000
RUN addgroup -g ${APP_GROUP_ID} -S ${APP_GROUP} \
	&& adduser -u ${APP_USER_ID} -S ${APP_USER} -G ${APP_GROUP}

###########################################################################
# Set Timezone
###########################################################################

ARG TZ=UTC
ENV TZ ${TZ}

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

###########################################################################
# PHP extras
###########################################################################

# install php extensions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

RUN install-php-extensions xdebug zip

RUN apk update && apk add --no-cache make g++ autoconf \
    && docker-php-source extract \
    && pecl install ds \
    && docker-php-ext-enable ds \
    && docker-php-source delete \
    && apk del make g++ autoconf && rm -rf /tmp/*

# php config
COPY ${SERVICE_DIR}/config/php/conf.d/*  /usr/local/etc/php/conf.d/

###########################################################################
# Composer
###########################################################################

# install composer
RUN apk update \
	&& apk add --no-cache git curl \
	&& curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && rm -rf /tmp/*

USER ${APP_USER}

# speedup composer installs
RUN composer global require --no-suggest --no-interaction hirak/prestissimo

# make sure PATH contains all composer scripts
ENV PATH="~/.composer/vendor/bin:${PATH}"

###########################################################################
# Working directory
###########################################################################

USER root

# Make sure app directory has correct ownership
ARG APP_CODE_PATH="/app"
RUN mkdir ${APP_CODE_PATH} \
	&& chown ${APP_USER}:${APP_GROUP} ${APP_CODE_PATH} \
	&& chmod 775 ${APP_CODE_PATH} \
    && mkdir /opt/phpstorm-coverage \
    && chown ${APP_USER}:${APP_GROUP} /opt/phpstorm-coverage \
    && chmod 775 /opt/phpstorm-coverage

WORKDIR ${APP_CODE_PATH}

###########################################################################
# Project
###########################################################################

# execute below as non-root user
USER ${APP_USER}

# make sure PATH contains all composer scripts
ENV PATH="./vendor/bin:${PATH}"

