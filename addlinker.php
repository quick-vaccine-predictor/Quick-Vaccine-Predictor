<?php
//This file is to link addindex.php and my_vaccine.php when a user creates a new Vaccine instance into de database
include("globals.inc.php");
print headerDBW($title);
print navbar('MyVaccine');
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
} elseif (count($_REQUEST) == 0) {
    header("location: error.php");
}
$idVaccine = $_REQUEST["idVaccine"];
$idEpitope = $_REQUEST["idEpitope"];
$newVaccine = $_REQUEST["newVaccine"];
$idUser = $_SESSION["idUser"];
//Conection to the DB if needed
echo "<div class=\"container\">";
$conn = connectSQL();
if (!strlen($newVaccine) == 0) {
    $sql = "INSERT INTO Vaccine SET nameVaccine = '$newVaccine' , idUser ='$idUser';";
    $conn->query($sql);
    $idVaccine = mysqli_insert_id($conn);
    $sql = "INSERT INTO VaccineContent SET idVaccine = '$idVaccine' , idEpitope ='$idEpitope';";
    $conn->query($sql);
    $status = '<div class="alert alert-success">
    <strong>SUCCESS:</strong> Epitope added successfully!
    <a class="close" data-dismiss="alert">×</a>
    </div>';
    $_SESSION["status"] = $status;
    header("location: addindex.php?idEpitope=$idEpitope");
} elseif (!strlen($idVaccine) == 0) {
    $sql = "SELECT idEpitope FROM VaccineContent WHERE (idVaccine = '$idVaccine' AND idEpitope = '$idEpitope');";
    $var = mysqli_num_rows($conn->query($sql));
    echo $var;
    if ($var == 0) {
        $sql = "INSERT INTO VaccineContent SET idVaccine = '$idVaccine' , idEpitope ='$idEpitope';";
        $conn->query($sql);
        $status = '<div class="alert alert-success">
        <strong>SUCCESS:</strong> Epitope added successfully!
        <a class="close" data-dismiss="alert">×</a>
        </div>';
        $_SESSION["status"] = $status;
        header("location: addindex.php?idEpitope=$idEpitope");
    } else {
        echo '<div class="alert alert-danger">';
        echo "<strong>FAILED:</strong> Epitope already in Vaccine!";
        echo '<a class="close" data-dismiss="alert">×</a>';
        echo '</div>';
        $status = '<div class="alert alert-danger">
        <strong>FAILED:</strong> Epitope already in Vaccine!
        <a class="close" data-dismiss="alert">×</a>
        </div>';
        $_SESSION["status"] = $status;
        header("location: addindex.php?idEpitope=$idEpitope");
    } 
}
echo "</div>";
$conn->close();
print footerDBW();