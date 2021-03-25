# Family meteo
![example branch parameter](https://github.com/SoleneLivran/family-meteo/actions/workflows/ci.yml/badge.svg?branch=master)

(English below)

Projet personnel | Symfony

Projet réalisé en août 2020, en parallèle de ma formation à l'école O'Clock.

Site permettant de créer une liste de ses proches, rassemblés par foyer, pour avoir un apercu de la météo actuelle chez eux. Une page permet également de consulter les dates des prochains anniversaires à venir.<br>
Développé en cadeau d'anniversaire pour ma grand-mère !

**Identifiants de test du site**<br>
Nom d'utilisateur : test<br>
Mot de passe : i4wq7tpeAm<br>

<a href="http://family-meteo.herokuapp.com/">-> Voir le site live</a>

---

Personal project | Symfony

Developed in august 2020, in parallel with my cursus at école O'Clock.

Website allowing users to create a list of their relatives, grouped by home, and get a glimpse of the weather they are having. On another page you can see a list of the next incoming birthdays.<br>
Developed as a birthday gift for my grandma!

**Website test credentials**<br>
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
