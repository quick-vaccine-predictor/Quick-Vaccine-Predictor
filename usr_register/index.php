<?php
/* Main pgae with two forms: sign up and log in*/

// Include connection file
require_once('connect.php');

session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    $_SESSION['msg'] = "You must Log in first";
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>My Vaccine</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body>
		<div class="page-header">
            <h2>Home Page</h2>
        </div>
        <div class="content">
            <!-- Notification message  -->
            <div class="error success">
                <h3><?php echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>                    
                </h3>
            </div>
            <h4>Hi, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b>. Welcome to our site.</h4>
        </div>
        <p>
            <a href="reset_pass.php" class="btn btn-warning">Reset Your Password</a>
            <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
            <a href="remove_account.php" class="btn btn-danger">Delete Your Account</a>
        </p>

	</body>
</html>
    
