### clone and start with Sympfony

CLONE

 Go to the root of the course repo
rsync -av example/symfony me/kmom01
cd me/kmom01/symfony


INSTALL

composer create-project symfony/website-skeleton app
cd app
composer require webapp
composer show

RUN
php -S localhost:8888 -t public



Metrics in the mvc course
=========================

[![Build Status](https://scrutinizer-ci.com/g/nasp22/DV1608-mvc/badges/build.png?b=main)](https://scrutinizer-ci.com/g/nasp22/DV1608-mvc/build-status/main)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nasp22/DV1608-mvc/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/nasp22/DV1608-mvc/?branch=main)
[![Code Coverage](https://scrutinizer-ci.com/g/nasp22/DV1608-mvc/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/nasp22/DV1608-mvc/?branch=main)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/nasp22/DV1608-mvc/badges/code-intelligence.svg?b=main)](https://scrutinizer-ci.com/code-intelligence)

This repo is used to test and verify that it can be integrated with external tools for continous integration, automated test and statical code analysis for code quality.

The repo is part of course material for the [dbwebb mvc-course](https://github.com/dbwebb-se/mvc). The repo is a Symfony app.



Install `tools/`
-------------------------

Here are the exercises to install each tool in detail.

* [php-cs-fixer](https://github.com/dbwebb-se/mvc/tree/main/example/symfony-codestyle)
* [phpmd, phpstan](https://github.com/dbwebb-se/mvc/tree/main/example/php-linter-and-mess-detection)
* [phpunit](https://github.com/dbwebb-se/mvc/tree/main/example/phpunit-symfony)
* [phpdoc](https://github.com/dbwebb-se/mvc/tree/main/example/phpdoc)
* [phpmetrics](https://github.com/dbwebb-se/mvc/tree/main/example/phpmetrics)

Read on to get the fast track to install each tool.



### php-cs-fixer

Install like this.

```
# php-cs-fixer
mkdir --parents tools/php-cs-fixer
composer require --working-dir=tools/php-cs-fixer friendsofphp/php-cs-fixer
```

Add the [configuration file](https://github.com/dbwebb-se/mvc/blob/main/example/symfony-codestyle/.php-cs-fixer.dist.php) you need to be able to validate code in many directories.

```
curl -s https://raw.githubusercontent.com/dbwebb-se/mvc/main/example/symfony-codestyle/.php-cs-fixer.dist.php > .php-cs-fixer.dist.php
```

This is the script part that you add to `composer.json`.

```json
    "scripts": {
        "csfix": "tools/php-cs-fixer/vendor/bin/php-cs-fixer --config=.php-cs-fixer.dist.php fix src tests",
        "csfix:dry": "tools/php-cs-fixer/vendor/bin/php-cs-fixer --config=.php-cs-fixer.dist.php fix src tests --dry-run -v"
    }
```



### phpmd

Install like this.

```
# phpmd
mkdir --parents tools/phpmd
composer require --working-dir=tools/phpmd phpmd/phpmd
```

Add the [config file](https://github.com/dbwebb-se/mvc/blob/main/example/php-linter-and-mess-detection/phpmd.xml).

```
curl -s https://raw.githubusercontent.com/dbwebb-se/mvc/main/example/php-linter-and-mess-detection/phpmd.xml > phpmd.xml
```

This is the script part that you add to `composer.json`.

```json
    "scripts": {
        "phpmd": "tools/phpmd/vendor/bin/phpmd . text phpmd.xml || true"
    }
```



### phpstan

Install like this.

```
# phpstan
mkdir --parents tools/phpstan
composer require --working-dir=tools/phpstan phpstan/phpstan
```

Add the [config file](https://github.com/dbwebb-se/mvc/blob/main/example/php-linter-and-mess-detection/phpstan.neon).

```
curl -s https://raw.githubusercontent.com/dbwebb-se/mvc/main/example/php-linter-and-mess-detection/phpstan.neon > phpstan.neon
```

This is the script part that you add to `composer.json`.

```json
    "scripts": {
        "phpstan": "tools/phpstan/vendor/bin/phpstan || true",
        "lint": [
            "@phpmd",
            "@phpstan"
        ]
    }
```



### phpunit

Install like this.

```
# phpunit
composer require --dev symfony/test-pack
```

Update the configuration file `phpunit.xml.dist` with a report instruction on the code coverage. Add it between the `<coverage>` tags.

```xml
<report>
  <clover outputFile="docs/coverage.clover"/>
  <html outputDirectory="docs/coverage" lowUpperBound="35" highLowerBound="70"/>
</report>
```

This is the script part that you add to `composer.json`.

```json
    "scripts": {
        "phpunit": "XDEBUG_MODE=coverage vendor/bin/phpunit"
    }
```



### phpdoc

Install like this.

```
# phpdoc
mkdir --parents tools/phpdoc
wget https://phpdoc.org/phpDocumentor.phar -O tools/phpdoc/phpdoc
chmod 755 tools/phpdoc/phpdoc
```

Add the [config file](https://github.com/dbwebb-se/mvc/blob/main/example/phpdoc/phpdoc.xml).

```
curl -s https://raw.githubusercontent.com/dbwebb-se/mvc/main/example/phpdoc/phpdoc.xml > phpdoc.xml
```

This is the script part that you add to `composer.json`.

```json
    "scripts": {
        "phpdoc": "tools/phpdoc/phpdoc"
    }
```

Add the directory `.phpdoc` to your `.gitignore` file.



### phpmetrics

Install like this.

```
# phpmetrics
mkdir --parents tools/phpmetrics
composer require --working-dir=tools/phpmetrics phpmetrics/phpmetrics
```

Add the [config file](https://github.com/dbwebb-se/mvc/blob/main/example/phpmetrics/phpmetrics.json).

```
curl -s https://raw.githubusercontent.com/dbwebb-se/mvc/main/example/phpmetrics/phpmetrics.json > phpmetrics.json
```

This is the script part that you add to `composer.json`.

```json
    "scripts": {
        "phpmetrics": "tools/phpmetrics/vendor/bin/phpmetrics --config=phpmetrics.json"
    }
```



Add to Scrutinizer
-------------------------

There is an exercise showing you the details.

* [Scrutinizer](https://github.com/dbwebb-se/mvc/tree/main/example/scrutinizer)

Here is the fast track.

Add the [config file](https://github.com/dbwebb-se/mvc/blob/main/example/scrutinizer/.scrutinizer.yml).

```
curl -s https://raw.githubusercontent.com/dbwebb-se/mvc/main/example/scrutinizer/.scrutinizer.yml > .scrutinizer.yml
```
