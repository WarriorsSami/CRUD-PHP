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
    header ('location: angajat.php');
    exit (0);
}

if (isset ($_POST['delete'])) {
    if (isset ($_SESSION['admin']) and $_SESSION['admin'] != 0)
        deleteData ();
    else $_SESSION['perm-denied'] = true;
    header ('location: angajat.php');
    exit (0);
}

if (isset ($_POST['update'])) {
    if (isset ($_SESSION['admin']) and $_SESSION['admin'] != 0)
        updateData ();
    else $_SESSION['perm-denied'] = true;
    header ('location: angajat.php');
    exit (0);
}

if (isset ($_POST['create'])) {
    if (isset ($_SESSION['admin']) and $_SESSION['admin'] != 0)
        createData ();
    else $_SESSION['perm-denied'] = true;
    header ('location: angajat.php');
    exit (0);
}


function createData () {
    global $conn;

    $name = textboxValue ('ang_name');
    $surname = textboxValue ('ang_surname');
    $adr = textboxValue ('ang_adr');
    $email = textboxValue ('ang_email');
    $manager = textboxValue ('is_manager');
    $leader = textboxValue ('is_lead');
    $jdate = textboxValue ('date');
    $salary = textboxValue ('money');
    $dep_id = textboxValue ('dep_id');
    $team_id = textboxValue ('team_id');

    if ($name and $surname and $adr and $email and $manager and $leader and $jdate and $salary and $dep_id and filter_var ($email, FILTER_VALIDATE_EMAIL)) {
        $sqlD = 'SELECT * FROM angajat WHERE manager=\'YES\' AND departament_id=? LIMIT 1';
        $stmtD = $conn->prepare ($sqlD);
        $stmtD->bind_param ('i', $dep_id);
        $stmtD->execute ();
        $resultD = $stmtD->get_result ();
        $mng = $resultD->fetch_assoc ();

        $sqlT = 'SELECT * FROM angajat WHERE sef_proiect=\'YES\' AND echipa_id=? LIMIT 1';
        $stmtT = $conn->prepare ($sqlT);
        $stmtT->bind_param ('i', $team_id);
        $stmtT->execute ();
        $resultT = $stmtT->get_result ();
        $tmld = $resultT->fetch_assoc ();

        $sqlFD = 'SELECT * FROM departament WHERE id=? LIMIT 1';
        $stmtFD = $conn->prepare ($sqlFD);
        $stmtFD->bind_param ('i', $dep_id);
        $stmtFD->execute ();
        $resultFD = $stmtFD->get_result ();
        $is_dep = $resultFD->fetch_assoc ();

        $sqlFT = 'SELECT * FROM echipa WHERE id=? LIMIT 1';
        $stmtFT = $conn->prepare ($sqlFT);
        $stmtFT->bind_param ('i', $team_id);
        $stmtFT->execute ();
        $resultFT = $stmtFT->get_result ();
        $is_team = $resultFT->fetch_assoc ();

        if (!isset ($is_dep) or !isset ($is_team)) {
            $_SESSION['no-team-dep'] = true;
        } else if (($resultD->num_rows > 0 and $manager == 'YES') or ($resultT->num_rows > 0 and $leader == 'YES')) {
            if ($resultD->num_rows > 0 and $manager == 'YES') {
                $sqltest = 'SELECT denumire FROM departament WHERE id=?';
                $stmttest = $conn->prepare ($sqltest);
                $stmttest->bind_param ('i', $dep_id);
                $stmttest->execute ();
                $resulttest = $stmttest->get_result ();
                $depart = $resulttest->fetch_assoc ();

                $_SESSION['duplicate-manager'] = $depart['denumire'];
                $_SESSION['nume_manager'] = $mng['prenume'] . " " . $mng['nume'];
            }
            
            if ($resultT->num_rows > 0 and $leader == 'YES') {
                $sqltest = 'SELECT denumire FROM echipa WHERE id=?';
                $stmttest = $conn->prepare ($sqltest);
                $stmttest->bind_param ('i', $team_id);
                $stmttest->execute ();
                $resulttest = $stmttest->get_result ();
                $team = $resulttest->fetch_assoc ();

                $_SESSION['duplicate-leader'] = $team['denumire'];
                $_SESSION['nume_sef'] = $tmld['prenume'] . " " . $tmld['nume'];
            }
        } else {
            $sql = 'INSERT INTO angajat (prenume, nume, adresa, email, manager, sef_proiect, data_angajare, salariu, departament_id, echipa_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $stmt = $conn->prepare ($sql);
            $stmt->bind_param ('sssssssdii', $name, $surname, $adr, $email, $manager, $leader, $jdate, $salary, $dep_id, $team_id);

            if ($stmt->execute ()) {
                $_SESSION['inserted'] = true;
            } else {
                #die ("ERROR: " . $stmt->error);
                $_SESSION['uninserted'] = true;
            }

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

    $sql = 'SELECT * FROM angajat';
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

    $id = textboxValue ('ang_id');
    $name = textboxValue ('ang_name');
    $surname = textboxValue ('ang_surname');
    $adr = textboxValue ('ang_adr');
    $email = textboxValue ('ang_email');
    $manager = textboxValue ('is_manager');
    $leader = textboxValue ('is_lead');
    $jdate = textboxValue ('date');
    $salary = textboxValue ('money');
    $dep_id = textboxValue ('dep_id');
    $team_id = textboxValue ('team_id');

    if ($name and $surname and $adr and $email and $manager and $leader and $jdate and $salary and $dep_id and filter_var ($email, FILTER_VALIDATE_EMAIL)) {
        $sqlD = 'SELECT * FROM angajat WHERE manager=\'YES\' AND departament_id=? AND id<>? LIMIT 1';
        $stmtD = $conn->prepare ($sqlD);
        $stmtD->bind_param ('ii', $dep_id, $id);
        $stmtD->execute ();
        $resultD = $stmtD->get_result ();
        $mng = $resultD->fetch_assoc ();

        $sqlT = 'SELECT * FROM angajat WHERE sef_proiect=\'YES\' AND echipa_id=? AND id<>? LIMIT 1';
        $stmtT = $conn->prepare ($sqlT);
        $stmtT->bind_param ('ii', $team_id, $id);
        $stmtT->execute ();
        $resultT = $stmtT->get_result ();
        $tmld = $resultT->fetch_assoc ();

        $sqlFD = 'SELECT * FROM departament WHERE id=? LIMIT 1';
        $stmtFD = $conn->prepare ($sqlFD);
        $stmtFD->bind_param ('i', $dep_id);
        $stmtFD->execute ();
        $resultFD = $stmtFD->get_result ();
        $is_dep = $resultFD->fetch_assoc ();

        $sqlFT = 'SELECT * FROM echipa WHERE id=? LIMIT 1';
        $stmtFT = $conn->prepare ($sqlFT);
        $stmtFT->bind_param ('i', $team_id);
        $stmtFT->execute ();
        $resultFT = $stmtFT->get_result ();
        $is_team = $resultFT->fetch_assoc ();

        if (!isset ($is_dep) or !isset ($is_team)) {
            $_SESSION['no-team-dep'] = true;
        } else if (($resultD->num_rows > 0 and $manager == 'YES') or ($resultT->num_rows > 0 and $leader == 'YES')) {
            if ($resultD->num_rows > 0 and $manager == 'YES') {
                $sqltest = 'SELECT denumire FROM departament WHERE id=?';
                $stmttest = $conn->prepare ($sqltest);
                $stmttest->bind_param ('i', $dep_id);
                $stmttest->execute ();
                $resulttest = $stmttest->get_result ();
                $depart = $resulttest->fetch_assoc ();

                $_SESSION['duplicate-manager'] = $depart['denumire'];
                $_SESSION['nume_manager'] = $mng['prenume'] . " " . $mng['nume'];
            }
            
            if ($resultT->num_rows > 0 and $leader == 'YES') {
                $sqltest = 'SELECT denumire FROM echipa WHERE id=?';
                $stmttest = $conn->prepare ($sqltest);
                $stmttest->bind_param ('i', $team_id);
                $stmttest->execute ();
                $resulttest = $stmttest->get_result ();
                $team = $resulttest->fetch_assoc ();

                $_SESSION['duplicate-leader'] = $team['denumire'];
                $_SESSION['nume_sef'] = $tmld['prenume'] . " " . $tmld['nume'];
            }
        } else {
            $sql = "UPDATE angajat SET nume=?, prenume=?, adresa=?, email=?, manager=?, sef_proiect=?, data_angajare=?, salariu=?, departament_id=?, echipa_id=? WHERE id=?";
            $stmt = $conn->prepare ($sql);
            $stmt->bind_param ('sssssssdiii', $surname, $name, $adr, $email, $manager, $leader, $jdate, $salary, $dep_id, $team_id, $id);

            if ($stmt->execute ())
                $_SESSION['updated'] = true;
            else $_SESSION['ufail'] = true;

            $stmt->close ();
        }
    } else $_SESSION['uempty'] = true;
}

function deleteData () {
    global $conn;

    $id = (int)textboxValue ('ang_id');
    $sql = 'SELECT * FROM angajat WHERE id=? LIMIT 1';
    $stmt = $conn->prepare ($sql);
    $stmt->bind_param ('i', $id);
    $stmt->execute ();
    $result = $stmt->get_result ();
    
    if ($result->num_rows > 0) {
        $sql = "DELETE FROM angajat WHERE id=?";
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

    $sql = "DELETE FROM angajat";
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