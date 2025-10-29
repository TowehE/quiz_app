# Use a robust base image that includes PHP, Nginx, and Composer
FROM richarvey/nginx-php-fpm:latest

# Set the working directory for the application
WORKDIR /var/www/html

# Copy all your application files into the container
COPY . /var/www/html

# Set the webroot to the 'public' directory, standard for Laravel
ENV WEBROOT /var/www/html/public

# Allow Composer to run as root user during the build/start process
ENV COMPOSER_ALLOW_SUPERUSER 1

# Define the command to run the start.sh script
CMD ["/var/www/html/start.sh"]
