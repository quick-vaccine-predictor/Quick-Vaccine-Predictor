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
        
	}


// Close connection
$conn->close();

print navbar('HLA');
?>


<div class="container">
    <form action="addindex.php" method="post">
        <p> 
        idEpitope: <?php echo $_SESSION["idEpitope"];?> 
        idHLA: <?php echo $_SESSION["idHLA"];?> 
        seqEpitope: <?php echo $_SESSION["seqEpitope"];?> 
        </p>
        nameVaccine: <input type="text" name="nVaccine" /><br><br>
        
        <input id='<?php echo $_SESSION["idEpitope"]?>' type='submit' name='addbutton' value="myVaccine">
        <a class="btn btn-link" href="my_vaccine.php">Cancel</a>
    </form>
    <form action="addindex.php" method="GET">
        <div class="form-group">
        <label>Insert <?php echo $_SESSION["seqEpitope"];?> into an existing vaccine:</label> <br>
        <select name="vaccine[]" size="8">
            <?php
            $conn = connectSQL();
            $idUser = $_SESSION["idUser"];
            $sql = "SELECT idVaccine, nameVaccine from Vaccine WHERE idUser = '$idUser'";
            $vaccineTable = $conn->query($sql);
            $conn->close();
            $allnameVaccine = array();
            foreach ($vaccineTable as $vaccinerow) {
              if (!in_array($vaccinerow["nameVaccine"], $allnameVaccine)) {
                  array_push($allnameVaccine,$vaccinerow["nameVaccine"] );
                  $nameVaccine = $vaccinerow["nameVaccine"];
              ?>
            <option selected name="<?php print $nameVaccine ?>"  value="<?php print $nameVaccine ?>"><?php print $nameVaccine. "\n"?></option>
            
            <?php }               
            }
            ?>  
            <input id='<?php echo $nameVaccine?>' type='submit' name='namevac' value="myVaccine">
            <a class="btn btn-link" href="queries.php">Cancel</a>
        </select>
        <br>
        </form>
    </div>
    </form>

</div>

<?php print footerDBW();?>
