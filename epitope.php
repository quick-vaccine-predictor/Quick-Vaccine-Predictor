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
    <title><?php if (isset($_GET["idEpitope"])){echo $_GET['idEpitope'];}?></title>
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
if (isset($_GET["idEpitope"])){
$servername = "localhost";
$username = "qvp";
$password = "qvp";
$dbname = "qvp";
$idEpitope = $_GET["idEpitope"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT idEpitope, HLA.idHLA, logAff, nMAff, nameHLA from Affinity JOIN HLA ON Affinity.idHLA = HLA.idHLA where idEpitope = $idEpitope";
$affTable = $conn->query($sql);
#print_r(mysqli_fetch_all($affTable));
$affdata = mysqli_fetch_all($conn->query($sql));
$sql = "SELECT idEpitope, seqEpitope, Immunogenecity_score, Antigen.idAntigen, nameAntigen, start,end, Antigen.idProtein, nameProtein, Antigen.idOrganism, nameOrganism from Epitope JOIN Antigen ON Epitope.idAntigen = Antigen.idAntigen JOIN Protein ON Antigen.idProtein = Protein.idProtein JOIN Organism ON Antigen.idOrganism = Organism.idOrganism  WHERE idEPitope = $idEpitope";
$epTable = mysqli_fetch_array($conn->query($sql));
#print_r($epTable);

$conn->close();
$nm_data = [];
$log_data = [];
foreach ($affdata as $r){
  array_push($nm_data, $r[3]);
  array_push($log_data, $r[2]);
}

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
                <th scope="col"><h2>Epitope</h2></th>
              </thead>
              <tbody>
                <tr>
                  <th scope="row" class="text-right">Id</th>
                  <td class="text-left">
                  <?php $idEptiope = $epTable['idEpitope'];
                        echo "<a href='http://www.iedb.org/epitope/$idEpitope' target='_blank'>$idEpitope</a>"
                  ?></td>
                </tr>
                <tr>
                  <th scope="row" class="text-right">Sequence</th>
                  <td class="text-left" id="sequence"><?php echo $epTable['seqEpitope'] ?></td>
                </tr>
                <tr>
                  <th scope="row" class="text-right">Length</th>
                  <td class="text-left"><?php echo $epTable['end'] - $epTable['start'] ?></td>
                </tr>
                <tr>
                  <th scope="row" class="text-right">Immunogenicity score:</th>
                  <td class="text-left"><?php echo $epTable['Immunogenecity_score'] ?></td>
                </tr>
                <tr>
                  <th scope="row" class="text-right">Antigen Id</th>
                  <?php $idAntigen = $epTable['idAntigen'];
                  echo "<td class='text-left'>$idAntigen</td>"
                  ?>
                </tr>
                
                <tr>
                  <th scope="row" class="text-right">Antigen name</th>
                  <?php $nameAntigen = $epTable['nameAntigen'];
                  echo "<td class='text-left'>$nameAntigen</td>"
                  ?>
                </tr>
                <tr>
                  <th scope="row" class="text-right">Protein Id</th>
                    <td class='text-left'><?php echo $epTable['idProtein']?></td>
                </tr>
                <tr>
                  <th scope="row" class="text-right">Protein name</th>
                    <td class='text-left'><?php echo $epTable['nameProtein']?></td>
                </tr>
                <tr>
                <tr>
                  <th scope="row" class="text-right">Organism</th>
                  <td class="text-left">
                    <?php $idOrganism = $epTable['idOrganism'];
                          $nameOrganism = $epTable['nameOrganism'];
                        echo "<a href='https://www.ncbi.nlm.nih.gov/Taxonomy/Browser/wwwtax.cgi?id=$idOrganism' target='_blank'>$nameOrganism</a>"
                  ?>
                  </td>
                </tr>
                <tr>
                  <table>
                  <tbody>
                    <tr>
                      <div class="chart-container " style="height: 300px; width: auto; text-align:center">
                      <canvas id="Polarity"></canvas>
                      </div>
                    <tr>
                  </tbody>
                  </table>
                </tr>
              </tbody>
            </table>
      </div>
      <div class="col-md-7 ">
        <div class="chart-container " style="height: 700px; width: auto; text-align:center">
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
              <th>HLA</th>
              <th>log</th>
              <th>nM</th>
            </tr>
          </thead>
      <tbody>
        <?php foreach ($affTable as $row){ ?>
          <tr>
            <th scope='row' id="idEpitope"><?php $idEptiope = $epTable['idEpitope'];
                        echo "<a href='epitope.php?idEpitope=$idEpitope'>$idEpitope</a>"?></th>
            <td class='text-center' id="hla"><a href=
              <?php $idHLA=$row['idHLA']; echo "hla.php?idHLA=$idHLA target='_blank'" ?>>
              <?php echo $row['nameHLA'] ?></td>

            <td class='text-center' id="log"><?php echo $row['logAff'] ?></td>
            <td class='text-center' id="nM"><?php echo $row['nMAff'] ?></td>
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
        var seq = document.getElementById("sequence").textContent;
        var polar = (seq.match(/[G,A,V,L,I,M,W,F,P]/g)||[]).length;
        var non_polar = (seq.match(/[S,T,C,Y,N,Q]/g)||[]).length;
        var negative = (seq.match(/[D,E]/g)||[]).length;
        var positive = (seq.match(/[L,R,H]/g)||[]).length;


        var nm_array = <?php echo json_encode($nm_data); ?>;
        var log_array = <?php echo json_encode($log_data); ?>;

        var arr_jsons_data = [];
        var idEpitope = <?php echo json_encode($idEpitope); ?>;
        
        var nm_num_array = nm_array.map(Number);
        var log_num_array = log_array.map(Number);

        var i;
        for (i = 0; i < nm_num_array.length; i++) {
          arr_jsons_data.push({x:log_num_array[i], y: nm_num_array[i]});
        } 

        var options = {
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Amino acid properties'
        }
        };

        new Chart(document.getElementById("Polarity"), {
        type: 'doughnut',
        data: {
          labels: ["Polar", "Non-Polar","Basic ( + )", "Acidic ( - )"],
          datasets: [{
            label: "doughnut",
            backgroundColor: ["#baba00", "#127000","#c40000", "#0060af"],
            data: [polar,non_polar,positive,negative]
          }]
        },
        options: options
        });

        new Chart(document.getElementById("Scatter"), {
        type: 'bubble',
        title: "Affinity",
        data: {
          datasets: [{
            label: idEpitope,
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
      });
      

    </script>

</html>