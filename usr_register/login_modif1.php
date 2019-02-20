<?php
// Start the session
session_start();
require_once('connect.php');


if(isset($_POST) & !empty($_POST)){ 
	$email = mysqli_real_escape_string($conn, $_POST['email']); // escape variables for security (escape special characters in a string)
	$password = ($_POST['password']); //with md5 password encripted.

	$sql = "SELECT * FROM User WHERE mailUser='$email' AND Password='$password'";
	$result = mysqli_query($conn, $sql);
	// Check wether this data exist in database or not (should be 1, we have this specific user).
	$count = mysqli_num_rows($result);
	

	if($count == 1){
		// Set session to mailUser variable
		$_SESSION['mailUser'] = $email;
		print_r($_SESSION['mailUser']);
	} else {
		$fmsg = "Invalid Username or Password\n";
	}
}

// Check if in the $_SESSION there is a mail or not
if(isset($_SESSION['mailUser'])){
	$smsg = "User already logged in\n";
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
			<?php if(isset($smsg)){ ?><div class="alert alert-success" role="alert"> <?php echo $smsg; ?></div>
			<?php  } ?>
			<?php if(isset($fmsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?></div>
			<?php  } ?>
			<form class="form-signin" method="POST">
	 			<h2 class="form-signin-heading">Please Register</h2>
	 			<label for="inputEmail" class="sr-only">Email address</label>
			    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
			    <label for="inputPassword" class="sr-only">Password</label>
			    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
			    <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
			    <p>You don't have an account yet? <a href="register_modif1.php">Register here</a>.</p>
			</form>
		</div>
	</body>
</html>