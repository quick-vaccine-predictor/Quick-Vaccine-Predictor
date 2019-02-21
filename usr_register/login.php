<?php
//To debug in the terminal when the server is on
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

// Include connection file
require_once('connect.php');

// Start the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: index.php");
  exit;
}

// Include connection file
require_once('connect.php');

// Iniziatializing variables
$email = "";
$password = "";
$errors = array();

// Login User
// Check if imput fields are filled and setting variables
if(isset($_POST) & !empty($_POST)) {
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['password']); 
	//print_r($_POST);
	//die;

	//Form validation by adding corresponding errors into $errors array
	if(empty($email)) {
		array_push($errors, "Email is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	if(count($errors) == 0) {
		$query = "SELECT * FROM User WHERE mail_user = '$email'";
		$result = mysqli_query($conn, $query);
		// Fetching a result user as an associative array
		$user = mysqli_fetch_assoc($result);
		//printf("%s, \n, (%s)",$user["password"], strlen($user["password"]));
		//die;

		// Check if username exists, if yes then verify password
		if (mysqli_num_rows($result) == 1){	
			$hash = $user['password'];
			if(password_verify($password,$hash)) {
				// Password is correct, so start a new session
				session_start();

				// Store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["id_user"] = $id_user;
                $_SESSION["email"] = $email;
                // Redirect user to MyVaccine page
                header('location: index.php');
			}else{
				// Display an error message if password is not valid
				array_push($errors, "The password you entered was not valid.");
			}
		
		} else {
		// Display an error message if username doesn't exist
		array_push($errors, "No account found with that username.");
		}

	} else {
		array_push($errors, "Oops! Something went wrong. Please try again!");
		header('location: loginn.php');

	}
	// Close connection
	mysqli_close($conn);	
}
	

?>

<!DOCTYPE html>
<html>
<head>
	<title>User Login</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
	<body>
		<div class="container">
			<form class="form-signin" method="POST"><?php include('errors.php'); ?>
	 			<h2 class="form-signin-heading">Please Login</h2>
	 			<label for="inputEmail" class="sr-only">Email address</label>
			    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
			    <label for="inputPassword" class="sr-only">Password</label>
			    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
			    <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
			    <p>Not yet a member? <a href="register.php">Sign up here</a>.</p>
			</form>
		</div>
	</body>
</html>
