<?php

    require_once ('Config/create_connection_db.php');
    require_once ('js_util/component.php');

    function getDataConv ($id) {
        global $conn;

        $query = 'SELECT * FROM conversation WHERE author_id=?';
        $stmt = $conn->prepare ($query);
        $stmt->bind_param ('i', $id);
        $stmt->execute ();
        $result = $stmt->get_result ();
        $stmt->close ();

        return $result;
    }

    function getDataConvAll () {
        global $conn;

        $query = 'SELECT * FROM conversation';
        $stmt = $conn->prepare ($query);
        $stmt->execute ();
        $result = $stmt->get_result ();
        $stmt->close ();

        return $result;
    }

    function getDataInvAll ($id) {
        global $conn;

        $query = 'SELECT * FROM invitation WHERE chat_id=?';
        $stmt = $conn->prepare ($query);
        $stmt->bind_param ('i', $id);
        $stmt->execute ();
        $result = $stmt->get_result ();
        $stmt->close ();

        return $result;
    }

    function getDataInvAll1 ($id) {
        global $conn;

        $query = 'SELECT * FROM invitation WHERE chat_id=?';
        $stmt = $conn->prepare ($query);
        $stmt->bind_param ('i', $id);
        $stmt->execute ();
        $result = $stmt->get_result ();
        $stmt->close ();

        return $result;
    }

    function getDataInvAllForUser ($id) {
        global $conn;

        $query = 'SELECT * FROM invitation WHERE usr_to=?';
        $stmt = $conn->prepare ($query);
        $stmt->bind_param ('i', $id);
        $stmt->execute ();
        $result = $stmt->get_result ();
        $stmt->close ();

        return $result;
    }

    function setIdConv (): int {
        $result = getDataConvAll ();
        $id = 0;

        if ($result) {
            while ($row = $result->fetch_assoc ())
                $id = $row['id'];
        }

        return $id + 1;
    }

    function setIdInv (): int {
        $result = getDataInvAll1 ($_GET['conversation']);
        $id = 0;

        if ($result) {
            while ($row = $result->fetch_assoc ())
                $id = $row['id'];
        }

        return $id + 1;
    }

    if (isset ($_POST['create-conv'])) {
        global $conn;

        $date = date ('Y-m-d', time ());
        $sql = 'INSERT INTO conversation (last_msg_id, last_msg_dir, time, author_id) VALUES (?, \'dr\', ?, ?)';
        $stmt = $conn->prepare ($sql);
        # if (!($stmt = $conn->prepare ($sql)))
            # echo ($conn->errno . ': ' . $conn->error);
        $stmt->bind_param ('isi', $_SESSION['id'], $date, $_SESSION['id']);

        if ($stmt->execute ()) {
            $_SESSION['conv-done'] = true;
        } else
            $_SESSION['conv-fail'] = $stmt->errno . ': ' . $stmt->error;

        /*$time = date ('Y-m-d H:i:s', time ());
        $sql1 = 'INSERT INTO invitation (status, usr_from, usr_to, chat_id, time) VALUES (\'acc\', ?, ?, ?, ?)';
        $stmt1 = $conn->prepare ($sql1);
        $stmt1->bind_param ('iiis',$_SESSION['id'], $_SESSION['id'], setIdConv (), $time);

        if ($stmt1->execute ()) {
            $_SESSION['conv-done'] = true;
        } else
            $_SESSION['conv-fail'] = $stmt1->errno . ': ' . $stmt1->error;*/

        header ('location: conversations.php');
        exit (0);
    }

    if (isset ($_POST['create-inv'])) {
        global $conn;

        $email = textboxValue1 ('user_email');
        $user = null;

        if (filter_var ($email, FILTER_VALIDATE_EMAIL) and !empty ($email)) {
            $sql = 'SELECT * FROM users WHERE email=? LIMIT 1';
            $stmt = $conn->prepare ($sql);
            $stmt->bind_param ('s', $email);
            $stmt->execute ();
            $result = $stmt->get_result ();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc ();
                $stmt->close ();
            } else {
                $_SESSION['no-user-inDB'] = true;
            }
        } else {
            $_SESSION['no-email'] = true;
        }

        if (!isset ($_SESSION['no-email']) and !isset ($_SESSION['no-user-inDB'])) {
            $sql = 'SELECT * FROM invitation WHERE chat_id=? and usr_to=?';
            $stmt = $conn->prepare ($sql);
            $stmt->bind_param ('ii', $_GET['conversation'], $user['id']);
            $stmt->execute ();
            $result = $stmt->get_result ();

            if (!$result->num_rows) {
                $time = date('Y-m-d H:i:s', time());
                $sql1 = 'INSERT INTO invitation (status, usr_from, usr_to, chat_id, time) VALUES (\'pending\', ?, ?, ?, ?)';
                $stmt1 = $conn->prepare($sql1);
                $stmt1->bind_param('iiis', $_SESSION['id'], $user['id'], $_GET['conversation'], $time);

                if ($stmt1->execute()) {
                    $_SESSION['inv-done'] = true;
                } else
                    $_SESSION['inv-fail'] = $stmt1->errno . ': ' . $stmt1->error;
            } else
                $_SESSION['already-inv-for-usr-conv'] = true;
        }

        header ('location: conversations.php?conversation=' . $_GET['conversation']);
        exit (0);
    }

    function getDataInv ($id) {
        global $conn;

        $query = 'SELECT * FROM invitation WHERE chat_id=? and status=\'acc\'';
        $stmt = $conn->prepare ($query);
        $stmt->bind_param ('i', $id);
        $stmt->execute ();
        $result = $stmt->get_result ();
        $stmt->close ();

        return $result;
    }

    function setIdInvMine (): int {
        $result = getDataInv ($_GET['conversation']);
        $id = 0;

        if ($result) {
            while ($row = $result->fetch_assoc ())
                $id = $row['id'];
        }

        return $id + 1;
    }