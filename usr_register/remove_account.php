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
    if($password != $confirm_password) { array_push($errors, "The two passwords do not match, try again!"); }
    
     // Check input errors before updating the database
    if(count($errors) == 0) {
        // Check the DB to make sure a user does not already exist with the same email.
        $user_check_query = "SELECT * FROM User WHERE mail_user = '$email' LIMIT 1";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);
        //print_r($user);
        //die;

        // Check if email exists, if yes then verify password
        if (mysqli_num_rows($result) == 1){
            $hash = $user['password'];
            if(password_verify($password,$hash)) {
                // Password is correct so we proceed to deleted the user by the id
                $user_delete_query = "DELETE FROM User WHERE mail_user = '$email' LIMIT 1";
                $RESULT = mysqli_query($conn, $user_delete_query);
                // Check if the DELETE statement was sucssesfully by looking affected rows in User table:
                if(mysqli_affected_rows($conn) == 1){
                    session_destroy();
                    header('location: register.php');
                    exit; }
            } else {
                // Display an error message if password is not valid
                array_push($errors, "The password you entered was not valid."); } 
        } else {
            // Display an error message if user doe email doesn't exist
            array_push($errors, "Incorrect email. Please try again."); }
    } else {
        array_push($errors, "Oops! Something went wrong. Please try again!");
        //header('location: login.php'); 
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
    <meta charset="UTF-8">
    <title>Remove Account</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
    <body>
        <div class="container">
            <form class="form-signin" action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST"><?php include('errors.php'); ?>
                <h2 class="form-signin-heading">Fill the form with your email and password.</h2>
                <div class="form-group">
                    <label for="inputEmail" class="sr-only">Email address</label>
                    <input type="email" name="email" id="inputEmail" value="<?php if(isset($email) & !empty($email)){ echo $email; } ?>" class="form-control" placeholder="Email address" required autofocus>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="sr-only">Confirm Password</label>
                    <input type="password" name="confirm_password" id="inputPassword" class="form-control" placeholder="Confirm Password" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Delete Account</button>
                    <a class="btn btn-link" href="index.php">Cancel</a>
                </div>
            </form>
        </div>
    </body>
</html>