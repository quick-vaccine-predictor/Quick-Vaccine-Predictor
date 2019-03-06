<?php
if (isset($_GET["idAntigen"])){
include("globals.inc.php");
$idAntigen = $_GET["idAntigen"];
print headerDBW($idAntigen);
$conn = connectSQL();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT nameAntigen, Antigen.idOrganism, Organism.nameOrganism, Antigen.idProtein, Protein.nameProtein from Antigen JOIN Organism ON Antigen.idOrganism = Organism.idOrganism JOIN Protein ON Antigen.idProtein = Protein.idProtein WHERE idAntigen = '$idAntigen'";
$AntTable = mysqli_fetch_array($conn->query($sql));
$sql = "SELECT idEpitope, seqEpitope, scoreImmunogenecity, start, end FROM Epitope WHERE idAntigen = '$idAntigen'";
$affTable = $conn->query($sql);
$array = array();
foreach ($affTable as $row){
  $array[] = $row;
}
$_SESSION["array"] = $array;
$conn->close();
print navbar('Antigen');
if (mysqli_num_rows($affTable) == 0) {
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
                  <th scope="col"><h2>Antigen</h2></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row" class="text-right">Id</th>
                  <td class="text-left" colspan="2">
                  <?php echo "<a href='https://www.ncbi.nlm.nih.gov/protein/$idAntigen' target='_blank'>$idAntigen</a>"
                  ?></td>
                </tr>
                <tr>
                  <th scope="row" class="text-right">Name Antigen</th>
                  <td class="text-left" id="sequence" colspan="2"><?php echo $AntTable['nameAntigen'] ?></td>
                </tr>
                <tr>
                  <th scope="row" class="text-right">Organism</th>
                  <td class="text-left" colspan="2"><?php $idOrganism = $AntTable['idOrganism']; $nameOrganism = $AntTable['nameOrganism'];
                        echo "<a href='organism.php?idOrganism=$idOrganism' target='_blank'>$nameOrganism</a>";?></td>
                </tr>
                <tr>
                  <th scope="row" class="text-right">Protein</th>
                  <td class="text-left" colspan="2"><?php $idProtein = $AntTable['idProtein']; $nameProtein = $AntTable['nameProtein'];
                        echo "<a href='protein.php?idProtein=$idProtein' target='_blank'>$nameProtein</a>";?></td>
                </tr>
                <tr>
                  <th scope="row" class="text-right">Find homolog</th>
                  <form action="blast.php" method="POST">
                  <td class="text-left">
                      <input checked type="radio" name="db" value="sprot">Swissprot<br>
                      <input type="hidden" value='<?php echo $idAntigen?>' name='id'>
                      <input type="radio" name="db" value="pdb">PDB<br>
                  </td>
                  <td><input type="submit" value="Submit"></td>
                  </form>
                </tr>
                <tr>
                  <th class="text-left">Find more epitopes<br> (Proteosome)</th>
                  <form action="proteosomeManager.php" method="POST">
                  <td class="text-left">
                      <label>Select length</label><br>
                      <input checked type="radio" name="length" value="0">9<br>
                      <input checked type="radio" name="length" value="1">10<br>
                      <input checked type="radio" name="length" value="2">Both<br>
                      <input type="hidden" value='<?php echo $idAntigen?>' name='ncbiId'>
                      <input type="hidden" value='0' name='in_dna'>
                  </td>
                  <td><input type="submit" value="Submit"></td></td>
                  </form>
                </tr>
              </tbody>
            </table>
      </div>
  </div>
      <div class="row">
        <h2>Antigens</h2><br>
        <button id='tabletocsv'> Export to CSV</button><br>
        <table class="table table-striped table-sm table-responsive" id="affTable">
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
    <script type="text/javascript">
      $(document).ready(function () {
        $('#affTable').DataTable();
        document.getElementById("tabletocsv").onclick = function () {
        location.href = "tabletocsv.php";
    };
      });
    </script>
<?php

print footerDBW();
?>
