<?php

    require_once ("js_util/component.php");
    require_once ("Controllers/authControllers.php");
    require_once ("Controllers/quizzControllers.php");
    require_once ("Controllers/userProfileControllers.php");
	
	if (!isset ($_SESSION['id'])) {
        $_SESSION['logout'] = true;
        header ('location: homepage.php');
        exit (0);
    }

    if (isset ($_SESSION['id']) and $_SESSION['verified'] == 0) {
        $_SESSION['illegal-access'] = true;
        header ('location: homepage.php');
        exit (0);
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Graph Quiz</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css">

    <link rel="icon" href="images/favi1.jpg" type="image/gif" sizes="16x16">

    <!-- Fontawesome Icons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

    <!-- Custom styles for this template -->
    <link href="css_util/carousel.css" rel="stylesheet"/>

    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script src="https://mdbootstrap.com/legacy/4.3.2/assets/compiled.min.js"></script>

    <style>
      p, h1, h2, h3, h4, h5 {
        color: whitesmoke;
        font-weight: bolder;
      }
    </style>
  </head>

  <body>
    <?php //test user's existence
    checkUser ();?>

    <header>
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="homepage.php"><!--<div id="root"></div>--><h2>Tech Savvy</h2></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="btn btn-primary" href="homepage.php"><i class="fa fa-home"></i> Home <span class="sr-only">(current)</span></a>
            </li>
            <?php if (!isset ($_SESSION['id'])): ?>
              <li class="nav-item">
                <a class="btn btn-info" href="login.php"><i class="fa fa-sign-in-alt" title="sign in"></i> Log In</a>
              </li>
              <li class="nav-item">
                <a class="btn btn-info" href="signup.php"><i class="fa fa-user-plus" title="sign up"></i> Register</a>
              </li>
            <?php endif; ?>
            <li class="nav-item">
              <a class="btn btn-success" href="meet.php"><i class="fa fa-users"></i> Meet the Team</a>
            </li>
            <?php if (!isset ($_SESSION['quiz-end'])): ?>
                <li class="nav-item">
                    <a class="btn btn-success" data-toggle="modal" data-target="#myModal0" href="#"><i class="fa fa-question"></i> Launch the Quiz</a>
                </li>
            <?php endif; ?>
            <li class="nav-item">
              <a class="btn btn-success disabled" data-toggle="modal" data-target="#question" href="#"><i class="fa fa-folder-plus"></i> Add a new question</a>
            </li>
          </ul>
            <?php if (isset ($_SESSION['id'])): ?>
                <a class="btn btn-outline-dark" data-toggle="modal" data-target="#menu" href="#"><span style="color: white;"><!-- <i class="fa fa-user-circle fa-lg"></i> -->
                        <img class="rounded-circle" src=<?php echo (getImage ()); ?> alt="Generic placeholder image" width="30" height="30">
                        <span style="color: darkorange;"><?php echo (getName ()); ?></span></span></a>
            <?php endif; ?>
        </div>
      </nav>
    </header>

    <main role="main">

        <div class="container text-left">
            <div class="modal fade" id="menu" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-body">
                            <div class="list-group">
                                <a class="btn btn-outline-light" href="profile.php"><i class="fa fa-user" style="color: coral;"></i> Profile</a>
                                <br>
                                <a class="btn btn-outline-light" href="conversations.php"><i class="fa fa-comment" style="color: tomato;"></i><sup>1</sup> Conversations</a>
                                <br>
                                <a class="btn btn-outline-light" href="homepage.php?logout=1"><i class="fa fa-sign-out-alt" style="color: deepskyblue;"></i> Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br><br><br>
      
        <form action="" method="post">
        <div class="container text-center">
            <h1 class="py-4 bg-dark text-light rounded"><i class="fas fa-project-diagram"></i> Enjoy our Graph Theory and Math Quiz</h1>

            <br>
            <div class="d-flex justify-content-center">
                <div class="content">
                    <div class="slider-wrapper">
                        Here you can
                        <div class="slider">
                            <div class="slider-text1">test your graph knowledge</div>
                            <div class="slider-text2">enjoy a lovely math quiz</div>
                            <div class="slider-text3">admire our front-end</div>
                        </div>
                    </div>       
                </div>
            </div>

            <?php if (isset ($_SESSION['quiz-end'])) { ?>
                <br>
                <h5 class="py-4 bg-dark text-light rounded">Your score: `<?php echo ($_SESSION['score']); ?>`/`10` point(s). 
                    <span style="color: orange;">
                        <?php
                            if ($_SESSION['score'] < (float)8.5)
                                echo ('Better luck next time!');
                            else if ((float)8.5 <= $_SESSION['score'] and $_SESSION['score'] <= (float)9.5)
                                echo ('Well done!');
                            else if ((float)9.5 < $_SESSION['score'])
                                echo ('Congratulations, champion!');
                        ?>
                    </span></h5>

                <!--<form action="" method="post">-->
                    <button class="btn btn-warning btn-lg" name="quiz-reset">Reset your score</button>
                <!--</form>-->
            <?php } ?>
        </div>

        <!-- Panel for Question Inserting -->
        <div class="container text-left">
            <div class="modal fade" id="question" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4 class="modal-title">Here you can create a new question!</h4>
                        </div>

                        <div class="modal-body">
                            <!--<form action="" method="post">-->

                            <!--</form>-->
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
        <!--<div class="container mt-sm-5 my-1">
                <div class="question ml-sm-5 pl-sm-5 pt-2">
                    <div class="py-2 h5"><b>Q. which option best describes your job role?</b></div>
                    <div class="ml-md-3 ml-sm-3 pl-md-5 pt-sm-0 pt-3" id="options"> <label class="options">Small Business Owner or Employee <input type="radio" name="radio"> <span class="checkmark"></span> </label> <label class="options">Nonprofit Owner or Employee <input type="radio" name="radio"> <span class="checkmark"></span> </label> <label class="options">Journalist or Activist <input type="radio" name="radio"> <span class="checkmark"></span> </label> <label class="options">Other <input type="radio" name="radio"> <span class="checkmark"></span> </label> </div>
                </div>
                <div class="d-flex align-items-center pt-3">
                    <div id="prev"> <button class="btn btn-primary">Previous</button> </div>
                    <div class="ml-auto mr-sm-5"> <button class="btn btn-success">Next</button> </div>
                </div>
        </div>

        <div class="container-fluid bg-info">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3><span class="label label-warning" id="qid">2</span> THREE is CORRECT</h3>
                    </div>
                    <div class="modal-body">
                        <div class="col-xs-3 col-xs-offset-5">
                            <div id="loadbar" style="display: none;">
                                <div class="blockG" id="rotateG_01"></div>
                                <div class="blockG" id="rotateG_02"></div>
                                <div class="blockG" id="rotateG_03"></div>
                                <div class="blockG" id="rotateG_04"></div>
                                <div class="blockG" id="rotateG_05"></div>
                                <div class="blockG" id="rotateG_06"></div>
                                <div class="blockG" id="rotateG_07"></div>
                                <div class="blockG" id="rotateG_08"></div>
                            </div>
                        </div>

                        <div class="quiz" id="quiz" data-toggle="buttons">
                            <label class="element-animation1 btn btn-lg btn-primary btn-block"><span class="btn-label"><i class="glyphicon glyphicon-chevron-right"></i></span> <input type="radio" name="q_answer" value="1">1 One</label>
                            <label class="element-animation2 btn btn-lg btn-primary btn-block"><span class="btn-label"><i class="glyphicon glyphicon-chevron-right"></i></span> <input type="radio" name="q_answer" value="2">2 Two</label>
                            <label class="element-animation3 btn btn-lg btn-primary btn-block"><span class="btn-label"><i class="glyphicon glyphicon-chevron-right"></i></span> <input type="radio" name="q_answer" value="3">3 Three</label>
                            <label class="element-animation4 btn btn-lg btn-primary btn-block"><span class="btn-label"><i class="glyphicon glyphicon-chevron-right"></i></span> <input type="radio" name="q_answer" value="4">4 Four</label>
                        </div>
                    </div>
                    <div class="modal-footer text-muted">
                        <span id="answer"></span>
                    </div>
                </div>
            </div>
        </div>-->

        <!-- Q1 -->
        <div class="container text-left">
            <div class="modal fade" id="myModal0" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4 class="modal-title">Answer the question 1!</h4>
                        </div>

                        <div class="modal-body">
                            <!--<form action="" method="post">-->
                                <h5>&nbsp;&nbsp;&nbsp;&nbsp;What kind of binary tree is Left Leaning Red-Black Tree?</h5>

                                <br><br>

                                <div class="row">
                                    <!--<div class="col">-->
                                        <div class="form-check">
                                            &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios1" id="exampleRadios11" value="Binary Heap">
                                            <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios11">
                                                $$ Binary\ Heap $$
                                            </label>
                                        </div>
                                    <!--</div>-->

                                    <!--<div class="col">-->
                                        <div class="form-check">
                                            &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios1" id="exampleRadios12" value="Binomial Heap">
                                            <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios12">
                                                $$ Binomial\ Heap $$
                                            </label>
                                        </div>
                                    <!--</div>-->
                                </div>
                                    
                                <div class="row">
                                    <!--<div class="col">-->
                                        <div class="form-check">
                                            &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios1" id="exampleRadios13" value="Binary Search Tree">
                                            <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios13">
                                                $$ Binary\ Search\ Tree $$
                                            </label>
                                        </div>
                                    <!--</div>-->
                                        
                                    <!--<div class="col">-->
                                        <div class="form-check">
                                            &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios1" id="exampleRadios14" value="Complete Binary Tree">
                                            <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios14">
                                                $$ Complete\ Binary\ Tree $$
                                            </label>
                                        </div>
                                    <!--</div>-->
                                </div>

                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <?php for ($i = 1; $i <= 18; ++ $i) 
                                    echo ('<a href="#" style="color:' . ($i == 1 ? 'whitesmoke;' : 'gray;') . '"data-dismiss="modal" data-toggle="modal" data-target="#myModal' . ($i - 1) . '">`' . $i . '`</a>&nbsp;&nbsp;'); ?>

                                <!--<button type="submit" class="btn btn-success" name="compute">Send your answers</button>-->
                            <!--</form>-->
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal17"><i class="fa fa-arrow-left"></i> Previous</button>
                            <?php for ($i = 1; $i <= 64; ++ $i) echo ('&nbsp;'); ?>
                            <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal1"><i class="fa fa-arrow-right"></i> Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Q2 -->
        <div class="container text-left">
            <div class="modal fade" id="myModal1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4 class="modal-title">Answer the question 2!</h4>
                        </div>

                        <div class="modal-body">
                            <h5>&nbsp;&nbsp;&nbsp;&nbsp;What is the value of the determinant diplayed below?</h5>
                            <h1> $$ \begin{vmatrix}
                                        1 & 1 & 1\\
                                        a & b & c\\
                                        a^2 & b^2 & c^2\\
                                    \end{vmatrix} $$ </h1>

                            <div class="row">
                                <div class="form-check">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios2" id="exampleRadios21" value="(c - b)(c - a)(b - a)">
                                    <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios21">
                                        $$ (c - b)(c - a)(b - a) $$
                                    </label>
                                </div>

                                <div class="form-check">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios2" id="exampleRadios22" value="(c - b^2)(c^2 - a)(b - a)">
                                    <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios22">
                                        $$ (c - b^2)(c^2 - a)(b - a) $$
                                    </label>
                                </div>
                            </div>
                                
                            <div class="row">
                                <div class="form-check">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios2" id="exampleRadios23" value="(c - b)(c + a)(b + a)">
                                    <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios23">
                                        $$ (c - b)(c + a)(b + a) $$
                                    </label>
                                </div>
                                    
                                <div class="form-check">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios2" id="exampleRadios24" value="(c - b)(c - a)(a - b)">
                                    <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios24">
                                        $$ (c - b)(c - a)(a - b) $$
                                    </label>
                                </div>
                            </div>

                            &nbsp;&nbsp;&nbsp;&nbsp;
                                <?php for ($i = 1; $i <= 18; ++ $i) 
                                    echo ('<a href="#" style="color:' . ($i == 2 ? 'whitesmoke;' : 'gray;') . '" data-dismiss="modal" data-toggle="modal" data-target="#myModal' . ($i - 1) . '">`' . $i . '`</a>&nbsp;&nbsp;'); ?>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal0"><i class="fa fa-arrow-left"></i> Previous</button>
                            <?php for ($i = 1; $i <= 64; ++ $i) echo ('&nbsp;'); ?>
                            <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal2"><i class="fa fa-arrow-right"></i> Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Q3 -->
        <div class="container text-center">
            <div class="modal fade" id="myModal2" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4 class="modal-title">Answer the question 3!</h4>
                        </div>

                        <div class="modal-body">
                            <h5>&nbsp;&nbsp;&nbsp;&nbsp;Which is the probability to choose a reversible element from the ring `(\mathbb{Z_10},+,\cdot)`?</h5>

                            <br><br>

                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios3" id="exampleRadios31" value="1/10">
                                        <label class="btn btn-primary form-check-label" style="width: 150px; height: 70px;" for="exampleRadios31">
                                            $$ \frac{1}{10} $$
                                        </label>
                                    </div>
                                <!--</div>-->

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios3" id="exampleRadios32" value="2/5">
                                        <label class="btn btn-primary form-check-label" style="width: 150px; height: 70px;" for="exampleRadios32">
                                            $$ \frac{2}{5} $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>
                                
                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios3" id="exampleRadios33" value="7/10">
                                        <label class="btn btn-primary form-check-label" style="width: 150px; height: 70px;" for="exampleRadios33">
                                            $$ \frac{7}{10} $$
                                        </label>
                                    </div>
                                <!--</div>-->
                                    
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios3" id="exampleRadios34" value="1/2">
                                        <label class="btn btn-primary form-check-label" style="width: 150px; height: 70px;" for="exampleRadios34">
                                            $$ \frac{1}{2} $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>

                            &nbsp;&nbsp;&nbsp;&nbsp;
                                <?php for ($i = 1; $i <= 18; ++ $i) 
                                    echo ('<a href="#" style="color:' . ($i == 3 ? 'whitesmoke;' : 'gray;') . '" data-dismiss="modal" data-toggle="modal" data-target="#myModal' . ($i - 1) . '">`' . $i . '`</a>&nbsp;&nbsp;'); ?>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal1"><i class="fa fa-arrow-left"></i> Previous</button>
                            <?php for ($i = 1; $i <= 64; ++ $i) echo ('&nbsp;'); ?>
                            <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal3"><i class="fa fa-arrow-right"></i> Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Q4 -->
        <div class="container text-left">
            <div class="modal fade" id="myModal3" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4 class="modal-title">Answer the question 4!</h4>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <h5>&nbsp;&nbsp;&nbsp;&nbsp;What is the value of the maximum flow through the network displayed beside?</h5>
                                </div>

                                <div class="col">
                                    <img class="rounded" style="width: 250px; height: 250px;" src="images/graph.jpg" alt="The given network flow">
                                </div>
                            </div>

                            <br><br>

                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios4" id="exampleRadios41" value="1">
                                        <label class="btn btn-primary form-check-label" style="width: 150px; height: 50px;" for="exampleRadios41">
                                            $$ 1 $$
                                        </label>
                                    </div>
                                <!--</div>-->

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios4" id="exampleRadios42" value="10">
                                        <label class="btn btn-primary form-check-label" style="width: 150px; height: 50px;" for="exampleRadios42">
                                            $$ 10 $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>
                                
                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios4" id="exampleRadios43" value="4">
                                        <label class="btn btn-primary form-check-label" style="width: 150px; height: 50px;" for="exampleRadios43">
                                            $$ 4 $$
                                        </label>
                                    </div>
                                <!--</div>-->
                                    
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios4" id="exampleRadios44" value="6">
                                        <label class="btn btn-primary form-check-label" style="width: 150px; height: 50px;" for="exampleRadios44">
                                            $$ 6 $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>

                            &nbsp;&nbsp;&nbsp;&nbsp;
                                <?php for ($i = 1; $i <= 18; ++ $i) 
                                    echo ('<a href="#" style="color:' . ($i == 4 ? 'whitesmoke;' : 'gray;') . '" data-dismiss="modal" data-toggle="modal" data-target="#myModal' . ($i - 1) . '">`' . $i . '`</a>&nbsp;&nbsp;'); ?>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal2"><i class="fa fa-arrow-left"></i> Previous</button>
                            <?php for ($i = 1; $i <= 64; ++ $i) echo ('&nbsp;'); ?>
                            <button type="button" class="btn btn-success"  data-dismiss="modal" data-toggle="modal" data-target="#myModal4"><i class="fa fa-arrow-right"></i> Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Q5 -->
        <div class="container text-center">
            <div class="modal fade" id="myModal4" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4 class="modal-title">Answer the question 5!</h4>
                        </div>

                        <div class="modal-body">
                            <h5>&nbsp;&nbsp;&nbsp;&nbsp;Which are the solutions of the equation `\overline {2}x \ +\ \overline {5}\ =\ \overline {1}` in `\mathbb{Z_6}`?</h5>

                            <br><br>

                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios5" id="exampleRadios51" value="1,2,3">
                                        <label class="btn btn-primary form-check-label" style="width: 150px; height: 70px;" for="exampleRadios51">
                                            $$ \{{\overline {1}},\ {\overline {2}},\ {\overline {3}}\} $$
                                        </label>
                                    </div>
                                <!--</div>-->

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios5" id="exampleRadios52" value="1,4">
                                        <label class="btn btn-primary form-check-label" style="width: 150px; height: 70px;" for="exampleRadios52">
                                            $$ \{{\overline {1}},\ {\overline {4}}\} $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>
                                
                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios5" id="exampleRadios53" value="2,3,4,5">
                                        <label class="btn btn-primary form-check-label" style="width: 150px; height: 70px;" for="exampleRadios53">
                                            $$ \{{\overline {2}},\ {\overline {3}},\ {\overline {4}},\ {\overline {5}}\} $$
                                        </label>
                                    </div>
                                <!--</div>-->
                                    
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios5" id="exampleRadios54" value="none">
                                        <label class="btn btn-primary form-check-label" style="width: 150px; height: 70px;" for="exampleRadios54">
                                            $$ \emptyset $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>

                            &nbsp;&nbsp;&nbsp;&nbsp;
                                <?php for ($i = 1; $i <= 18; ++ $i) 
                                    echo ('<a href="#" style="color:' . ($i == 5 ? 'whitesmoke;' : 'gray;') . '" data-dismiss="modal" data-toggle="modal" data-target="#myModal' . ($i - 1) . '">`' . $i . '`</a>&nbsp;&nbsp;'); ?>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal3"><i class="fa fa-arrow-left"></i> Previous</button>
                            <?php for ($i = 1; $i <= 64; ++ $i) echo ('&nbsp;'); ?>
                            <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal5"><i class="fa fa-arrow-right"></i> Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Q6 -->
        <div class="container text-center">
            <div class="modal fade" id="myModal5" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4 class="modal-title">Answer the question 6!</h4>
                        </div>

                        <div class="modal-body">
                            <h5>&nbsp;&nbsp;&nbsp;&nbsp;What is the value of the determinant diplayed below in `\mathbb{Z} _{6}`?</h5>
                            <h1> $$ \begin{vmatrix}
                                        {\overline {1}} & {\overline {2}} & {\overline {3}}\\
                                        {\overline {2}} & {\overline {3}} & {\overline {1}}\\
                                        {\overline {3}} & {\overline {1}} & {\overline {2}}\\
                                    \end{vmatrix} $$ </h1>

                            <div class="row">
                                <div class="form-check">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios6" id="exampleRadios61" value="1">
                                    <label class="btn btn-primary form-check-label" style="width: 150px; height: 70px;" for="exampleRadios61">
                                        $$ {\overline {1}} $$
                                    </label>
                                </div>

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios6" id="exampleRadios62" value="2">
                                    <label class="btn btn-primary form-check-label" style="width: 150px; height: 70px;" for="exampleRadios62">
                                        $$ {\overline {2}} $$
                                    </label>
                                </div>
                            </div>
                                
                            <div class="row">
                                <div class="form-check">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios6" id="exampleRadios63" value="0s">
                                    <label class="btn btn-primary form-check-label" style="width: 150px; height: 70px;" for="exampleRadios63">
                                        $$ {\overline {0}} $$
                                    </label>
                                </div>
                                    
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios6" id="exampleRadios64" value="4">
                                    <label class="btn btn-primary form-check-label" style="width: 150px; height: 70px;" for="exampleRadios64">
                                        $$ {\overline {4}} $$
                                    </label>
                                </div>
                            </div>

                            &nbsp;&nbsp;&nbsp;&nbsp;
                                <?php for ($i = 1; $i <= 18; ++ $i) 
                                    echo ('<a href="#" style="color:' . ($i == 6 ? 'whitesmoke;' : 'gray;') . '" data-dismiss="modal" data-toggle="modal" data-target="#myModal' . ($i - 1) . '">`' . $i . '`</a>&nbsp;&nbsp;'); ?>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal4"><i class="fa fa-arrow-left"></i> Previous</button>
                            <?php for ($i = 1; $i <= 64; ++ $i) echo ('&nbsp;'); ?>
                            <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal6"><i class="fa fa-arrow-right"></i> Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Q7 -->
        <div class="container text-center">
            <div class="modal fade" id="myModal6" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4 class="modal-title">Answer the question 7!</h4>
                        </div>

                        <div class="modal-body">
                            <h5>&nbsp;&nbsp;&nbsp;&nbsp;Which are the solutions of the system of equations displayed below in `\mathbb{Z_6}`?</h5>
                            <h1> $$ \left\{
                                        \begin{align*}
                                            {\overline {2}}x\ +\ y\ =\ {\overline {4}}\\
                                            x\ +\ {\overline {2}}y\ =\ {\overline {5}}\\
                                        \end{align*}
                                    \right. $$ </h1>

                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios7" id="exampleRadios71" value="(1,2),(3,4),(5,0)">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios71">
                                            $$ \{({\overline {1}},\ {\overline {2}});\ ({\overline {3}},\ {\overline {4}});\ ({\overline {5}},\ {\overline {0}})\} $$
                                        </label>
                                    </div>
                                <!--</div>-->

                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios7" id="exampleRadios72" value="(1,4),(2,0),(5,3)">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios72">
                                            $$ \{({\overline {1}},\ {\overline {4}});\ ({\overline {2}},\ {\overline {0}});\ ({\overline {5}},\ {\overline {3}})\} $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>
                                
                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios7" id="exampleRadios73" value="(2,3),(4,5)">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios73">
                                            $$ \{({\overline {2}},\ {\overline {3}});\ ({\overline {4}},\ {\overline {5}})\} $$
                                        </label>
                                    </div>
                                <!--</div>-->
                                    
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios7" id="exampleRadios74" value="none">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios74">
                                            $$ \emptyset $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>

                            &nbsp;&nbsp;&nbsp;&nbsp;
                                <?php for ($i = 1; $i <= 18; ++ $i) 
                                    echo ('<a href="#" style="color:' . ($i == 7 ? 'whitesmoke;' : 'gray;') . '" data-dismiss="modal" data-toggle="modal" data-target="#myModal' . ($i - 1) . '">`' . $i . '`</a>&nbsp;&nbsp;'); ?>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal5"><i class="fa fa-arrow-left"></i> Previous</button>
                            <?php for ($i = 1; $i <= 64; ++ $i) echo ('&nbsp;'); ?>
                            <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal7"><i class="fa fa-arrow-right"></i> Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Q8 -->
        <div class="container text-center">
            <div class="modal fade" id="myModal7" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4 class="modal-title">Answer the question 8!</h4>
                        </div>

                        <div class="modal-body">
                            <h5>&nbsp;&nbsp;&nbsp;&nbsp;What algorithm among the given list is used in computing the maximum flow in a network?</h5>

                            <br><br>

                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios8" id="exampleRadios81" value="D'Esopo-Pape">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios81">
                                            $$ D'Esopo-Pape $$
                                        </label>
                                    </div>
                                <!--</div>-->

                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios8" id="exampleRadios82" value="Boruvka">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios82">
                                            $$ Boruvka $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>
                                
                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios8" id="exampleRadios83" value="Dinic">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios83">
                                            $$ Dinic $$
                                        </label>
                                    </div>
                                <!--</div>-->
                                    
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios8" id="exampleRadios84" value="Kahn">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios84">
                                            $$ Kahn $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>

                            &nbsp;&nbsp;&nbsp;&nbsp;
                                <?php for ($i = 1; $i <= 18; ++ $i) 
                                    echo ('<a href="#" style="color:' . ($i == 8 ? 'whitesmoke;' : 'gray;') . '" data-dismiss="modal" data-toggle="modal" data-target="#myModal' . ($i - 1) . '">`' . $i . '`</a>&nbsp;&nbsp;'); ?>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal6"><i class="fa fa-arrow-left"></i> Previous</button>
                            <?php for ($i = 1; $i <= 64; ++ $i) echo ('&nbsp;'); ?>
                            <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal8"><i class="fa fa-arrow-right"></i> Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Q9 -->
        <div class="container text-center">
            <div class="modal fade" id="myModal8" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4 class="modal-title">Answer the question 9!</h4>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <h5>&nbsp;&nbsp;&nbsp;&nbsp;What is the length of the third shortest path between vertices `6` and `4` in the weighted directed graph displayed beside?</h5>
                                </div>

                                <div class="col">
                                    <img class="rounded" style="width: 250px; height: 250px;" src="images/graph1.jpg" alt="The given graph">
                                </div>
                            </div>

                            <br><br>

                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios9" id="exampleRadios91" value="1">
                                        <label class="btn btn-primary form-check-label" style="width: 150px; height: 50px;" for="exampleRadios91">
                                            $$ 1 $$
                                        </label>
                                    </div>
                                <!--</div>-->

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios9" id="exampleRadios92" value="10">
                                        <label class="btn btn-primary form-check-label" style="width: 150px; height: 50px;" for="exampleRadios92">
                                            $$ 10 $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>
                                
                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios9" id="exampleRadios93" value="4">
                                        <label class="btn btn-primary form-check-label" style="width: 150px; height: 50px;" for="exampleRadios93">
                                            $$ 4 $$
                                        </label>
                                    </div>
                                <!--</div>-->
                                    
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios9" id="exampleRadios94" value="6">
                                        <label class="btn btn-primary form-check-label" style="width: 150px; height: 50px;" for="exampleRadios94">
                                            $$ 6 $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>

                            &nbsp;&nbsp;&nbsp;&nbsp;
                                <?php for ($i = 1; $i <= 18; ++ $i) 
                                    echo ('<a href="#" style="color:' . ($i == 9 ? 'whitesmoke;' : 'gray;') . '" data-dismiss="modal" data-toggle="modal" data-target="#myModal' . ($i - 1) . '">`' . $i . '`</a>&nbsp;&nbsp;'); ?>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal7"><i class="fa fa-arrow-left"></i> Previous</button>
                            <?php for ($i = 1; $i <= 64; ++ $i) echo ('&nbsp;'); ?>
                            <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal9"><i class="fa fa-arrow-right"></i> Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Q10 -->
        <div class="container text-center">
            <div class="modal fade" id="myModal9" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4 class="modal-title">Answer the question 10!</h4>
                        </div>

                        <div class="modal-body">
                            <h5>&nbsp;&nbsp;&nbsp;&nbsp;What is the time complexity of the Dijkstra's Algorithm on sparse weighted graphs?</h5>

                            <br><br>

                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios10" id="exampleRadios101" value="O1">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios101">
                                            $$ O(m \log n) $$
                                        </label>
                                    </div>
                                <!--</div>-->

                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios10" id="exampleRadios102" value="O2">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios102">
                                            $$ O(\log^2 n) $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>
                                
                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios10" id="exampleRadios103" value="O3">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios103">
                                            $$ O(n^2) $$
                                        </label>
                                    </div>
                                <!--</div>-->
                                    
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios10" id="exampleRadios104" value="O4">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios104">
                                            $$ O(n^2 \log n) $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>

                            &nbsp;&nbsp;&nbsp;&nbsp;
                                <?php for ($i = 1; $i <= 18; ++ $i) 
                                    echo ('<a href="#" style="color:' . ($i == 10 ? 'whitesmoke;' : 'gray;') . '" data-dismiss="modal" data-toggle="modal" data-target="#myModal' . ($i - 1) . '">`' . $i . '`</a>&nbsp;&nbsp;'); ?>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal8"><i class="fa fa-arrow-left"></i> Previous</button>
                            <?php for ($i = 1; $i <= 64; ++ $i) echo ('&nbsp;'); ?>
                            <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal10"><i class="fa fa-arrow-right"></i> Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Q11 -->
        <div class="container text-center">
            <div class="modal fade" id="myModal10" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4 class="modal-title">Answer the question 11!</h4>
                        </div>

                        <div class="modal-body">
                            <h5>&nbsp;&nbsp;&nbsp;&nbsp;Consider a square `ABCD` with length of its side equal with `2`, `M` - the middle point of `BC` side 
                            and `N` - the middle point of `DC`. What is the value of the expression: `|\vec {AM}\ +\ \vec {AN}|`?</h5>

                            <br><br>

                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios11" id="exampleRadios111" value="V1">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios111">
                                            $$ 3\sqrt{2} $$
                                        </label>
                                    </div>
                                <!--</div>-->

                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios11" id="exampleRadios112" value="V2">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios112">
                                            $$ \frac{3}{2} $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>
                                
                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios11" id="exampleRadios113" value="V3">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios113">
                                            $$ 3 $$
                                        </label>
                                    </div>
                                <!--</div>-->
                                    
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios11" id="exampleRadios114" value="V4">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios114">
                                            $$ 3\sqrt{3} $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>

                            &nbsp;&nbsp;&nbsp;&nbsp;
                                <?php for ($i = 1; $i <= 18; ++ $i) 
                                    echo ('<a href="#" style="color:' . ($i == 11 ? 'whitesmoke;' : 'gray;') . '" data-dismiss="modal" data-toggle="modal" data-target="#myModal' . ($i - 1) . '">`' . $i . '`</a>&nbsp;&nbsp;'); ?>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal9"><i class="fa fa-arrow-left"></i> Previous</button>
                            <?php for ($i = 1; $i <= 64; ++ $i) echo ('&nbsp;'); ?>
                            <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal11"><i class="fa fa-arrow-right"></i> Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Q12 -->
        <div class="container text-center">
            <div class="modal fade" id="myModal11" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4 class="modal-title">Answer the question 12!</h4>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <h5>&nbsp;&nbsp;&nbsp;&nbsp;What is the weight of the minimum spanning tree of the graph displayed beside?</h5>
                                </div>

                                <div class="col">
                                    <img class="rounded" style="width: 250px; height: 250px;" src="images/graph2.jpg" alt="The given graph">
                                </div>
                            </div>

                            <br><br>

                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios12" id="exampleRadios121" value="17">
                                        <label class="btn btn-primary form-check-label" style="width: 150px; height: 50px;" for="exampleRadios121">
                                            $$ 17 $$
                                        </label>
                                    </div>
                                <!--</div>-->

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios12" id="exampleRadios122" value="10">
                                        <label class="btn btn-primary form-check-label" style="width: 150px; height: 50px;" for="exampleRadios122">
                                            $$ 10 $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>
                                
                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios12" id="exampleRadios123" value="14">
                                        <label class="btn btn-primary form-check-label" style="width: 150px; height: 50px;" for="exampleRadios123">
                                            $$ 14 $$
                                        </label>
                                    </div>
                                <!--</div>-->
                                    
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios12" id="exampleRadios124" value="13">
                                        <label class="btn btn-primary form-check-label" style="width: 150px; height: 50px;" for="exampleRadios124">
                                            $$ 13 $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>

                            &nbsp;&nbsp;&nbsp;&nbsp;
                                <?php for ($i = 1; $i <= 18; ++ $i) 
                                    echo ('<a href="#" style="color:' . ($i == 12 ? 'whitesmoke;' : 'gray;') . '" data-dismiss="modal" data-toggle="modal" data-target="#myModal' . ($i - 1) . '">`' . $i . '`</a>&nbsp;&nbsp;'); ?>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal10"><i class="fa fa-arrow-left"></i> Previous</button>
                            <?php for ($i = 1; $i <= 64; ++ $i) echo ('&nbsp;'); ?>
                            <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal12"><i class="fa fa-arrow-right"></i> Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Q13 -->
        <div class="container text-center">
            <div class="modal fade" id="myModal12" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4 class="modal-title">Answer the question 13!</h4>
                        </div>

                        <div class="modal-body">
                            <h5>&nbsp;&nbsp;&nbsp;&nbsp;Consider the function `f:\ \mathbb {R}\ \rightarrow\ \mathbb {R}`, 
                            `f\ =\ \frac{2}{x^2\ +\ 1}`. Choose from the given list a primitive of this function which cancels itself in `x\ =\ 0`.</h5>

                            <br><br>

                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios13" id="exampleRadios131" value="F1">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios131">
                                            $$ 2\ln {x} $$
                                        </label>
                                    </div>
                                <!--</div>-->

                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios13" id="exampleRadios132" value="F2">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios132">
                                            $$ 2\arcsin {x} $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>
                                
                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios13" id="exampleRadios133" value="F3">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios133">
                                            $$ 2\arctan {x} $$
                                        </label>
                                    </div>
                                <!--</div>-->
                                    
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios13" id="exampleRadios134" value="F4">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios134">
                                            $$ 2\sin {x^2} $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>

                            &nbsp;&nbsp;&nbsp;&nbsp;
                                <?php for ($i = 1; $i <= 18; ++ $i) 
                                    echo ('<a href="#" style="color:' . ($i == 13 ? 'whitesmoke;' : 'gray;') . '" data-dismiss="modal" data-toggle="modal" data-target="#myModal' . ($i - 1) . '">`' . $i . '`</a>&nbsp;&nbsp;'); ?>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal11"><i class="fa fa-arrow-left"></i> Previous</button>
                            <?php for ($i = 1; $i <= 64; ++ $i) echo ('&nbsp;'); ?>
                            <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal13"><i class="fa fa-arrow-right"></i> Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Q14 -->
        <div class="container text-center">
            <div class="modal fade" id="myModal13" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4 class="modal-title">Answer the question 14!</h4>
                        </div>

                        <div class="modal-body">
                            <h5>&nbsp;&nbsp;&nbsp;&nbsp;Compute the given integral: $$ \displaystyle\int\limits_0^1 \frac{2x}{(x\ +\ 1)(x^2\ +\ 1)}dx $$</h5>

                            <br><br>

                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios14" id="exampleRadios141" value="F1">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios141">
                                            $$ \frac{1}{2\pi} $$
                                        </label>
                                    </div>
                                <!--</div>-->

                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios14" id="exampleRadios142" value="F2">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios142">
                                            $$ \frac{\pi}{2}\ -\ \frac{1}{2}\ln {2} $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>
                                
                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios14" id="exampleRadios143" value="F3">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios143">
                                            $$ \frac{\pi}{4} $$
                                        </label>
                                    </div>
                                <!--</div>-->
                                    
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios14" id="exampleRadios144" value="F4">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios144">
                                            $$ \frac{\pi}{4}\ -\ \frac{1}{2}\ln {2} $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>

                            &nbsp;&nbsp;&nbsp;&nbsp;
                                <?php for ($i = 1; $i <= 18; ++ $i) 
                                    echo ('<a href="#" style="color:' . ($i == 14 ? 'whitesmoke;' : 'gray;') . '" data-dismiss="modal" data-toggle="modal" data-target="#myModal' . ($i - 1) . '">`' . $i . '`</a>&nbsp;&nbsp;'); ?>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal12"><i class="fa fa-arrow-left"></i> Previous</button>
                            <?php for ($i = 1; $i <= 64; ++ $i) echo ('&nbsp;'); ?>
                            <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal14"><i class="fa fa-arrow-right"></i> Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Q15 -->
        <div class="container text-center">
            <div class="modal fade" id="myModal14" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4 class="modal-title">Answer the question 15!</h4>
                        </div>

                        <div class="modal-body">
                            <h5>&nbsp;&nbsp;&nbsp;&nbsp;Compute the given limit: $$ \lim_{n \to \infty} \displaystyle\int\limits_0^1 \frac{n\,x^n}{3x\ +\ 5}dx $$</h5>

                            <br><br>

                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios15" id="exampleRadios151" value="F1">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios151">
                                            $$ \frac{1}{2} $$
                                        </label>
                                    </div>
                                <!--</div>-->

                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios15" id="exampleRadios152" value="F2">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios152">
                                            $$ \frac{1}{2}\ -\ \frac{1}{8}\ln {2} $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>
                                
                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios15" id="exampleRadios153" value="F3">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios153">
                                            $$ \frac{1}{8} $$
                                        </label>
                                    </div>
                                <!--</div>-->
                                    
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios15" id="exampleRadios154" value="F4">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios154">
                                            $$ \pi\sqrt {3} $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>

                            &nbsp;&nbsp;&nbsp;&nbsp;
                                <?php for ($i = 1; $i <= 18; ++ $i) 
                                    echo ('<a href="#" style="color:' . ($i == 15 ? 'whitesmoke;' : 'gray;') . '" data-dismiss="modal" data-toggle="modal" data-target="#myModal' . ($i - 1) . '">`' . $i . '`</a>&nbsp;&nbsp;'); ?>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal13"><i class="fa fa-arrow-left"></i> Previous</button>
                            <?php for ($i = 1; $i <= 64; ++ $i) echo ('&nbsp;'); ?>
                            <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal15"><i class="fa fa-arrow-right"></i> Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Q16 -->
        <div class="container text-center">
            <div class="modal fade" id="myModal15" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4 class="modal-title">Answer the question 16!</h4>
                        </div>

                        <div class="modal-body">
                            <h5>&nbsp;&nbsp;&nbsp;&nbsp;Consider the binomial tuple: $$ \left(x^2\ +\ \frac{1}{\sqrt[\leftroot{-1}\uproot{2}\scriptstyle 3] {x}}\right)^{16},\ where\ x\ \in \mathbb{R}^{*}. $$
                            Which is the rank of the element from the binomial decomposition which contains `x^4`?</h5>

                            <br><br>

                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios16" id="exampleRadios161" value="F1">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios161">
                                            $$ 13 $$
                                        </label>
                                    </div>
                                <!--</div>-->

                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios16" id="exampleRadios162" value="F2">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios162">
                                            $$ 14 $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>
                                
                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios16" id="exampleRadios163" value="F3">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios163">
                                            $$ 15 $$
                                        </label>
                                    </div>
                                <!--</div>-->
                                    
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios16" id="exampleRadios164" value="F4">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios164">
                                            $$ 12 $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>

                            &nbsp;&nbsp;&nbsp;&nbsp;
                                <?php for ($i = 1; $i <= 18; ++ $i) 
                                    echo ('<a href="#" style="color:' . ($i == 16 ? 'whitesmoke;' : 'gray;') . '" data-dismiss="modal" data-toggle="modal" data-target="#myModal' . ($i - 1) . '">`' . $i . '`</a>&nbsp;&nbsp;'); ?>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal14"><i class="fa fa-arrow-left"></i> Previous</button>
                            <?php for ($i = 1; $i <= 64; ++ $i) echo ('&nbsp;'); ?>
                            <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal16"><i class="fa fa-arrow-right"></i> Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Q17 -->
        <div class="container text-center">
            <div class="modal fade" id="myModal16" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4 class="modal-title">Answer the question 17!</h4>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <h5>&nbsp;&nbsp;&nbsp;&nbsp;Which is the minimum lexicographic topological sorting of the directed graph displayed beside?</h5>
                                </div>

                                <div class="col">
                                    <img class="rounded" style="width: 250px; height: 250px;" src="images/graph3.jpg" alt="The given graph">
                                </div>
                            </div>

                            <br><br>

                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios17" id="exampleRadios171" value="F1">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 50px;" for="exampleRadios171">
                                            $$ \left(1,\ 2,\ 4,\ 3,\ 5,\ 7,\ 8,\ 6\right) $$
                                        </label>
                                    </div>
                                <!--</div>-->

                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios17" id="exampleRadios172" value="F2">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 50px;" for="exampleRadios172">
                                            $$ \left(1,\ 2,\ 6,\ 8,\ 3,\ 5,\ 4,\ 7\right) $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>
                                
                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios17" id="exampleRadios173" value="F3">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 50px;" for="exampleRadios173">
                                            $$ \left(7,\ 2,\ 8,\ 6,\ 4,\ 5,\ 3,\ 1\right) $$
                                        </label>
                                    </div>
                                <!--</div>-->
                                    
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios17" id="exampleRadios174" value="F4">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 50px;" for="exampleRadios174">
                                            $$ \left(1,\ 4,\ 6,\ 8,\ 3,\ 5,\ 2,\ 7\right) $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>

                            &nbsp;&nbsp;&nbsp;&nbsp;
                                <?php for ($i = 1; $i <= 18; ++ $i) 
                                    echo ('<a href="#" style="color:' . ($i == 17 ? 'whitesmoke;' : 'gray;') . '" data-dismiss="modal" data-toggle="modal" data-target="#myModal' . ($i - 1) . '">`' . $i . '`</a>&nbsp;&nbsp;'); ?>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal15"><i class="fa fa-arrow-left"></i> Previous</button>
                            <?php for ($i = 1; $i <= 64; ++ $i) echo ('&nbsp;'); ?>
                            <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal17"><i class="fa fa-arrow-right"></i> Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Q18 -->
        <div class="container text-center">
            <div class="modal fade" id="myModal17" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4 class="modal-title">Answer the question 18!</h4>
                        </div>

                        <div class="modal-body">
                            <h5>&nbsp;&nbsp;&nbsp;&nbsp;Which is the number of expressions contanining exactly `n` pairs of paranthesis correctly matched?</h5>

                            <br><br>

                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios18" id="exampleRadios181" value="F1">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios181">
                                            $$ {1 \over n\,+\,1}{2\,n \choose n} $$
                                        </label>
                                    </div>
                                <!--</div>-->

                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios18" id="exampleRadios182" value="F2">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 70px;" for="exampleRadios182">
                                            $$ {1 \over 2\,n\,-\,1}{3\,n \choose n\,-\,1} $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>
                                
                            <div class="row">
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios18" id="exampleRadios183" value="F3">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 90px;" for="exampleRadios183">
                                            $$ \left({1 \over 2\,n\,+\,1}\right)^{n^{2}\,+\,1} $$
                                        </label>
                                    </div>
                                <!--</div>-->
                                    
                                <!--<div class="col">-->
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="radios18" id="exampleRadios184" value="F4">
                                        <label class="btn btn-primary form-check-label" style="width: 200px; height: 90px;" for="exampleRadios184">
                                            $$ {1 \over 2\,n\,+\,1}{2n \choose n} $$
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>

                            &nbsp;&nbsp;&nbsp;&nbsp;
                                <?php for ($i = 1; $i <= 18; ++ $i) 
                                    echo ('<a href="#" style="color:' . ($i == 18 ? 'whitesmoke;' : 'gray;') . '" data-dismiss="modal" data-toggle="modal" data-target="#myModal' . ($i - 1) . '">`' . $i . '`</a>&nbsp;&nbsp;'); ?>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal16"><i class="fa fa-arrow-left"></i> Previous</button>
                            <?php for ($i = 1; $i <= 12; ++ $i) echo ('&nbsp;'); ?>
                            <button type="submit" class="btn btn-danger" name="shut-down">Send your answers</button>
                            <?php for ($i = 1; $i <= 14; ++ $i) echo ('&nbsp;'); ?>
                            <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#myModal0"><i class="fa fa-arrow-right"></i> Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>

        <br><br>
      <!-- FOOTER -->
      <footer class="container">
        <p class="float-right"><a href="#">Back to top</a></p>
        <p>&copy; 2020-2021 Company, Inc. &middot; <a href="#">Privacy</a> 
        &middot; <a href="#">Terms</a> &middot; <a href="mailto: usertechsavvy@gmail.com">Contact</a></p>
      </footer>
    </main>

    <!-- Toastr Control Panel -->
    <script src="js_util/toastr.js"></script>

    <!--<script>
        MathJax = {
            loader: {load: ['input/amsmath/systeme', 'output/chtml']}
        }
    </script>-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/holder.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.13.3/react.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.13.3/JSXTransformer.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-MML-AM_CHTML'></script>

    <!--<script>
        $(function(){
            var loading = $('#loadbar').hide();
            $(document)
            .ajaxStart(function () {
                loading.show();
            }).ajaxStop(function () {
                loading.hide();
            });
            
            $("label.btn").on('click',function () {
                var choice = $(this).find('input:radio').val();
                $('#loadbar').show();
                $('#quiz').fadeOut();
                setTimeout(function(){
                $( "#answer" ).html(  $(this).checking(choice) );      
                    $('#quiz').show();
                    $('#loadbar').fadeOut();
                /* something else */
                }, 1500);
            });

            $ans = 3;

            $.fn.checking = function(ck) {
                if (ck != $ans)
                    return 'INCORRECT';
                else 
                    return 'CORRECT';
            }; 
        });	
    </script>-->

    <?php if (isset ($_SESSION['login'])) {
      unset ($_SESSION['login']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.info ('You are logged in...');
              });
      </script>
    "); } ?>

    <?php if (isset ($_SESSION['logout'])) {
      unset ($_SESSION['logout']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('Please, log in first of all!');
              });
      </script>
    "); } ?>

    <?php if (isset ($_SESSION['illegal-access'])) {
      unset ($_SESSION['illegal-access']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('Please, verify your account!');
              });
      </script>
    "); } ?>

    <?php if (isset ($_SESSION['unfound-email'])) {
      unset ($_SESSION['unfound-email']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('Email does not exist in database...');
              });
      </script>
    ");} ?>

    <?php if (isset ($_SESSION['verified']) and $_SESSION['verified'] == 0) echo ("
      <script>
              $(document).ready (function () {
                toastr.info ('A verification link has been sent to your <a href=\"https://mail.google.com\">email</a>...');
              });
      </script>
    "); ?>

    <?php if (isset ($_SESSION['sent'])) {
      unset ($_SESSION['sent']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.info ('A recovering link has been sent to your <a href=\"https://mail.google.com\">email</a>...');
              });
      </script>
    ");} ?>

    <?php if (isset ($_SESSION['reset'])) {
      unset ($_SESSION['reset']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.info ('Your password has been reset...');
              });
      </script>
    ");} ?>

    <?php if (isset ($_SESSION['verif-acc'])) {
      unset ($_SESSION['verif-acc']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.success ('Your account has been successfully verified!');
              });
      </script>
    ");} ?>

    <?php if (isset ($_SESSION['reconnect'])) {
      unset ($_SESSION['reconnect']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.info ('You are already logged in!');
              });
      </script>
    ");} ?>

    <?php if (isset ($_SESSION['undef-user'])) {
      unset ($_SESSION['undef-user']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('User does not exist in our database...');
              });
      </script>
    ");} ?>
  </body>
</html>
