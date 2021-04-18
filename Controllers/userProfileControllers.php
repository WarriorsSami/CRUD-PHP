<?php

    require_once ('Config/create_connection_db.php');
    require_once ('js_util/component.php');

    function getName (): string {
        global $conn;

        $sql = 'SELECT * FROM users WHERE id=?';
        $stmt = $conn->prepare ($sql);
        $stmt->bind_param ('i', $_SESSION['id']);
        $stmt->execute ();
        $result = $stmt->get_result ();

        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc ();
            return $result['username'] . ' (' . ($result['admin'] != 0 ? ($result['admin'] == 1 ? 'Admin' : 'SAdmin') : 'User') . ')';
        }

        $stmt->close ();
        return '(No user)';
    }

    function getNameByID ($id): string {
        global $conn;

        $sql = 'SELECT * FROM users WHERE id=?';
        $stmt = $conn->prepare ($sql);
        $stmt->bind_param ('i', $id);
        $stmt->execute ();
        $result = $stmt->get_result ();

        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc ();
            return $result['username'] . ' (' . ($result['admin'] != 0 ? ($result['admin'] == 1 ? 'Admin' : 'SAdmin') : 'User') . ')';
        }

        $stmt->close ();
        return '(No user)';
    }

    function getBios (): string {
        global $conn;

        $sql = 'SELECT * FROM users WHERE id=?';
        $stmt = $conn->prepare ($sql);
        $stmt->bind_param ('i', $_SESSION['id']);
        $stmt->execute ();
        $result = $stmt->get_result ();

        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc ();
            return $result['bios'];
        }

        $stmt->close ();
        return '';
    }

    function getImage (): string {
        global $conn;

        $sql = 'SELECT * FROM users WHERE id=?';
        $stmt = $conn->prepare ($sql);
        $stmt->bind_param ('i', $_SESSION['id']);
        $stmt->execute ();
        $result = $stmt->get_result ();

        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc ();
            if (!empty ($result['image_profile'])) {
                return 'images/' . $result['image_profile'];
            }
        }

        $stmt->close ();
        return 'images/rac.jpg';
    }

    function getImageByID ($id): string {
        global $conn;

        $sql = 'SELECT * FROM users WHERE id=?';
        $stmt = $conn->prepare ($sql);
        $stmt->bind_param ('i', $id);
        $stmt->execute ();
        $result = $stmt->get_result ();

        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc ();
            if (!empty ($result['image_profile'])) {
                return 'images/' . $result['image_profile'];
            }
        }

        $stmt->close ();
        return 'images/rac.jpg';
    }

    function textboxValue1 ($value) {
        global $conn;

        $textbox = $conn->real_escape_string (trim ($_POST[$value]));

        if (empty ($textbox))
            return false;
        else return $textbox;
    }

    if (isset ($_POST['update'])) {
        global $conn;

        $user_id = ($_SESSION['admin'] != 0 ? textboxValue1 ('user_id') : $_SESSION['id']);

        if ($user_id != setId1 ()) {
            $user_admin = textboxValue1('user_admin');
            $user_name = textboxValue1('user_name');
            $user_bios = textboxValue1('user_bios');

            if (!empty ($user_admin)) {

                if ($user_admin == 'cancel')
                    $user_admin = 0;

                $sql = 'UPDATE users SET admin=? WHERE id=?';
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ii', $user_admin, $user_id);

                if ($stmt->execute())
                    $_SESSION['upd-done'] = $user_name;
                else
                    $_SESSION['upd-fail'] = true;

                $stmt->close();
            }

            if (!empty ($user_name)) {

                $sql = 'UPDATE users SET username=? WHERE id=?';
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('si', $user_name, $user_id);

                if ($stmt->execute())
                    $_SESSION['upd-done'] = $user_name;
                else
                    $_SESSION['upd-fail'] = true;

                $stmt->close();
            }

            if (!empty ($user_bios)) {

                $sql = 'UPDATE users SET bios=? WHERE id=?';
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('si', $user_bios, $user_id);

                if ($stmt->execute())
                    $_SESSION['upd-done'] = true;
                else
                    $_SESSION['upd-fail'] = true;

                $stmt->close();
            }

            if (!empty ($_FILES['user_img']['name'])) {
                /*$file_name = basename ($_FILES['user_img']['name']);
                $file_type = pathinfo ($file_name, PATHINFO_EXTENSION);

                $allow_types = array ('jpg', 'jpeg', 'png', 'gif');
                if (in_array($file_type, $allow_types)) {
                    $image = $_FILES['user_img']['tmp_name'];
                    $img_content = addslashes (file_get_contents ($image));

                    $sql = 'UPDATE users SET image=? WHERE id=?';
                    $stmt = $conn->prepare ($sql);
                    $stmt->bind_param ('si', $img_content, $_SESSION['id']);

                    if ($stmt->execute ()) {
                        $_SESSION['upd-done'] = true;
                        $conn->query ('UPDATE users SET exist_photo=1 WHERE id=' . $_SESSION['id']);
                    }
                    else
                        $_SESSION['upd-fail'] = true;
                }*/

                $image_name = $_FILES['user_img']['name'];
                #$destination_path = getcwd () . DIRECTORY_SEPARATOR;
                $image_path = /*$destination_path . */
                    'C:/xampp/htdocs/Proiect Info/images/' . basename($image_name);
                $image_type = pathinfo($image_name, PATHINFO_EXTENSION);
                # chmod ('C:/xampp1/htdocs/Proiect Info/images', 0666);

                $allow_types = array('jpg', 'jpeg', 'png', 'gif');
                if (in_array($image_type, $allow_types)) {

                    $sql = 'UPDATE users SET image_profile=? WHERE id=?';
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('si', $image_name, $user_id);

                    if ($stmt->execute() and /*move_uploaded_file($_FILES['image']['tmp_name'], $image_path)*/
                        rename($_FILES['user_img']['tmp_name'], 'C:/xampp/htdocs/Proiect Info/images/' . basename($image_name))) {
                        $_SESSION['upd-done'] = true;
                        $conn->query('UPDATE users SET exist_photo=1 WHERE id=' . $user_id);
                    } else
                        $_SESSION['upd-fail'] = true;
                }
            }
        } else
            $_SESSION['no-upd'] = true;

        header ('location: profile.php');
        exit (0);
    }

    function getDataSami () {
        global $conn;

        $query = 'SELECT * FROM users';
        $stmt = $conn->prepare ($query);
        $stmt->execute ();
        $result = $stmt->get_result ();
        $stmt->close ();

        return $result;
    }

    function setId1 (): int {
        $result = getDataSami ();
        $id = 0;

        if ($result) {
            while ($row = $result->fetch_assoc ())
                $id = $row['id'];
        }

        return $id + 1;
    }

    function deleteData1 () {
        global $conn;

        $id = (int)textboxValue1 ('user_id');
        $sql = 'SELECT * FROM users WHERE id=? LIMIT 1';
        $stmt = $conn->prepare ($sql);
        $stmt->bind_param ('i', $id);
        $stmt->execute ();
        $result = $stmt->get_result ();

        if ($result->num_rows > 0) {
            $sql = "DELETE FROM users WHERE id=?";
            $stmt = $conn->prepare ($sql);
            $stmt->bind_param ('i', $id);

            if ($stmt->execute ())
                $_SESSION['deleted'] = true;
            else $_SESSION['dfail'] = true;

            $stmt->close ();
        }
    }

    if (isset ($_POST['del'])) {
        global $conn;

        $user_id = textboxValue1 ('user_id');

        if ($user_id != setId1 ()) {

            $sql = 'SELECT * FROM users WHERE id=? LIMIT 1';
            $stmt = $conn->prepare ($sql);
            $stmt->bind_param ('i', $user_id);
            $stmt->execute ();
            $result = $stmt->get_result ();
            $result = $result->fetch_assoc ();
            $user_status = $result['admin'];

            if ($user_status == 0 or $_SESSION['admin'] == 2) {
                deleteData1 ();
            } else
                $_SESSION['denied-perm'] = true;
        } else
            $_SESSION['no-del'] = true;

        header ('location: profile.php');
        exit (0);
    }