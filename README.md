Startwars Events with sf2
================================

This is a demo project for getting start with symfony 2.

## Setup on Mac OS X
NO apache2 required, we will used the internal PHP native web server provided by sf2.
To start the project, we need:

- install vendors via composer
- install MySQL on Mac
- config database for current project
- start web server and test

### instal vendors
```
composer install
```

### install mysql server on mac OS X
```
brew install mysql
```
Updated the password of `root` user, if you are not able to login with `root`
```
$(brew --prefix mysql)/bin/mysqladmin -u root password my_new_password
```

### config database for current project
```
cd app/config/
cp parameters.yml.dist parameters.yml
```

Enter the correct database config data in `parameters.yml`

## Setup database
### Create database `symfony`
```
php app/console doctrine:database:create
```

### create all tables according to created entity classes
```
php app/console doctrine:schema:create
```

## start web server
```
php app/console server:run
```
