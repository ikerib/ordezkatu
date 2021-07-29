#FROM php:7.4-fpm
FROM php:7.4.21-fpm-alpine3.13

ARG USER_ID=1000
ARG GROUP_ID=1000
ARG DOCKER_TIMEZONE=${DOCKER_TIMEZONE}
ARG DEBUGMODE=0

ENV PS1="\u@\h:\w\\$ "

RUN echo "user:x:$USER_ID:$USER_ID::/home/www-data:" >> /etc/passwd \
    echo "user:!:$(($(date +%s) / 60 / 60 / 24)):0:99999:7:::" >> /etc/shadow \
    echo "user:x:$USER_ID:" >> /etc/group \
    mkdir /home/www-data && chown www-data: /home/www-data

RUN echo "${DOCKER_TIMEZONE}" > /etc/timezone

RUN echo -n "With debug:          " ; if [[ "${DEBUGMODE}" = "on" ]] ;      then echo "Yes"; else echo "No" ; fi && \
    if [ -z ${USER_ID+x} ]; then echo "USER_ID is unset"; USER_ID=1000; else echo "USER_ID is set to '$USER_ID'"; fi && \
    if [ -z ${GROUP_ID+x} ]; then echo "GROUP_ID is unset"; GROUP_ID=1000; else echo "GROUP_ID is set to '$GROUP_ID'"; fi

RUN apk update \
 && apk add --no-cache $PHPIZE_DEPS \
    bash \
    git \
    unzip libxml2-dev yarn

RUN apk add --no-cache zip libzip-dev
RUN docker-php-ext-install zip
RUN docker-php-ext-install xml

# PHP extensions
RUN docker-php-ext-install opcache pdo pdo_mysql mysqli
RUN docker-php-ext-enable opcache

# Enable GD
RUN apk add --no-cache libpng libpng-dev libjpeg-turbo-dev libwebp-dev zlib-dev libxpm-dev && docker-php-ext-install gd && apk del libpng-dev
RUN apk add --no-cache --virtual .build-dependencies $PHPIZE_DEPS \
        && pecl install apcu \
        && docker-php-ext-enable apcu \
        && pecl clear-cache \
        && apk del .build-dependencies
# Enable LDAP
RUN  apk add --update --no-cache \
          libldap && \
      # Build dependancy for ldap \
      apk add --update --no-cache --virtual .docker-php-ldap-dependancies \
          openldap-dev && \
      docker-php-ext-configure ldap && \
      docker-php-ext-install ldap && \
      apk del .docker-php-ldap-dependancies && \
      php -m;

#
RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN rm -rf /var/cache/apk/*
#
WORKDIR /usr/src/app
COPY . /usr/src/app
RUN PATH=$PATH:/usr/src/apps/vendor/bin:bin

#
#RUN userdel -f www-data &&\
#    if getent group www-data ; then groupdel www-data; fi &&\
#    groupadd -g $GROUP_ID www-data &&\
#    useradd -l -u $USER_ID -g www-data www-data &&\
#    install -d -m 0755 -o www-data -g www-data /home/www-data &&\
#	echo 'www-data ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers
#
#RUN apt-get update && apt-get install -y \
#    openssl \
#    git \
#    htop \
#    iputils-ping \
#    vim \
#    unzip locales openssh-client \
#    zlib1g-dev libonig-dev libpng-dev \
#    libxml2-dev \
#    grc \
#    && locale-gen es_ES.UTF-8 \
#    && echo "LC_ALL=es_ES.UTF-8" >> /etc/environment \
#    && echo "LANG=es_ES.UTF-8" >> /etc/environment \
#    && echo "LC_ALL=es_ES.UTF-8" >> /etc/default/locale \
#    && echo "LANG=es_ES.UTF-8" >> /etc/default/locale
#
#RUN docker-php-ext-install pdo pdo_mysql
#RUN ln -snf /usr/share/zoneinfo/${DOCKER_TIMEZONE} /etc/localtime && echo ${DOCKER_TIMEZONE} > /etc/timezone \
#&& printf '[PHP]\ndate.timezone = "%s"\n', ${DOCKER_TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
#&& "date"
#
#
##LDAP
#RUN set -x \
#    && apt-get update \
#    && apt-get install -y libldap2-dev \
#    && rm -rf /var/lib/apt/lists/* \
#    && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
#    && docker-php-ext-install ldap \
#    && apt-get purge -y --auto-remove libldap2-dev
#
## REDIS
#RUN pecl install -o -f redis \
#    &&  rm -rf /tmp/pear \
#    &&  docker-php-ext-enable redis
#
##PHP ZIP
#RUN apt-get update && apt-get install -y \
#    zlib1g-dev \
#    libcurl4-openssl-dev \
#    libzip-dev
#RUN docker-php-ext-install zip
#RUN docker-php-ext-install xml
#RUN docker-php-ext-install curl
#RUN docker-php-ext-install mbstring
#RUN docker-php-ext-install gd
#RUN docker-php-ext-install opcache
#
## APCU
#RUN pecl install apcu \
#	&& docker-php-ext-enable apcu \
#	&& (rm -rf /usr/local/lib/php/test/apcu || true) \
#	&& (rm -rf /usr/local/lib/php/doc/apcu || true)
#
## Install Composer
#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
#&& composer --version
#
## Install NodeJS
#RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - && apt-get install -y nodejs
#
## Add Yarn repository
#RUN apt-get update && apt-get install -y gnupg2
#RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
#RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list &&\
#	apt-get update -y && \
#	apt-get install yarn zsh wget -y
#
#RUN pecl install xdebug && docker-php-ext-enable xdebug
#
## zsh eta oh my zsh
#USER www-data
#RUN wget https://github.com/robbyrussell/oh-my-zsh/raw/master/tools/install.sh -O - | zsh || true
#COPY ./docker/dev/php/conf/.zshrc /home/www-data/.zshrc
#
#WORKDIR /usr/src/app
#
#COPY . /usr/src/app
#
#RUN PATH=$PATH:/usr/src/apps/vendor/bin:bin
