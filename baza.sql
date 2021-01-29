# DROP TABLE Mark;
# DROP TABLE User;
# DROP TABLE Statement;

# Podstawowe kwerendy SQL tworzace strukture bazy danych

CREATE TABLE Mark
(
    id         INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    mark       INT(1)  NOT NULL,
    student_id INT(10) NOT NULL,
    teacher_id INT(10) NOT NULL,
    added_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE User
(
    id       INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name     VARCHAR(32) NOT NULL,
    surname  VARCHAR(32) NOT NULL,
    login    VARCHAR(32) NOT NULL,
    password VARCHAR(32) NOT NULL,
    role     VARCHAR(32) NOT NULL
);

CREATE TABLE Statement
(
    id      INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    message TEXT NOT NULL
);
