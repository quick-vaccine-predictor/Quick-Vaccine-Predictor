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
$email="";

$email= $_SESSION["email"];
$sql = "SELECT idVaccine, nameVaccine FROM Vaccine ";
$sql2 = "SELECT idUser FROM User WHERE mailUser='$email' ";

//$sql = "SELECT User (mailUser, Password) VALUES ('$email', '$password')";
//$sql = "SELECT User.idUser, mailUser, Vaccine.idVaccine, nameVaccine, idEpitope from User JOIN Vaccine ON User.idUser = Vaccine.idUser JOIN VaccineContent ON Vaccine.idVaccine = VaccineContent.idVaccine WHERE isUser = $idUser";
$result = $conn->query($sql); /* the search is done here */  
$result2 = $conn->query($sql2);

$conn->close();



print navbar('myVaccine');
?> 

<div class="container">
    <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b>. Welcome to our site.</h1>
    <div class="row"> 
        <div class="col-sm-8">
            Here will go a brief explanation about QVVP and if we have time we should put a video tuturial or just a tutorial.
        </div>

    </div>

    <div class="row">
        <h2>Epitopes</h2>
        <table class="table table-striped table-sm table-responsive" id="affTable">
          <thead>
            <tr>
              <th>Vaccine name</th>
              <th>idEpitope</th>
              <th>idVaccine</th>
            </tr>
          </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()) { ?>
          <tr>
            <th scope='row' id="idUser"><a href="<?php echo $row['nameVaccine'] ?>"><?php echo $row['nameVaccine'] ?></th>
            <td class='text-center' id="mail"><?php echo $row['idUser'] ?></td>
            <td class='text-center' id="idVaccine"><?php echo $row['idVaccine'] ?></td>
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
