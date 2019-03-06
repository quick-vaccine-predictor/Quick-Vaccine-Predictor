<?php
include("globals.inc.php");
$title = "MyVaccine";
print headerDBW($title);
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: login.php");
}
//Conection to the DB
$conn = connectSQL();
$idUser = $_SESSION['idUser'];
$email= $_SESSION['email'];
$sql = "SELECT idVaccine, nameVaccine FROM Vaccine  WHERE idUser ='$idUser' ";
$vaccines = $conn->query($sql); /* the search is done here */  
print navbar('MyVaccine'); 
?> 
<div class="container">
    <div class="jumbotron" style="background:transparent !important"> 
          <h2>Hi, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b>. Welcome to your personal site.</h2>
          <p>Here is your personal site inside QVVP. You can create vaccines, add as many epitopes as you need. All of them reachable from a simple query into our database.</p>
    </div>
    <hr class="featurette-divider">
    <div class="row">
        <h2>Vaccines</h2>
        <?php
          foreach ($vaccines as $vrow) {
             $nVac = $vrow["nameVaccine"];
             $idVaccine = $vrow["idVaccine"];
        ?>
        <h3>Name: <?php echo $nVac ?></h3>
        <form method="POST" action="my_vaccine.php" >
          <button type="button" class="btn btn-info btn-sm pull-left" data-toggle="modal" data-target="#myModalrename<?php echo $idVac ?>">Rename</button>
        </form>
        <form method="POST" action="my_vaccine.php" >
          <input type="hidden" name="removeVac" value="<?php echo $idVaccine ?>">
          <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-target="#myModalremove<?php echo $idVaccine ?>">Remove <?php echo $nVac ?></button>
        </form>
        <br>
        <br>
        <!-- Modal -->
        <div class="modal fade" id="myModalrename<?php echo $idVac ?>" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-body">
                <form class="form-signin" action= "renameVaccine.php" method="POST"><?php include('errors.php'); ?>
                  <input type="hidden" name="currentVac" value="<?php echo $idVaccine ?>">
                  <h2 class="form-signin-heading">Rename <?php echo $nVac ?></h2>
                  <p>Please fill out this form to rename your Vaccine.</p>
                  <div class="form-group">
                    <label><p>Type your new Vaccine name</p></label>
                    <input type="text" name="newVaccinename" id="newVaccinename" class="form-control" placeholder="New Vaccine name" required>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-primary" type="submit">Rename</button>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>        
          </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myModalremove<?php echo $idVaccine ?>" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-body">
                <form class="form-signin" action= "removeVaccine.php" method="POST"><?php include('errors.php'); ?>
                  <input type="hidden" name="currentVac" value="<?php echo $idVaccine ?>">
                  <div class="text-center">
                    Are you sure?<br><br>
                    <button class="btn btn-danger" onclick="my_function()">Remove</button>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <table class="table table-striped table-sm table-responsive affTable" id="affTable">
          <thead>
            <tr>
              <th>Epitope ID </th>
              <th>Sequence</th>
              <th>Immunogenecity score</th>
              <th></th>
            </tr>
          </thead>
          <tbody> 
          <?php
            $sql = "SELECT  vc.idEpitope, e.seqEpitope, scoreImmunogenecity FROM Vaccine v, VaccineContent vc, Epitope e WHERE idUser ='$idUser' AND v.idVaccine = vc.idVaccine AND vc.idEpitope = e.idEpitope  AND v.nameVaccine ='$nVac' ";
            $epitopes = $conn->query($sql);
            foreach ($epitopes as $erow) {
              $idEpitope = $erow["idEpitope"];
              $seqEpitope = $erow["seqEpitope"];
              $scoreImmunogenecity = $erow["scoreImmunogenecity"];
          ?>
            <tr>
              <td><a href="epitope.php?idEpitope=<?php echo $idEpitope?>"><?php echo $idEpitope?></a></td>
              <td><?php echo $seqEpitope ?></td>
              <td><?php echo $scoreImmunogenecity ?></td>
              <td>
                <form method="POST" action="removeSequence.php">
                  <input type="hidden" name="idEpitope" value="<?php echo $idEpitope ?>">
                  <input type="hidden" name="idVaccine" value="<?php echo $idVaccine ?>">
                  <button type="submit" class="btn btn-danger">Delete</button>
                </form>
              </td>
            </tr>
          <?php    
              } ?>
          </tbody>
        </table>
        <hr class="featurette-divider">
          <?php
            }
          ?>
 </div>  <!--</div> -->
    <script type="text/javascript">
      $(document).ready(function () {
        $('.affTable').DataTable();
      });
    </script>
</div>

<?php print footerDBW();?>
