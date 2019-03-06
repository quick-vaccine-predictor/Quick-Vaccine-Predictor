<?php
include("globals.inc.php");
$conn = connectSQL();
// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
    header("location: login.php");
}
if(isset($_POST) & !empty($_POST)){
    $newVaccinename= $_POST["newVaccinename"];
    $currentVacid = $_POST["currentVac"]; 
    $idUser = $_SESSION["idUser"];   
    $sql = "UPDATE Vaccine SET nameVaccine = '$newVaccinename' WHERE idVaccine = $currentVacid AND idUser ='$idUser'";
    mysqli_query($conn, $sql);
    $idVaccine = mysqli_insert_id($conn);
    $conn->close();
    header("location: my_vaccine.php");
}
?>

