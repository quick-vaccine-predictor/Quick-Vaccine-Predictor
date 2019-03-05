<?php
if (isset($_GET["idHLA"])){
include("globals.inc.php");
$idHLA = $_GET["idHLA"];
print headerDBW($idHLA);
$conn = connectSQL();
// Check connection
if ($conn->connect_error) {
    header('Location: error.php');
}
$sql = "SELECT nameHLA, pdbHLA FROM HLA WHERE idHLA = '$idHLA';";
$HLA_data = mysqli_fetch_all($conn->query($sql))[0];
$nameHLA = $HLA_data[0];
$pdbHLA = $HLA_data[1];
$sql ="SELECT Affinity.idEpitope, idHLA, logAff, nMAff, seqEpitope from Affinity JOIN Epitope ON Affinity.idEpitope = Epitope.idEpitope WHERE idHLA = '$idHLA' ORDER BY logAff DESC, nMAff ASC;";
$affTable = $conn->query($sql);
$array = array();
$dataTable = array();
foreach ($affTable as $row){
  $array[] = $row;
  $dataTable[] = [$row["idEpitope"],$row["seqEpitope"],$row["logAff"],$row["nMAff"]];
}
$_SESSION["array"] = $array;
$affdata = $array;
$nm_data = [];
$log_data = [];
for ($x = 0; $x <= 30; $x++) {
    $nm = $affdata[$x]['nMAff'];
    $log = $affdata[$x]['logAff'];
    array_push($nm_data, $nm);
    array_push($log_data, $log);
}

$conn->close();
}
else {
  $affTable = [];
  $epTable = [];
}
print navbar('HLA');
get_url();
?>
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
        <h2>Binding Affinities</h2><br>
        <button id='tabletocsv'>Export to CSV</button><br>
        <table class="table table-striped table-sm table-responsive" id="affTable">
          <thead>
            <tr>
              <th>idEpitope</th>
              <th>Sequence</th>
              <th>log</th>
              <th>nM</th>
            </tr>
          </thead>
      </table>
      </div>
    </div> <!-- /container -->
    <script type="text/javascript">
      var data = <?php echo json_encode($dataTable); ?>;
      console.log(data);
        $('#affTable').DataTable( {
            data:           data,
            deferRender:    true,
            scrollY:        500,
            scrollCollapse: true,
            scroller:       true
        } );
        document.getElementById("tabletocsv").onclick = function () {
        location.href = "tabletocsv.php";
    };
        
        var nm_array = <?php echo json_encode($nm_data); ?>;
        var log_array = <?php echo json_encode($log_data); ?>;

        var arr_jsons_data = [];
        var HLA_name = <?php echo json_encode($idHLA); ?>;
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
<?php 
print footerDBW();
?>