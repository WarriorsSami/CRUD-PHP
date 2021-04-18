<?php

require_once ('Config/create_connection_db.php');
require_once ('js_util/component.php');


/*if (isset ($_POST['read'])) {
    getData ();
}*/

if (isset ($_POST['deleteall'])) {
    if (isset ($_SESSION['admin']) and $_SESSION['admin'] == 2)
        deleteAll ();
    else $_SESSION['perm-denied1'] = true;
    header ('location: main.php');
    exit (0);
}

if (isset ($_POST['delete'])) {
    if (isset ($_SESSION['admin']) and $_SESSION['admin'] != 0)
        deleteData ();
    else $_SESSION['perm-denied'] = true;
    header ('location: main.php');
    exit (0);
}

if (isset ($_POST['update'])) {
    if (isset ($_SESSION['admin']) and $_SESSION['admin'] != 0)
        updateData ();
    else $_SESSION['perm-denied'] = true;
    header ('location: main.php');
    exit (0);
}

if (isset ($_POST['create'])) {
    if (isset ($_SESSION['admin']) and $_SESSION['admin'] != 0)
        createData ();
    else $_SESSION['perm-denied'] = true;
    header ('location: main.php');
    exit (0);
}


function createData () {
    global $conn;

    $name = textboxValue ('client_name');
    $surname = textboxValue ('client_surname');
    $adr = textboxValue ('client_adr');
    $email = textboxValue ('client_email');

    if ($name and $surname and $adr and $email) {
        $sql = 'INSERT INTO client (prenume, nume, adresa, email) VALUES (?, ?, ?, ?)';
        $stmt = $conn->prepare ($sql);
        $stmt->bind_param ('ssss', $name, $surname, $adr, $email);

        if ($stmt->execute ()) {
            $_SESSION['inserted'] = true;
        } else $_SESSION['uninserted'] = true;

        $stmt->close ();
    } else $_SESSION['empty'] = true;
}

function textboxValue ($value) {
    global $conn;

    $textbox = $conn->real_escape_string (trim ($_POST[$value]));

    if (empty ($textbox))
        return false;
    else return $textbox;
}

function getData () {
    global $conn;

    $sql = 'SELECT * FROM client';
    $stmt = $conn->prepare ($sql);
    $stmt->execute ();
    $result = $stmt->get_result ();

    if ($result->num_rows > 0) {
        return $result;
    }

    $stmt->close ();
}

function updateData () {
    global $conn;

    $id = textboxValue ('client_id');
    $name = textboxValue ('client_name');
    $surname = textboxValue ('client_surname');
    $adr = textboxValue ('client_adr');
    $email = textboxValue ('client_email');

    if ($name and $surname and $adr and $email) {
        $sql = "UPDATE client SET nume=?, prenume=?, adresa=?, email=? WHERE client_id=?";
        $stmt = $conn->prepare ($sql);
        $stmt->bind_param ('ssssi', $surname, $name, $adr, $email, $id);

        if ($stmt->execute ())
            $_SESSION['updated'] = true;
        else $_SESSION['ufail'] = true;

        $stmt->close ();
    } else $_SESSION['uempty'] = true;
}

function deleteData () {
    global $conn;

    $id = (int)textboxValue ('client_id');
    $sql = 'SELECT * FROM client WHERE client_id=? LIMIT 1';
    $stmt = $conn->prepare ($sql);
    $stmt->bind_param ('i', $id);
    $stmt->execute ();
    $result = $stmt->get_result ();
    
    if ($result->num_rows > 0) {
        $sql = "DELETE FROM client WHERE client_id=?";
        $stmt = $conn->prepare ($sql);
        $stmt->bind_param ('i', $id);

        if ($stmt->execute ())
            $_SESSION['deleted'] = true;
        else $_SESSION['dfail'] = true;

        $stmt->close ();
    } else $_SESSION['dempty'] = true;
}

function deleteBtn () {
    $result = getData ();
    $cnt = 0;

    if ($result) {
        while ($client = $result->fetch_assoc ()) {
            ++ $cnt;
            if ($cnt > 3) {
                buttonElement ('btn-deleteall', 'btn btn-danger', '<i class= "fa fa-trash fa-lg"></i> Delete All', 'deleteall', '');
                return;
            }
        }
    }
}

function deleteAll () {
    global $conn;

    $sql = "DELETE FROM client";
    $stmt = $conn->prepare ($sql);

    if ($stmt->execute ())
        $_SESSION['dall'] = true;
    else $_SESSION['dallfail'] = true;

    $stmt->close ();
}

function setId () {
    $result = getData ();
    $id = 0;

    if ($result) {
        while ($row = $result->fetch_assoc ())
            $id = $row['client_id'];
    }

    return $id + 1;
}