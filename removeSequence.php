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
$idVaccine = "";
$errors = array();
$idEpitope = "";

// Register User
if(isset($_POST) & !empty($_POST) ){ 
    //Recieve all input values from the form

    list($idVaccine, $idEpitope) = explode("|",$_POST["removeSeq"]);
    $sql = "DELETE FROM VaccineContent WHERE idVaccine = '$idVaccine' AND idEpitope = '$idEpitope' LIMIT 1";
    mysqli_query($conn, $sql);
    header("location: my_vaccine.php");
}    
// Close connection
$conn->close();
?>