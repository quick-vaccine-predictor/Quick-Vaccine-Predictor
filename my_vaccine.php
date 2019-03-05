<?php
//To debug in the terminal when the server is on
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

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
$email= $_SESSION['email'];
$sql = "SELECT idVaccine, nameVaccine FROM Vaccine  WHERE idUser ='$idUser' ";
//$sql = "SELECT idVaccine, nameVaccine FROM Vaccine WHERE idUser ='$idUser'";

$result = $conn->query($sql); /* the search is done here */  



print navbar('myVaccine'); 

// This is the code for all datatables that are coming;
// $allnameVaccine = array();
// $nVac="";
// while($row = $result->fetch_assoc()) { 
  // if (!in_array($row["nameVaccine"], $allnameVaccine)) {
    // array_push($allnameVaccine,$row["nameVaccine"] );
    // $nVac=$row['nameVaccine'];
    // $sql2 = "SELECT  vc.idEpitope, e.seqEpitope FROM Vaccine v, VaccineContent vc, Epitope e WHERE idUser ='$idUser' AND v.idVaccine = vc.idVaccine AND vc.idEpitope = e.idEpitope  AND v.nameVaccine ='$nVac' ";
    // $result2 = $conn->query($sql2); /* the search is done here */  
    // while($row2 = $result2->fetch_assoc()) { 
      // echo $nVac;
      // echo $row2['idEpitope']."  ";
    // }
  // } 
  // else {continue;}
// } 


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
        <?php 
            $allnameVaccine = array();
            $nVac="";
            while($row = $result->fetch_assoc()) { 
              if (!in_array($row["nameVaccine"], $allnameVaccine)) {
                array_push($allnameVaccine,$row["nameVaccine"] );
                $nVac=$row['nameVaccine'];
                $idVaccine = $row["idVaccine"];
                $sql2 = "SELECT  vc.idEpitope, e.seqEpitope FROM Vaccine v, VaccineContent vc, Epitope e WHERE idUser ='$idUser' AND v.idVaccine = vc.idVaccine AND vc.idEpitope = e.idEpitope  AND v.nameVaccine ='$nVac' ";
                $result2 = $conn->query($sql2); /* the search is done here */  
          ?>

        <table class="table table-striped table-sm table-responsive affTable" id="affTable">
          <thead>
            <tr>
              <th scope='row' id="idUser"><?php echo $nVac ?> </th>
              <th>
                <form method="post" action="renameVaccine.php" >
                  <input type="hidden" name="renameVac" value="<?php echo $idVaccine ?>">
                  <input type="submit" value="rename <?php echo $nVac ?>">
                </form>
              </th> 
              <th>
                <form method="post" action="removeVaccine.php" >
                  <input type="hidden" name="removeVac" value="<?php echo $idVaccine ?>">
                  <input type="submit" value="remove <?php echo $nVac ?>">
                </form>
              <th>
            </tr>
          </thead>
      <tbody>
          <?php while($row2 = $result2->fetch_assoc()) {  ?>
            <tr>
            <td scope='row' id="Epitope" class='text-center' >
              <a href="<?php echo "epitope.php?idEpitope=".$row2['idEpitope']; ?>" target="_blank"><?php echo $row2['seqEpitope'] ;}?>
            </td>
            <td>
              <?php $idEpitope = $row2['idEpitope'] ;?>
              <form method="post" action="removeSequence.php" >
                <input type="hidden" name="removeSeq" value="<?php echo $idVaccine?>">
                <input type="submit" value="remove sequence">
              </form>

            </td>
          </tr>
        
      </tbody>
      <?php }
        else {continue;}
      } $conn->close();?>
      </table>

      </div>  <!--</div> -->
   
    <script type="text/javascript">
      $(document).ready(function () {
        $('.affTable').DataTable({
          paging:false, 
          "info":false}
        );
        
      });
    </script>
</div>

<?php print footerDBW();?>
