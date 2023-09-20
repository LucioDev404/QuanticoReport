CREATE TABLE `Users`(
    id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    username varchar(50) NOT NULL,
    password varchar(255) NOT NULL,
    permesso char(1) NOT NULL,
    reparto varchar(50) NOT NULL
);

CREATE TABLE `Reparto`(
    id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nome_reparto varchar(50) NOT NULL,
    email_support varchar(50) NOT NULL
);

CREATE TABLE `Report`(
    id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    reparto varchar(50) NOT NULL,
    titolo varchar(50) NOT NULL,
    descrizione varchar(255) NOT NULL,
    file1 varchar(255),
    file2 varchar(255),
    data_report TIMESTAMP NOT NULL
);
