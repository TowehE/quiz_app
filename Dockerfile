FROM richarvey/nginx-php-fpm:latest

WORKDIR /var/www/html

COPY . /var/www/html

COPY nginx-site.conf /etc/nginx/sites-available/default.conf

RUN chmod +x start.sh 

RUN chown -R www-data:www-data /var/www/html

ENV WEBROOT /var/www/html/public

ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/var/www/html/start.sh"]