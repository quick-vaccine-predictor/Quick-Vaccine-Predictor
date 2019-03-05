<?php
include("globals.inc.php");

//Conection to the DB if needed
$conn = connectSQL();
// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
  }

  // Iniziatializing variables
$password = "";
$newVaccinename = "";
$currentVacid = "";
$idUser= "";
$errors = array();


if(isset($_POST) & !empty($_POST)){
    //Recieve all input values from the form
    $password = mysqli_real_escape_string($conn, check_data($_POST['password']));
    $newVaccinename= $_POST["newVaccinename"];
    $currentVacid = $_POST["currentVac"]; 
    $idUser = $_SESSION["idUser"];
	//Form validation by adding corresponding errors into $errors array
    if(empty($newVaccinename)) { array_push($errors, "a new Vaccine name is required"); }
    if(empty(check_data($password))) { array_push($errors, "Password is required"); }


    // If there is no errors in the form rename Vaccine:
	if (count($errors) == 0) {
        $email = $_SESSION['email']; //provided from register.php or login.php 
        $query_database = "SELECT * FROM User WHERE mailUser = '$email'"; //the email is unique
        $result_database = mysqli_query($conn, $query_database);
        // Fetching a result user as an associative array
        $user_database = mysqli_fetch_assoc($result_database);
        if (mysqli_num_rows($result_database) == 1){ 
            $hash = $user_database['Password'];
            // Verifying password:
            if(password_verify($password,$hash)) {
                // Check input errors before updating the database
                if(count($errors) == 0) {     
                    $sql = "UPDATE Vaccine SET nameVaccine = '$newVaccinename' WHERE idVaccine = '$currentVacid' AND idUser ='$idUser'";

                    mysqli_query($conn, $sql);
                    $idVaccine = mysqli_insert_id($conn);

                    $sql2 = "INSERT INTO VaccineContent SET idVaccine = '$idVaccine' ,idEpitope ='$idEpitope'";   
                    mysqli_query($conn, $sql2);
                    header("location: my_vaccine.php");
                }
	}

}
    }}

$conn->close();

?>

