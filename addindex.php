<?php
include("globals.inc.php");
$title = "MyVaccine";
print headerDBW($title);
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
  }
print navbar('MyVaccine');
$conn = connectSQL();
$idUser = $_SESSION["idUser"];
$sql = "SELECT idVaccine, nameVaccine from Vaccine WHERE idUser = '$idUser'";
$vaccineTable = $conn->query($sql);
$vaccine_arr = array();
$conn->close();
?>
<div class="container">
    <?php echo $_SESSION["status"]; $_SESSION["status"] = ""; ?>
    <form action="addlinker.php" method="POST">
        <h3>Add epitope <?php echo $_REQUEST["idEpitope"]?>:</h3>
        <label>Add to a new Vaccine: </label><input type="text" name="newVaccine" required>
        <input hidden value="<?php echo $_REQUEST["idEpitope"] ?>" name="idEpitope">
        <button type='submit' class="btn btn-info btn-sm">Add</button>
        <button onclick="self.close()" class="btn btn-warning btn-sm">Cancel</button>
    </form>
    <form action="addlinker.php" method="GET" id="existingVacc">
        <div class="form-group">
            <label>Insert into an existing vaccine:</label> <br>
            <select name="idVaccine">
                <?php
                foreach ($vaccineTable as $vaccinerow) {
                    $nameVaccine = $vaccinerow["nameVaccine"];
                    $idVaccine = $vaccinerow["idVaccine"];
                    $vaccine_arr[] = $idVaccine;
                  ?>
                <option selected value="<?php echo $idVaccine ?>"><?php echo $nameVaccine?></option>
                <?php                
                } 
                ?>
            </select>
            <input hidden value="<?php echo $_REQUEST["idEpitope"] ?>" name="idEpitope">
            <button type='submit' class="btn btn-info btn-sm">Add</button>
            <button onclick="self.close()" class="btn btn-warning btn-sm">Cancel</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    var vaccine_json = '<?php echo json_encode($vaccine_arr) ?>';
    if (vaccine_json == '[]') {
        $('#existingVacc').hide();
    } else {
        $('#existingVacc').show();
    }
</script>
<?php print footerDBW();?>
