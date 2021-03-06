<?php
include("globals.inc.php");
//Conection to the DB if needed
$conn = connectSQL();
if (isset($_GET["nameOrganism"])){
	$name = $_GET["nameOrganism"];
	$sql = "SELECT nameOrganism, idOrganism FROM Organism WHERE nameOrganism LIKE '%".$name."%';";
}
elseif (isset($_GET["nameProtein"])) {
	$name = $_GET["nameProtein"];
	$sql = "SELECT nameProtein, idProtein FROM Protein WHERE nameProtein LIKE '%".$name."%';";
}
elseif (isset($_GET["nameAntigen"])) {
	$name = $_GET["nameAntigen"];
	$sql = "SELECT nameAntigen, idAntigen FROM Antigen WHERE nameAntigen LIKE '%".$name."%';";
}
else {
		$hla_arr = $_GET["hla"];
		$sql = "SELECT Affinity.idEpitope, Epitope.seqEpitope, HLA.idHLA, logAff, nMAff, nameHLA from Affinity JOIN HLA ON Affinity.idHLA = HLA.idHLA JOIN Epitope ON Epitope.idEpitope = Affinity.idEpitope WHERE ";
		if (strlen($_GET["sequenceName"]) > 0){
			$sql .= "seqEpitope LIKE '%".$_GET["sequenceName"]."%' AND ";
		}
		elseif (strlen($_GET["idEpitope"]) > 0){
			$sql .= "Affinity.idEpitope=".$_GET["idEpitope"]." AND ";
		}
		$hla_string = "";
		foreach ($hla_arr as $hla){
			if ($hla == $hla_arr[0]){
				$hla_string .= "(HLA.idHLA ='$hla' ";
			}
			elseif ($hla == array_values(array_slice($hla_arr, -1))[0]){
				$hla_string .= "OR HLA.idHLA ='$hla')";
			}
			else{
				$hla_string .= "OR HLA.idHLA ='$hla' ";
			}
			
		}
		if (count($hla_arr) == 1) {
			$hla_string .= ") ";
		}
		$sql .= $hla_string;
		$sql .= " AND (logAff >= ".$_GET["wblog"]." AND nMAff <= ".$_GET["wbaff"]."); ";
}
$nameTable = $conn->query($sql);
foreach ($nameTable as $row){
  $array[] = $row;
}
$_SESSION["array"] = $array;
$conn->close();
print headerDBW("Name Search");
print navbar('Epitope');
$json_data = array();
?>

<div class="container">
	<h2>Results</h2>
    <button id='tabletocsv'> Export to CSV</button><br>
    <table class="table table-striped table-sm table-responsive" id="<?php if (isset($_GET["nameOrganism"])){echo 'nameTable';} else {echo 'affTable';}?>">
    	<thead>
            <tr>
            <?php 
            if (isset($_GET["nameOrganism"])){ 
            	echo "<th>Organism Name</th><th>Organism Id</th>";
            }
            elseif (isset($_GET["nameProtein"])){
            	echo "<th>Protein Name</th><th>Protein Id</th>";
            }
            elseif (isset($_GET["nameAntigen"])){
            	echo "<th>Antigen Name</th><th>Antigen Id</th>";
            }
            else {
            	echo "	<th>Epitope Id</th>
            			<th>Sequence</th>
            			<th>HLA</th>
            			<th>log</th>
            			<th>nM</th>
            			<th>Link</th>";
            }
            ?>
            </tr>
        </thead>
			<?php foreach ($nameTable as $row){ ?>
		      	<?php if (isset($_GET["nameOrganism"])){ ?>
		      	<tr>
			      	<th scope='row' class='text-center'><?php echo $row["nameOrganism"]?> </th>
			      	<td class='text-center'>
			      		<?php $id = $row["idOrganism"];
			      			echo "<a href='organism.php?idOrganism=$id' target='_blank'>{$id}</a>";
			      		?>
			      	</td>
		      	</tr>
		      	<?php } elseif (isset($_GET["nameProtein"])){ ?>
		      	<tr>
			      	<th scope='row' class='text-center'><?php echo $row["nameProtein"]?> </th>
			      	<td class='text-center'>
			      		<?php $id = $row["idProtein"];
			      			echo "<a href='protein.php?idProtein=$id' target='_blank'>{$id}</a>"; 
			      		?>
			      	</td>
		      	</tr>
		      	<?php } elseif (isset($_GET["nameAntigen"])){ ?>
		      	<tr>
			      	<th scope='row' class='text-center'><?php echo $row["nameAntigen"]?> </th>
			      	<td class='text-center'>
			      		<?php $id = $row["idAntigen"];
			      			echo "<a href='antigen.php?idAntigen=$id' target='_blank'>{$id}</a>";
			      		?>
			      	</td>
		      	</tr>
		      	<?php } else {
		      		$json_data[] = ["idEpitope" => $row["idEpitope"],
				                    "seqEpitope" => $row["seqEpitope"],
				                    "nameHLA" => $row["nameHLA"],
				                    "logAff" => $row["logAff"],
				                    "nMAff" => $row["nMAff"], 
				                    "link" => "addindex.php?idEpitope=".$row["idEpitope"]];
				        } 
				} ?>
  	</table>
</div>

<script type="text/javascript">
      $(document).ready(function () {
        $('#nameTable').DataTable();
        document.getElementById("tabletocsv").onclick = function () {
        location.href = "tabletocsv.php";
    	};
    	var data = <?php echo json_encode($json_data); ?>;
    	console.log(data);
    	$('#affTable').DataTable( {
            data:           data,
            deferRender:    true,
            scrollY:        500,
            scrollCollapse: true,
            scroller:       true,
            columns: [
              { data: "idEpitope" , render : function ( data, type, row, meta ) {
                    return type === 'display'  ?
                    '<a href="epitope.php?idEpitope=' + data + '" target="_blank">' + data + '</a>' :
                    data;
                  }},
              { data: "seqEpitope" },
              { data: "nameHLA" },
              { data: "logAff" },
              { data: "nMAff" },
              { data: "link" , render : function ( data, type, row, meta ) {
                    return type === 'display'  ?
                    '<a class="btn btn-info btn-sm" href="' + data + '" target="_blank">' + 'Add' + '</a>' :
                    data;
                  }},
          ],
        } );
      });
</script>

<?php print footerDBW(); ?>
