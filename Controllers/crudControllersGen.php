<?php

    require_once ('Config/create_connection_db.php');
    require_once ('js_util/component.php');

    if (isset ($_POST['display1'])) {
        $_SESSION['display1'] = true;
        header ('location: general.php');
        exit (0);
    }

    if (isset ($_POST['hide1'])) {
        unset ($_SESSION['display1']);
        header ('location: general.php');
        exit (0);
    }

    if (isset ($_POST['display2'])) {
        $_SESSION['display2'] = true;
        header ('location: general.php');
        exit (0);
    }

    if (isset ($_POST['hide2'])) {
        unset ($_SESSION['display2']);
        header ('location: general.php');
        exit (0);
    }

    if (isset ($_POST['display3'])) {
        $_SESSION['display3'] = true;
        header ('location: general.php');
        exit (0);
    }

    if (isset ($_POST['hide3'])) {
        unset ($_SESSION['display3']);
        header ('location: general.php');
        exit (0);
    }

    if (isset ($_POST['display4'])) {
        $_SESSION['display4'] = true;
        header ('location: general.php');
        exit (0);
    }

    if (isset ($_POST['hide4'])) {
        unset ($_SESSION['display4']);
        header ('location: general.php');
        exit (0);
    }

    if (isset ($_POST['display5'])) {
        $_SESSION['display5'] = true;
        header ('location: general.php');
        exit (0);
    }

    if (isset ($_POST['hide5'])) {
        unset ($_SESSION['display5']);
        header ('location: general.php');
        exit (0);
    }

    if (isset ($_POST['display6'])) {
        $_SESSION['display6'] = true;
        header ('location: general.php');
        exit (0);
    }

    if (isset ($_POST['hide6'])) {
        unset ($_SESSION['display6']);
        header ('location: general.php');
        exit (0);
    }
    
    if (isset ($_POST['display7'])) {
        $_SESSION['display7'] = true;
        header ('location: general.php');
        exit (0);
    }

    if (isset ($_POST['hide7'])) {
        unset ($_SESSION['display7']);
        header ('location: general.php');
        exit (0);
    }

    if (isset ($_POST['display8'])) {
        $_SESSION['display8'] = true;
        header ('location: general.php');
        exit (0);
    }

    if (isset ($_POST['hide8'])) {
        unset ($_SESSION['display8']);
        header ('location: general.php');
        exit (0);
    }

    if (isset ($_POST['display9'])) {
        $_SESSION['display9'] = true;
        header ('location: general.php');
        exit (0);
    }

    if (isset ($_POST['hide9'])) {
        unset ($_SESSION['display9']);
        header ('location: general.php');
        exit (0);
    }

    if (isset ($_POST['display10'])) {
        $_SESSION['display10'] = true;
        header ('location: general.php');
        exit (0);
    }

    if (isset ($_POST['hide10'])) {
        unset ($_SESSION['display10']);
        header ('location: general.php');
        exit (0);
    }


    function textboxValue ($value) {
        global $conn;
    
        $textbox = $conn->real_escape_string (trim ($_POST[$value]));
    
        if (empty ($textbox))
            return false;
        else return $textbox;
    }

    function getData1 () {
        global $conn;
    
        $sql = 'SELECT * FROM client INNER JOIN comanda ON client.client_id=comanda.client_id GROUP BY client.client_id';
        $stmt = $conn->prepare ($sql);

        if ($stmt->execute ()) {
            $result = $stmt->get_result ();
        
            if ($result->num_rows > 0) {
                return $result;
            }
        
            $stmt->close ();
        } else $_SESSION['fail-query'] = true;
    }

    function getData2 () {
        global $conn;
    
        $sql = 'SELECT * FROM produs INNER JOIN comanda ON produs.id=comanda.produs_id GROUP BY produs.id';
        $stmt = $conn->prepare ($sql);

        if ($stmt->execute ()) {
            $result = $stmt->get_result ();
        
            if ($result->num_rows > 0) {
                return $result;
            }
        
            $stmt->close ();
        } else $_SESSION['fail-query'] = true;
    }

    function getData3 ($id) {
        global $conn;
    
        $sql = 'SELECT * FROM proiect WHERE echipa_id IN (SELECT echipa_id FROM echipa INNER JOIN comanda ON echipa.id=comanda.echipa_id AND comanda.produs_id=?)';
        $stmt = $conn->prepare ($sql);
        $stmt->bind_param ('i', $id);

        if ($stmt->execute ()) {
            $result = $stmt->get_result ();
        
            if ($result->num_rows > 0) {
                return $result;
            }
        
            $stmt->close ();
        } else $_SESSION['fail-query'] = true;
    }

    function getData4 () {
        global $conn;
    
        $sql = 'SELECT * FROM echipa INNER JOIN proiect ON echipa.id=proiect.echipa_id';
        $stmt = $conn->prepare ($sql);

        if ($stmt->execute ()) {
            $result = $stmt->get_result ();
        
            if ($result->num_rows > 0) {
                return $result;
            }
        
            $stmt->close ();
        } else $_SESSION['fail-query'] = true;
    }

    function getData5 ($join_date, $salary) {
        global $conn;
    
        $sql = 'SELECT * FROM angajat WHERE data_angajare<? AND salariu>?';
        $stmt = $conn->prepare ($sql);
        $stmt->bind_param ('sd', $join_date, $salary);

        if ($stmt->execute ()) {
            $result = $stmt->get_result ();
        
            if ($result->num_rows > 0) {
                return $result;
            }
        
            $stmt->close ();
        } else $_SESSION['fail-query'] = true;
    }

    function getData6 ($id) {
        global $conn;
    
        $sql = 'SELECT * FROM echipa INNER JOIN proiect ON echipa.id=proiect.echipa_id AND echipa.id=(SELECT echipa_id FROM angajat WHERE id=?) GROUP BY proiect.id';
        $stmt = $conn->prepare ($sql);
        $stmt->bind_param ('i', $id);

        if ($stmt->execute ()) {
            $result = $stmt->get_result ();
        
            if ($result->num_rows > 0) {
                return $result;
            }
        
            $stmt->close ();
        } else $_SESSION['fail-query'] = true;
    }

    function getData7 ($id) {
        global $conn;
    
        $sql = 'SELECT * FROM comanda INNER JOIN produs ON produs.id=comanda.produs_id AND comanda.client_id=? GROUP BY produs.id';
        $stmt = $conn->prepare ($sql);
        $stmt->bind_param ('i', $id);

        if ($stmt->execute ()) {
            $result = $stmt->get_result ();
        
            if ($result->num_rows > 0) {
                return $result;
            }
        
            $stmt->close ();
        } else $_SESSION['fail-query'] = true;
    }

    function getData8 ($id) {
        global $conn;
    
        $sql = 'SELECT * FROM comanda INNER JOIN client ON client.client_id=comanda.client_id AND comanda.produs_id=? GROUP BY client.client_id';
        $stmt = $conn->prepare ($sql);
        $stmt->bind_param ('i', $id);

        if ($stmt->execute ()) {
            $result = $stmt->get_result ();
        
            if ($result->num_rows > 0) {
                return $result;
            }
        
            $stmt->close ();
        } else $_SESSION['fail-query'] = true;
    }

    function getData9 ($id) {
        global $conn;
    
        $sql = 'SELECT * FROM angajat INNER JOIN echipa ON angajat.echipa_id=echipa.id AND angajat.departament_id=? GROUP BY echipa.id';
        $stmt = $conn->prepare ($sql);
        $stmt->bind_param ('i', $id);

        if ($stmt->execute ()) {
            $result = $stmt->get_result ();
        
            if ($result->num_rows > 0) {
                return $result;
            }
        
            $stmt->close ();
        } else $_SESSION['fail-query'] = true;
    }

    function getData10Team ($id) {
        global $conn;
    
        $sql = 'SELECT * FROM angajat WHERE echipa_id=?';
        $stmt = $conn->prepare ($sql);
        $stmt->bind_param ('i', $id);

        if ($stmt->execute ()) {
            $result = $stmt->get_result ();
        
            if ($result->num_rows > 0) {
                return $result;
            }
        
            $stmt->close ();
        } else $_SESSION['fail-query'] = true;
    }

    function getData10Dep ($id) {
        global $conn;
    
        $sql = 'SELECT * FROM angajat WHERE departament_id=?';
        $stmt = $conn->prepare ($sql);
        $stmt->bind_param ('i', $id);

        if ($stmt->execute ()) {
            $result = $stmt->get_result ();
        
            if ($result->num_rows > 0) {
                return $result;
            }
        
            $stmt->close ();
        } else $_SESSION['fail-query'] = true;
    }
