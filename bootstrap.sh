#!/bin/bash
set -e

timedatectl set-timezone 'America/Mexico_City'

# curl -fsSL https://github.com/memiux/cloud/tarball/master | tar --strip 1 -xzC $(mkdir -p ~/.cloud; echo $_)
curl -sL https://deb.nodesource.com/setup_6.x | sudo -E bash -

apt-get install -y build-essential nodejs ruby2.3 vsftpd
gem2.3 install sass -v 3.4.23 --no-ri --no-rdoc
npm install -g uglify-js --depth=0


# printf "\n" | pecl install imagick
# su vagrant -c 'cd /vagrant && composer.phar install'
mysql -u root -p123 -e "CREATE DATABASE IF NOT EXISTS bkt_odp CHARACTER SET utf8 COLLATE utf8_general_ci;" &> /dev/null
systemctl restart vsftpd

echo "Done"

# /usr/local/sbin/php-fpm --nodaemonize
# /usr/local/bin/httpd -D NO_DETACH
# sudo tail -f /var/log/syslog /var/log/mysql/error.log /tmp/*.log /vagrant/public/site/assets/logs/*.txt