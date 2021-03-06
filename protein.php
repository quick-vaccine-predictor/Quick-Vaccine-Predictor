<?php
if (isset($_GET["idProtein"])){
include("globals.inc.php");
$idProtein = $_GET["idProtein"];
print headerDBW($idProtein);
$conn = connectSQL();
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT nameProtein from Protein WHERE idProtein = '$idProtein'";
$nameProtein = mysqli_fetch_array($conn->query($sql))['nameProtein'];
$sql = "SELECT idAntigen, nameAntigen, idOrganism FROM Antigen WHERE idProtein = '$idProtein'";
$antTable = $conn->query($sql);
$array = array();
foreach ($antTable as $row){
  $array[] = $row;
}
$_SESSION["array"] = $array;
$conn->close();
print navbar('Protein');
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
            <tr>
              <th scope="col"><h2>Protein</h2></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row" class="text-right">Id</th>
              <td class="text-left" colspan="2">
              <?php $idEptiope = $idProtein;
                echo "<a href='https://www.ncbi.nlm.nih.gov/protein/$idProtein' target='_blank'>$idProtein</a>"
              ?></td>
            </tr>
            <tr>
              <th scope="row" class="text-right">Name</th>
              <td class="text-left" id="sequence" colspan="2"><?php echo $nameProtein ?></td>
            </tr>
          </tbody>
        </table>
        <form action="blast.php" method="POST">
          <table class="table table-striped table-sm table-responsive">
            <tr>
              <th scope="row" class="text-right">Find homolog</th>
              <td class="text-left">
                <input checked type="radio" name="db" value="sprot">Swissprot<br>
                <input type="hidden" value='<?php echo $idProtein?>' name='id'>
                <input type="radio" name="db" value="pdb">PDB
              </td>
              <td><input type="submit" value="Submit"></td>
            </tr>
          </table>
        </form>
        <form action="proteosomeManager.php" method="POST" id="protQuery">
          <table class="table table-striped table-sm table-responsive">
            <tr>
              <th class="text-left">Find more epitopes<br> (Proteosome)</th>
              <td class="text-left">
                <label>Select length</label><br>
                <input checked type="radio" name="length" value="0">9<br>
                <input checked type="radio" name="length" value="1">10<br>
                <input checked type="radio" name="length" value="2">Both<br>
                <input type="hidden" value='<?php echo $idProtein?>' name='ncbiId'>
                <input type="hidden" value='0' name='in_dna'>
              </td>
              <td><input type="submit" value="Submit"></td>
            </tr>
          </table>
        </form> 
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
              <th>id Organism</th>
            </tr>
          </thead>
      <tbody>
        <?php foreach ($antTable as $row){ ?>
          <tr>
            <th scope='row'><?php $idAntigen = $row['idAntigen'];
                        echo "<a href='antigen.php?idAntigen=$idAntigen' target='_blank'>$idAntigen</a>"?></th>
            <td class='text-left'>
              <?php echo $row['nameAntigen'] ?></td>
            <td class='text-center'><?php $idOrganism = $row['idOrganism'];
              echo "<a href='organism.php?idOrganism=$idOrganism' target='_blank'>$idOrganism</a>"
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
        var protId = '<?php echo $idProtein ?>';
        console.log(protId);
        if (protId == 'unknwon') {
          $('#protQuery').hide();
        } else {
          $('#protQuery').show();
        }
      });
      

    </script>
<?php 
print footerDBW();
?>
