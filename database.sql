CREATE DATABASE expensesapp;
USE expensesapp;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+1:00";
SET CHARSET 'utf8';


CREATE TABLE users(

    id int(5) auto_increment,
    name varchar(100) NOT NULL,
    username varchar(150) NOT NULL UNIQUE,
    password varchar(150) NOT NULL,
    budget float(10,2
    ),
    created_at date DEFAULT(CURRENT_DATE()), 

    CONSTRAINT use_id_pk PRIMARY KEY(id)
);

INSERT INTO users (id, username, password) VALUES (1, 'admin', 'admin');


CREATE TABLE categories(
    id int(5) auto_increment,
    user_id int(5),
    name varchar(100) NOT NULL,
    color varchar(7) NOT NULL,
    created_at date DEFAULT(CURRENT_DATE()), 

    CONSTRAINT cat_id_pk PRIMARY KEY(id),
    CONSTRAINT cat_use_fk FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO categories (id, user_id, name, color) VALUES(1, 1, 'Sin categoria', '#78ffb9');


CREATE TABLE expenses(
    id int(10) auto_increment,
    user_id int(5),
    category_id int(5),
    name varchar(100),
    amount float(10,2) NOT NULL,
    date date DEFAULT(CURRENT_DATE()),

    CONSTRAINT exp_id_pk PRIMARY KEY(id),
    CONSTRAINT exp_use_fk FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT exp_cat_fk FOREIGN KEY(category_id) REFERENCES categories(id) ON DELETE SET NULL
);




