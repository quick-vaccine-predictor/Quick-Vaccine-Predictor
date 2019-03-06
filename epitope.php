<?php
include("globals.inc.php");
$idEpitope = $_GET["idEpitope"];
if (isset($idEpitope)){
print headerDBW($idEpitope);
$conn = connectSQL();
$sql = "SELECT idEpitope, HLA.idHLA, logAff, nMAff, nameHLA from Affinity JOIN HLA ON Affinity.idHLA = HLA.idHLA where idEpitope = $idEpitope";
$affTable = $conn->query($sql);
$array = array();
$nm_data = [];
$log_data = [];
foreach ($affTable as $row){
  $array[] = $row;
  $nm_data[] = $row["nMAff"];
  $log_data[] = $row["logAff"];
}
$_SESSION["array"] = $array;
$affdata = $array;
$sql = "SELECT idEpitope, seqEpitope, scoreImmunogenecity, Antigen.idAntigen, nameAntigen, start,end, Antigen.idProtein, nameProtein, Antigen.idOrganism, nameOrganism from Epitope JOIN Antigen ON Epitope.idAntigen = Antigen.idAntigen JOIN Protein ON Antigen.idProtein = Protein.idProtein JOIN Organism ON Antigen.idOrganism = Organism.idOrganism  WHERE idEPitope = $idEpitope";
$epTable = mysqli_fetch_array($conn->query($sql));
$conn->close();
print navbar('Epitope');
if (mysqli_num_rows($affTable) == 0) {
  header('Location: error.php');
}
}
else{
  header('Location: error.php');
}
get_url();
?>
<div class="container">
<!-- Main component for a primary marketing message or call to action -->
  <h2>Epitope <a class="btn btn-info btn-sm" href="addindex.php?idEpitope=<?php echo $idEpitope ?>">Add</a></h2>
  <div class="row">
    <div class="col-md-5">
      <table class="table table-striped table-sm table-responsive">
        <tbody>
          <tr>
            <th scope="row" class="text-right">Id</th>
            <td class="text-left">
              <?php $idEptiope = $epTable['idEpitope'];
                    echo "<a href='http://www.iedb.org/epitope/$idEpitope' target='_blank'>$idEpitope</a>"
              ?>
            </td>
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
            <td class="text-left"><?php echo $epTable['scoreImmunogenecity'] ?></td>
          </tr>
          <tr>
            <th scope="row" class="text-right">Antigen Id</th>
            <td class='text-left'>
              <?php $idAntigen = $epTable['idAntigen'];
                    echo "<a href='antigen.php?idAntigen=$idAntigen' target='_blank'>$idAntigen</a>"?>
            </td>
          </tr>
          <tr>
            <th scope="row" class="text-right">Antigen name</th>
            <td class='text-left'>
              <?php $nameAntigen = $epTable['nameAntigen'];
                  echo "$nameAntigen"
              ?>
            </td>
          </tr>
          <tr>
            <th scope="row" class="text-right">Protein Id</th>
            <td class='text-left'>
              <?php $idProtein = $epTable['idProtein'];
                    echo "<a href='protein.php?idProtein=$idProtein' target='_blank'>$idProtein</a>"?>
            </td>
          </tr>
          <tr>
            <th scope="row" class="text-right">Protein name</th>
            <td class='text-left'><?php echo $epTable['nameProtein']?></td>
          </tr>
          <tr>
            <th scope="row" class="text-right">Organism</th>
            <td class="text-left">
              <?php $idOrganism = $epTable['idOrganism'];
                    $nameOrganism = $epTable['nameOrganism'];
                    echo "<a href='organism.php?idOrganism=$idOrganism' target='_blank'>$nameOrganism</a>"
              ?>
            </td>
          </tr>
          <tr>
            <th colspan="2">
              <div class="chart-container" style='height: 300px; width: auto; text-align:center'>
                <canvas id="Polarity"></canvas>
              </div>
            </th>
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
      <h2>Binding Affinities</h2><br>
      <button id='tabletocsv'> Export to CSV</button><br>
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
            <th scope='row' id="idEpitope">
              <?php $idEptiope = $epTable['idEpitope'];
                    echo "<a href='epitope.php?idEpitope=$idEpitope'>$idEpitope</a>"?>
             </th>
            <td class='text-center' id="hla"><a href=<?php $idHLA=$row['idHLA']; echo "'hla.php?idHLA=$idHLA' target='_blank'" ?>><?php echo $row['nameHLA'] ?></a></td>
            <td class='text-center' id="log"><?php echo $row['logAff'] ?></td>
            <td class='text-center' id="nM"><?php echo $row['nMAff'] ?></td>
          </tr>
        <?php } ?>
      </tbody>
      </table>
      </div>
    </div> <!-- /container -->
    <script type="text/javascript">
      $(document).ready(function () {
        $('#affTable').DataTable();
        document.getElementById("tabletocsv").onclick = function () {
        location.href = "tabletocsv.php";
        };
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
<?php 

print footerDBW(); ?>