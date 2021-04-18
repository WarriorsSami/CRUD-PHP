<?php

require_once ('constants.php');

$mysql = mysqli_init();
mysqli_real_connect ($mysql,
    HOSTNAME_SQL,
    USERNAME_SQL,
    PASSWORD_SQL,
    DATABASE_SQL,
    3306);

if (!$mysql) {
	echo "Nu s-a realizat conectarea la MySQL!";
	exit (0);
}

$command = mysqli_query ($mysql, "CREATE DATABASE IF NOT EXISTS userboard");
if (!$command) {
	echo "Nu s-a reusit crearea bazei de date!";
	exit (0);
}

$base = mysqli_select_db ($mysql, "userboard");
$request = "CREATE TABLE IF NOT EXISTS users (
    id int (11) NOT NULL AUTO_INCREMENT,
    username varchar (100), 
    email varchar (200) UNIQUE, 
    verified tinyint, 
    token varchar (100), 
    bios varchar (255) default 'No status', 
    image longblob not null, 
    password varchar (255), 
    admin tinyint default 0, 
    image_profile VARCHAR(100),
    exist_photo TINYINT(4) DEFAULT 0,
    PRIMARY KEY (id))";

$command = mysqli_query ($mysql, $request);
if (!$command) {
	echo mysqli_errno ($mysql).":".mysqli_error ($mysql);
}

$request = "CREATE TABLE IF NOT EXISTS conversation (
    id INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    last_msg_id INT(11) NOT NULL,
    last_msg_dir VARCHAR(20) NOT NULL DEFAULT 'dr',
    time VARCHAR(20) NOT NULL,
    author_id INT(11)
);";

$command = mysqli_query ($mysql, $request);
if (!$command) {
    echo mysqli_errno ($mysql).":".mysqli_error ($mysql);
}

$request = "CREATE TABLE IF NOT EXISTS invitation (
    id INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    status VARCHAR(20) NOT NULL DEFAULT 'pending',
    time VARCHAR(20) NOT NULL,
    usr_from INT(11) NOT NULL,
    usr_to INT(11) NOT NULL,
    chat_id INT(11) NOT NULL,
    FOREIGN KEY (usr_from)
        REFERENCES users (id),
    FOREIGN KEY (usr_to)
        REFERENCES users (id),
    FOREIGN KEY (chat_id)
        REFERENCES conversation (id)
);";

$command = mysqli_query ($mysql, $request);
if (!$command) {
    echo mysqli_errno ($mysql).":".mysqli_error ($mysql);
}

$request = "CREATE TABLE IF NOT EXISTS message (
    id INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    text VARCHAR(1000) NOT NULL,
    status VARCHAR(20) DEFAULT 'No',
    time VARCHAR(20) NOT NULL,
    usr_id INT(11) NOT NULL,
    chat_id INT(11) NOT NULL,
    FOREIGN KEY (usr_id)
        REFERENCES users (id),
    FOREIGN KEY (chat_id)
        REFERENCES conversation (id)
);";

$command = mysqli_query ($mysql, $request);
if (!$command) {
    echo mysqli_errno ($mysql).":".mysqli_error ($mysql);
}