# My Repository

# Metrics proj mvc project kmom10

[![Build Status](https://scrutinizer-ci.com/g/AdrianFreshman/Mvc/badges/build.png?b=main)](https://scrutinizer-ci.com/g/AdrianFreshman/Mvc/build-status/main)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/AdrianFreshman/Mvc/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/AdrianFreshman/Mvc/?branch=main)
[![Code Coverage](https://scrutinizer-ci.com/g/AdrianFreshman/Mvc/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/AdrianFreshman/Mvc/?branch=main)

Links for docs and metrics.

-   [docs](https://www.student.bth.se/~adde22/dbwebb-kurser/mvc/me/report/docs/api/packages/App-Controller.html)
-   [metrics](https://www.student.bth.se/~adde22/dbwebb-kurser/mvc/me/report/docs/metrics/)

This repo is used for various tasks during the course MVC at BTH university, it used symfony,javascript, doctrine ,composer and npm and other various tools

The repo is part of course material for the [dbwebb mvc-course](https://github.com/dbwebb-se/mvc). The repo is a Symfony app.

# My Repository

This repository contains my project files for [MVV].

# Mvc Repository

This repository contains the source code for the Mvc project.Check src/Controller and tests/Proj for the code used

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


We need to install the npm and its dependencies

```

npm install

```

We need to run the build and its dependencies

```

npm run build

```

Have php 8.2.4 installed and then run

```
 php -S localhost:8888 -t public

```

### php-cs-fixer

```

composer require friendsofphp/php-cs-fixer --dev

```

### phpmd

```

composer require phpmd/phpmd --dev

```

### phpstan

```

composer require phpstan/phpstan --dev

```

### phpunit

```

composer require phpunit/phpunit --dev

```

### phpdoc

```

composer require phpdocumentor/phpdocumentor --dev

```

### phpmetrics

```

composer require phpmetrics/phpmetrics --dev

```

### add to composer.json

```
"require-dev": {
    "friendsofphp/php-cs-fixer": "^2.0",
    "phpmd/phpmd": "^2.10",
    "phpstan/phpstan": "^0.12",
    "phpunit/phpunit": "^9.0",
    "phpdocumentor/phpdocumentor": "^3.0",
    "phpmetrics/phpmetrics": "^2.4"
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
