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
	if (strlen($_GET["sequenceName"]) > 0){
		$hla_arr = $_GET["hla"];
		$sql = "SELECT Affinity.idEpitope, Epitope.seqEpitope, HLA.idHLA, logAff, nMAff, nameHLA from Affinity JOIN HLA ON Affinity.idHLA = HLA.idHLA JOIN Epitope ON Epitope.idEpitope = Affinity.idEpitope WHERE seqEpitope LIKE '%".$_GET["sequenceName"]."%' AND ";
		$hla_string = "";
		foreach ($hla_arr as $hla){
			if ($hla == $hla_arr[0]){
				$hla_string .= "(HLA.idHLA ='$hla' ";
			}
			elseif ($hla == array_values(array_slice($hla_arr, -1))[0]){
				$hla_string .= "OR HLA.idHLA ='$hla');";
			}
			else{
				$hla_string .= "OR HLA.idHLA ='$hla' ";
			}
			
		}
		$sql .= $hla_string;
	}
	elseif (isset($_GET["idEpitope"])){
		$sql ="SELECT Affinity.idEpitope, Epitope.seqEpitope, HLA.idHLA, logAff, nMAff, nameHLA from Affinity JOIN HLA ON Affinity.idHLA = HLA.idHLA JOIN Epitope ON Epitope.idEpitope = Affinity.idEpitope WHERE Affinity.idEpitope=".$_GET["idEpitope"].";";
	}
}
$nameTable = $conn->query($sql);
$_SESSION["array"] = mysqli_fetch_all($nameTable);
$conn->close();
print headerDBW("Name Search");
print navbar('Epitope');
//sequenceName
?>

<div class="container">
	<div class="row">
		<a class="btn btn-primary btn-lg" href="queries.php#proteosome" role="button">Go back</a>
        <h2>Name Results</h2><br>
        <button id='tabletocsv'> Export to CSV</button><br>
        <table class="table table-striped table-sm table-responsive" id="nameTable">
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
            	echo "<th>Epitope Id</th><th>Sequence</th><th>HLA</th><th>log</th><th>nM</th>";
            }
            ?>
            </tr>
          </thead>
      		<tbody>
		      	<?php foreach ($nameTable as $row){ ?>
		      		<tr>
		      			<?php if (isset($_GET["nameOrganism"])){ ?>
		      			<th scope='row' class='text-center'><?php echo $row["nameOrganism"]?>	
		      			</th>
		      			<td class='text-center'><?php $id = $row["idOrganism"];
		      				echo "<a href='organism.php?idOrganism=$id' target='_blank'>{$id}</a>";
		      			} 
		      			elseif (isset($_GET["nameProtein"])){ ?>
		      			<th scope='row' class='text-center'><?php echo $row["nameProtein"]?>	
		      			</th>
		      			<td class='text-center'><?php $id = $row["idProtein"];
		      				echo "<a href='protein.php?idProtein=$id' target='_blank'>{$id}</a>";
		      			}
		      			elseif (isset($_GET["nameAntigen"])){ ?>
		      			<th scope='row' class='text-center'><?php echo $row["nameAntigen"]?>	
		      			</th>
		      			<td class='text-center'><?php $id = $row["idAntigen"];
		      				echo "<a href='antigen.php?idAntigen=$id' target='_blank'>{$id}</a>";
		      			}
		      			else { ?>
		      			<th scope='row' class='text-center'><?php echo $row["idEpitope"]?></th>
		      			<td class='text-center'><?php echo $row["seqEpitope"]?></td>
		      			<td class='text-center'><?php echo $row["nameHLA"]?></td>
		      			<td class='text-center'><?php echo $row["logAff"]?></td>
		      			<td class='text-center'><?php echo $row["nMAff"]?></td>
		      			<?php }  
		      			?>
		      			
		      			
		      		</tr>
		      	<?php } ?>
      		</tbody>
  		</table>
	</div>
</div>

<script type="text/javascript">
      $(document).ready(function () {
        $('#nameTable').DataTable();
        document.getElementById("tabletocsv").onclick = function () {
        location.href = "tabletocsv.php";
    };
      });
</script>

<?php print footerDBW(); ?>
