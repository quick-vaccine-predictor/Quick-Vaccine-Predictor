<?php
include("globals.inc.php");
$conn = connectSQL();
// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
  header("location: my_vaccine.php");
}
if(isset($_POST) & !empty($_POST) ){
	$idVaccine = $_REQUEST["idVaccine"];
	$idEpitope = $_REQUEST["idEpitope"];
    $sql = "DELETE FROM VaccineContent WHERE idVaccine = $idVaccine AND idEpitope = $idEpitope;";
    mysqli_query($conn, $sql);
	$conn->close();
    header("location: my_vaccine.php");
}    
?>