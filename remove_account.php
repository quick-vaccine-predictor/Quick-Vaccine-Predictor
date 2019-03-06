<?php
//To debug in the terminal when the server is on
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

// Include connection file
include("globals.inc.php");
$title = "Remove Account";
print headerDBW($title);

//Conection to the DB if needed
$conn = connectSQL();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
  header("location: my_vaccine.php");
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
        $user_check_query = "SELECT * FROM User WHERE mailUser = '$email' LIMIT 1";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);
        $idUser = $user["idUser"];
        
        // Check if email exists, if yes then verify password
        if (mysqli_num_rows($result) == 1){
            $hash = $user['Password'];
            if(password_verify($password,$hash)) {

                // Password is correct so we proceed to deleted the user by the id
                // Select all vaccines od the user from Vaccine table 

                $select_vaccines = "SELECT idVaccine FROM Vaccine WHERE idUser = '$idUser'";
                $query = mysqli_query($conn, $select_vaccines);
                $id_vaccine_arr = array();
                // Put the results into an array:
                foreach ($query as $q) {
                    $id_vaccine_arr[] = $q["idVaccine"];
                }
                // Last element of the query
                $last_element = array_values(array_slice($id_vaccine_arr, -1))[0];

                $delete_vaccine_content = "DELETE FROM VaccineContent WHERE (";
                $delete_vaccine = "DELETE FROM Vaccine WHERE (";
                foreach ($id_vaccine_arr as $id_vac) {
                   if(count($id_vaccine_arr) == 1 OR $id_vac == $last_element){
                        $delete_vaccine_content .= " idVaccine = $id_vac);";
                        $delete_vaccine .= " idVaccine = $id_vac);";
                    } else {
                        $delete_vaccine_content .= " idVaccine = $id_vac OR ";
                        $delete_vaccine .= " idVaccine = $id_vac OR ";
                    }
                }
                // Execute queries
                $conn->query($delete_vaccine_content);
                $conn->query($delete_vaccine);                
                $delete_user = "DELETE FROM User WHERE idUser = $idUser;";
                $conn->query($delete_user);

                // Check if the DELETE statement was sucssesfully by looking affected rows in User table:
                if(mysqli_affected_rows($conn) == 1){
                    session_destroy();
                    header('location: index.php');
                }
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
    $conn->close();

}
print navbar('Remove Account');
?>



<div class="container">
    <form class="form-signin" action= "remove_account.php" method="POST"><?php include('errors.php'); ?>
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
            <button class="btn btn-primary" type="submit" onclick="my_alert()">Delete Account</button>
            <a class="btn btn-link" href="my_vaccine.php">Cancel</a>
        </div>
    </form>
</div>

<script>
function my_alert() {
  alert("Are you sure you want to delete your account?");
}
</script>

<?php print footerDBW();?>

