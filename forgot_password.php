<?php
    require_once ("Controllers/authControllers.php");
    require_once ("Controllers/userProfileControllers.php");

    if (isset ($_SESSION['id'])) {
        $_SESSION['reconnect'] = true;
        header ('location: homepage.php');
        exit (0);
    }

    global $errors, $username, $email;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css">
	
  <link rel="icon" href="images/favi1.jpg" type="image/gif" sizes="16x16">

  <!-- Fontawesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
  <script src="https://mdbootstrap.com/legacy/4.3.2/assets/compiled.min.js"></script>

	<!-- Custom styles for this template -->
  <link href="css_util/carousel.css" rel="stylesheet"/>

	<title>Forgot Password</title>

  <style>
      p, h1, h2 {
        color: whitesmoke;
        font-weight: bolder;
      }
  </style>
</head>

<body>

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
            <li class="nav-item">
              <a class="btn btn-success" href="meet.php"><i class="fa fa-users"></i> Meet the Team</a>
            </li>
            <li class="nav-item">
              <a class="btn btn-success" href="main.php"><i class="fab fa-apple fa-lg"></i> CRUD App</a>
            </li>
          </ul>
            <?php if (isset ($_SESSION['id'])): ?>
                <a class="btn btn-outline-dark" data-toggle="modal" data-target="#menu" href="#"><span style="color: white;"><!-- <i class="fa fa-user-circle fa-lg"></i> -->
                        <img class="rounded-circle" src=<?php echo (getImage ()); ?> alt="Generic placeholder image" width="30" height="30">
                        <span style="color: darkorange;"><?php echo (getName ()); ?></span></span></a>
            <?php endif; ?>
            <?php if (!isset ($_SESSION['id'])): ?>
                <a class="btn btn-info" href="login.php"><i class="fa fa-sign-in-alt" title="sign in"></i> Log In</a>
                &nbsp;&nbsp;
                <a class="btn btn-info" href="signup.php"><i class="fa fa-user-plus" title="sign up"></i> Register</a>
            <?php endif; ?>
        </div>
      </nav>
    </header>

<div class="container">
	<div class="row">
		<div class="col-md-4 offset-md-4 form-div login">
			<form action="forgot_password.php" method="post">
				<h3 class="text-center">Recover your password</h3>
				        <p>
                    Please enter your email address you used to sign up
                    on our website and we will assist you in recovering
                    your password. 
                </p>

				<!--<div class="alert alert-danger">
					<li>Username required</li>
				</div>-->
				<?php if (isset ($errors['db-error'])): ?>
					<div class="alert alert-danger">
						<li><?php echo $errors['db-error']; ?></li>
					</div>
				<?php endif; ?>

				<div class="form-group">
					<input type="email" name="email" class="form-control form-control-lg">
				</div>
				
				<div class="form-group">
					<button type="submit" name="forgot-password" class="btn btn-outline-primary btn-block btn-lg">
            Recover your password
          </button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- FOOTER -->
<footer class="container" style="font-weight: bolder;">
    <p class="float-right"><a href="#">Back to top</a></p>
    <p>&copy; 2020-2021 Company, Inc. &middot; <a href="#">Privacy</a> 
    &middot; <a href="#">Terms</a> &middot; <a href="mailto: usertechsavvy@gmail.com">Contact</a></p>
</footer>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script>window.jQuery || document.write('&lt;script src="../../assets/js/vendor/jquery-slim.min.js">&lt;\/script>')</script>
<script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
<script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js"></script>
<!-- Just to make our placeholder images work. Don't actually copy the next line! -->
<script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/holder.min.js"></script>

    <!-- Toastr Control Panel -->
    <script src="js_util/toastr.js"></script>

    <?php if (isset ($_SESSION['femail'])) {
      unset ($_SESSION['femail']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('Email is required!');
              });
      </script>
    "); } ?>

</body>

</html>
