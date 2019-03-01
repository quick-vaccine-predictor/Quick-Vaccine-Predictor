<?php
include("globals.inc.php");
$title = "my Vaccine";
print headerDBW($title);


// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: login.php");
  exit;
}

//Conection to the DB
$conn = connectSQL();

//declaration of some variables
$idUser = "";
$email="";

$idUser = $_SESSION['idUser'];
$email= $_SESSION["email"];
$sql = "SELECT v.idVaccine, v.nameVaccine, vc.idEpitope, e.seqEpitope, vc.idEpitope FROM Vaccine v, VaccineContent vc, Epitope e WHERE idUser ='$idUser' AND v.idVaccine = vc.idVaccine AND vc.idEpitope = e.idEpitope";
//$sql = "SELECT idVaccine, nameVaccine FROM Vaccine WHERE idUser ='$idUser'";

$result = $conn->query($sql); /* the search is done here */  

$conn->close();

print navbar('myVaccine');
?> 

<div class="container">
    <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b>. Welcome to your personal site.</h1>
    <div class="row"> 
        <div class="col-sm-8">
            Here will go a brief explanation about QVVP .
        </div>

    </div>


    <div class="row">
        <h2>Vaccines</h2>
        <table class="table table-striped table-sm table-responsive" id="affTable">
          <thead>
            <tr>
              <th>Vaccine name</th>
              <th>seqEpitope</th>
            </tr>
          </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()) { ?>
          <tr>
            <th scope='row' id="idUser"><?php echo $row['nameVaccine'] ?></th>
            <td class='text-center' id="epitope">
              <a href="<?php echo "epitope.php?idEpitope=".$row['idEpitope']; ?>" ><?php echo $row['seqEpitope'] ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
      </table>
      </div>
    <!--</div> -->
    <script type="text/javascript">
      $(document).ready(function () {
        $('#affTable').DataTable();
        
      });
    </script>
</div>

<?php print footerDBW();?>
