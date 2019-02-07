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
    <title><?php if (isset($_GET["idHLA"])){echo $_GET['idHLA'];}?></title>
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
if (isset($_GET["idHLA"])){
$servername = "localhost";
$username = "qvp";
$password = "qvp";
$dbname = "qvp";
$idHLA = $_GET["idHLA"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT nameHLA, pdbHLA FROM HLA WHERE idHLA = '$idHLA';";
$HLA_data = mysqli_fetch_all($conn->query($sql))[0];
$nameHLA = $HLA_data[0];
$pdbHLA = $HLA_data[1];

$sql = "SELECT Affinity.idEpitope, idHLA, logAff, nMAff, seqEpitope from Affinity JOIN Epitope ON Affinity.idEpitope = Epitope.idEpitope where idHLA = '$idHLA'";
$affTable = $conn->query($sql);
$affdata = mysqli_fetch_all($conn->query($sql));
$nm_data = [];
$log_data = [];

for ($x = 0; $x <= 30; $x++) {
    $nm = $affdata[$x][3];
    $log = $affdata[$x][2];
    array_push($nm_data, $nm);
    array_push($log_data, $log);
}

$conn->close();
}
else {
  $affTable = [];
  $epTable = [];
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
    <h2>HLA allele</h2>
    <div class="row">
      <div class="col-md-4">
        <table class="table table-striped table-sm table-responsive">
              <tbody>
                <tr>
                  <th scope="row" class="text-right">Id</th>
                  <td class="text-center"><?php echo "<a href='https://www.ebi.ac.uk/cgi-bin/ipd/imgt/hla/get_allele.cgi?$idHLA' target='_blank'>$idHLA</a>"
                  ?></td>
                </tr>
                <tr>
                  <th scope="row" class="text-right">Name</th>
                  <td class="text-center" id="name"><?php echo $nameHLA ?></td>
                </tr>
                <tr>
                  <th scope="row" class="text-right">PDB</th>
                  <td class="text-center" id="name">
                    <?php if($pdbHLA != "None"){echo "<img src='http://www.pdb.org/pdb/images/{$pdbHLA}_bio_r_250.jpg' width='250' height='250' border='0'><br><a href='http://www.pdb.org/pdb/explore.do?structureId=$pdbHLA'>Link to PDB</a>";} ?>
                    </td>
                </tr>
              </tbody>
            </table>
      </div>
      <div class="col-md-8 ">
        <div class="chart-container " style="height: 400px; width: auto; text-align:center">
          <canvas id="Scatter"></canvas>
      </div>
      </div>
  </div>
      <div class="row">
        <h2>Binding Affinities</h2>
        <table class="table table-striped table-sm table-responsive" id="affTable">
          <thead>
            <tr>
              <th>idEpitope</th>
              <th>Sequence</th>
              <th>log</th>
              <th>nM</th>
            </tr>
          </thead>
      <tbody>
        <?php foreach ($affTable as $r){ ?>
          <tr>
            <?php $idEpitope = $r['idEpitope']; ?>
            <th scope='row' id="idEpitope"><a href=<?php $idEpitope=$r['idEpitope']; echo  "epitope.php?idEpitope=$idEpitope target='_blank'" ?>>
              <?php echo $idEpitope ?></a></th>
            <td class='text-center' id="seq">
              <?php echo $r['seqEpitope'] ?>
            </td>
            <td class='text-center' id="log"><?php echo $r['logAff'] ?></td>
            <td class='text-center' id="nM"><?php echo $r['nMAff'] ?></td>
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
      
        $('#affTable').DataTable();
        
        var nm_array = <?php echo json_encode($nm_data); ?>;
        var log_array = <?php echo json_encode($log_data); ?>;

        var arr_jsons_data = [];
        var HLA_name = <?php echo json_encode($idHLA); ?>;
        console.log(nm_array);
        console.log(log_array);
        var nm_num_array = nm_array.map(Number);
        var log_num_array = log_array.map(Number);

        var i;
        for (i = 0; i < nm_num_array.length; i++) {
          arr_jsons_data.push({x:log_num_array[i], y: nm_num_array[i]});
        } 


        new Chart(document.getElementById("Scatter"), {
        type: 'bubble',
        title: "Affinity",
        data: {
          datasets: [{
            label: HLA_name,
            data: arr_jsons_data,
            borderColor: '#2196f3', // Add custom color border            
            backgroundColor: '#2196f3',
          }]

        },
        options: {
          title: {
            display: true,
            text: 'Affinity'
        },
          scales: {
            xAxes: [{
                scaleLabel: {
                display: true,
                labelString: 'log'
                }
            }],
            yAxes: [{
                scaleLabel: {
                display: true,
                labelString: 'nM'
                }
            }]
          }
        }
        });
   
      

    </script>

</html>