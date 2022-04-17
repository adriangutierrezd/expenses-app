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

/* NEW */

CREATE TABLE results (
    id INT(10) NOT NULL AUTO_INCREMENT,
    user_id INT(5) NOT NULL,
    budget FLOAT(10,2) NOT NULL,
    spent FLOAT(10,2) NOT NULL,
    date DATE NOT NULL,
    CONSTRAINT res_id_pk PRIMARY KEY(id),
    CONSTRAINT res_use_fk FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Activamos eventos 
SET GLOBAL event_scheduler = 1;

-- Creamos un evento para que todos los meses saque los resultados del mes del usuario
DELIMITER $$
CREATE EVENT generate_monthly_summary
ON SCHEDULE EVERY '1' MONTH
STARTS '2022-05-01 00:00:00'
DO 
BEGIN
    INSERT INTO results (user_id, budget, spent, date) SELECT expenses.user_id, users.budget, SUM(expenses.amount), DATE_SUB(CURDATE(), INTERVAL 1 DAY)
    FROM expenses INNER JOIN users ON expenses.user_id = users.id 
    AND (MONTH(expenses.date) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 DAY)) AND YEAR(expenses.date) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 DAY))) 
    GROUP BY user_id;
END$$

DELIMITER ;

-- Si el usuario añade, actualiza o elimina un gasto de un mes pasado, se actualizan los resultados de dicho mes
DELIMITER $$
CREATE TRIGGER trigger_insert_expenses_update_results 
AFTER INSERT ON expenses
FOR EACH ROW
BEGIN 
	IF NEW.user_id IN (SELECT user_id FROM results WHERE MONTH(date) = MONTH(NEW.date)) THEN
		IF MONTH(NEW.date) != MONTH(CURDATE()) THEN 
			UPDATE results SET spent = (SELECT SUM(amount) FROM expenses WHERE NEW.user_id = user_id AND MONTH(date) = MONTH(NEW.date)) 
			WHERE NEW.user_id = user_id AND MONTH(date) = MONTH(NEW.date);
        END IF;
    END IF;
END; $$



DELIMITER $$
CREATE TRIGGER trigger_update_expenses_update_results 
AFTER UPDATE ON expenses
FOR EACH ROW
BEGIN 
	IF MONTH(NEW.date) != MONTH(CURDATE()) THEN 
		UPDATE results SET spent = (SELECT SUM(amount) FROM expenses WHERE NEW.user_id = user_id AND MONTH(date) = MONTH(NEW.date)) 
        WHERE NEW.user_id = user_id AND MONTH(date) = MONTH(NEW.date);
	END IF;
END; $$


DELIMITER $$
CREATE TRIGGER trigger_delete_expenses_update_results 
AFTER DELETE ON expenses
FOR EACH ROW
BEGIN 
	IF MONTH(OLD.date) != MONTH(CURDATE()) THEN 
		UPDATE results SET spent = (SELECT SUM(amount) FROM expenses WHERE OLD.user_id = user_id AND MONTH(date) = MONTH(OLD.date)) 
        WHERE OLD.user_id = user_id AND MONTH(date) = MONTH(OLD.date);
	END IF;
END; $$



