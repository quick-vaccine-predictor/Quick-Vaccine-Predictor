<?php
//To debug in the terminal when the server is on
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

// Include connection file
require_once('connect.php');

// Iniziatializing variables
$email = "";
$password = "";
$errors = array();

// Register User
if(isset($_POST) & !empty($_POST)){
	//Recieve all input values from the form
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['password']); 
	$confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);


	//Form validation by adding corresponding errors into $errors array
	if(empty($email)) { array_push($errors, "Username is required"); }
	if(empty($password)) { array_push($errors, "Password is required"); }
	if($password != $confirm_password) { array_push($errors, "The two passwords do not match, try again!"); }
	

	// Check the DB to make sure a user does not already exist with the same email.
	//Prepare query
	$user_check_query = "SELECT * FROM User WHERE mail_user = '$email' LIMIT 1";
	$result = mysqli_query($conn, $user_check_query);
	// Fetching a result user as an associative array
	$user = mysqli_fetch_assoc($result);
	//print_r($user);
	//print($email);
	//die;


	if($user) { //if user exists
		if($user['mail_user'] == $email) {
			array_push($errors, "This email is already registered");
		}
	}
	
	// If there is no errors in the form register user:
	if (count($errors) == 0) {
		$password = password_hash($password, PASSWORD_DEFAULT);

		$sql = "INSERT INTO User (mail_user, password) VALUES ('$email', '$password')";
		mysqli_query($conn, $sql);

		session_start();
		$_SESSION['email'] = $email;
		$_SESSION['success'] = "You are now logged in!";
		header('location: index.php');

	}
	// Close connection
	mysqli_close($conn);

}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Sing Up</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
	<body>
		<div class="container">
			<form class="form-signin" action= "registerr.php" method="POST"><?php include('errors.php'); ?>
	 			<h2 class="form-signin-heading">Sign Up</h2>
	 			<p>Please fill this form to create an account.</p>
				<label for="inputEmail" class="sr-only">Email address</label>
			    <input type="email" name="email" id="inputEmail" value="<?php echo $email ?>" class="form-control" placeholder="Email address" required autofocus>
			    <label for="inputPassword" class="sr-only">Password</label>
			    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
			    <label for="inputPassword" class="sr-only">Confirm Password</label>
			    <input type="password" name="confirm_password" id="inputPassword" class="form-control" placeholder="Confirm Password" required>
			    <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
			   	<p>Already have an account? <a href="login.php">Sign in</a>.

			</form>
		</div>
	</body>
</html>
