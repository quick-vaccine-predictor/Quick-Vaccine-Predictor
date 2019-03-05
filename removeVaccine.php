<?php
//To debug in the terminal when the server is on
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

// Include connection file
include("globals.inc.php");

//Conection to the DB if needed
$conn = connectSQL();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
  header("location: my_vaccine.php");
  exit;
}

// Iniziatializing variables
$email = "";
$idUser= "";
$idVaccine = "";
$password = "";
$errors = array();

// Register User
if(isset($_POST) & !empty($_POST) ){ 
    //Recieve all input values from the form
    $email = mysqli_real_escape_string($conn, check_data($_POST['email']));
    $password = mysqli_real_escape_string($conn, check_data($_POST['password'])); 
    $confirm_password = mysqli_real_escape_string($conn, check_data($_POST['confirm_password']));
    $idUser = $_SESSION["idUser"];
    $idVaccine = $_POST["currentVac"]; 


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

        // Check if email exists, if yes then verify password
        if (mysqli_num_rows($result) == 1){
            $hash = $user['Password']; 

            if(password_verify($password,$hash)) { 
                // Password is correct so we proceed to deleted the user by the id
            
                $sql = "DELETE FROM VaccineContent WHERE idVaccine = '$idVaccine'";
                mysqli_query($conn, $sql);
                $sql2 = "DELETE FROM Vaccine WHERE idVaccine = '$idVaccine'";
                mysqli_query($conn, $sql2);
                header("location: my_vaccine.php");
                } else {
                    // Display an error message if nameVaccine is not valid
                    array_push($errors, "The vaccine name was not valid."); } 
            } else {
                // Display an error message if password is not valid
                array_push($errors, "The password you entered was not valid."); } 
        } else {
            // Display an error message if user doe email doesn't exist
            array_push($errors, "Incorrect email. Please try again."); }
    } 
    // Close connection
    $conn->close();

function my_function() {
    confirm("Are you sure?");
}
?>

