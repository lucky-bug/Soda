# Soda MVC

## Installation

### Database
1. Run `CREATE DATABASE soda_db;` to create database.
2. Run
   ```
   CREATE TABLE tasks (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    text VARCHAR(255) NOT NULL,
    status BIT NOT NULL DEFAULT 0,
    edited BIT NOT NULL DEFAULT 0
    );
   ```
3. Run `CREATE USER soda@localhost identified by 'secret';`
4. Run `GRANT ALL PRIVILEGES ON soda_db.* TO soda@localhost;`
5. Run `FLUSH PRIVILEGES;`


### Application
1. Run `composer install`.
2. Run `cd public`.
3. Run `php -S localhost:8888`.
4. Visit http://localhost:8888.
