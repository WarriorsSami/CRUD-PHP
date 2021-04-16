<?php

require_once ('create_connection_db.php');

global $conn;

$sql1 = "CREATE TABLE IF NOT EXISTS client (
    client_id INT UNIQUE NOT NULL AUTO_INCREMENT,
    nume VARCHAR(50) NOT NULL,
    prenume VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    adresa VARCHAR(100) NOT NULL,
    PRIMARY KEY (client_id))";

$stmt1 = $conn->prepare ($sql1);

if (!$stmt1)
    die ("DB ERROR: " . $conn->error);

if (!$stmt1->execute ())
    die ("DB ERROR: " . $stmt1->error);

$stmt1->close ();


$sql2 = "CREATE TABLE IF NOT EXISTS produs (
    id INT UNIQUE NOT NULL AUTO_INCREMENT,
    descriere VARCHAR(100) NOT NULL,
    cerinte VARCHAR(1000) NOT NULL,
    disponibil VARCHAR(10) NOT NULL,
    PRIMARY KEY (id))";

$stmt2 = $conn->prepare ($sql2);

if (!$stmt2)
    die ("DB ERROR: " . $conn->error);

if (!$stmt2->execute ())
    die ("DB ERROR: " . $stmt2->error);

$stmt2->close ();

  
$sql3 = "CREATE TABLE IF NOT EXISTS echipa (
    id INT UNIQUE NOT NULL AUTO_INCREMENT,
    denumire VARCHAR(50) NOT NULL,
    PRIMARY KEY (id))";

$stmt3 = $conn->prepare ($sql3);

if (!$stmt3)
    die ("DB ERROR: " . $conn->error);

if (!$stmt3->execute ())
    die ("DB ERROR: " . $stmt3->error);

$stmt3->close ();


$sql4 = "CREATE TABLE IF NOT EXISTS comanda (
    id INT UNIQUE NOT NULL AUTO_INCREMENT,
    data_finalizare DATE NOT NULL,
    client_id INT NOT NULL,
    produs_id INT NOT NULL,
    echipa_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (client_id)
      REFERENCES client (client_id),
    FOREIGN KEY (produs_id)
      REFERENCES produs (id),
    FOREIGN KEY (echipa_id)
      REFERENCES echipa (id))";

$stmt4 = $conn->prepare ($sql4);

if (!$stmt4)
    die ("DB ERROR: " . $conn->error);

if (!$stmt4->execute ())
    die ("DB ERROR: " . $stmt4->error);

$stmt4->close ();

  
$sql5 = "CREATE TABLE IF NOT EXISTS departament (
    id INT UNIQUE NOT NULL AUTO_INCREMENT,
    denumire VARCHAR(100) NOT NULL,
    PRIMARY KEY (id))";

$stmt5 = $conn->prepare ($sql5);

if (!$stmt5)
    die ("DB ERROR: " . $conn->error);

if (!$stmt5->execute ())
    die ("DB ERROR: " . $stmt5->error);

$stmt5->close ();

  
$sql6 = "CREATE TABLE IF NOT EXISTS angajat (
    id INT UNIQUE NOT NULL AUTO_INCREMENT,
    nume VARCHAR(50) NOT NULL,
    prenume VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    adresa VARCHAR(100) NOT NULL,
    manager VARCHAR(10) NOT NULL,
    sef_proiect VARCHAR(10) NOT NULL,
    departament_id INT NOT NULL,
    echipa_id INT NOT NULL,
    data_angajare DATE NOT NULL,
    salariu DECIMAL(8,2) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (departament_id)
      REFERENCES departament (id),
    FOREIGN KEY (echipa_id)
      REFERENCES echipa (id))";

$stmt6 = $conn->prepare ($sql6);

if (!$stmt6)
    die ("DB ERROR: " . $conn->error);

if (!$stmt6->execute ())
    die ("DB ERROR: " . $stmt6->error);

$stmt6->close ();
  

$sql7 = "CREATE TABLE IF NOT EXISTS proiect (
    id INT UNIQUE NOT NULL AUTO_INCREMENT,
    tip VARCHAR(50) NOT NULL,
    deadline DATE NOT NULL,
    echipa_id INT NOT NULL,
    finalizat VARCHAR(10) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (echipa_id)
      REFERENCES echipa (id))";

$stmt7 = $conn->prepare ($sql7);

if (!$stmt7)
    die ("DB ERROR: " . $conn->error);

if (!$stmt7->execute ())
    die ("DB ERROR: " . $stmt7->error);

$stmt7->close ();

$sql = "CREATE TABLE IF NOT EXISTS question (
    id INT UNIQUE NOT NULL AUTO_INCREMENT PRIMARY KEY,
    enunt VARCHAR(1000) NOT NULL,
    ans1 VARCHAR(100) NOT NULL,
    ans2 VARCHAR(100) NOT NULL,
    ans3 VARCHAR(100) NOT NULL,
    ans4 VARCHAR(100) NOT NULL,
    corect VARCHAR(100) NOT NULL,
    punctaj DECIMAL(3, 2) NOT NULL,
    nr_spaces INT NOT NULL,
    insert_sp INT NOT NULL,
    special_button VARCHAR(1000) NOT NULL,
    special_element VARCHAR(1000) NOT NULL
)";

$stmt = $conn->prepare ($sql);

if (!$stmt)
    die ("DB ERROR: " . $conn->error);

if (!$stmt->execute ())
    die ("DB ERROR: " . $stmt->error);

$stmt->close ();