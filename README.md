# IMDb Movie Search App

This is a simple PHP-based movie search application that uses the [OMDb API](http://www.omdbapi.com/) to search and store movie data. It follows a lightweight MVC architecture and includes an API-based search interface with the ability to save selected movies to a MySQL database.

---

## Features

- Search for movies by title or IMDb ID using the OMDb API
- Fetch and display detailed movie information
- Save selected movies to a local database
- Fast and lightweight custom MVC framework
- Basic migration system for setting up the database table

---

## Requirements

- PHP 8.0 or higher
- Composer
- MySQL
- OMDb API Key (get it from [https://www.omdbapi.com/apikey.aspx](https://www.omdbapi.com/apikey.aspx))

---

## Setup Instructions

### 1. Clone the repository

git clone https://github.com/Sidney-Dev/imdb_movie.git

### 2. Enter directory
cd imdb_movie

### 3. Copy environment file
cp .env-example .env

Replace all the credentials for your own

Create a new MySQL database that matches the name in your .env

### 4. Run composer
composer install

### 5. Run run migrations
php migrate.php

### 6. Start the application
php -S localhost:8000 -t public
