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
    header ('location: comanda.php');
    exit (0);
}

if (isset ($_POST['delete'])) {
    if (isset ($_SESSION['admin']) and $_SESSION['admin'] != 0)
        deleteData ();
    else $_SESSION['perm-denied'] = true;
    header ('location: comanda.php');
    exit (0);
}

if (isset ($_POST['update'])) {
    if (isset ($_SESSION['admin']) and $_SESSION['admin'] != 0)
        updateData ();
    else $_SESSION['perm-denied'] = true;
    header ('location: comanda.php');
    exit (0);
}

if (isset ($_POST['create'])) {
    if (isset ($_SESSION['admin']) and $_SESSION['admin'] != 0)
        createData ();
    else $_SESSION['perm-denied'] = true;
    header ('location: comanda.php');
    exit (0);
}


function createData () {
    global $conn;

    $date = textboxValue ('deadline');
    $client = textboxValue ('client_id');
    $prod = textboxValue ('prod_id');
    $team = textboxValue ('team_id');

    if ($date and $client and $prod and $team) {
        $sql1 = 'SELECT * FROM client WHERE client_id=? LIMIT 1';
        $stmt1 = $conn->prepare ($sql1);
        $stmt1->bind_param ('i', $client);
        $stmt1->execute ();
        $result1 = $stmt1->get_result ();
        $ent1 = $result1->fetch_assoc ();

        $sql2 = 'SELECT * FROM produs WHERE id=? LIMIT 1';
        $stmt2 = $conn->prepare ($sql2);
        $stmt2->bind_param ('i', $prod);
        $stmt2->execute ();
        $result2 = $stmt2->get_result ();
        $ent2 = $result2->fetch_assoc ();

        $sql3 = 'SELECT * FROM echipa WHERE id=? LIMIT 1';
        $stmt3 = $conn->prepare ($sql3);
        $stmt3->bind_param ('i', $team);
        $stmt3->execute ();
        $result3 = $stmt3->get_result ();
        $ent3 = $result3->fetch_assoc ();

        $sql = 'SELECT * FROM proiect WHERE echipa_id=? AND finalizat=\'WORKING\' LIMIT 1';
        $stmt = $conn->prepare ($sql);
        $stmt->bind_param ('i', $team);
        $stmt->execute ();
        $result = $stmt->get_result ();
        $proj = $result->fetch_assoc ();

        if (!isset ($ent1) or !isset ($ent2) or !isset ($ent3)) {
            $_SESSION['failed-order'] = true;
        } else if ($ent2['disponibil'] == "NO") {
            $_SESSION['no-prod'] = $ent2['descriere'];
        } else if (isset ($proj)) {
            $_SESSION['occupied-team'] = $ent3['denumire'];
            $_SESSION['occ-proj'] = $proj['tip'];
        } else {
            $sql = 'INSERT INTO comanda (data_finalizare, client_id, produs_id, echipa_id) VALUES (?, ?, ?, ?)';
            $stmt = $conn->prepare ($sql);
            $stmt->bind_param ('siii', $date, $client, $prod, $team);

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

    $sql = 'SELECT * FROM comanda';
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

    $id = textboxValue ('order_id');
    $date = textboxValue ('deadline');
    $client = textboxValue ('client_id');
    $prod = textboxValue ('prod_id');
    $team = textboxValue ('team_id');

    if ($date and $client and $prod and $team) {
        $sql1 = 'SELECT * FROM client WHERE client_id=? LIMIT 1';
        $stmt1 = $conn->prepare ($sql1);
        $stmt1->bind_param ('i', $client);
        $stmt1->execute ();
        $result1 = $stmt1->get_result ();
        $ent1 = $result1->fetch_assoc ();

        $sql2 = 'SELECT * FROM produs WHERE id=? LIMIT 1';
        $stmt2 = $conn->prepare ($sql2);
        $stmt2->bind_param ('i', $prod);
        $stmt2->execute ();
        $result2 = $stmt2->get_result ();
        $ent2 = $result2->fetch_assoc ();

        $sql3 = 'SELECT * FROM echipa WHERE id=? LIMIT 1';
        $stmt3 = $conn->prepare ($sql3);
        $stmt3->bind_param ('i', $team);
        $stmt3->execute ();
        $result3 = $stmt3->get_result ();
        $ent3 = $result3->fetch_assoc ();

        $sql = 'SELECT * FROM proiect WHERE echipa_id=? AND finalizat=\'WORKING\' LIMIT 1';
        $stmt = $conn->prepare ($sql);
        $stmt->bind_param ('i', $team);
        $stmt->execute ();
        $result = $stmt->get_result ();
        $proj = $result->fetch_assoc ();

        if (!isset ($ent1) or !isset ($ent2) or !isset ($ent3)) {
            $_SESSION['failed-order'] = true;
        } else if ($ent2['disponibil'] == "NO") {
            $_SESSION['no-prod'] = $ent2['descriere'];
        } else if (isset ($proj)) {
            $_SESSION['occupied-team'] = $ent3['denumire'];
            $_SESSION['occ-proj'] = $proj['tip'];
        } else {
            $sql = "UPDATE comanda SET data_finalizare=?, client_id=?, produs_id=?, echipa_id=? WHERE id=?";
            $stmt = $conn->prepare ($sql);
            $stmt->bind_param ('siiii', $date, $client, $prod, $team, $id);

            if ($stmt->execute ())
                $_SESSION['updated'] = true;
            else $_SESSION['ufail'] = true;

            $stmt->close ();
        }
    } else $_SESSION['uempty'] = true;
}

function deleteData () {
    global $conn;

    $id = (int)textboxValue ('order_id');
    $sql = 'SELECT * FROM comanda WHERE id=? LIMIT 1';
    $stmt = $conn->prepare ($sql);
    $stmt->bind_param ('i', $id);
    $stmt->execute ();
    $result = $stmt->get_result ();
    
    if ($result->num_rows > 0) {
        $sql = "DELETE FROM comanda WHERE id=?";
        $stmt = $conn->prepare ($sql);
        $stmt->bind_param ('i', $id);

        if ($stmt->execute ())
            $_SESSION['deleted'] = true;
        else $_SESSION['dfail'] = true;

        $stmt->close ();
    } else $_SESSION['dempty'] = true;

    $stmt->close ();
}

function deleteBtn () {
    $result = getData ();
    $cnt = 0;

    if ($result) {
        while ($client = $result->fetch_assoc ()) {
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

    $sql = "DELETE FROM comanda";
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