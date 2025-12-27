<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Basic Project Template</h1>
    <br>
</p>

Yii 2 Basic Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
rapidly creating small projects.

The template contains the basic features including user login/logout and a contact page.
It includes all commonly used configurations that would allow you to focus on adding new
features to your application.

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![Build Status](https://travis-ci.org/yiisoft/yii2-app-basic.svg?branch=master)](https://travis-ci.org/yiisoft/yii2-app-basic)

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

### Install via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this project template using the following command:

~~~
composer create-project --prefer-dist yiisoft/yii2-app-basic basic
~~~

Now you should be able to access the application through the following URL, assuming `basic` is the directory
directly under the Web root.

~~~
http://localhost/basic/web/
~~~

### Install from an Archive File

Extract the archive file downloaded from [yiiframework.com](http://www.yiiframework.com/download/) to
a directory named `basic` that is directly under the Web root.

Set cookie validation key in `config/web.php` file to some random secret string:

```php
'request' => [
    // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
    'cookieValidationKey' => '<secret random string goes here>',
],
```

You can then access the application through the following URL:

~~~
http://localhost/basic/web/
~~~


### Install with Docker

1. Create `.env` file from example (copy the variables below):

```bash
# Application Environment
APP_ENV=dev
APP_DEBUG=true

# Database Configuration
DB_HOST=mysql
DB_NAME=words_db
DB_USER=words_user
DB_PASS=words_password

# MySQL Root Password
MYSQL_ROOT_PASSWORD=root_password
```

2. **Using Makefile (recommended):**

```bash
# Full setup (rebuild, install, setup)
make setup

# Or step by step:
make up          # Start containers
make install     # Install dependencies
make assets      # Set permissions
make migrate     # Run migrations
```

3. **Using docker-compose directly:**

```bash
# Start containers
docker-compose up -d

# Install dependencies
docker-compose exec php composer install

# Run migrations
docker-compose exec php php yii migrate

# Set proper permissions
docker-compose exec php chmod -R 777 runtime web/assets
```

You can then access the application through the following URLs:

- Application: http://127.0.0.1:8000
- phpMyAdmin: http://127.0.0.1:8080

**Available services:**
- `php` - PHP 8.2 with Apache (port 8000)
- `mysql` - MySQL 8.0 (port 3306)
- `phpmyadmin` - phpMyAdmin interface (port 8080)

**Useful Makefile commands:**
- `make help` - Show all available commands
- `make up` / `make start` - Start containers
- `make down` / `make stop` - Stop containers
- `make restart` - Restart containers
- `make logs` - View logs from all containers
- `make shell` - Open shell in PHP container
- `make install` - Install composer dependencies
- `make update` - Update composer dependencies
- `make migrate` - Run database migrations
- `make assets` - Set proper permissions
- `make clean` - Clean cache and logs
- `make test` - Run tests
- `make yii CMD="cache/flush"` - Run Yii console command

**Useful docker-compose commands:**
- Stop containers: `docker-compose down`
- View logs: `docker-compose logs -f`
- Execute commands in PHP container: `docker-compose exec php <command>`
- Access MySQL: `docker-compose exec mysql mysql -u words_user -p words_db`

**NOTES:** 
- Minimum required Docker engine version `17.04` for development (see [Performance tuning for volume mounts](https://docs.docker.com/docker-for-mac/osxfs-caching/))
- The default configuration uses a host-volume in your home directory `.docker-composer` for composer caches
- Database data is persisted in Docker volume `mysql_data`


CONFIGURATION
-------------

### Database

The application uses environment variables for database configuration. Create a `.env` file in the project root:

```bash
# Application Environment
APP_ENV=dev
APP_DEBUG=true

# Database Configuration
DB_HOST=mysql          # For Docker use 'mysql', for local use 'localhost'
DB_NAME=words_db
DB_USER=words_user
DB_PASS=words_password

# MySQL Root Password (for Docker)
MYSQL_ROOT_PASSWORD=root_password
```

The database configuration is loaded from `config/db.php` which reads these environment variables.

**For Docker:**
- Database is automatically created when containers start
- Use `DB_HOST=mysql` to connect to the MySQL container

**For local development:**
- Create the database manually before accessing it
- Use `DB_HOST=localhost` or your MySQL host
- Update other files in the `config/` directory to customize your application as required

**NOTES:**
- Refer to the README in the `tests` directory for information specific to basic application tests.


TESTING
-------

Tests are located in `tests` directory. They are developed with [Codeception PHP Testing Framework](http://codeception.com/).
By default there are 3 test suites:

- `unit`
- `functional`
- `acceptance`

Tests can be executed by running

```
vendor/bin/codecept run
```

The command above will execute unit and functional tests. Unit tests are testing the system components, while functional
tests are for testing user interaction. Acceptance tests are disabled by default as they require additional setup since
they perform testing in real browser. 


### Running  acceptance tests

To execute acceptance tests do the following:  

1. Rename `tests/acceptance.suite.yml.example` to `tests/acceptance.suite.yml` to enable suite configuration

2. Replace `codeception/base` package in `composer.json` with `codeception/codeception` to install full featured
   version of Codeception

3. Update dependencies with Composer 

    ```
    composer update  
    ```

4. Download [Selenium Server](http://www.seleniumhq.org/download/) and launch it:

    ```
    java -jar ~/selenium-server-standalone-x.xx.x.jar
    ```

    In case of using Selenium Server 3.0 with Firefox browser since v48 or Google Chrome since v53 you must download [GeckoDriver](https://github.com/mozilla/geckodriver/releases) or [ChromeDriver](https://sites.google.com/a/chromium.org/chromedriver/downloads) and launch Selenium with it:

    ```
    # for Firefox
    java -jar -Dwebdriver.gecko.driver=~/geckodriver ~/selenium-server-standalone-3.xx.x.jar
    
    # for Google Chrome
    java -jar -Dwebdriver.chrome.driver=~/chromedriver ~/selenium-server-standalone-3.xx.x.jar
    ``` 
    
    As an alternative way you can use already configured Docker container with older versions of Selenium and Firefox:
    
    ```
    docker run --net=host selenium/standalone-firefox:2.53.0
    ```

5. (Optional) Create `yii2_basic_tests` database and update it by applying migrations if you have them.

   ```
   tests/bin/yii migrate
   ```

   The database configuration can be found at `config/test_db.php`.


6. Start web server:

    ```
    tests/bin/yii serve
    ```

7. Now you can run all available tests

   ```
   # run all available tests
   vendor/bin/codecept run

   # run acceptance tests
   vendor/bin/codecept run acceptance

   # run only unit and functional tests
   vendor/bin/codecept run unit,functional
   ```

### Code coverage support

By default, code coverage is disabled in `codeception.yml` configuration file, you should uncomment needed rows to be able
to collect code coverage. You can run your tests and collect coverage with the following command:

```
#collect coverage for all tests
vendor/bin/codecept run -- --coverage-html --coverage-xml

#collect coverage only for unit tests
vendor/bin/codecept run unit -- --coverage-html --coverage-xml

#collect coverage for unit and functional tests
vendor/bin/codecept run functional,unit -- --coverage-html --coverage-xml
```

You can see code coverage output under the `tests/_output` directory.
