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
    header ('location: proiect.php');
    exit (0);
}

if (isset ($_POST['delete'])) {
    if (isset ($_SESSION['admin']) and $_SESSION['admin'] != 0)
        deleteData ();
    else $_SESSION['perm-denied'] = true;
    header ('location: proiect.php');
    exit (0);
}

if (isset ($_POST['update'])) {
    if (isset ($_SESSION['admin']) and $_SESSION['admin'] != 0)
        updateData ();
    else $_SESSION['perm-denied'] = true;
    header ('location: proiect.php');
    exit (0);
}

if (isset ($_POST['create'])) {
    if (isset ($_SESSION['admin']) and $_SESSION['admin'] != 0)
        createData ();
    else $_SESSION['perm-denied'] = true;
    header ('location: proiect.php');
    exit (0);
}


function createData () {
    global $conn;

    $type = textboxValue ('type');
    $deadline = textboxValue ('deadline');
    $team_id = textboxValue ('team_id');
    $state = textboxValue ('finished');

    if ($type and $deadline and $team_id and $state) {
        $query = 'SELECT * FROM echipa WHERE id=? LIMIT 1';
        $run = $conn->prepare ($query);
        $run->bind_param ('i', $team_id);
        $run->execute ();
        $result = $run->get_result ();
        $team = $result->fetch_assoc ();

        $query = 'SELECT * FROM proiect WHERE echipa_id=? and finalizat=\'WORKING\' LIMIT 1';
        $run = $conn->prepare ($query);
        $run->bind_param ('i', $team_id);
        $run->execute ();
        $result = $run->get_result ();
        $project = $result->fetch_assoc ();

        if (!isset ($team)) {
            $_SESSION['no-team'] = true;
        } else if ($state == "WORKING" and isset ($project)) {
            $_SESSION['occupied'] = true;
            $_SESSION['name_proj'] = $project['tip'];
            $_SESSION['name_team'] = $team['denumire'];
        } else {
            $sql = 'INSERT INTO proiect (tip, deadline, echipa_id, finalizat) VALUES (?, ?, ?, ?)';
            $stmt = $conn->prepare ($sql);
            $stmt->bind_param ('ssss', $type, $deadline, $team_id, $state);

            if ($stmt->execute ()) {
                $_SESSION['inserted'] = true;
            } else $_SESSION['uninserted'] = true;

            $stmt->close ();
        }
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

    $sql = 'SELECT * FROM proiect';
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

    $id = textboxValue ('prod_id');
    $type = textboxValue ('type');
    $deadline = textboxValue ('deadline');
    $team_id = textboxValue ('team_id');
    $state = textboxValue ('finished');

    if ($type and $deadline and $team_id and $state) {
        $query = 'SELECT * FROM echipa WHERE id=? LIMIT 1';
        $run = $conn->prepare ($query);
        $run->bind_param ('i', $team_id);
        $run->execute ();
        $result = $run->get_result ();
        $team = $result->fetch_assoc ();

        $query = 'SELECT * FROM proiect WHERE echipa_id=? and finalizat=\'WORKING\' LIMIT 1';
        $run = $conn->prepare ($query);
        $run->bind_param ('i', $team_id);
        $run->execute ();
        $result = $run->get_result ();
        $project = $result->fetch_assoc ();

        if (!isset ($team)) {
            $_SESSION['no-team'] = true;
        } else if ($state == "WORKING" and isset ($project)) {
            $_SESSION['occupied'] = true;
            $_SESSION['name_proj'] = $project['tip'];
            $_SESSION['name_team'] = $team['denumire'];
        } else {
            $sql = "UPDATE proiect SET tip=?, echipa_id=?, deadline=?, finalizat=? WHERE id=?";
            $stmt = $conn->prepare ($sql);
            $stmt->bind_param ('ssssi', $type, $team_id, $deadline, $state, $id);

            if ($stmt->execute ())
                $_SESSION['updated'] = true;
            else $_SESSION['ufail'] = true;

            $stmt->close ();
        }
    } else $_SESSION['uempty'] = true;
}

function deleteData () {
    global $conn;

    $id = (int)textboxValue ('prod_id');
    $sql = 'SELECT * FROM proiect WHERE id=? LIMIT 1';
    $stmt = $conn->prepare ($sql);
    $stmt->bind_param ('i', $id);
    $stmt->execute ();
    $result = $stmt->get_result ();
    
    if ($result->num_rows > 0) {
        $sql = "DELETE FROM proiect WHERE id=?";
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
        while ($proiect = $result->fetch_assoc ()) {
            ++ $cnt;
            if ($cnt > 3) {
                echo buttonElement ('btn-deleteall', 'btn btn-danger', '<i class= "fa fa-trash fa-lg"></i> Delete All', 'deleteall', '');
                return;
            }
        }
    }
}

function deleteAll () {
    global $conn;

    $sql = "DELETE FROM proiect";
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
            $id = $row['id'];
    }

    return $id + 1;
}