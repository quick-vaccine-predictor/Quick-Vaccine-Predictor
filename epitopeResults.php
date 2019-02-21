<?php
  include("globals.inc.php");
  print headerDBW("Search");
  $sequence = $_GET["sequenceName"];
  $conn = connectSQL();
  $sql = "SELECT idEpitope, seqEpitope, Immunogenecity_score FROM Epitope WHERE seqEpitope LIKE '%".$sequence."%'";
  $result = $conn->query($sql); /* the search is done here */  
  $conn->close();
  print navbar('HLA');
?>
    <div class="container">
      <div class="row">
        <h2>Epitopes</h2>
        <table class="table table-striped table-sm table-responsive" id="affTable">
          <thead>
            <tr>
              <th>idEpitope</th>
              <th>Sequence</th>
              <th>Immunogenecity score</th>
            </tr>
          </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()) { ?>
          <tr>
            <th scope='row' id="idEpitope"><?php echo $row['idEpitope'] ?></th>
            <td class='text-center' id="seq"><?php echo $row['seqEpitope'] ?></td>
            <td class='text-center' id="iScore"><?php echo $row['Immunogenecity_score'] ?></td>
          </tr>
        <?php } ?>
      </tbody>
      </table>
      </div>
    </div>
    <script type="text/javascript">
      $(document).ready(function () {
        $('#affTable').DataTable();
        
      });
    </script>
<?php print footerDBW();?>