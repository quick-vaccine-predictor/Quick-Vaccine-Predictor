<?php

require_once('connect.php');

if(isset($_POST) & !empty($_POST)){
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = md5($_POST['password']);

	$sql = "INSERT INTO User (mailUser, Password) VALUES ('$email', '$password')";

	if ($conn->query($sql) === TRUE) {
    	$smsg = "User Registration Successfull\n";
	} else {
	    $fmsg = "User Registration Failed\n";
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>User registration</title>
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
			    <label for="inputPassword" class="sr-only">Confirm_Password</label>
			    <input type="password" name="confirm_password" id="inputPassword" class="form-control" placeholder="Confirm_Password" required>
			    <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
			   	<p>Already have an account? <a href="login_modif1.php">Login here</a>.</p>
			</form>
		</div>
	</body>
</html>