<?php
    include("globals.inc.php");
    print headerDBW("Proteosome results");
    $in_dna = $_POST["in_dna"];
    $seq = $_POST["proteosomeText"];
    $len = $_POST["length"];

    $command = escapeshellcmd('python3 proteosome.py '.$in_dna." ".$seq." ".$len);
    $output = explode(" ", shell_exec($command));
    $query_string = "SELECT Affinity.idEpitope, Epitope.seqEpitope, HLA.idHLA, logAff, nMAff, nameHLA from Affinity JOIN HLA ON Affinity.idHLA = HLA.idHLA JOIN Epitope ON Epitope.idEpitope = Affinity.idEpitope WHERE ";
    foreach($output as $o){
      $query_string .= " seqEpitope = \"$o\" OR";
    }
    $query_string = substr($query_string, 0, -2).";";
    $conn = connectSQL();
    $results = $conn->query($query_string);
    $conn->close();
    print navbar('Proteosome');
?>
    <div class="container">
      <a class="btn btn-primary btn-lg" href="queries.php#proteosome" role="button">Go back</a>
      <div class="row">
        <h2>Epitopes</h2>
        <table class="table table-striped table-sm table-responsive" id="affTable">
          <thead>
            <tr>
              <th>idEpitope</th>
              <th>Sequence</th>
              <th>HLA</th>
              <th>log</th>
              <th>nM</th>
            </tr>
          </thead>
      <tbody>
        <?php foreach($results as $row) { ?>
          <tr>
            <th scope='row' id="idEpitope"><?php $idEpitope = $row['idEpitope'];
                        echo "<a href='epitope.php?idEpitope=$idEpitope'>$idEpitope</a>"?></th>
            <td class='text-center' id="seq"><?php echo $row['seqEpitope'] ?></td>
            <td class='text-center' id="hla"><a href=<?php $idHLA=$row['idHLA']; echo "'hla.php?idHLA=$idHLA' target='_blank'" ?>><?php echo $row['nameHLA'] ?></a></td>
            <td class='text-center' id="log"><?php echo $row['logAff'] ?></td>
            <td class='text-center' id="nM"><?php echo $row['nMAff'] ?></td>
          </tr>
        <?php } ?>
      </tbody>
      </table>
      </div>
    </div>
 <!-- /container -->
    <script type="text/javascript">
      $(document).ready(function () {
        $('#affTable').DataTable();
        
      });
    </script>
<?php print footerDBW();?>