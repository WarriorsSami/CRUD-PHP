<?php 

  require_once ("js_util/component.php");
  require_once ("Controllers/authControllers.php");
  require_once ("Controllers/crudControllersAng.php");
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

    <title>Employee</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css">

    <link rel="icon" href="images/favi1.jpg" type="image/gif" sizes="16x16">

    <!-- Fontawesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

    <!-- Custom styles for this template -->
    <link href="css_util/carousel.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script src="https://mdbootstrap.com/legacy/4.3.2/assets/compiled.min.js"></script>

    <style>
      p, h1, h2, h3, h4 {
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
              <div class="dropdown">
                <a href="#" class="dropdown-toggle btn btn-success" data-toggle="dropdown"><i class="fab fa-apple fa-lg"></i> CRUD App</a>
                  <div class="dropdown-menu bg-dark">
                    <a class="btn btn-success" href="main.php"><i class="fa fa-mug-hot"></i> Customer</a>
                    <a class="btn btn-success" href="departament.php"><i class="fa fa-building"></i> Department</a>
                    <a class="btn btn-success" href="comanda.php"><i class="fa fa-sort-amount-up"></i> Order</a>
                    <a class="btn btn-success" href="proiect.php"><i class="fa fa-project-diagram"></i> Project</a>
                    <a class="btn btn-success" href="produs.php"><i class="fab fa-microsoft"></i> Product</a>
                    <a class="btn btn-success" href="echipa.php"><i class="fab fa-teamspeak"></i> Team</a>
                    <a class="btn btn-success" href="general.php"><i class="fa fa-globe"></i> General</a>
                  </div>
              </div>
            </li>-->

            <li class="nav-item">
              <a href="#" class="dropdown-toggle btn btn-success" data-toggle="modal" data-target="#panel"><i class="fab fa-apple fa-lg"></i> CRUD App</a>
            </li>

            <!--<li class="nav-item">
              <a class="btn btn-success" href="#"><i class="fa fa-apple"></i> CRUD App</a>
            </li>-->
            <!--<li class="nav-item">
              <a class="btn btn-success" href="main.php"><i class="fa fa-mug-hot"></i> Customer</a>
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
          <h1 class="py-4 bg-dark text-light rounded"><i style="color: orange;" class="fab fa-apple fa-lg"></i> IT CRUD Panel - Employee</h1>
          
          <br><br>
          <div class="d-flex justify-content-center">
              <form action="" method="post" class="w-50">
                  <div class="py-2">
                      <?php inputElement ('<i class="fa fa-id-badge fa-lg"></i>', 'ID', 'ang_id', setId ()); ?>
                  </div>
                  
                  <div class="row">
                      <div class="col">
                          <div class="py-2">
                              <?php inputElement ('<i class="fa fa-user fa-lg"></i>', 'First Name', 'ang_name', ''); ?>
                          </div>
                      </div>

                      <div class="col">
                          <div class="py-2">
                              <?php inputElement ('<i class="fa fa-users fa-lg"></i>', 'Last Name', 'ang_surname', ''); ?>
                          </div>
                      </div>
                  </div>

                  <div class="py-2">
                      <?php inputElement ('<i class="fa fa-envelope fa-lg"></i>', 'Email', 'ang_email', ''); ?>
                  </div>

                  <div class="py-2">
                      <?php inputElement ('<i class="fa fa-building fa-lg"></i>', 'Address', 'ang_adr', ''); ?>
                  </div>

                  <div class="row">
                      <div class="col">
                          <div class="py-2">
                              <?php inputElement ('<i class="fa fa-user fa-lg"></i>', 'Manager', 'is_manager', ''); ?>
                          </div>
                      </div>

                      <div class="col">
                          <div class="py-2">
                              <?php inputElement ('<i class="fa fa-users fa-lg"></i>', 'Team Leader', 'is_lead', ''); ?>
                          </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col">
                          <div class="py-2">
                              <?php inputElement ('<i class="fa fa-calendar-week fa-lg"></i>', 'Joining Date', 'date', ''); ?>
                          </div>
                      </div>

                      <div class="col">
                          <div class="py-2">
                              <?php inputElement ('<i class="fa fa-dollar-sign fa-lg"></i>', 'Salary', 'money', ''); ?>
                          </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col">
                          <div class="py-2">
                              <?php inputElement ('<i class="fa fa-building fa-lg"></i>', 'Department ID', 'dep_id', ''); ?>
                          </div>
                      </div>

                      <div class="col">
                          <div class="py-2">
                              <?php inputElement ('<i class="fab fa-teamspeak fa-lg"></i>', 'Team ID', 'team_id', ''); ?>
                          </div>
                      </div>
                  </div>
                  
                  <div class="d-flex justify-content-center">
                      <?php buttonElement ('btn-create', 'btn btn-success', '<i class= "fa fa-plus fa-lg"></i> Create', 'create', 'data-toggle="tooltip" data-placement="bottom" title="Create"'); ?>
                      <?php buttonElement ('btn-read', 'btn btn-primary', '<i class= "fa fa-sync fa-lg"></i> Read', 'read', 'data-toggle="tooltip" data-placement="bottom" title="Read"'); ?>
                      <?php buttonElement ('btn-update', 'btn btn-warning', '<i class= "fa fa-pen fa-lg"></i> Update', 'update', 'data-toggle="tooltip" data-placement="bottom" title="Update"'); ?>
                      <?php buttonElement ('btn-delete', 'btn btn-danger', '<i class= "fa fa-trash fa-lg"></i> Delete', 'delete', 'data-toggle="tooltip" data-placement="bottom" title="delete"'); ?>
                      <?php deleteBtn (); ?>
                  </div>
              </form>
          </div>

          <br><br><br>
          <!-- Bootstrap table -->
          <div class="d-flex table-data wide">
              <table class="table table-striped table-dark">
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
                          <th>Edit</th>
                      </tr>
                  </thead>
                  <tbody id="tbody">
                      <?php 
                          if (isset ($_POST['read'])) {
                              $result = getData ();

                              if ($result) {
                                  $index = 0;
                                  while ($row = $result->fetch_assoc () and $index < 100) {
                                      ++ $index; ?>

                      <tr>
                          <td data-id="<?php echo ($row['id']); ?>"><?php echo ($row['id']); ?></td>
                          <td data-id="<?php echo ($row['id']); ?>"><?php echo ($row['prenume']); ?></td>
                          <td data-id="<?php echo ($row['id']); ?>"><?php echo ($row['nume']); ?></td>
                          <td data-id="<?php echo ($row['id']); ?>"><?php echo ($row['email']); ?></td>
                          <td data-id="<?php echo ($row['id']); ?>"><?php echo ($row['adresa']); ?></td>
                          <td data-id="<?php echo ($row['id']); ?>"><?php echo ($row['manager']); ?></td>
                          <td data-id="<?php echo ($row['id']); ?>"><?php echo ($row['sef_proiect']); ?></td>
                          <td data-id="<?php echo ($row['id']); ?>"><?php echo ($row['data_angajare']); ?></td>
                          <td data-id="<?php echo ($row['id']); ?>"><?php echo ('$' . $row['salariu']); ?></td>
                          <td data-id="<?php echo ($row['id']); ?>"><?php echo ($row['departament_id']); ?></td>
                          <td data-id="<?php echo ($row['id']); ?>"><?php echo ($row['echipa_id']); ?></td>
                          <td><i class="fa fa-edit btnedit" data-id="<?php echo ($row['id']); ?>"></i></td>
                      </tr>

                      <?php       }
                                  $_SESSION['refreshed'] = true;
                              }
                          }
                      ?>
                  </tbody>
              </table>
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
                                    <i class="fa fa-mug-hot"></i>  Customer
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

                            <a class="btn btn-success" href="general.php">
                                <li>
                                    <i class="fa fa-globe"></i> General
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
      
      <br><br><br>
      <!-- FOOTER -->
      <footer class="container">
        <p class="float-right"><a href="#">Back to top</a></p>
        <p>&copy; 2020-2021 Company, Inc. &middot; <a href="#">Privacy</a> 
        &middot; <a href="#">Terms</a> &middot; <a href="mailto: usertechsavvy@gmail.com">Contact</a></p>
      </footer>
    </main>

    <script src="js_util/ang_disp.js"></script>

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

    <?php if (isset ($_SESSION['inserted'])) {
      unset ($_SESSION['inserted']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.success ('New employee inserted!');
              });
      </script>
    "); } ?>

    <?php if (isset ($_SESSION['duplicate-manager'])) {
      echo ("
      <script>
              $(document).ready (function () {
                toastr.warning ('" . $_SESSION['nume_manager']. " is already the manager of " . $_SESSION['duplicate-manager'] . "!');
              });
      </script>
    "); 
      unset ($_SESSION['duplicate-manager']);} ?>

    <?php if (isset ($_SESSION['no-team-dep'])) {
      echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('Inexistent team or department!');
              });
      </script>
    "); 
      unset ($_SESSION['no-team-dep']);} ?>

    <?php if (isset ($_SESSION['perm-denied'])) {
      echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('Only admins can perform this action!');
              });
      </script>
    "); 
      unset ($_SESSION['perm-denied']);} ?>

    <?php if (isset ($_SESSION['perm-denied1'])) {
        echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('Only super admins can perform this action!');
              });
      </script>
    ");
        unset ($_SESSION['perm-denied1']);} ?>

    <?php if (isset ($_SESSION['duplicate-leader'])) {
      echo ("
      <script>
              $(document).ready (function () {
                toastr.warning ('" . $_SESSION['nume_sef']. " is already the team leader of " . $_SESSION['duplicate-leader'] . "!');
              });
      </script>
    "); 
      unset ($_SESSION['duplicate-leader']);} ?>

    <?php if (isset ($_SESSION['uninserted'])) {
      unset ($_SESSION['uninserted']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('Insertion failed!');
              });
      </script>
    "); } ?>

    <?php if (isset ($_SESSION['empty'])) {
      unset ($_SESSION['empty']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('Values required!');
              });
      </script>
    "); } ?>

    <?php if (isset ($_SESSION['updated'])) {
      unset ($_SESSION['updated']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.success ('Successfully updation!');
              });
      </script>
    "); } ?>

    <?php if (isset ($_SESSION['ufail'])) {
      unset ($_SESSION['ufail']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('Updation failed!');
              });
      </script>
    "); } ?>

    <?php if (isset ($_SESSION['uempty'])) {
      unset ($_SESSION['uempty']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('Select values using edit icon!');
              });
      </script>
    "); } ?>

    <?php if (isset ($_SESSION['refreshed'])) {
      unset ($_SESSION['refreshed']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.info ('Database has been refreshed!');
              });
      </script>
    "); } ?>

    <?php if (isset ($_SESSION['dempty'])) {
      unset ($_SESSION['dempty']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('Select values to delete!');
              });
      </script>
    "); } ?>

    <?php if (isset ($_SESSION['dfail'])) {
      unset ($_SESSION['dfail']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('Deletion failed!');
              });
      </script>
    "); } ?>

    <?php if (isset ($_SESSION['deleted'])) {
      unset ($_SESSION['deleted']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.success ('Successfully deletion!');
              });
      </script>
    "); } ?>

    <?php if (isset ($_SESSION['dall'])) {
      unset ($_SESSION['dall']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.success ('Successfully complete deletion!');
              });
      </script>
    "); } ?>

    <?php if (isset ($_SESSION['dallfail'])) {
      unset ($_SESSION['dallfail']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('Something went wrong and deletion collapsed!');
              });
      </script>
    "); } ?>
  </body>
</html>
