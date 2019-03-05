<?php
if (isset($_GET["idOrganism"])){
$idOrganism = $_GET["idOrganism"];
include("globals.inc.php");
print headerDBW($idOrganism);
$conn = connectSQL();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT nameOrganism from Organism WHERE idOrganism = $idOrganism";
$nameOrganism = mysqli_fetch_array($conn->query($sql))['nameOrganism'];

$sql = "SELECT idAntigen, nameAntigen, idProtein FROM Antigen WHERE idOrganism = $idOrganism";
$antTable = $conn->query($sql);
$array = array();
foreach ($antTable as $row){
  $array[] = $row;
}
$_SESSION["array"] = $array;
$conn->close();
print navbar('Organism');
if (mysqli_num_rows($antTable) == 0) {
  header('Location: error.php');
}
else {
}
}
else{
  header('Location: error.php');
}
get_url();
?>
    <div class="container">

      <!-- Main component for a primary marketing message or call to action -->
    <div class="row">
      <div class="col-md-5">
        <table class="table table-striped table-sm table-responsive">
              <thead>
                <th scope="col"><h2>Organism</h2></th>
              </thead>
              <tbody>
                <tr>
                  <th scope="row" class="text-right">Id</th>
                  <td class="text-left">
                  <?php $idEptiope = $idOrganism;
                        echo "<a href='https://www.ncbi.nlm.nih.gov/Taxonomy/Browser/wwwtax.cgi?id=$idOrganism' target='_blank'>$idOrganism</a>"
                  ?></td>
                </tr>
                <tr>
                  <th scope="row" class="text-right">Name</th>
                  <td class="text-left" id="sequence"><?php echo $nameOrganism ?></td>
                </tr>
              </tbody>
            </table>
      </div>
  </div>
      <div class="row">
        <h2>Antigens</h2><br>
        <button id='tabletocsv'>Export to CSV</button><br>
        <table class="table table-striped table-sm table-responsive" id="affTable">
          <thead>
            <tr>
              <th>id Antigen</th>
              <th>Name Antigen</th>
              <th>id Protein</th>
            </tr>
          </thead>
      <tbody>
        <?php foreach ($antTable as $row){ ?>
          <tr>
            <th scope='row'><?php $idAntigen = $row['idAntigen'];
                        echo "<a href='antigen.php?idAntigen=$idAntigen' target='_blank'>$idAntigen</a>"?></th>
            <td class='text-left'>
              <?php echo $row['nameAntigen'] ?></td>
            <td class='text-center'><?php $idProtein = $row['idProtein'];
              echo "<a href='protein.php?idProtein=$idProtein'>$idProtein</a>"
             ?></td>
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
      });
      

    </script>
<?php
get_url();
print footerDBW();
?>
