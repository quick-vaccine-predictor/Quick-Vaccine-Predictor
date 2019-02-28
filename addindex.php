<?php
//To debug in the terminal when the server is on
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

include("globals.inc.php");
$title = "add";
print headerDBW($title);

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    $email= $_SESSION["email"];
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

// Register User
//if(isset($_POST["addintobutton"]) & !empty($_POST)){
//    //Recieve all input values from the form
//    $idEpitope = $_SESSION["idEpitope"];
//
//    $idHLA = $_SESSION["idHLA"];
//    $seqEpitope = $_SESSION["seqEpitope"];
//    print($idHLA);
//    die;
//}


if(isset($_POST["addbutton"]) & !empty($_POST)){
    //Recieve all input values from the form
    $idEpitope = $_SESSION["idEpitope"];
    $idHLA = $_SESSION["idHLA"];
    $nVaccine = $_POST["nVaccine"];
    $idUser = $_SESSION["idUser"];
	//Form validation by adding corresponding errors into $errors array
    if(empty($nVaccine)) { array_push($errors, "nameVaccine isc required"); }
}

// If there is no errors in the form register user:
	if (count($errors) == 0) {
        $sql = "INSERT INTO Vaccine SET nameVaccine = '$nVaccine' , idUser ='$idUser'";

        mysqli_query($conn, $sql);
        $idVaccine = mysqli_insert_id($conn);

        $sql2 = "INSERT INTO VaccineContent SET idVaccine = '$idVaccine' ,idEpitope ='$idEpitope'";   
        mysqli_query($conn, $sql2);
	}


// Close connection
$conn->close();

print navbar('HLA');
?>


<div class="container">
    <form action="" method="post">
        <p> 
        idEpitope: <?php echo $_SESSION["idEpitope"];?> 
        idHLA: <?php echo $_SESSION["idHLA"];?> 
        seqEpitope: <?php echo $_SESSION["seqEpitope"];?> 
        </p>
        nameVaccine: <input type="text" name="nVaccine" /><br><br>
        <!--<input type="submit" />-->
        <input id='<?php echo $_SESSION["idEpitope"]?>' type='submit' name='addbutton' value="myVaccine">
        <!--echo $_SESSION["idEpitope"].$_SESSION["nameHLA"]?>-->
    </form>
</div>

<?php print footerDBW();?>
