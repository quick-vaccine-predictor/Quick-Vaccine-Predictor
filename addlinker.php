<?php
//This file is to link addindex.php and my_vaccine.php when a user creates a new Vaccine instance into de database
include("globals.inc.php");

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
  }

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
        $query = "SELECT * FROM Vaccine WHERE nameVaccine = '$nVaccine' AND idUser = '$idUser' LIMIT 1";
        $result = mysqli_query ($conn, $query);

        if ($result -> num_rows == 1){
            foreach ($result as $almostresult) {
                $idVaccine = $almostresult["idVaccine"];
                $query2 = "SELECT * FROM VaccineContent WHERE idVaccine = '$idVaccine' AND idEpitope = '$idEpitope' LIMIT 1";
                $result2 = mysqli_query ($conn, $query2);

                if ($result2 -> num_rows == 0) {  //if idEpitope soesn't exist in that User and nameVaccine
                    $sql = "INSERT INTO VaccineContent SET idVaccine = '$idVaccine' ,idEpitope ='$idEpitope'";   
                    mysqli_query($conn, $sql);
                } else {array_push($errors, "that Epitope sequence already exist in this nameVaccine");}
            }
            header("location: my_vaccine.php");
        } elseif ($result -> num_rows == 0 ){ //it doesn't exists
            $sql = "INSERT INTO Vaccine SET nameVaccine = '$nVaccine' , idUser ='$idUser'";
            $result2 = mysqli_query($conn, $sql);
            $idVaccine = mysqli_insert_id($conn);
            $sql2 = "INSERT INTO VaccineContent SET idVaccine = '$idVaccine' ,idEpitope ='$idEpitope'";   
            mysqli_query($conn, $sql2);
            header("location: my_vaccine.php");
        }
    }
    else {
        header("location: addindex.php");
    }


// Close connection
$conn->close();
?>
