# My Repository

# Metrics proj mvc project kmom10

[![Build Status](https://scrutinizer-ci.com/g/AdrianFreshman/Mvc/badges/build.png?b=main)](https://scrutinizer-ci.com/g/AdrianFreshman/Mvc/build-status/main)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/AdrianFreshman/Mvc/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/AdrianFreshman/Mvc/?branch=main)
[![Code Coverage](https://scrutinizer-ci.com/g/AdrianFreshman/Mvc/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/AdrianFreshman/Mvc/?branch=main)

Links for docs and metrics.

-   [docs](https://www.student.bth.se/~adde22/dbwebb-kurser/mvc/me/report/docs/api/packages/App-Controller.html)
-   [metrics](https://www.student.bth.se/~adde22/dbwebb-kurser/mvc/me/report/docs/metrics/)

This repo is used to test and verify that it can be integrated with external tools for continous integration, automated test and statical code analysis for code quality.

The repo is part of course material for the [dbwebb mvc-course](https://github.com/dbwebb-se/mvc). The repo is a Symfony app.

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

# My Repository

This repository contains my project files for [project name].

# Mvc Repository

This repository contains the source code for the Mvc project.

## Cloning the Repository

To clone and download the repository, follow these steps:

1. Open a terminal or command prompt on your local machine.
2. Navigate to the directory where you want to clone the repository.
3. Run the following command to clone the repository:

```

git clone https://github.com/AdrianFreshman/Mvc.git

```

```

cd Mvc

```

## Before we start

We need to install the dependencies to the application and install the modules needed for the unit tests. Composer and php solves that for us.

```
composer install

```

This will set up the autoloader in composer so that all source files can be found.

You can inspect the `composer.json` how it setup the autoloader and how it includes phpunit.

You can always restart and begin from the beginning.

```

composer clean-all
composer install

```

```

composer install

```

We need to install the npm and its dependencies

```

npm install

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

````
curl -s https://raw.githubusercontent.com/dbwebb-se/mvc/main/example/php-linter-and-mess-detection/phpstan.neon > phpstan.neon



This is the script part that you add to `composer.json`.

```json
    "scripts": {
        "phpstan": "tools/phpstan/vendor/bin/phpstan || true",
        "lint": [
            "@phpmd",
            "@phpstan"
        ]
    }
````

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

## Add to Scrutinizer

There is an exercise showing you the details.

-   [Scrutinizer](https://github.com/dbwebb-se/mvc/tree/main/example/scrutinizer)

Here is the fast track.

Add the [config file](https://github.com/dbwebb-se/mvc/blob/main/example/scrutinizer/.scrutinizer.yml).

```
curl -s https://raw.githubusercontent.com/dbwebb-se/mvc/main/example/scrutinizer/.scrutinizer.yml > .scrutinizer.yml
```
