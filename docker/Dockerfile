FROM php:8.0.1-apache-buster

USER root

WORKDIR /var/www

COPY config/apache/projects.conf /etc/apache2/sites-available/projects.conf
# Install composer
RUN \
    apt-get update && apt-get -y install wget && apt-get install -y git &&\
    docker-php-ext-install pdo_mysql &&\
    a2enmod rewrite && \
    a2ensite projects && \
    echo '- Installing composer ...' && \
    EXPECTED_SIGNATURE="$(wget -q -O - https://composer.github.io/installer.sig)"; \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"; \
    ACTUAL_SIGNATURE="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"; \
    [ "$EXPECTED_SIGNATURE" != "$ACTUAL_SIGNATURE" ] && { >&2 echo 'ERROR: Invalid installer signature'; exit 1; }; \
    php composer-setup.php --quiet --install-dir=/bin --filename=composer && \
    rm composer-setup.php


