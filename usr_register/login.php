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
	$email = mysqli_real_escape_string($conn, check_data($_POST['email']));
	$password = mysqli_real_escape_string($conn, check_data($_POST['password'])); 
	//print_r($_POST);
	//die;

	//Form validation by adding corresponding errors into $errors array
	if(empty(check_data($email))) { array_push($errors, "Email is required"); 	}
	if (empty(check_data($password))) { array_push($errors, "Password is required"); 	}

	// If there are no errors prepare query to start session:
	if(count($errors) == 0) {
		$query = "SELECT * FROM User WHERE mail_user = '$email'";
		$result = mysqli_query($conn, $query);
		// Fetching a result user as an associative array
		$user = mysqli_fetch_assoc($result);

		// Check if emal exists, if yes then verify password
		if (mysqli_num_rows($result) == 1){	
			$hash = $user['password'];
			if(password_verify($password,$hash)) {
				// Password is correct, so start a new session
				session_start();

				// Store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["id_user"] = $user['id_user'];
                $_SESSION["email"] = $email;
                // Redirect user to MyVaccine page
                header('location: index.php');
			}else{
				// Display an error message if password is not valid
				array_push($errors, "The password you entered was not valid.");
			}
		
		} else {
		// Display an error message if user doe email doesn't exist
		array_push($errors, "No account found with that email. Please Sign Up.");
		
		}

	} else {
		array_push($errors, "Oops! Something went wrong. Please try again!");
		header('location: login.php');

	}
	// Close connection
	mysqli_close($conn);	
}

function check_data($data) {
    /* This function checks the data before storing in dtabase */
  $data = trim($data); //strip spaces, tabs or new lines
  $data = stripslashes($data); //remove "\" from user input data
  $data = htmlspecialchars($data); // converts special characters to HTML entities, avoiding user hacking.
  return $data;
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
			<form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST"><?php include('errors.php'); ?>
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
