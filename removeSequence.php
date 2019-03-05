<?php
//To debug in the terminal when the server is on
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

// Include connection file
include("globals.inc.php");
$title = "Remove Vaccine";
print headerDBW($title);

//Conection to the DB if needed
$conn = connectSQL();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
  header("location: my_vaccine.php");
  exit;
}

// Iniziatializing variables
$idUser= "";
$idVaccine = "";
$password = "";
$errors = array();
$idEpitope = "";

// print_r($_POST);
// die;
// Register User
if(isset($_POST) & !empty($_POST) & !isset($_POST["removeSeq"]) & !isset($_POST["idEpitope"])){ 
    //Recieve all input values from the form
    $idUser = $_SESSION["idUser"];
    $idVaccine = $_POST["currentVac"]; 
    //$idEpitope = $_POST["id"];
    //print($idEpitope);
    print($idVaccine);
    die;


    // Check input errors before updating the database
    if(count($errors) == 0) {
          
                $sql = "DELETE FROM VaccineContent WHERE idVaccine = '$idVaccine'";
                mysqli_query($conn, $sql);
                } else {
                    // Display an error message if nameVaccine is not valid
                    array_push($errors, "The vaccine name was not valid."); } 
                
            
    // Close connection
    $conn->close();
                }
print navbar('Remove Account');

function my_function() {
    confirm("Are you sure?");
}
?>



<div class="container">
    <form class="form-signin" action= "removeSequence.php" method="POST" onsubmit="return confirm('Are you sure you want to submit?')"><?php include('errors.php'); ?>
        <input type="hidden" name="currentVac" value="<?php echo $_POST["removeSeq"] ?>">
        <input type="hidden" name="id" value="<?php echo $_POST["idEpitope"] ?>">
        <div class="form-group">
            <button class="btn btn-primary" onclick="my_function()">Delete sequence</button>
            <a class="btn btn-link" href="my_vaccine.php">Cancel</a>
        </div>
    </form>
</div>

<?php print footerDBW();?>

