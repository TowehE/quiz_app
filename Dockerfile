# Use a robust base image that includes PHP, Nginx, and Composer
FROM richarvey/nginx-php-fpm:latest

# Set the working directory for the application
WORKDIR /var/www/html

# Copy all your application files into the container
COPY . /var/www/html

# 💥 NEW LINE: Ensure the startup script is executable 
RUN chmod +x start.sh 
# You should also apply this to the copied code, though the base image 
# often handles this for its user:
RUN chown -R www-data:www-data /var/www/html 

# Set the webroot to the 'public' directory, standard for Laravel
ENV WEBROOT /var/www/html/public

# Allow Composer to run as root user during the build/start process
ENV COMPOSER_ALLOW_SUPERUSER 1

# Define the command to run the start.sh script
CMD ["/var/www/html/start.sh"]