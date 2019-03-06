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
      <h3><?php echo "Protein ".$coords; $clean_cords = str_replace(":", "_", $coords); ?></h3>
      <a href="getFasta.php?coords=<?php echo $coords."&"."frame=".urlencode($_REQUEST["frame"]) ?>" target="_blank" class="btn btn-primary">Download FASTA</a><br>
      <form action="blast.php<?php echo '?coords='.$coords."&"."frame=".urlencode($_REQUEST["frame"]) ?>" method="POST">
      <table>
        <thead>
          <tr>
            <th colspan="2"><label>Find homolog:</label></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><input checked type="radio" name="db" value="sprot">Swissprot<br></td>
          </tr>
          <tr>
            <td><input type="radio" name="db" value="pdb">PDB<br></td>
            <td rowspan="2" class="text-center"><input type="submit" value="Submit"></td>
          </tr>
        </tbody>
      </table>
      </form>
      <br>
      <table class="table table-striped table-sm table-responsive text-center display" id='<?php echo "table".$clean_cords ?>'>
        <thead>
          <tr>
                <th>idEpitope</th>
                <th>Sequence</th>
                <th>HLA</th>
                <th>log</th>
                <th>nM</th>
                <th>My Vaccine</th>
          </tr>
        </thead>
          <?php 
          $json_data = array();
          foreach ($results as $row){
            $json_data[] = ["idEpitope" => $row["idEpitope"],
                            "seqEpitope" => $row["seqEpitope"],
                            "nameHLA" => $row["nameHLA"],
                            "logAff" => $row["logAff"],
                            "nMAff" => $row["nMAff"], 
                            "link" => "addindex.php?idEpitope=".$row["idEpitope"]];
             } ?>
      </table>
    </div>
    <script type="text/javascript">
      $(document).ready(function () {
      var data = <?php echo json_encode($json_data); ?>;
      console.log(data);
      $('<?php echo "#table".$clean_cords ?>').DataTable( {
            data:           data,
            deferRender:    true,
            scrollY:        500,
            scrollCollapse: true,
            scroller:       true,
            columns: [
              { data: "idEpitope" },
              { data: "seqEpitope" },
              { data: "nameHLA" },
              { data: "logAff" },
              { data: "nMAff" },
              { data: "link" , render : function ( data, type, row, meta ) {
                    return type === 'display'  ?
                    '<a class="btn btn-info btn-sm" href="' + data + '">' + 'Add' + '</a>' :
                    data;
                  }},
          ],
        } );
      });



    </script>
    <?php }?>

<script type="text/javascript">
</script>

<?php
$conn->close();
print footerDBW();
?>