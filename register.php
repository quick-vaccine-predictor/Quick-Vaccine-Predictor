<?php
//To debug in the terminal when the server is on
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

// Include connection file
include("globals.inc.php");
$title = "Register Page";
print headerDBW($title);

//Conection to the DB if needed
$conn = connectSQL();

// Iniziatializing variables
$email = "";
$password = "";
$errors = array();

// Register User
if(isset($_POST) & !empty($_POST)){
	//Recieve all input values from the form
	$email = mysqli_real_escape_string($conn, check_data($_POST['email']));
	$password = mysqli_real_escape_string($conn, check_data($_POST['password'])); 
	$confirm_password = mysqli_real_escape_string($conn, check_data($_POST['confirm_password']));


	//Form validation by adding corresponding errors into $errors array
	if(empty(check_data($email))) { array_push($errors, "Email is required"); }
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) { array_push($errors, "Invalid email format"); }
	if(empty(check_data($password))) { array_push($errors, "Password is required"); }
	if(strlen(check_data($password)) < 6){ array_push($errors, "Password must have atleast 6 characters."); }
	if($password != $confirm_password) { array_push($errors, "The two passwords do not match, try again!"); }
	

	// Check the DB to make sure a user does not already exist with the same email.
	$user_check_query = "SELECT * FROM User WHERE mailUser = '$email' LIMIT 1";
	$result = mysqli_query($conn, $user_check_query);
	// Fetching a result user as an associative array
	$user = mysqli_fetch_assoc($result);

	if($user) { //if user exists
		if($user['mailUser'] == $email) {
			array_push($errors, "This email is already registered");
		}
	}
	
	// If there is no errors in the form register user:
	if (count($errors) == 0) {
		$password = password_hash($password, PASSWORD_BCRYPT);

		$sql = "INSERT INTO User (mailUser, Password) VALUES ('$email', '$password')";
		mysqli_query($conn, $sql);

		session_start();
		$_SESSION["loggedin"] = true;
		$_SESSION['email'] = $email;
		$_SESSION['success'] = "You are now logged in!";
		header('location: my_vaccine.php');

	}
	// Close connection
		$conn->close();

}

print navbar('Sing Up');
?>


<div class="container">
	<form class="form-signin" action= "register.php" method="POST" autocomplete="on"><?php include('errors.php'); ?>
	 	<h2 class="form-signin-heading">Sign Up</h2>
	 	<h4>Please fill this form to create an account</h4>
	 	<br>
	 	<div class="input-group">
	 		<span class="input-group-addon"><i class="glyphicon glyphicon-user" data-toggle="tooltip" title="Introduce a correct email account" ></i></span>
			<label for="inputEmail" class="sr-only">Email address</label>
		    <input type="email" name="email" id="inputEmail" value="<?php if(isset($email) & !empty($email)){ echo $email; } ?>" class="form-control" placeholder="Email address" required autofocus>
		</div>
		<div class="input-group">
			<span class="input-group-addon"><i class="glyphicon glyphicon-lock" data-toggle="tooltip" title="Your password must be more than 6 characters long, and must not contain spaces, special characters, or emoji."></i></span>
		    <label for="inputPassword" class="sr-only">Password</label>
		    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
		</div>
		<div class="input-group">
			<span class="input-group-addon"><i class="glyphicon glyphicon-lock" data-toggle="tooltip" title="You need to repeat your password in order to register"></i></span>
		    <label for="inputPassword" class="sr-only">Confirm Password</label>
		    <input type="password" name="confirm_password" id="inputPassword" class="form-control" placeholder="Confirm Password" required>
		    
		</div>
	    <div class="form-group">
        <div class="checkbox">
            <label>
            	<input id="field_terms" onchange="this.setCustomValidity(validity.valueMissing ? 'Please indicate that you accept the Terms and Conditions' : '');" type="checkbox" requiered name="terms" />I accept the <a href="tc_english.html" target="_blank">Terms and Conditions</a>
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
	   	<p>Already have an account? <a href="login.php">Sign in</a>.
	</form>
	<script>
  		document.getElementById("field_terms").setCustomValidity("Please indicate that you accept the Terms and Conditions");
	</script>
</div>
	
<?php print footerDBW();?>








