# Audibleecoscience.org

[![Build Status](https://www.travis-ci.com/IGBIllinois/audibleecoscience.svg?branch=master)](https://www.travis-ci.com/IGBIllinois/audibleecoscience)

Website: [https://audibleecoscience.org](https://audibleecoscience.org)

Audibleecoscience is a database of podcasts on subjects related to global change biology. It is designed as a resource for the general public and for educators looking to assign "required listening" to their students. Reviews of each podcast and links to the original source have been provided by students taking the IB107 class at the University of Illinois. The database is fully text searchable or you can browse on your favorite subject...

## Requirements
* Apache
* PHP
* PHP MYSQL
* MySQL/MariaDB >= 5.5

## Installation
* Git clone repository or download a tag release
```
git clone https://github.com/IGB-UIUC/audibleecoscience audibleecoscience
```
* Create mysql database
```
CREATE DATABASE audiblecoscience CHARACTER SET utf8;
```
* Create Mysql user with insert,update,select,delete privileges on the database
```
CREATE USER 'audibleecoscience'@'localhost' IDENTIFIED BY 'STRONG_PASSWORD';
GRANT SELECT,INSERT,DELETE,UPDATE ON posting_log.* to 'audibleecoscience'@'localhost';
```
* Import database structure
```
mysql -u root -p audibleecoscience < sql/audibleecoscience.sql
```

* Add apache config to apache configuration to point ot the html directory
```
Alias /audibleecoscience /var/www/audibleecoscience/html
<Directory /var/www/audibleecoscience/html>
	Options FollowSymLinks
	AllowOverride All
	Require all granted
</Directory>
```
* Copy conf/settings.inc.php.dist to conf/settings.inc.php
```
cp conf/settings.inc.php.dist conf/settings.inc.php
```
* Edit conf/settings.inc.php to have database settings
* Run composer to install depedencies
```
composer install
```

