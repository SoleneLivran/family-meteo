# Family meteo
[![example branch parameter](https://github.com/SoleneLivran/family-meteo/actions/workflows/ci.yml/badge.svg?branch=master)](https://github.com/SoleneLivran/family-meteo/actions/workflows/ci.yml)

Personal project | Symfony

Developed in august 2020, in parallel with my cursus at école O'Clock.

Website allowing users to create a list of their relatives, grouped by home, and get a glimpse of the weather they are having. On another page you can see a list of the next incoming birthdays.<br>
Developed as a birthday gift for my grandma!

**Test credentials for the live website:**<br>
Username : test<br>
Password : i4wq7tpeAm<br>

<a href="http://family-meteo.herokuapp.com/">-> See live website (french)</a>

---

## Requirements

- PHP 7.2+
- MySQL/MariaDB/Postgres
- Composer
- API Keys :
  - Openweathermap
  - LocationIq
  

## Installation 

### Step 1 : Clone
Clone project

### Step 2 : Install dependencies

```sh
$ composer install
```

### Step 3 : Project configuration
```sh
$ cp .env .env.local
```
Then modify .env.local with your configuration

### Step 4 : Database

Create database if necessary :

```sh
$ bin/console doctrine:database:create
```

Then, update schema :

```sh
$ bin/console doctrine:schema:update
```

### Step 5 : Run web server

```sh
$ symfony serve
```

**OR**

```sh
$ php -S localhost:8080 -t public
```
