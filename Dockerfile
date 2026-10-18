FROM php:8.3-apache
RUN docker-php-ext-install mysqli && a2enmod headers
COPY app/ /var/www/html/
RUN printf '%s\n' '<Directory /var/www/html>' 'Options -Indexes' 'AllowOverride None' 'Require all granted' '</Directory>' > /etc/apache2/conf-available/leaderboard.conf && a2enconf leaderboard
