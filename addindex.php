<?php
//To debug in the terminal when the server is on
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

include("globals.inc.php");
$title = "add";
print headerDBW($title);

// Check if the user is logged in, if not then redirect him to login page
//if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
//    header("location: login.php");
//    $email= $_SESSION["email"];
//    exit;
//  }

//Conection to the DB if needed
$conn = connectSQL();

// Iniziatializing variables
$nVaccine = "";
$errors = array();

// Register User
if(isset($_POST) & !empty($_POST)){
	//Recieve all input values from the form
    $nVaccine = $_POST['nVaccine'];

	//Form validation by adding corresponding errors into $errors array
    if(empty($nVaccine)) { echo "er"; array_push($errors, "nameVaccine is required"); }

    echo "<br>" ;
    echo "a";
    echo "<br>" ;
}

// If there is no errors in the form register user:
	if (count($errors) == 0) {
        //$sql = "INSERT INTO Vaccine set nameVaccine = $nVaccine, idUser = (SELEC idUser FROM User WHERE idUser='6')";
        $sql = "INSERT INTO Vaccine SET nameVaccine = '$nVaccine' , idUser = (SELECT idUser FROM User WHERE idUser = '7')";
        $sql2 = "INSERT INTO VaccineConent SET idVaccine = (SELECT idVaccine FROM Vaccine), idEpitope = '41'";

        mysqli_query($conn, $sql);
        mysqli_query($conn, $sql2);
        echo "1 record added";
	}


// Close connection
$conn->close();

print navbar('HLA');
?>


<div class="container">
    <form action="" method="post">
        nameVaccine: <input type="text" name="nVaccine" /><br><br>
        <!--<input type="submit" />-->
        <button id='<?php echo $_SESSION["idEpitope"].$_SESSION["nameHLA"]?>' type='reset' name='addbutton'>add</button>

    </form>
</div>

<?php print footerDBW();?>
