<?php
//To debug in the terminal when the server is on
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
// Include connection file
require_once('connect.php');

// Start the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
  header("location: index.php");
  exit;
}

// Iniziatializing variables
$new_password = "";
$confirm_password = "";
$errors = array();

// Login User
// Check if imput fields are filled and setting variables
if(isset($_POST) & !empty($_POST)) {
    $new_password = mysqli_real_escape_string($conn, check_data($_POST['new_password']));
    $confirm_password = mysqli_real_escape_string($conn, check_data($_POST['confirm_password'])); 

    //Form validation by adding corresponding errors into $errors array
    if(empty(check_data($new_password))) { array_push($errors, "Password is required"); }
    if(strlen(check_data($new_password)) < 6){ array_push($errors, "Password must have atleast 6 characters."); }
    if(empty(check_data($confirm_password))) { array_push($errors, "Must confirm the password"); }
    if($new_password != $confirm_password) { array_push($errors, "The two passwords do not match, try again!"); }

    // Check input errors before updating the database
    if(count($errors) == 0) {
        $id_user = $_SESSION['id_user']; 
        $new_password = password_hash($new_password, PASSWORD_BCRYPT);
        $sql = "UPDATE User SET password = '$new_password' WHERE id_user = '$id_user'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);

        if($result){
            //Password updated successfully. Destroy the session, and redirect to login page
            session_destroy();
            header("location: login.php");
            exit();
        } else {
            array_push($errors, "Oops! Something went wrong. Please try again!");
        }

         // Close connection
        mysqli_close($conn);
    }

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
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
    <body>
        <div class="container">
            <form class="form-signin" action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST"><?php include('errors.php'); ?>
            <h2 class="form-signin-heading">Reset Password</h2>
            <p>Please fill out this form to reset your password.</p>
                <div class="form-group">
                    <label for="inputPassword" class="sr-only">New Password</label>
                    <input type="password" name="new_password" id="inputPassword" class="form-control" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="sr-only">Confirm Password</label>
                    <input type="password" name="confirm_password" id="inputPassword" class="form-control" placeholder="Confirm Password" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Register</button>
                    <a class="btn btn-link" href="index.php">Cancel</a>
                </div>
            </form>
        </div>
    </body>
</html>