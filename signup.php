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

  <!-- Custom styles for this template -->
  <link href="css_util/carousel.css" rel="stylesheet"/>

  <title>Register</title>

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
            <li class="nav-item">
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
			<form action="signup.php" method="post">
				<h3 class="text-center">Register</h3>
				
				<!--<?php if (count ($errors) > 0): ?>
					<div class="alert alert-danger">
					<?php foreach ($errors as $error): ?>
						<li><?php echo $error; ?></li>
					<?php endforeach; ?>
					</div>
				<?php endif; ?>-->
				
				<?php if (isset ($errors['db-error'])): ?>
					<div class="alert alert-danger">
						<li><?php echo $errors['db-error']; ?></li>
					</div>
				<?php endif; ?>
				
				<div class="form-group">
					<label for="username">Username</label>
					<?php if (isset ($errors['username'])): ?>
						<div class="alert alert-danger">
							<li><?php echo $errors['username']; ?></li>
						</div>
					<?php endif; ?>

					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="fa fa-user fa-lg" title="user"></i>
							</span>
						</div>

						<input type="text" id="usernameInput" name="username" placeholder="Username" value="<?php echo $username; ?>" class="form-control form-control-lg" autofocus>
					</div>
				</div>
				
				<div class="form-group">
					<label for="email">Email</label>
					<?php if (isset ($errors['email'])): ?>
						<div class="alert alert-danger">
							<li><?php echo $errors['email']; ?></li>
						</div>
					<?php endif; ?>

					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="fa fa-envelope fa-lg" title="email"></i>
							</span>
						</div>

						<input type="email" id="emailInput" name="email" placeholder="Email" value="<?php echo $email; ?>" class="form-control form-control-lg">
					</div>
				</div>
				
				<div class="form-group">
					<label for="password">Password</label>
					<?php if (isset ($errors['password'])): ?>
						<div class="alert alert-danger">
							<li><?php echo $errors['password']; ?></li>
						</div>
					<?php endif; ?>

					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="fa fa-key fa-lg" title="password"></i>
							</span>
						</div>

						<input type="password" id="psw" name="password" class="form-control form-control-lg" 
							pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
							title="Must contain at least one number and one uppercase and lowercase letter, 
									and at least 8 or more characters" required>
					</div>
				</div>
				<div class="container" id="message">
					<h6>Password must contain the following:</h6>
					<p id="letter" class="invalid">A <b>lowercase</b> letter</p>
					<p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
					<p id="number" class="invalid">A <b>number</b></p>
					<p id="length" class="invalid">Minimum <b>8 characters</b></p>
    			</div>
    			<script type="application/javascript" src="js_util/testerPassword.js"></script>
				
				<div class="form-group">
					<label for="passwordConf">Password Confirm</label>

					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="fa fa-check fa-lg" title="cofirm password"></i>
							</span>
						</div>

						<input type="password" name="passwordConf" class="form-control form-control-lg">
					</div>
				</div>
				
				<div class="form-group">
					<button type="submit" name="signup-btn" class="btn btn-outline-primary btn-block btn-lg"><i class="fa fa-user-plus fa-lg" title="sign up"></i> Sign Up</button>
				</div>
				<p class="text-center" style="color: black;">Already a member? <a href="login.php">Sign In</a></p>
				
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

<?php if (isset ($_SESSION['another-err'])) {
    echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('".$_SESSION['another-err']."');
              });
      </script>
    ");
    unset ($_SESSION['another-err']);
} ?>

</body>

</html>
