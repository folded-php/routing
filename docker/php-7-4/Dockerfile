FROM php:7.4-apache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
	pecl install xdebug && \
	echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini && \
	echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini && \
	echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

EXPOSE 80
