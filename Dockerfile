# declare that you're extending this image
FROM lepiaf/docker-symfony2:latest

# who are you?
MAINTAINER Ayrton Gomes <com.ayrton@gmail.com>

# install a few more PHP extensions
RUN apt-get update && apt-get install -y php5-imagick php5-gd php5-curl php5-mcrypt php5-intl

# copy a custom config file from the directory where this Dockerfile resides to the image
# COPY php.ini /etc/php5/fpm/php.ini

# make a small change in an existing config file
RUN sed -i -e "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g" /etc/php5/fpm/php.ini