<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="Quick Vaccine Predictor" content="">
    <meta name="QVP" content="">
    <link rel="icon" href="">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <title><?php if (isset($_GET["idAntigen"])){echo "Antigen: ",$_GET['idAntigen'];}?></title>
    <!-- Minified Bootstrap 3 CSS-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <!--Minified jQuery 3 JS-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!--Latest Bootstrap 3 JS-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src=https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js></script>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css"/>
  </head>

<?php
if (isset($_GET["idAntigen"])){
$servername = "frmc.mmb.pcb.ub.es";
$username = "Qvvp";
$password = "Qvvp_121327";
$dbname = "qvvp";
$idAntigen = $_GET["idAntigen"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT nameAntigen, Antigen.idOrganism, Organism.nameOrganism, Antigen.idProtein, Protein.nameProtein from Antigen JOIN Organism ON Antigen.idOrganism = Organism.idOrganism JOIN Protein ON Antigen.idProtein = Protein.idProtein WHERE idAntigen = '$idAntigen'";
$AntTable = mysqli_fetch_array($conn->query($sql));
print_r($AntTable);
$sql = "SELECT idEpitope, seqEpitope, scoreImmunogenecity, start, end FROM Epitope WHERE idAntigen = '$idAntigen'";
$affTable = $conn->query($sql);
print_r($affTable);
exit();
$conn->close();
if (mysqli_num_rows($affTable) == 0) {
  header('Location: error.php');
}
else {
}
}
else{
  header('Location: error.php');
}
?>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>                        
          </button>
          <a class="navbar-brand" href="#">QVP</a>
        </div>
        <div id="myNavbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.html">Home</a></li>
            <li><a href="myvaccine.html">MyVaccine</a></li>
            <li><a href="queries.php">Queries</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="signin.html"> Sign Up</a></li>
            <li><a href="login.html"> Login</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container">

      <!-- Main component for a primary marketing message or call to action -->
    <div class="row">
      <div class="col-md-5">
        <table class="table table-striped table-sm table-responsive">
              <thead>
                <th scope="col"><h2>Antigen</h2></th>
              </thead>
              <tbody>
                <tr>
                  <th scope="row" class="text-right">Id</th>
                  <td class="text-left">
                  <?php echo "<a href='https://www.ncbi.nlm.nih.gov/protein/$idAntigen' target='_blank'>$idAntigen</a>"
                  ?></td>
                </tr>
                <tr>
                  <th scope="row" class="text-right">Name Antigen</th>
                  <td class="text-left" id="sequence"><?php echo $AntTable['nameAntigen'] ?></td>
                </tr>
                <tr>
                  <th scope="row" class="text-right">Organism</th>
                  <td class="text-left"><?php $idOrganism = $AntTable['idOrganism']; $nameOrganism = $AntTable['nameOrganism']
                        echo "<a href='organism.php?idOrganism=$idOrganism' target='_blank'>$nameOrgansim</a>"
                  ?></td>
                </tr>
                <tr>
                  <th scope="row" class="text-right">Protein</th>
                  <td class="text-left"><?php $idProtein = $AntTable['idProtein']; $nameProtein = $AntTable['nameProtein']
                        echo "<a href='protein.php?idProtein=$idProtein' target='_blank'>$nameProtein</a>"
                  ?></td>
                </tr>
              </tbody>
            </table>
      </div>
  </div>
      <div class="row">
        <h2>Antigens</h2>
        <table class="table table-striped table-sm table-responsive">
          <thead>
            <tr>
              <th>id Epitope</th>
              <th>Sequence</th>
              <th>Immunogenecity Score</th>
              <th>Start</th>
              <th>End</th>
            </tr>
          </thead>
      <tbody>
        <?php foreach ($affTable as $row){ ?>
          <tr>
            <th scope='row'><?php $idEpitope = $row['idEpitope'];
                        echo "<a href='epitope.php?idEpitope=$idEpitope' target='_blank'>$idEpitope</a>"?></th>
            <td class='text-center'>
              <?php echo $row['seqEpitope'] ?></td>
            <td class='text-center'><?php echo $row['scoreImmunogenecity'] ?></td>
            <td class='text-center'><?php echo $row['start'] ?></td>
            <td class='text-center'><?php echo $row['end'] ?></td>
          </tr>
        <?php } ?>
      </tbody>
      </table>
      </div>
    </div> <!-- /container -->
    <footer class="text-muted">
        <div class="container">
            <p>QVP © 2019 <a href="#">Back to top</a></p>
         </div>
    </footer>
    <script type="text/javascript">
      $(document).ready(function () {
        $('#affTable').DataTable();
      });
      

    </script>

</html>