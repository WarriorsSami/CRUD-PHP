<?php

    require_once ('Config/create_connection_db.php');

    $Valid = array (
        1 => "Binary Search Tree",
        2 => "(c - b)(c - a)(b - a)",
        3 => "2/5",
        4 => "6",
        5 => "1,4",
        6 => "0s",
        7 => "(1,2),(3,4),(5,0)",
        8 => "Dinic",
        9 => "6",
        10 => "O1",
        11 => "V1",
        12 => "13",
        13 => "F3",
        14 => "F4",
        15 => "F3",
        16 => "F1",
        17 => "F2",
        18 => "F1"
    );

    if (isset ($_POST['shut-down'])) {
        # receive and compute the final score
        $_SESSION['quiz-end'] = true;
        if (!isset ($_SESSION['score']))
            $_SESSION['score'] = (float)1;

        
        for ($i = 1; $i <= 18; ++ $i) {
            if (isset ($_POST['radios' . $i])) {
                $ans = $_POST['radios' . $i];
            }

            if (!empty ($ans) and $ans == $Valid[$i]) {
                $_SESSION['score'] += (float)0.5;
                # echo ('<br>' . '<br>' . '<br>' . '<br>' . '<br>' . '<br>' . $ans1);
            }
        }

        header ('location: quizz.php');
        exit (0);
    }

    if (isset ($_POST['quiz-reset'])) {
        # receive and compute the final score
        unset ($_SESSION['quiz-end']);
        $_SESSION['score'] = (float)1;

        header ('location: quizz.php');
        exit (0);
    }