<?php
include("globals.inc.php");
$title = "my Vaccine";
print headerDBW($title);

// Check if the user is logged in, if not then redirect him to login page
//if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
//    header("location: ./usr_register/login.php");
//    exit;
//}

//Conection to the DB
$conn = connectSQL();
$sql = "SELECT User.idUser, mailUser, Vaccine.idVaccine, nameVaccine, idEpitope from User JOIN Vaccine ON User.idUser = Vaccine.idUser JOIN VaccineContent ON Vaccine.idVaccine = VaccineContent.idVaccine WHERE isUser = $idUser";
$result = $conn->query($sql); /* the search is done here */  
$conn->close();





print navbar('myVaccine');
?> 

<div class="container">
    <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b>. Welcome to our site.</h1>
    <div class="row"> 
        <div class="col-sm-8">
            Here will go a brief explanation about QVVP and if we have time we should put a video tuturial or just a tutorial.
        </div>
        <div class="col-sm-4">
            tutorial
            <br>
            <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
            <br>
            <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
        </div>
    </div>

    <div class="row">
        <h2>Epitopes</h2>
        <table class="table table-striped table-sm table-responsive" id="affTable">
          <thead>
            <tr>
              <th>Vaccine name</th>
              <th>idEpitope</th>
            </tr>
          </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()) { ?>
          <tr>
            <th scope='row' id="nameVaccine"><a href="<?php echo $row['nameVaccine'] ?>"></th>
            <td class='text-center' id="idEpitope"><?php echo $row['idEpitope'] ?><?php echo $row['idUser'] ?></td>
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
