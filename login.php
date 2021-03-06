<?php
//To debug in the terminal when the server is on
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

// Include connection file
include("globals.inc.php");
$title = "Login";
print headerDBW($title);

//Conection to the DB if needed
$conn = connectSQL();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: my_vaccine.php");
  exit;
}

// Check if msg is set and not empty from my_vaccine.php
if(isset($_SESSION['msg']) && !empty($_SESSION['msg'])) {
	// If is set then we define the array $errors and push the missage
	$errors = array();
	array_push($errors, $_SESSION['msg']);
} else {
// In case the user only want to log in:	

	// Iniziatializing variables
	$email = "";
	$password = "";
	$errors = array();

	// Login User
	// Check if imput fields are filled and setting variables
	if(isset($_POST) & !empty($_POST)) {
		$email = mysqli_real_escape_string($conn, check_data($_POST['email']));
		$password = mysqli_real_escape_string($conn, check_data($_POST['password'])); 

		//Form validation by adding corresponding errors into $errors array
		if(empty(check_data($email))) { array_push($errors, "Email is required"); 	}
		if (empty(check_data($password))) { array_push($errors, "Password is required"); 	}

		// If there are no errors prepare query to start session:
		if(count($errors) == 0) {
			$query = "SELECT * FROM User WHERE mailUser = '$email'";
			$result = mysqli_query($conn, $query);
			// Fetching a result user as an associative array
			$user = mysqli_fetch_assoc($result);

			// Check if emal exists, if yes then verify password
			if (mysqli_num_rows($result) == 1){	
				$hash = $user['Password'];
				if(password_verify($password,$hash)) {
					// Password is correct, so start a new session
					session_start();
					// If user click on remember me checkbox then we set cookies:
					if(!empty($_POST["remember"])) {
						setcookie ("email",$_POST["email"],time()+ 3600);
						setcookie ("password",$_POST["password"],time()+ 3600);
						echo "Cookies Set Successfuly";
					// Else then we destroy the cookies if they are set
					} else {
						if(isset($_COOKIE["email"])){ 
							setcookie("username","");
						}
						if(isset($_COOKIE["password"])){
							setcookie("password","");
						}
						
					}

					// Store data in session variables
	                $_SESSION["loggedin"] = true;
	                $_SESSION["idUser"] = $user['idUser'];
	                $_SESSION["email"] = $email;
	                $_SESSION['success'] = "You are now logged in!";
	                // Redirect user to MyVaccine page
	                header('location: my_vaccine.php');
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
			$conn->close();

		}
	}


print navbar('Login');
?>

<div class="container">
	<form class="form-signin" action="login.php" method="POST"><?php include('errors.php'); ?>
	 	<h2 class="form-signin-heading">Please Login</h2>
	 	<div class="input-group">
		 	<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
			<label for="inputEmail" class="sr-only">Email address</label>
		    <input type="email" name="email" value="<?php if(isset($_COOKIE["email"])) { echo $_COOKIE["email"]; } ?>" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
		</div>
		<div class="input-group">
			<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
		    <label for="inputPassword" class="sr-only">Password</label>
		    <input type="password" name="password" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>" id="inputPassword" class="form-control" placeholder="Password" required>
		</div>
	   	<button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
	    <div class="checkbox">
	    	<!-- If user wants to be remembered then the checkbox will be automatically cheked -->
          <label><input type="checkbox" name="remember" <?php if(isset($_COOKIE["email"])) {?> cheked <?php }  ?> > Remember me</label>
        </div>
	    <p>Not yet a member? <a href="register.php">Sign up here</a>.</p>
	</form>
</div>

<?php print footerDBW();?>