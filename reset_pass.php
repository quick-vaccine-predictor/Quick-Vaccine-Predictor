<?php
//To debug in the terminal when the server is on
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

// Include connection file
include("globals.inc.php");
$title = "Reset Password";
print headerDBW($title);

//Conection to the DB if needed
$conn = connectSQL();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
  header("location: my_vaccine.php");
  exit;
}

// Iniziatializing variables
$password = "";
$new_password = "";
$confirm_new_password = "";
$errors = array();

// Login User
// Check if imput fields are filled and setting variables
if(isset($_POST) & !empty($_POST)) {
    $password = mysqli_real_escape_string($conn, check_data($_POST['password']));
    $new_password = mysqli_real_escape_string($conn, check_data($_POST['new_password']));
    $confirm_new_password = mysqli_real_escape_string($conn, check_data($_POST['confirm_new_password'])); 

    //Form validation by adding corresponding errors into $errors array
    if(empty(check_data($password))) { array_push($errors, "Password is required"); }
    if(empty(check_data($new_password))) { array_push($errors, "Password is required"); }
    if(strlen(check_data($new_password)) < 6){ array_push($errors, "Password must have atleast 6 characters."); }
    if(empty(check_data($confirm_new_password))) { array_push($errors, "Must confirm the password"); }
    if($new_password != $confirm_new_password) { array_push($errors, "The two passwords do not match, try again!"); }

    // If there are no errors prepare query to change password:
        if(count($errors) == 0) {
            $email = $_SESSION['email']; //provided from register.php or login.php 
            $query_database = "SELECT * FROM User WHERE mailUser = '$email'"; //the email is unique
            $result_database = mysqli_query($conn, $query_database);
            // Fetching a result user as an associative array
            $user_database = mysqli_fetch_assoc($result_database);
            //print_r($user_database);
            //die;
            //[idUser] => 16 [mailUser] => alta1@gmail.com [Password] => $2y$10$QOUcWIEtRz1lZHRzPHlpj.rv4dI5lCQb8tW7HSyv6seFc0FvUkm.2 

            // Check if emal exists, if yes then verify password
            if (mysqli_num_rows($result_database) == 1){ 
                $hash = $user_database['Password'];
                // Verifying password:
                if(password_verify($password,$hash)) {
                    // Check input errors before updating the database
                    if(count($errors) == 0) { 
                        $new_password = password_hash($new_password, PASSWORD_BCRYPT);
                        $sql = "UPDATE User SET Password = '$new_password' WHERE mailUser = '$email'";
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
                        $conn->close();
                    }

                }
            }
        }
    }

print navbar('Reset Password');
?>


<div class="container">
    <form class="form-signin" action= "reset_pass.php" method="POST"><?php include('errors.php'); ?>
    <h2 class="form-signin-heading">Reset Password</h2>
    <p>Please fill out this form to reset your password.</p>
        <div class="form-group">
            <label><p>Type your Password</p></label>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        </div>
        <div class="form-group">
            <label><p>Type a new password</p></label>
            <label for="inputPassword" class="sr-only">New Password</label>
            <input type="password" name="new_password" id="inputPassword" class="form-control" placeholder="New Password" required>
        </div>
        <div class="form-group">
            <label><p>Confirm the new password</p></label>
            <label for="inputPassword" class="sr-only">Confirm Password</label>
            <input type="password" name="confirm_new_password" id="inputPassword" class="form-control" placeholder="Confirm New Password" required>
        </div>
        <div class="form-group">
            <button class="btn btn-primary" type="submit">Register</button>
            <a class="btn btn-link" href="my_vaccine.php">Cancel</a>
        </div>
    </form>
</div>

   
<div class="container">
</div>

<?php print footerDBW();?>
