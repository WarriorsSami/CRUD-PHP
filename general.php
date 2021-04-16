<?php 

  require_once ("Config/create_connection_db.php");
  require_once ("js_util/component.php");
  require_once ("Controllers/authControllers.php");
  require_once ("Controllers/crudControllersGen.php");
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

    global $conn;
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

  <title>General</title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css">

  <link rel="icon" href="images/favi1.jpg" type="image/gif" sizes="16x16">

  <!-- Fontawesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

  <!-- Custom styles for this template -->
  <link href="css_util/carousel.css" rel="stylesheet"/>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet">
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
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

  <header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <a class="navbar-brand" href="homepage.php"><h2>Tech Savvy</h2></a>
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
              <a class="btn btn-info" href="login.php"><i class="fa fa-sign-in" title="sign in"></i> Log In</a>
            </li>
            <li class="nav-item">
              <a class="btn btn-info" href="signup.php"><i class="fa fa-user-plus" title="sign up"></i> Register</a>
            </li>
          <?php endif; ?>
          <li class="nav-item">
            <a class="btn btn-success" href="meet.php"><i class="fa fa-users"></i> Meet the Team</a>
          </li>
          <!--<li class="nav-item">
            <a class="btn btn-success" href="#"><i class="fa fa-apple"></i> CRUD App</a>
          </li>-->

          <!--<li class="nav-item">
            <div class="dropdown">
              <a href="#" class="dropdown-toggle btn btn-success" data-toggle="dropdown"><i class="fab fa-apple fa-lg"></i> CRUD App</a>
                <div class="dropdown-menu bg-dark">
                  <a class="btn btn-success" href="main.php"><i class="fa fa-mug-hot"></i> Customer</a>
                  <a class="btn btn-success" href="angajat.php"><i class="fa fa-user-tie"></i> Employee</a>
                  <a class="btn btn-success" href="departament.php"><i class="fa fa-building"></i> Department</a>
                  <a class="btn btn-success" href="comanda.php"><i class="fa fa-sort-amount-up"></i> Order</a>
                  <a class="btn btn-success" href="proiect.php"><i class="fa fa-project-diagram"></i> Project</a>
                  <a class="btn btn-success" href="produs.php"><i class="fab fa-microsoft"></i> Product</a>
                  <a class="btn btn-success" href="echipa.php"><i class="fab fa-teamspeak"></i> Team</a>
                </div>
            </div>
          </li>-->

          <li class="nav-item">
            <a href="#" class="dropdown-toggle btn btn-success" data-toggle="modal" data-target="#panel"><i class="fab fa-apple fa-lg"></i> CRUD App</a>
          </li>

          <li class="nav-item">
            <a class="btn btn-success" href="#" data-toggle="modal" data-target="#myModal"><i class= "fa fa-tv"></i> Get Query</a>
          </li>

          <!--<li class="nav-item">
            <a class="btn btn-success" href="angajat.php"><i class="fa fa-user-tie"></i> Employee</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-success" href="departament.php"><i class="fa fa-building"></i> Department</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-success" href="#"><i class="fa fa-sort-amount-up"></i> Order</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-success" href="#"><i class="fa fa-project-diagram"></i> Project</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-success" href="#"><i class="fab fa-microsoft"></i> Product</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-success" href="#"><i class="fab fa-teamspeak"></i> Team</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-success" href="#"><i class="fa fa-globe"></i> General</a>
          </li>-->
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
    <br><br>
    
    <div class="container text-center">
        <h1 class="py-4 bg-dark text-light rounded"><i style="color: orange;" class="fab fa-apple fa-lg"></i> IT CRUD Panel - General Queries</h1>
        
        <br>
        <div class="d-flex justify-content-center">
            <div class="content">
                <div class="slider-wrapper">
                    Here you can
                    <div class="slider">
                        <div class="slider-text1">launch SQL queries</div>
                        <div class="slider-text2">discover our DB and Team</div>
                        <div class="slider-text3">admire our front-end</div>
                    </div>
                </div>       
            </div>
        </div>

        <?php if (isset ($_SESSION['display1']) or (isset($_GET['panel']) and $_GET['panel'] == 1)) { ?>
            <br><br>
            <!-- Bootstrap form -->
            <div class="d-flex justify-content-center">
                <form action="" method="post" class="w-100">
                    <div class="d-flex justify-content-left">
                        <div class="row">
                            <div class="col">
                                <br>
                                <h5><span style="color: tomato;">Query 1: </span>Display all customers with at least one demand stored in our Data Base: </h5>
                            </div>

                            <div class="col">
                                <?php buttonElement ('btn-read1', 'btn btn-primary', '<i class= "fa fa-rocket fa-lg"></i> Launch execution', 'read1', 'data-toggle="tooltip" data-placement="bottom" title="execute query 1"'); ?>
                                <?php buttonElement ('btn-hide1', 'btn btn-warning', '<i class= "fas fa-eye-slash fa-lg"></i> Hide Query', 'hide1', 'data-toggle="tooltip" data-placement="bottom" title="hide query panel 1"'); ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <br><br>
            <!-- Bootstrap table -->
            <div class="d-flex table-data">
                <table class="table table-striped table-dark">
                    <thead class="thead-dark">
                        <tr>
                          <th>ID</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Email</th>
                          <th>Address</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php 
                            if (isset ($_POST['read1']) or (isset ($_GET['play']) and $_GET['play'] == 1)) {
                                $result = getData1 ();

                                if ($result) {
                                    $index = 0;
                                    while ($row = $result->fetch_assoc () and $index < 50) {
                                    ++ $index; ?>

                        <tr>
                            <td><?php echo ($row['client_id']); ?></td>
                            <td><?php echo ($row['prenume']); ?></td>
                            <td><?php echo ($row['nume']); ?></td>
                            <td><?php echo ($row['email']); ?></td>
                            <td><?php echo ($row['adresa']); ?></td>
                        </tr>

                        <?php       }
                                    $_SESSION['refreshed'] = true;
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>

        <?php if (isset ($_SESSION['display2']) or (isset ($_GET['panel']) and $_GET['panel'] == 2)) { ?>
            <br><br><br><br>
            <!-- Bootstrap form -->
            <div class="d-flex justify-content-center">
                <form action="" method="post" class="w-100">
                    <div class="d-flex justify-content-left">
                        <div class="row">
                            <div class="col">
                                <br>
                                <h5><span style="color: tomato;">Query 2: </span>Display all software products stored in our Data Base which
                                    occur in at least one demand: </h5>
                            </div>

                            <div class="col">
                                <?php buttonElement ('btn-read2', 'btn btn-primary', '<i class= "fa fa-rocket fa-lg"></i> Launch execution', 'read2', 'data-toggle="tooltip" data-placement="bottom" title="execute query 2"'); ?>
                                <?php buttonElement ('btn-hide2', 'btn btn-warning', '<i class= "fas fa-eye-slash fa-lg"></i> Hide Query', 'hide2', 'data-toggle="tooltip" data-placement="bottom" title="hide query panel 2"'); ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <br><br>
            <!-- Bootstrap table -->
            <div class="d-flex table-data">
                <table class="table table-striped table-dark">
                    <thead class="thead-dark">
                        <tr>
                          <th>ID</th>
                          <th>Name/Description</th>
                          <th>Requirements/Details</th>
                          <th>Disponibility</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php 
                            if (isset ($_POST['read2']) or (isset ($_GET['play']) and $_GET['play'] == 2)) {
                                $result = getData2 ();

                                if ($result) {
                                    $index = 0;
                                    while ($row = $result->fetch_assoc () and $index < 50) {
                                    ++ $index; ?>

                        <tr>
                            <td><?php echo ($row['produs_id']); ?></td>
                            <td><?php echo ($row['descriere']); ?></td>
                            <td><?php echo ($row['cerinte']); ?></td>
                            <td><?php echo ($row['disponibil']); ?></td>
                        </tr>

                        <?php       }
                                    $_SESSION['refreshed'] = true;
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>

        <?php if (isset ($_SESSION['display3']) or (isset ($_GET['panel']) and $_GET['panel'] == 3)) { ?>
            <br><br><br><br>
            <!-- Bootstrap form -->
            <div class="d-flex justify-content-center">
                <form action="" method="post" class="w-100">
                    <div class="d-flex justify-content-left">
                        <div class="row">
                            <div class="col">
                                <h5><span style="color: tomato;">Query 3: </span>Display all software projects which involve a specified product: </h5>

                                <?php buttonElement ('btn-read3', 'btn btn-primary', '<i class= "fa fa-rocket fa-lg"></i> Launch execution', 'read3', 'data-toggle="tooltip" data-placement="bottom" title="execute query 3"'); ?>
                                <?php buttonElement ('btn-hide3', 'btn btn-warning', '<i class= "fas fa-eye-slash fa-lg"></i> Hide Query', 'hide3', 'data-toggle="tooltip" data-placement="bottom" title="hide query panel 3"'); ?>
                            </div>

                            <div class="col">
                                <div class="py-4">
                                    <?php inputElement ('<i class="fa fa-id-badge fa-lg"></i>', 'ID', 'prod_id', ''); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <br><br>
            <!-- Bootstrap table -->
            <div class="d-flex table-data">
                <table class="table table-striped table-dark">
                    <thead class="thead-dark">
                        <tr>
                          <th>ID</th>
                          <th>Description</th>
                          <th>Deadline</th>
                          <th>Team ID</th>
                          <th>State</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php 
                            if (isset ($_POST['read3']) or (isset ($_GET['play']) and $_GET['play'] == 3)) {
                                if (isset ($_POST['read3']))
                                    $id = textboxValue ('prod_id');
                                else if (isset ($_GET['play']) and $_GET['play'] == 3)
                                    $id = $_GET['id1'];
                                $err = false;
                                #if (isset ($_SESSION['unset-np']))
                                    #unset ($_SESSION['unset-np']);

                                if (empty ($id)) {
                                    $err = true;
                                    $_SESSION['empty'] = true;
                                }
                                
                                if (!empty ($id)) {
                                    global $conn;
                                    $sql = 'SELECT * FROM produs WHERE id=? LIMIT 1';
                                    $stmt = $conn->prepare ($sql);
                                    $stmt->bind_param ('i', $id);
                                    $stmt->execute ();
                                    $result = $stmt->get_result ();
                                    $prod = $result->fetch_assoc ();

                                    if (isset ($prod))
                                        $_SESSION['product'] = $prod['descriere'];

                                    if (!$result->num_rows) {
                                        $err = true;
                                        #if (!isset ($_SESSION['no-prod']) and !isset ($_SESSION['unset-np']))
                                        $_SESSION['no-prod'] = true;
                                    }

                                    $stmt->close ();
                                }

                                if (!$err) {
                                    $result = getData3 ($id);
                        ?>

                        <!--<?php   if (isset ($_SESSION['product'])) { ?>-->

                        <tr>
                            <td colspan="5"><h5>Projects in which implementing a(n) <?php echo ($_SESSION['product']); ?> is involved are:</h5></td>
                        </tr>

                        <!--<?php   } ?>-->

                        <?php
                                    if ($result) {
                                        $index = 0;
                                        while ($row = $result->fetch_assoc () and $index < 50) {
                                            ++ $index; 
                        ?>

                        <tr>
                            <td><?php echo ($row['id']); ?></td>
                            <td><?php echo ($row['tip']); ?></td>
                            <td><?php echo ($row['deadline']); ?></td>
                            <td><?php echo ($row['echipa_id']); ?></td>
                            <td><?php echo ($row['finalizat']); ?></td>
                        </tr>

                        <?php           }
                                        $_SESSION['refreshed'] = true;
                                    }
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>

        <?php if (isset ($_SESSION['display4']) or (isset ($_GET['panel']) and $_GET['panel'] == 4)) { ?>
            <br><br><br><br>
            <!-- Bootstrap form -->
            <div class="d-flex justify-content-center">
                <form action="" method="post" class="w-100">
                    <div class="d-flex justify-content-left">
                        <div class="row">
                            <div class="col">
                                <br>
                                <h5><span style="color: tomato;">Query 4: </span>Display all teams involved in at least one project: </h5>
                            </div>

                            <div class="col">
                                <?php buttonElement ('btn-read4', 'btn btn-primary', '<i class= "fa fa-rocket fa-lg"></i> Launch execution', 'read4', 'data-toggle="tooltip" data-placement="bottom" title="execute query 4"'); ?>
                                <?php buttonElement ('btn-hide4', 'btn btn-warning', '<i class= "fas fa-eye-slash fa-lg"></i> Hide Query', 'hide4', 'data-toggle="tooltip" data-placement="bottom" title="hide query panel 4"'); ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <br><br>
            <!-- Bootstrap table -->
            <div class="d-flex table-data">
                <table class="table table-striped table-dark">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php 
                            if (isset ($_POST['read4']) or (isset ($_GET['play']) and $_GET['play'] == 4)) {
                                $result = getData4 ();

                                if ($result) {
                                    $index = 0;
                                    while ($row = $result->fetch_assoc () and $index < 50) {
                                    ++ $index; ?>

                        <tr>
                            <td><?php echo ($row['id']); ?></td>
                            <td><?php echo ($row['denumire']); ?></td>
                        </tr>

                        <?php       }
                                    $_SESSION['refreshed'] = true;
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>

        <?php if (isset ($_SESSION['display5']) or (isset ($_GET['panel']) and $_GET['panel'] == 5)) { ?>
            <br><br><br><br>
            <!-- Bootstrap form -->
            <div class="d-flex justify-content-center">
                <form action="" method="post" class="w-100">
                    <div class="d-flex justify-content-left">
                        <div class="row">
                            <div class="col">
                                <h5><span style="color: tomato;">Query 5: </span>Display all employees hired before a 
                                    specified date time with wage greater than a given one: </h5>

                                <?php buttonElement ('btn-read5', 'btn btn-primary', '<i class= "fa fa-rocket fa-lg"></i> Launch execution', 'read5', 'data-toggle="tooltip" data-placement="bottom" title="execute query 5"'); ?>
                                <?php buttonElement ('btn-hide5', 'btn btn-warning', '<i class= "fas fa-eye-slash fa-lg"></i> Hide Query', 'hide5', 'data-toggle="tooltip" data-placement="bottom" title="hide query panel 5"'); ?>
                            </div>

                            <div class="col">
                                <div class="py-2">
                                    <?php inputElement ('<i class="fa fa-calendar-week fa-lg"></i>', 'Joining Date', 'date', ''); ?>
                                </div>

                                <div class="py-2">
                                    <?php inputElement ('<i class="fa fa-dollar-sign fa-lg"></i>', 'Salary', 'money', ''); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <br><br><br>
            <!-- Bootstrap table -->
            <div class="d-flex table-data wide1">
                <table class="table table-striped table-dark ">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Manager</th>
                            <th>Team Leader</th>
                            <th>Joining Date</th>
                            <th>Salary</th>
                            <th>Department ID</th>
                            <th>Team ID</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php 
                            if (isset ($_POST['read5']) or (isset ($_GET['play']) and $_GET['play'] == 5)) {
                                if (isset ($_POST['read5'])) {
                                    $join_date = textboxValue('date');
                                    $salary = textboxValue('money');
                                } else if (isset ($_GET['play']) and $_GET['play'] == 5) {
                                    $join_date = $_GET['id1'];
                                    $salary = $_GET['id2'];
                                }
                                $err = false;

                                if (empty ($join_date) or empty ($salary)) {
                                    $err = true;
                                    $_SESSION['empty'] = true;
                                }

                                if (!empty ($join_date)) {
                                    $dt = DateTime::createFromFormat ("Y-m-d", $join_date);
                                    if ($dt === false) {
                                        $err = true;
                                        $_SESSION['wrong-data'] = true;
                                    }
                                }

                                if (!$err) {
                                    $result = getData5 ($join_date, $salary); ?>

                        <tr>
                            <td colspan="11"><h5>The entire list of employees hired before <?php echo ($join_date); ?> with
                                                wage greater than $<?php echo ($salary . ".00") ?> is: </h5></td>
                        </tr>

                        <?php       if ($result) {
                                        $index = 0;
                                        while ($row = $result->fetch_assoc () and $index < 50) {
                                            ++ $index; ?>

                        <tr>
                            <td><?php echo ($row['id']); ?></td>
                            <td><?php echo ($row['prenume']); ?></td>
                            <td><?php echo ($row['nume']); ?></td>
                            <td><?php echo ($row['email']); ?></td>
                            <td><?php echo ($row['adresa']); ?></td>
                            <td><?php echo ($row['manager']); ?></td>
                            <td><?php echo ($row['sef_proiect']); ?></td>
                            <td><?php echo ($row['data_angajare']); ?></td>
                            <td><?php echo ('$' . $row['salariu']); ?></td>
                            <td><?php echo ($row['departament_id']); ?></td>
                            <td><?php echo ($row['echipa_id']); ?></td>
                        </tr>

                        <?php           }
                                        $_SESSION['refreshed'] = true;
                                    }
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>

        <?php if (isset ($_SESSION['display6']) or (isset ($_GET['panel']) and $_GET['panel'] == 6)) { ?>
            <br><br><br><br>
            <!-- Bootstrap form -->
            <div class="d-flex justify-content-center">
                <form action="" method="post" class="w-100">
                    <div class="d-flex justify-content-left">
                        <div class="row">
                            <div class="col">
                                <h5><span style="color: tomato;">Query 6: </span>Display all projects a specified
                                employee is involved in: </h5>

                                <?php buttonElement ('btn-read6', 'btn btn-primary', '<i class= "fa fa-rocket fa-lg"></i> Launch execution', 'read6', 'data-toggle="tooltip" data-placement="bottom" title="execute query 6"'); ?>
                                <?php buttonElement ('btn-hide6', 'btn btn-warning', '<i class= "fas fa-eye-slash fa-lg"></i> Hide Query', 'hide6', 'data-toggle="tooltip" data-placement="bottom" title="hide query panel 6"'); ?>
                            </div>

                            <div class="col">
                                <div class="py-4">
                                    <?php inputElement ('<i class="fa fa-id-badge fa-lg"></i>', 'ID', 'emp_id', ''); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <br><br><br>
            <!-- Bootstrap table -->
            <div class="d-flex table-data wide1">
                <table class="table table-striped table-dark ">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Description</th>
                            <th>Deadline</th>
                            <th>Team ID</th>
                            <th>State</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php 
                            if (isset ($_POST['read6']) or (isset ($_GET['play']) and $_GET['play'] == 6)) {
                                if (isset ($_POST['read6']))
                                    $id = textboxValue ('emp_id');
                                else if (isset ($_GET['play']) and $_GET['play'] == 6)
                                    $id = $_GET['id1'];
                                $err = false;

                                if (empty ($id)) {
                                    $err = true;
                                    $_SESSION['empty'] = true;
                                }

                                if (!empty ($id)) {
                                    $sql ='SELECT * FROM angajat WHERE id=? LIMIT 1';
                                    $stmt = $conn->prepare ($sql);
                                    $stmt->bind_param ('i', $id);
                                    $stmt->execute ();
                                    $result = $stmt->get_result ();
                                    $emp = $result->fetch_assoc ();

                                    if (!isset ($emp)) {
                                        $err = true;
                                        $_SESSION['no-emp'] = true;
                                    }
                                }
                                
                                if (!$err) {
                                    $result = getData6 ($id); ?>

                        <tr>
                            <td colspan="5"><h5>The entire list of projects in which 
                            <?php echo ($emp['prenume'] . ' ' . $emp['nume']); ?> is involved is:</h5></td>
                        </tr>

                        <?php       if ($result) {
                                        $index = 0;
                                        while ($row = $result->fetch_assoc () and $index < 50) {
                                            ++ $index; ?>

                        <tr>
                            <td><?php echo ($row['id']); ?></td>
                            <td><?php echo ($row['tip']); ?></td>
                            <td><?php echo ($row['deadline']); ?></td>
                            <td><?php echo ($row['echipa_id']); ?></td>
                            <td><?php echo ($row['finalizat']); ?></td>
                        </tr>

                        <?php           }
                                        $_SESSION['refreshed'] = true;
                                    }
                                }
                            } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>

        <?php if (isset ($_SESSION['display7']) or (isset ($_GET['panel']) and $_GET['panel'] == 7)) { ?>
            <br><br><br><br>
            <!-- Bootstrap form -->
            <div class="d-flex justify-content-center">
                <form action="" method="post" class="w-100">
                    <div class="d-flex justify-content-left">
                        <div class="row">
                            <div class="col">
                                <h5><span style="color: tomato;">Query 7: </span>Display all software articles requsted by a specific customer: </h5>

                                <?php buttonElement ('btn-read7', 'btn btn-primary', '<i class= "fa fa-rocket fa-lg"></i> Launch execution', 'read7', 'data-toggle="tooltip" data-placement="bottom" title="execute query 7"'); ?>
                                <?php buttonElement ('btn-hide7', 'btn btn-warning', '<i class= "fas fa-eye-slash fa-lg"></i> Hide Query', 'hide7', 'data-toggle="tooltip" data-placement="bottom" title="hide query panel 7"'); ?>
                            </div>

                            <div class="col">
                                <div class="py-4">
                                    <?php inputElement ('<i class="fa fa-id-badge fa-lg"></i>', 'ID', 'cust_id', ''); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <br><br>
            <!-- Bootstrap table -->
            <div class="d-flex table-data">
                <table class="table table-striped table-dark">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name/Description</th>
                            <th>Requirements/Details</th>
                            <th>Disponibility</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php 
                            if (isset ($_POST['read7']) or (isset ($_GET['play']) and $_GET['play'] == 7)) {
                                if (isset ($_POST['read7']))
                                    $id = textboxValue ('cust_id');
                                else if (isset ($_GET['play']) and $_GET['play'] == 7)
                                    $id = $_GET['id1'];
                                $err = false;

                                if (empty ($id)) {
                                    $err = true;
                                    $_SESSION['empty'] = true;
                                }
                                
                                if (!empty ($id)) {
                                    $sql = 'SELECT * FROM client WHERE client_id=? LIMIT 1';
                                    $stmt = $conn->prepare ($sql);
                                    $stmt->bind_param ('i', $id);
                                    $stmt->execute ();
                                    $result = $stmt->get_result ();
                                    $client = $result->fetch_assoc ();

                                    if (!isset ($client)) {
                                        $err = true;
                                        $_SESSION['no-cust'] = true;
                                    }

                                    $stmt->close ();
                                }

                                if (!$err) {
                                    $result = getData7 ($id); ?>

                        <tr>
                            <td colspan="4"><h5>The whole list of software articles requested by <?php echo ($client['prenume'] . ' ' . $client['nume']); ?> is:</h5></td>
                        </tr>

                        <?php
                                    if ($result) {
                                        $index = 0;
                                        while ($row = $result->fetch_assoc () and $index < 50) {
                                            ++ $index; ?>

                        <tr>
                            <td><?php echo ($row['id']); ?></td>
                            <td><?php echo ($row['descriere']); ?></td>
                            <td><?php echo ($row['cerinte']); ?></td>
                            <td><?php echo ($row['disponibil']); ?></td>
                        </tr>

                        <?php           }
                                        $_SESSION['refreshed'] = true;
                                    }
                                }
                            } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>

        <?php if (isset ($_SESSION['display8']) or (isset ($_GET['panel']) and $_GET['panel'] == 8)) { ?>
            <br><br><br><br>
            <!-- Bootstrap form -->
            <div class="d-flex justify-content-center">
                <form action="" method="post" class="w-100">
                    <div class="d-flex justify-content-left">
                        <div class="row">
                            <div class="col">
                                <h5><span style="color: tomato;">Query 8: </span>Display all customers who requested a specific software article: </h5>

                                <?php buttonElement ('btn-read8', 'btn btn-primary', '<i class= "fa fa-rocket fa-lg"></i> Launch execution', 'read8', 'data-toggle="tooltip" data-placement="bottom" title="execute query 8"'); ?>
                                <?php buttonElement ('btn-hide8', 'btn btn-warning', '<i class= "fas fa-eye-slash fa-lg"></i> Hide Query', 'hide8', 'data-toggle="tooltip" data-placement="bottom" title="hide query panel 8"'); ?>
                            </div>

                            <div class="col">
                                <div class="py-4">
                                    <?php inputElement ('<i class="fa fa-id-badge fa-lg"></i>', 'ID', 'art_id', ''); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <br><br>
            <!-- Bootstrap table -->
            <div class="d-flex table-data">
                <table class="table table-striped table-dark">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php 
                            if (isset ($_POST['read8']) or (isset ($_GET['play']) and $_GET['play'] == 8)) {
                                if (isset ($_POST['read8']))
                                    $id = textboxValue ('art_id');
                                else if (isset ($_GET['play']) and $_GET['play'] == 8)
                                    $id = $_GET['id1'];
                                $err = false;

                                if (empty ($id)) {
                                    $err = true;
                                    $_SESSION['empty'] = true;
                                }
                                
                                if (!empty ($id)) {
                                    $sql = 'SELECT * FROM produs WHERE id=? LIMIT 1';
                                    $stmt = $conn->prepare ($sql);
                                    $stmt->bind_param ('i', $id);
                                    $stmt->execute ();
                                    $result = $stmt->get_result ();
                                    $prod = $result->fetch_assoc ();

                                    if (!isset ($prod)) {
                                        $err = true;
                                        $_SESSION['no-prod'] = true;
                                    }

                                    $stmt->close ();
                                }

                                if (!$err) {
                                    $result = getData8 ($id); ?>

                        <tr>
                            <td colspan="5"><h5>The whole list of customers who requested a(n) <?php echo ($prod['descriere']); ?> is:</h5></td>
                        </tr>

                        <?php
                                    if ($result) {
                                        $index = 0;
                                        while ($row = $result->fetch_assoc () and $index < 50) {
                                            ++ $index; ?>

                        <tr>
                            <td><?php echo ($row['client_id']); ?></td>
                            <td><?php echo ($row['prenume']); ?></td>
                            <td><?php echo ($row['nume']); ?></td>
                            <td><?php echo ($row['email']); ?></td>
                            <td><?php echo ($row['adresa']); ?></td>
                        </tr>

                        <?php           }
                                        $_SESSION['refreshed'] = true;
                                    }
                                }
                            } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>

        <?php if (isset ($_SESSION['display9']) or (isset ($_GET['panel']) and $_GET['panel'] == 9)) { ?>
            <br><br><br><br>
            <!-- Bootstrap form -->
            <div class="d-flex justify-content-center">
                <form action="" method="post" class="w-100">
                    <div class="d-flex justify-content-left">
                        <div class="row">
                            <div class="col">
                                <h5><span style="color: tomato;">Query 9: </span>Display all teams employees from a specific department are engaged in: </h5>

                                <?php buttonElement ('btn-read9', 'btn btn-primary', '<i class= "fa fa-rocket fa-lg"></i> Launch execution', 'read9', 'data-toggle="tooltip" data-placement="bottom" title="execute query 9"'); ?>
                                <?php buttonElement ('btn-hide9', 'btn btn-warning', '<i class= "fas fa-eye-slash fa-lg"></i> Hide Query', 'hide9', 'data-toggle="tooltip" data-placement="bottom" title="hide query panel 9"'); ?>
                            </div>

                            <div class="col">
                                <div class="py-4">
                                    <?php inputElement ('<i class="fa fa-id-badge fa-lg"></i>', 'ID', 'dep_id', ''); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <br><br>
            <!-- Bootstrap table -->
            <div class="d-flex table-data">
                <table class="table table-striped table-dark">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php 
                            if (isset ($_POST['read9']) or (isset ($_GET['play']) and $_GET['play'] == 9)) {
                                if (isset ($_POST['read9']))
                                    $id = textboxValue ('dep_id');
                                else if (isset ($_GET['play']) and $_GET['play'] == 9)
                                    $id = $_GET['id1'];
                                $err = false;

                                if (empty ($id)) {
                                    $err = true;
                                    $_SESSION['empty'] = true;
                                }
                                
                                if (!empty ($id)) {
                                    $sql = 'SELECT * FROM departament WHERE id=? LIMIT 1';
                                    $stmt = $conn->prepare ($sql);
                                    $stmt->bind_param ('i', $id);
                                    $stmt->execute ();
                                    $result = $stmt->get_result ();
                                    $dep = $result->fetch_assoc ();

                                    if (!isset ($dep)) {
                                        $err = true;
                                        $_SESSION['no-dep'] = true;
                                    }

                                    $stmt->close ();
                                }

                                if (!$err) {
                                    $result = getData9 ($id); ?>

                        <tr>
                            <td colspan="2"><h5>The whole list of teams employees from <?php echo ($dep['denumire']); ?> are engaged in is:</h5></td>
                        </tr>

                        <?php
                                    if ($result) {
                                        $index = 0;
                                        while ($row = $result->fetch_assoc () and $index < 50) {
                                            ++ $index; ?>

                        <tr>
                            <td><?php echo ($row['id']); ?></td>
                            <td><?php echo ($row['denumire']); ?></td>
                        </tr>

                        <?php           }
                                        $_SESSION['refreshed'] = true;
                                    }
                                }
                            } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>

        <?php if (isset ($_SESSION['display10']) or (isset ($_GET['panel']) and $_GET['panel'] == 10)) { ?>
            <br><br><br><br>
            <!-- Bootstrap form -->
            <div class="d-flex justify-content-center">
                <form action="" method="post" class="w-100">
                    <div class="d-flex justify-content-left">
                        <div class="row">
                            <div class="col">
                                <h5><span style="color: tomato;">Query 10: </span>Display employees from a specific team and department and their team leader and manager: </h5>

                                <?php buttonElement ('btn-read10', 'btn btn-primary', '<i class= "fa fa-rocket fa-lg"></i> Launch execution', 'read10', 'data-toggle="tooltip" data-placement="bottom" title="execute query 10"'); ?>
                                <?php buttonElement ('btn-hide10', 'btn btn-warning', '<i class= "fas fa-eye-slash fa-lg"></i> Hide Query', 'hide10', 'data-toggle="tooltip" data-placement="bottom" title="hide query panel 10"'); ?>
                            </div>

                            <div class="col">
                                <div class="py-2">
                                    <?php inputElement ('<i class="fa fa-id-badge fa-lg"></i>', 'Team ID', 'tm_id', ''); ?>
                                </div>

                                <div class="py-2">
                                    <?php inputElement ('<i class="fa fa-id-badge fa-lg"></i>', 'Department ID', 'dp_id', ''); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <br><br><br>
            <!-- Bootstrap tables -->
            <div class="row">
                <div class="col">
                    <div class="d-flex table-data">
                        <table class="table table-striped table-dark ">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <?php 
                                    if (isset ($_POST['read10']) or (isset ($_GET['play']) and $_GET['play'] == 10)) {
                                        if (isset ($_POST['read10']))
                                            $id = textboxValue ('tm_id');
                                        else if (isset ($_GET['play']) and $_GET['play'] == 10)
                                            $id = $_GET['id1'];
                                        $err = false;

                                        if (empty ($id)) {
                                            $err = true;
                                            $_SESSION['empty'] = true;
                                        }

                                        if (!empty ($id)) {
                                            $sql = 'SELECT * FROM echipa WHERE id=? LIMIT 1';
                                            $stmt = $conn->prepare ($sql);
                                            $stmt->bind_param ('i', $id);
                                            $stmt->execute ();
                                            $result = $stmt->get_result ();
                                            $team = $result->fetch_assoc ();

                                            if (!isset ($team)) {
                                                $err = true;
                                                $_SESSION['no-team'] = true;
                                            }

                                            if (!$err) {
                                                $sql = 'SELECT * FROM angajat WHERE echipa_id=? AND sef_proiect=\'YES\' LIMIT 1';
                                                $stmt = $conn->prepare ($sql);
                                                $stmt->bind_param ('i', $id);
                                                $stmt->execute ();
                                                $result = $stmt->get_result ();
                                                $leader = $result->fetch_assoc ();
                                            }

                                            $stmt->close ();
                                        }

                                        if (!$err) {
                                            $result = getData10Team ($id); ?>

                                <tr>
                                    <td colspan="3"><h5>The team leader of <?php echo ($team['denumire']) ?> Team is:</h5></td>
                                </tr>

                                <?php if (isset ($leader)) { ?>
                                <tr>
                                    <td><?php echo ($leader['id']); ?></td>
                                    <td><?php echo ($leader['prenume']); ?></td>
                                    <td><?php echo ($leader['nume']); ?></td>
                                </tr>
                                <?php } ?>

                                <tr>
                                    <td colspan="3"><h5>Members of <?php echo ($team['denumire']) ?> Team are:</h5></td>
                                </tr>

                                <?php       if ($result) {
                                                $index = 0;
                                                while ($row = $result->fetch_assoc () and $index < 50) {
                                                    ++ $index; ?>

                                <tr>
                                    <td><?php echo ($row['id']); ?></td>
                                    <td><?php echo ($row['prenume']); ?></td>
                                    <td><?php echo ($row['nume']); ?></td>
                                </tr>

                                <?php           }
                                                $_SESSION['refreshed'] = true;
                                            }
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col">
                    <div class="d-flex table-data">
                        <table class="table table-striped table-dark ">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <?php 
                                    if (isset ($_POST['read10']) or (isset ($_GET['play']) and $_GET['play'] == 10)) {
                                        if (isset ($_POST['read10']))
                                            $id = textboxValue ('dp_id');
                                        else if (isset ($_GET['play']) and $_GET['play'] == 10)
                                            $id = $_GET['id2'];
                                        $err = false;

                                        if (empty ($id)) {
                                            $err = true;
                                            $_SESSION['empty'] = true;
                                        }

                                        if (!empty ($id)) {
                                            $sql = 'SELECT * FROM departament WHERE id=? LIMIT 1';
                                            $stmt = $conn->prepare ($sql);
                                            $stmt->bind_param ('i', $id);
                                            $stmt->execute ();
                                            $result = $stmt->get_result ();
                                            $dep = $result->fetch_assoc ();

                                            if (!isset ($dep)) {
                                                $err = true;
                                                $_SESSION['no-dep'] = true;
                                            }

                                            if (!$err) {
                                                $sql = 'SELECT * FROM angajat WHERE departament_id=? AND manager=\'YES\' LIMIT 1';
                                                $stmt = $conn->prepare ($sql);
                                                $stmt->bind_param ('i', $id);
                                                $stmt->execute ();
                                                $result = $stmt->get_result ();
                                                $manager = $result->fetch_assoc ();
                                            }

                                            $stmt->close ();
                                        }

                                        if (!$err) {
                                            $result = getData10Dep ($id); ?>

                                <tr>
                                    <td colspan="3"><h5>The manager of <?php echo ($dep['denumire']) ?> is:</h5></td>
                                </tr>

                                <tr>
                                    <td><?php echo ($manager['id']); ?></td>
                                    <td><?php echo ($manager['prenume']); ?></td>
                                    <td><?php echo ($manager['nume']); ?></td>
                                </tr>

                                <tr>
                                    <td colspan="3"><h5>Members of <?php echo ($dep['denumire']) ?> are:</h5></td>
                                </tr>

                                <?php       if ($result) {
                                                $index = 0;
                                                while ($row = $result->fetch_assoc () and $index < 50) {
                                                    ++ $index; ?>

                                <tr>
                                    <td><?php echo ($row['id']); ?></td>
                                    <td><?php echo ($row['prenume']); ?></td>
                                    <td><?php echo ($row['nume']); ?></td>
                                </tr>

                                <?php           }
                                                $_SESSION['refreshed'] = true;
                                            }
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    
    <div class="container text-center">
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content bg-dark">
                    <!--<div class="modal-header">
                        <h4 class="modal-title">Modal Header</h4>
                    </div>-->

                    <div class="modal-body">
                        <h5>Choose your query!</h5>

                        <div class="d-flex justify-content-center">
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col">
                                        <?php buttonElement ('btn-display1', 'btn btn-primary', '<i class= "fa fa-tv fa-lg"></i> Display Query 1', 'display1', 'data-toggle="tooltip" data-placement="bottom" title="display query panel 1"'); ?>
                                    </div>

                                    <div class="col">
                                        <?php buttonElement ('btn-display2', 'btn btn-success', '<i class= "fa fa-tv fa-lg"></i> Display Query 2', 'display2', 'data-toggle="tooltip" data-placement="bottom" title="display query panel 2"'); ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <?php buttonElement ('btn-display3', 'btn btn-warning', '<i class= "fa fa-tv fa-lg"></i> Display Query 3', 'display3', 'data-toggle="tooltip" data-placement="bottom" title="display query panel 3"'); ?>
                                    </div>

                                    <div class="col">
                                        <?php buttonElement ('btn-display4', 'btn btn-danger', '<i class= "fa fa-tv fa-lg"></i> Display Query 4', 'display4', 'data-toggle="tooltip" data-placement="bottom" title="display query panel 4"'); ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <?php buttonElement ('btn-display5', 'btn btn-success', '<i class= "fa fa-tv fa-lg"></i> Display Query 5', 'display5', 'data-toggle="tooltip" data-placement="bottom" title="display query panel 5"'); ?>
                                    </div>

                                    <div class="col">
                                        <?php buttonElement ('btn-display6', 'btn btn-primary', '<i class= "fa fa-tv fa-lg"></i> Display Query 6', 'display6', 'data-toggle="tooltip" data-placement="bottom" title="display query panel 6"'); ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <?php buttonElement ('btn-display7', 'btn btn-danger', '<i class= "fa fa-tv fa-lg"></i> Display Query 7', 'display7', 'data-toggle="tooltip" data-placement="bottom" title="display query panel 7"'); ?>
                                    </div>

                                    <div class="col">
                                        <?php buttonElement ('btn-display8', 'btn btn-warning', '<i class= "fa fa-tv fa-lg"></i> Display Query 8', 'display8', 'data-toggle="tooltip" data-placement="bottom" title="display query panel 8"'); ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <?php buttonElement ('btn-display9', 'btn btn-primary', '<i class= "fa fa-tv fa-lg"></i> Display Query 9', 'display9', 'data-toggle="tooltip" data-placement="bottom" title="display query panel 9"'); ?>
                                    </div>

                                    <div class="col">
                                        <?php buttonElement ('btn-display10', 'btn btn-success', '<i class= "fa fa-tv fa-lg"></i> Display Query 10', 'display10', 'data-toggle="tooltip" data-placement="bottom" title="display query panel 10"'); ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!--<div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>-->
                </div>
            </div>
        </div>
    </div>

    <div class="container text-center">
        <div class="modal fade" id="panel" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <h4 class="modal-title">Choose your CRUD GUI table!</h4>
                    </div>

                    <div class="modal-body">
                        <ul class="list-group" style="list-style-type: none;">
                            <a class="btn btn-success" href="main.php">
                                <li>
                                    <i class="fa fa-mug-hot"></i> Customer
                                </li>
                            </a>

                            <a class="btn btn-success" href="angajat.php">
                                <li>
                                    <i class="fa fa-user-tie"></i> Employee
                                </li>
                            </a>

                            <a class="btn btn-success" href="departament.php">
                                <li>
                                    <i class="fa fa-building"></i> Department
                                </li>
                            </a>

                            <a class="btn btn-success" href="comanda.php">
                                <li>
                                    <i class="fa fa-sort-amount-up"></i> Order
                                </li>
                            </a>

                            <a class="btn btn-success" href="proiect.php">
                                <li>
                                    <i class="fa fa-project-diagram"></i> Project
                                </li>
                            </a>

                            <a class="btn btn-success" href="produs.php">
                                <li>
                                    <i class="fab fa-microsoft"></i> Product
                                </li>
                            </a>

                            <a class="btn btn-success" href="echipa.php">
                                <li>
                                    <i class="fab fa-teamspeak"></i> Team
                                </li>
                            </a>
                        </ul>
                    </div>

                    <!--<div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>-->
                </div>
            </div>
        </div>
    </div>

    <br><br><br><br>
    <!-- FOOTER -->
    <footer class="container">
      <p class="float-right"><a href="#">Back to top</a></p>
      <p>&copy; 2020-2021 Company, Inc. &middot; <a href="#">Privacy</a> 
      &middot; <a href="#">Terms</a> &middot; <a href="mailto: usertechsavvy@gmail.com">Contact</a></p>
    </footer>
  </main>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>

  <!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
  <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
  <script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js"></script>
  <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
  <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/holder.min.js"></script>

  <!-- Toastr Control Panel -->
  <script src="js_util/toastr.js"></script>

  <!--<?php if (isset ($_SESSION['login'])) {
    unset ($_SESSION['login']);
    echo ("
    <script>
            $(document).ready (function () {
              toastr.info ('You are logged in...');
            });
    </script>
  "); } ?>-->

  <?php if (isset ($_SESSION['empty'])) {
    unset ($_SESSION['empty']);
    echo ("
    <script>
            $(document).ready (function () {
              toastr.error ('Enter input values for current query!');
            });
    </script>
  "); } ?>

  <?php if (isset ($_SESSION['refreshed'])) {
    unset ($_SESSION['refreshed']);
    echo ("
    <script>
            $(document).ready (function () {
              toastr.success ('Query was launched and executed successfully!');
            });
    </script>
  "); } ?>

  <?php if (isset ($_SESSION['fail-query'])) {
    unset ($_SESSION['fail-query']);
    echo ("
    <script>
            $(document).ready (function () {
              toastr.error ('Query failed during execution!');
            });
    </script>
  "); } ?>

  <?php if (isset ($_SESSION['wrong-data'])) {
    unset ($_SESSION['wrong-data']);
    echo ("
    <script>
            $(document).ready (function () {
              toastr.error ('Specified a correct date time format!');
            });
    </script>
  "); } ?>

  <?php if (isset ($_SESSION['no-prod'])) {
    unset ($_SESSION['no-prod']);
    #$_SESSION['unset-np'] = true;
    echo ("
    <script>
            $(document).ready (function () {
              toastr.error ('There is no product with specified id!');
            });
    </script>
  "); } ?>

  <?php if (isset ($_SESSION['no-emp'])) {
    unset ($_SESSION['no-emp']);
    #$_SESSION['unset-np'] = true;
    echo ("
    <script>
            $(document).ready (function () {
              toastr.error ('There is no employee with specified id!');
            });
    </script>
  "); } ?>

  <?php if (isset ($_SESSION['no-cust'])) {
    unset ($_SESSION['no-cust']);
    #$_SESSION['unset-np'] = true;
    echo ("
    <script>
            $(document).ready (function () {
              toastr.error ('There is no customer with specified id!');
            });
    </script>
  "); } ?>

  <?php if (isset ($_SESSION['no-dep'])) {
    unset ($_SESSION['no-dep']);
    #$_SESSION['unset-np'] = true;
    echo ("
    <script>
            $(document).ready (function () {
              toastr.error ('There is no department with specified id!');
            });
    </script>
  "); } ?>

  <?php if (isset ($_SESSION['no-team'])) {
    unset ($_SESSION['no-team']);
    #$_SESSION['unset-np'] = true;
    echo ("
    <script>
            $(document).ready (function () {
              toastr.error ('There is no team with specified id!');
            });
    </script>
  "); } ?>

</body>
</html>