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
            $sql2 = "SELECT  vc.idEpitope, e.seqEpitope FROM Vaccine v, VaccineContent vc, Epitope e WHERE idUser ='$idUser' AND v.idVaccine = vc.idVaccine AND vc.idEpitope = e.idEpitope  AND v.nameVaccine ='$nVac' ";
            $result2 = $conn->query($sql2); /* the search is done here */  
          ?>

        <table class="table table-striped table-sm table-responsive affTable" id="affTable">
          <thead>
            <tr>
              <th scope='row' id="idUser"><?php echo $nVac ?> </th>
              <th>  
              <a href="renameVaccine.php"  target="_blank"> 
              	<button 
              	  <?php $_SESSION["currentVac"] = $row['nameVaccine']; ?>
              	id='<?php echo $nVac ?>' type='submit' name='renameVaccine'>rename <?php echo $nVac ?></button></a>
              </th> 
              <th>
              <a href="removeVaccine.php"  target="_blank"> 
              	<button 
              	  <?php $_SESSION["currentVac"] =  $nVac; ?>
              	id='<?php echo $nVac ?>' type='submit' name='removeVaccine'>remove <?php echo $nVac ?></button></a></th>
            </tr>
          </thead>
      <tbody>
        
        
          <?php while($row2 = $result2->fetch_assoc()) {  ?>
            <tr>
            <td scope='row' id="Epitope" class='text-center' >
              <a href="<?php echo "epitope.php?idEpitope=".$row2['idEpitope']; ?>" target="_blank"><?php echo $row2['seqEpitope'] ;}?>
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
