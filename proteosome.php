<?php
    require("globals.inc.php");
    print headerDBW("Proteosome results");
    print navbar('Proteosome');
    $epitopeLen = intval($_REQUEST["epitopeLen"]);
    $sequences_arr = $_SESSION["proteosome"][$_REQUEST["frame"]];
    $conn = connectSQL();
    foreach ($sequences_arr as $coords => $sequence) { 
      if ($epitopeLen == 0) {
        $lenSeq = strlen($sequence);
        $epitopes = array();
        for ($i=0; $i < $lenSeq; $i++) { 
          $epitope = substr($sequence, $i, 9);
          if (strlen($epitope) == 9) {
            $epitopes[] = $epitope;
          }
          else {
            break;
          }
        }
      } elseif ($epitopeLen == 1) {
        $lenSeq = strlen($sequence);
        $epitopes = array();
        for ($i=0; $i < $lenSeq; $i++) { 
          $epitope = substr($sequence, $i, 10);
          if (strlen($epitope) == 10) {
            $epitopes[] = $epitope;
          }
          else {
            break;
          }
        }
      } else {
        $lenSeq = strlen($sequence);
        $epitopes = array();
        for ($i=0; $i < $lenSeq; $i++) { 
          $epitope = substr($sequence, $i, 9);
          if (strlen($epitope) == 9) {
            $epitopes[] = $epitope;
          }
          $epitope = substr($sequence, $i, 10);
          if (strlen($epitope) == 10) {
            $epitopes[] = $epitope;
          }
        }

      }
      $query_string = "SELECT Affinity.idEpitope, Epitope.seqEpitope, HLA.idHLA, logAff, nMAff, nameHLA from Affinity JOIN HLA ON Affinity.idHLA = HLA.idHLA JOIN Epitope ON Epitope.idEpitope = Affinity.idEpitope WHERE ";
      $epitopes = array_unique($epitopes);
      foreach ($epitopes as $epitope) {
           $query_string .= " seqEpitope = \"$epitope\" OR";
        }
        $query_string = substr($query_string, 0, -2).";";
        $results = $conn->query($query_string);
        
      ?>
      <div>
      <h3><?php echo "Protein ".$coords ?></h3>
      <a href="getFasta.php?coords=<?php echo $coords."&"."frame=".urlencode($_REQUEST["frame"]) ?>" target="_blank"><button>Download FASTA</button></a>
      <table class="table table-striped table-sm table-responsive text-center display">
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
          <?php foreach ($results as $row) {?>
          <tr>
            <td scope='row' id="idEpitope"><?php $idEpitope = $row['idEpitope'];
                        echo "<a href='epitope.php?idEpitope=$idEpitope'>$idEpitope</a>"?></td>
            <td class='text-center' id="seq"><?php echo $row['seqEpitope'] ?></td>
            <td class='text-center' id="hla"><a href=<?php $idHLA=$row['idHLA']; echo "'hla.php?idHLA=$idHLA' target='_blank'" ?>><?php echo $row['nameHLA'] ?></a></td>
            <td class='text-center' id="log"><?php echo $row['logAff'] ?></td>
            <td class='text-center' id="nM"><?php echo $row['nMAff'] ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <?php }?>

<script type="text/javascript">
  $(document).ready(function() {
      $('table.display').DataTable();
  });
</script>

<?php
$conn->close();
print footerDBW();
?>