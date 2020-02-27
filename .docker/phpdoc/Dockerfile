FROM php:7.2-cli-alpine

ARG SERVICE_DIR="./.docker/phpdoc"

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

RUN install-php-extensions intl zip

RUN apk update && apk add --no-cache graphviz \
    && rm -rf /tmp/*

# php config
COPY ${SERVICE_DIR}/config/php/conf.d/*  /usr/local/etc/php/conf.d/

###########################################################################
# PHPDOC
###########################################################################

COPY --from=phpdoc/phpdoc:3 /opt/phpdoc /opt/phpdoc

RUN mkdir -p /opt/phpdoc/var \
    && chmod -R 777 /opt/phpdoc/var

COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN cd /opt/phpdoc \
    && /usr/bin/composer require phpdocumentor/reflection:dev-master

# execute below as non-root user
USER ${APP_USER}


WORKDIR /data
VOLUME /data

ENV PHPDOC_ENV=prod
ENV PATH="/opt/phpdoc/bin:${PATH}"

#ENTRYPOINT ["/opt/phpdoc/bin/phpdoc"]

#CMD ["help", "run"]