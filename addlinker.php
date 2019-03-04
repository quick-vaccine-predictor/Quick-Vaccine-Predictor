<?php
include("globals.inc.php");
//Conection to the DB if needed
$conn = connectSQL();

// Iniziatializing variables
$nVaccine = "";
$idUser="";
$errors = array();
$idEpitope= "";
$idHLA = "";
$seqEpitope="";
$idVaccine="";
$almostnVaccine = "";

if(isset($_POST["addbutton"]) & !empty($_POST)){
    //Recieve all input values from the form
    $idEpitope = $_SESSION["idEpitope"];
    $idHLA = $_SESSION["idHLA"];
    $nVaccine = $_POST["nVaccine"];
    $idUser = $_SESSION["idUser"];
	//Form validation by adding corresponding errors into $errors array
    if(empty($nVaccine)) { array_push($errors, "nameVaccine is required"); }
}
elseif(isset($_GET) & !empty($_GET)){

    //Recieve all input values from the form
    $idEpitope = $_SESSION["idEpitope"];
    $idHLA = $_SESSION["idHLA"];
    $almostnVaccine = $_GET["vaccine"];
    foreach ($almostnVaccine as $alnVaccine){
        $nVaccine = $alnVaccine;
    }
    $idUser = $_SESSION["idUser"];
	//Form validation by adding corresponding errors into $errors array
    if(empty($nVaccine)) { array_push($errors, "nameVaccine is required"); }
}


// If there is no errors in the form register user:
	if (count($errors) == 0) {
        $sql = "INSERT INTO Vaccine SET nameVaccine = '$nVaccine' , idUser ='$idUser'";

        mysqli_query($conn, $sql);
        $idVaccine = mysqli_insert_id($conn);

        $sql2 = "INSERT INTO VaccineContent SET idVaccine = '$idVaccine' ,idEpitope ='$idEpitope'";   
        mysqli_query($conn, $sql2);
        header("location: my_vaccine.php");
    }
    else {
        header("location: addindex.php");
    }


// Close connection
$conn->close();

print navbar('HLA');
?>
