<?php 
	require_once ("Controllers/authControllers.php");
	
	//reset the password for a specific user using password-token
	if (isset ($_GET['password-token'])) {
		$passwordToken = $_GET['password-token'];
		resetPassword ($passwordToken);
	}

	//verify the user using token
	if (isset ($_GET['token'])) {
		$token = $_GET['token'];
		verifyUser ($token);
	}

	if (!isset ($_SESSION['id'])) {
		//echo $_SESSION['email'];
		header ('location: login.php');
		exit (0);
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<!-- Bootstrap 4 CSS -->
	<link rel="stylesheet" href="bootstrap.min.css">
	
	<link rel="stylesheet" href="style.css">

	<title>Homepage</title>
</head>

<body>
<div class="container">
	<div class="row">
		<div class="col-md-4 offset-md-4 form-div login">
		
			<?php if (isset ($_SESSION['message'])): ?>
				<div class="alert <?php echo $_SESSION['alert-class']; ?>">
					<?php 
						echo $_SESSION['message'];
						unset ($_SESSION['message']);
						unset ($_SESSION['alert-class']);
					?>
				</div>
			<?php endif; ?>
			
			<h3>Welcome, <?php echo $_SESSION['username']; ?>!</h3>
			
			<a href="index.php?logout=1" class="logout">logout</a>
			
			<?php if (!$_SESSION['verified']): ?>
				<div class="alert alert-warning">
					You need to verify your account.
					Sign in to your email account and click the
					verification link we've just emailed you at
					<strong><?php echo $_SESSION['email']; ?></strong>
				</div>
			<?php endif; ?>
			
			<?php if ($_SESSION['verified']): ?>
				<button type="button" class="btn btn-block btn-lg btn-outline-primary">I am verified!</button>
			<?php endif; ?>
		</div>
	</div>
</div>
</body>

</html>
