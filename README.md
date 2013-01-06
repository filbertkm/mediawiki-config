Configuration settings for a multiple wiki setup with a single checkout of MediaWiki

#Instructions
Checkout a copy of Wikimedia's configuration settings:

https://gerrit.wikimedia.org/r/gitweb?p=operations/mediawiki-config.git;n,z

We put the stuff in:

* /live-1.5 (specifically index.php and to symlink the extensions, skins, and other directories)
* /multiversion

Put our stuff in:

/var/www/common

Have /live-1.5 and /multiversion as subdirectories

Checkout mediawiki core as a submodule in /var/www/common/php-master

Rename /var/www/common/php-master/extensions to /var/www/common/php-master/old-extensions

Checkout the mediawiki/extensions repo into /var/www/common/php-master/extensions:

https://gerrit.wikimedia.org/r/gitweb?p=mediawiki/extensions.git;a=summary

Do git submodule update --init (to checkout all of the extensions) or
git submodule update --init Cite (for example) to checkout only certain extensions

In /var/www/common/php-master/LocalSettings.php, create the file and include:

```php
<?php
require_once( __DIR__ . '/../CommonSettings.php' );
```

In /var/www/common/php-master/PrivateSettings.php, we need the following settings:

* $wgDBuser // database user, assumed the same across all DB servers
* $wgDBpassword // database password, with assumption it's the same across all DB servers
* $wmgSiteDomain // the domain, such as "wikipedia.org"
* $wmgDBserver2 // the ip address

In /var/www/common/multiversion/multiversion/defines.php, we need:

```php
define( 'MW_SITE_DOMAIN', 'wikipedia' ); // substitute your domain name here
```
