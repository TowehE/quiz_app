# Use a robust base image that includes PHP, Nginx, and Composer
FROM richarvey/nginx-php-fpm:latest

# Set the working directory for the application
WORKDIR /var/www/html

# Copy all your application files into the container
COPY . /var/www/html

# 💥 FIX FOR NGINX 404: Copy the custom Nginx config and replace the default one
COPY nginx-site.conf /etc/nginx/sites-available/default.conf

# Ensure the startup script is executable (Fixes Status 126)
RUN chmod +x start.sh 

# Fix permissions for the web server user
RUN chown -R www-data:www-data /var/www/html

# Set the webroot to the 'public' directory, standard for Laravel
ENV WEBROOT /var/www/html/public

# Allow Composer to run as root user during the build/start process
ENV COMPOSER_ALLOW_SUPERUSER 1

# Define the command to run the start.sh script
CMD ["/var/www/html/start.sh"]