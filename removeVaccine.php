<?php
include("globals.inc.php");
$conn = connectSQL();
// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
  header("location: my_vaccine.php");
}
if(isset($_POST) & !empty($_POST) ){ 
    $idUser = $_SESSION["idUser"];
    $idVaccine = $_POST["currentVac"];  
    $sql = "DELETE FROM VaccineContent WHERE idVaccine = '$idVaccine'";
    mysqli_query($conn, $sql);
    $sql2 = "DELETE FROM Vaccine WHERE idVaccine = '$idVaccine'";
    mysqli_query($conn, $sql2);
    // Close connection
    $conn->close();
    header("location: my_vaccine.php");           
    } 
?>

