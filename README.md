# Vermis
Open Source issue tracker and project management tool for software developers and project managers. Designed as a web application written in PHP.


## How to install Vermis

### Requirements

PHP 5.4.X (or newer) - (for 5.3 you need to set short_open_tag=On in php.ini)
MySQL 5.X
Apache HTTP Server (or compatible)
mod_rewrite (or compatible)



### Installation

* Download the vermis sources from http://https://github.com/koweb/Vermis

* Unpack it to your public_html directory (or different) used by your web server.

* Create a new MySQL database or use an existing one.
For example:

```
CREATE DATABASE vermis;
GRANT ALL PRIVILEGES ON vermis.* to vermis@localhost identified by 'vermis';
```

* Copy config/sample.config.php to config/config.php and edit values inside.

* Import SQL database.

```
mysql vermis --user=vermis --password=vermis < database.sql
```

* Create directories and set permissions to them.

```
mkdir _vermis/upload
mkdir _vermis/upload/tmp
mkdir _vermis/upload/issues
mkdir _vermis/captcha
mkdir _vermis/log
chmod -R ugo=rwx _vermis/upload _vermis/captcha _vermis/log
```

* Web server configuration

  * Apache

    * Make sure that your Apache web server has mod_rewrite enabled, and in your vhost settings there is a following line:

```
AllowOverride All
```

  * IIS

TODO

  * NGINX

TODO

* Run vermis from a web browser and login with username admin and password admin :)