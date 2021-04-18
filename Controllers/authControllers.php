<?php

session_start ();

# require_once ("Config/create_db.php");
# require_once ("Config/create_dbit.php");
require_once ("Config/create_connection_db.php");
require_once ("emailControllers.php");


$errors = array ();
$username = "";
$email = "";
global $conn;

if (isset ($_POST['signup-btn'])) {
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$passwordConf = $_POST['passwordConf'];
	
	//validation
	if (empty ($username)) {
		$errors['username'] = "Username required";
	}
	if (!filter_var ($email, FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = "Email address is Invalid";
	}
	if (empty ($email)) {
		$errors['email'] = "Email required";
	}
	if (empty ($password)) {
		$errors['password'] = "Password required";
	}
	if ($password != $passwordConf) {
		$errors['password'] = "The two passwords do not match";
	}
	
	$emailQuery = "SELECT * FROM users WHERE email=? LIMIT 1";
	$stmt = $conn->prepare ($emailQuery);
	$stmt->bind_param ('s', $email);
	$stmt->execute ();
	$result = $stmt->get_result ();
	$userCount = $result->num_rows;
	$stmt->close ();
	
	if ($userCount > 0) {
		$errors['email'] = "Email already exists";
	}
	
	if (count ($errors) === 0) {
		$password = password_hash ($password, PASSWORD_DEFAULT);
        try {
            $token = bin2hex(random_bytes(50));
        } catch (Exception $e) {
        }
        $verified = false;
		$admin = false;
		
		$sql = "INSERT INTO users (username, email, verified, token, password, admin) VALUES (?, ?, ?, ?, ?, ?)";
		$stmt = $conn->prepare ($sql);
		$stmt->bind_param ('ssbssb', $username, $email, $verified, $token, $password, $admin);
		
		if ($stmt->execute ()) {
			//login user
			$user_id = $conn->insert_id;
			$_SESSION['id'] = $user_id;
			$_SESSION['username'] = $username;
			$_SESSION['email'] = $email;
			$_SESSION['verified'] = $verified;
			$_SESSION['admin'] = $admin;
			
			sendVerificationEmail ($email, $token);
			
			//display flash message
			$_SESSION['message'] = "You are now logged in!";
			$_SESSION['alert-class'] = "alert-success";
			header ('location: homepage.php');
			exit (0);
		} else {
			$errors['db_error'] = "Database error: failed to register";
		}
	}
}


//if user clicks on the login button
if (isset ($_POST['login-btn'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if (empty ($username)) {
		$errors['username'] = "Username required";
	}
	if (empty ($password)) {
		$errors['password'] = "Password required";
	}
	
	$sql = "SELECT * FROM users WHERE email=? OR username=? LIMIT 1";
	$stmt = $conn->prepare ($sql);
	$stmt->bind_param ('ss', $username, $username);
	$stmt->execute ();
	$result = $stmt->get_result ();
	$user = $result->fetch_assoc ();
	
	if (isset ($user) and password_verify ($password, $user['password'])) {
		//successfully login
		$_SESSION['id'] = $user['id'];
		$_SESSION['username'] = $user['username'];
		$_SESSION['email'] = $user['email'];
		$_SESSION['verified'] = $user['verified'];
		$_SESSION['admin'] = $user['admin'];
		$_SESSION['login'] = true;
		
		//display flash message
		$_SESSION['message'] = "You are now logged in!";
		$_SESSION['alert-class'] = "alert-success";
		header ('location: homepage.php');
		exit (0);
	} else if (isset ($user) and !password_verify ($password, $user['password']) and !empty ($password)) {
		$errors['login-fail'] = "Wrong credentials";
	} else if (!isset ($user)) {
		$_SESSION['no-user'] = true;
	}
}


//logout user
if (isset ($_GET['logout'])) {
    unset ($_SESSION);
	session_destroy ();
	header ('location: homepage.php');
	exit (0);
}


//verify user by token
function verifyUser ($token) {
	global $conn;
	$sql = "SELECT * FROM users WHERE token=? LIMIT 1";
	$stmt = $conn->prepare ($sql);
	$stmt->bind_param ('s', $token);
	$stmt->execute ();
	$result = $stmt->get_result ();

	if ($result->num_rows > 0) {
		$user = $result->fetch_assoc ();
		$stmt->close ();
		$updateQuery = "UPDATE users SET verified=1 WHERE token=?";
		$stmt1 = $conn->prepare ($updateQuery);
		$stmt1->bind_param ('s', $token);

		if ($stmt1->execute ()) {
			//log user in
			$_SESSION['id'] = $user['id'];
			$_SESSION['username'] = $user['username'];
			$_SESSION['email'] = $user['email'];
			$_SESSION['admin'] = $user['admin'];
			$_SESSION['verified'] = 1;
			$_SESSION['verif-acc'] = true;
			
			//display flash message
			$_SESSION['message'] = "Your email address was successfully verified!";
			$_SESSION['alert-class'] = "alert-success";
			$stmt1->close ();
			header ('location: homepage.php');
			exit (0);
		}
	} else {
		$_SESSION['undef-user'] = true;
	}
}

//verify user by email
function checkUser () {
	if (isset ($_SESSION['email'])) {
		$email = $_SESSION['email'];
		global $conn;
		$sql = "SELECT * FROM users WHERE email=? LIMIT 1";
		$stmt = $conn->prepare ($sql);
		$stmt->bind_param ('s', $email);
		$stmt->execute ();
		$result = $stmt->get_result ();

		if ($result->num_rows > 0) {
			$user = $result->fetch_assoc ();
			$stmt->close ();
		} else {
			/*echo ("
			<script>
				$(document).ready (function () {
					toastr.error ('User does not exist anymore...');
				});
			</script>
			");*/
			#keep in mind: TOASTR DOESN'T WORK WITH LOGOUT!!!
			#DO NOT USE THEM TOGETHER ANYMORE!!!
			
			session_destroy ();
			unset ($_SESSION);
			header ('location: homepage.php');
		}
	}
}

//if user clicks on the forgot password button
if (isset ($_POST['forgot-password'])) {
	$email = $_POST['email'];

	if (!filter_var ($email, FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = "Email address is Invalid";
		$_SESSION['femail'] = true;
	}
	if (empty ($email)) {
		$errors['email'] = "Email required";
		$_SESSION['femail'] = true;
	}

	if (count ($errors) == 0) {
		$sql = "SELECT * FROM users WHERE email=? LIMIT 1";
		$stmt = $conn->prepare ($sql);
		$stmt->bind_param ('s', $email);
		$stmt->execute ();
		$result = $stmt->get_result ();
		if ($result->num_rows > 0) {
			$user = $result->fetch_assoc ();
			$token = $user['token'];
			sendPasswordResetLink ($email, $token);
			$_SESSION['sent'] = true;
			$stmt->close ();
		} else $_SESSION['unfound-email'] = true;
		header ('location: homepage.php');
		exit (0);
	} else {
		header ('location: forgot_password.php');
		exit (0);
	}
}


//if user clicks on the reset password button
if (isset ($_POST['reset-password'])) {
	$password = $_POST['password'];
	$passwordConf = $_POST['passwordConf'];

	if (empty ($password) || empty ($passwordConf)) {
		$errors['password'] = "Password required";
	}
	if ($password != $passwordConf) {
		$errors['password'] = "The two passwords do not match";
	}

	$password = password_hash ($password, PASSWORD_DEFAULT);
	$email = $_SESSION['email'];

	if (count ($errors) == 0) {
		$sql = "UPDATE users SET password=? WHERE email=?";
		$stmt = $conn->prepare ($sql);
		$stmt->bind_param ('ss', $password, $email);

		if ($stmt->execute ()) {
			//echo $email;

            $sql1 = "SELECT * FROM users WHERE email=? LIMIT 1";
            $stmt1 = $conn->prepare ($sql1);
            $stmt1->bind_param ('s',$email);
            $stmt1->execute ();
            $result = $stmt1->get_result ();
            $user = $result->fetch_assoc ();

            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['admin'] = $user['admin'];
            $_SESSION['login'] = true;
            if ($user['verified'] == 1)
                $_SESSION['verified'] = 1;

			$stmt->close ();
			$_SESSION['reset'] = true;
			header ('location: homepage.php');
			exit (0);
		}
	}
}


//reset password by password-token
function resetPassword ($token) {
	//echo $token;
	global $conn;
	$sql = "SELECT * FROM users WHERE token=? LIMIT 1";
	$stmt = $conn->prepare ($sql);
	$stmt->bind_param ('s', $token);
	$stmt->execute ();
	$result = $stmt->get_result ();
	$stmt->close ();
	$user = $result->fetch_assoc ();
	$_SESSION['email'] = $user['email'];
	//echo $user['email'];
	header ('location: reset_password.php');
	exit (0);
}