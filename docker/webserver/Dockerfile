FROM php:7.4.0-apache


#ESSE DOCKER É COM PHP 7.4 PARA FUNCIONAR O GD

# packages
RUN apt-get update \
  && DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
  # needed for gd
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libpng-dev \
  && rm -rf /var/lib/apt/lists/*

RUN apt-get update -y && apt-get install -y libpng-dev curl libcurl4-openssl-dev
RUN apt-get install -y vim
RUN docker-php-ext-install pdo pdo_mysql gd curl
RUN a2enmod rewrite

# GD
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

