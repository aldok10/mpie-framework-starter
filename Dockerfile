ARG COMPOSER_VERSION=latest

###########################################
# PHP dependencies
###########################################
FROM composer:${COMPOSER_VERSION} AS vendor

ENV GITHUB_TOKEN=${GITHUB_TOKEN:-GITHUB_TOKEN}

WORKDIR /www

COPY composer* ./

RUN composer config --global \
    github-oauth.github.com ${GITHUB_TOKEN}

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --ignore-platform-reqs \
    --optimize-autoloader \
    --apcu-autoloader \
    --ansi \
    --no-scripts

###########################################
# build base image openswoole
###########################################
FROM akarendra835/web-srv:openswoole.v4.12.0

WORKDIR /www

COPY . /www

COPY --from=vendor ${ROOT}/vendor ./vendor

EXPOSE 8989

CMD php81 bin/openswoole.php
