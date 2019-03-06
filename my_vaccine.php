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
$errors = array();

$idUser = $_SESSION['idUser'];
$email= $_SESSION['email'];
$sql = "SELECT idVaccine, nameVaccine FROM Vaccine  WHERE idUser ='$idUser' ";
//$sl = "SELECT idVaccine, nameVaccine FROM Vaccine WHERE idUser ='$idUser'";

$result = $conn->query($sql); /* the search is done here */  



print navbar('myVaccine'); 


?> 


<div class="container">
    <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b>. Welcome to your personal site.</h1>
    <div class="jumbotron"> 
        <div class="col-sm-8">
            Here is your personal site inside QVVP. You can create vaccines, add as many as needed epitopes. All of them from a simple query into our database.
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
                <form method="POST" action="my_vaccine.php" >
                  <button type="button" class="btn" data-toggle="modal" data-target="#myModalrename<?php echo $nVac ?>">Rename <?php echo $nVac ?></button>
                </form>
                  <!-- Modal -->
                  <div class="modal fade" id="myModalrename<?php echo $nVac ?>" role="dialog">
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-body">
                          <p>
                            <form class="form-signin" action= "renameVaccine.php" method="POST"><?php include('errors.php'); ?>
                            <input type="hidden" name="currentVac" value="<?php echo $idVaccine ?>">
                            <h2 class="form-signin-heading">Rename <?php echo $nVac ?></h2>
                            <p>Please fill out this form to rename your Vaccine.</p>
                                <div class="form-group">
                                    <label><p>Type your new Vaccine name</p></label>
                                    <input type="text" name="newVaccinename" id="newVaccinename" class="form-control" placeholder="New Vaccine name" required>
                                </div>
                                <div class="form-group">
                                    <label><p>Type your Password</p></label>
                                    <label for="inputPassword" class="sr-only">Password</label>
                                    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">Rename</button>
                                </div>
                            </form>
                          </p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                      </div>        
                    </div>
                  </div>
                </th>
                <th>
                <form method="POST" action="my_vaccine.php" >
                  <input type="hidden" name="removeVac" value="<?php echo $idVaccine ?>">
                </form>
                <button type="button" class="btn" data-toggle="modal" data-target="#myModalremove<?php echo $idVaccine ?>">Remove <?php echo $nVac ?></button>
                <!-- Modal -->
                <div class="modal fade" id="myModalremove<?php echo $idVaccine ?>" role="dialog">
                  <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-body">
                        <p>
                        <form class="form-signin" action= "removeVaccine.php" method="POST" onsubmit="return confirm('Are you sure you want to submit?')"><?php include('errors.php'); ?>
                          <input type="hidden" name="currentVac" value="<?php echo $idVaccine ?>">
                          <h2 class="form-signin-heading">Fill the form with your email and password<br></h2>
                          <div class="form-group">
                              <label for="inputEmail" class="sr-only">Email address</label>
                              <input type="email" name="email" id="inputEmail" value="<?php if(isset($email) & !empty($email)){ echo $email; } ?>" class="form-control" placeholder="Email address" required autofocus>
                          </div>
                          <div class="form-group">
                              <label for="inputPassword" class="sr-only">Password</label>
                              <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
                          </div>
                          <div class="form-group">
                              <label for="inputPassword" class="sr-only">Confirm Password</label>
                              <input type="password" name="confirm_password" id="inputPassword" class="form-control" placeholder="Confirm Password" required>
                          </div>
                          <div class="form-group">
                              <button class="btn btn-primary" onclick="my_function()">Remove</button>
                          </div>
                      </form>
                        </p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>           
              </th>
            <tr>
              <th>Epitope ID </th>
              <th>Sequence</th>
              <th>Immunogenecity score</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php while($row2 = $result2->fetch_assoc()) { 
              $idEpitope = $row2['idEpitope'];
              $sql3 = "SELECT scoreImmunogenecity FROM Epitope WHERE idEpitope = '$idEpitope'";
              $result3 = $conn->query($sql3); /* the search is done here */  
              $scoreImm = $result3->fetch_assoc();
              ?>
              <tr>
              <td scope='row' id="Epitopeid" class='text-center' >
                <a href="<?php echo "epitope.php?idEpitope=".$row2['idEpitope']; ?>" target="_blank"><?php echo $row2['idEpitope'] ;?>
              </td>
              <td scope='row' id="Epitopeseq" class='text-center' >
                <?php echo $row2['seqEpitope'] ;?>
              </td>
              <td> <?php echo $scoreImm["scoreImmunogenecity"]?>
              <td>
              <td>
                <form method="post" action="removeSequence.php" >
                  <input type="hidden" name="removeSeq" value="<?php echo $idVaccine."|".$row2['idEpitope']?>">
                  <!-- Trigger the modal with a button -->
                  <button type="button" class="btn" data-toggle="modal" data-target="#deleteSequence">Remove Epitope</button>
                  <!-- Modal -->
                  <div class="modal fade" id="deleteSequence" role="dialog">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-body">
                          <p>Are you sure?</p>
                            <input type="submit" value="Yes">
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
            <?php } ?>
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
          "info":false}
        );
      });
    </script>
</div>

<?php print footerDBW();?>
