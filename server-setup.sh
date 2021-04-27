# UPDATE REPOSITORIES
add-apt-repository ppa:ondrej/apache2 -y
add-apt-repository ppa:ondrej/php -y
apt-get update
apt-get dist-upgrade -Vy
apt-get autoremove --purge -Vy

# INSTALL REQUIRED PHP EXTENSIONS
apt-get install -Vy apache2 php php-common php-mysql php-curl php-mbstring php-xml php-json php-gd
apt-get clean

# ENABLE REQUIRED APACHE MODULES
a2enmod rewrite ssl http2 headers deflate negotiation
service apache2 restart

# PHP COMPOSER
wget -v https://getcomposer.org/installer -O ~/composer-setup.php
php ~/composer-setup.php --install-dir=/usr/local/bin --filename=composer
rm -f ~/composer-setup.php
composer install -v
composer clear-cache

# LARAVEL SPECIFICS
chmod -R 0777 bootstrap storage
cp .env.example .env
php artisan key:generate
php artisan storage:link
