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
elseif (isset($_POST["sequenceName"])) {
	$sql = "";
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
            	echo "<th>Organism Name</th><br><th>Organism Id</th>";
            }
            elseif (isset($_GET["nameProtein"])){
            	echo "<th>Protein Name</th><br><th>Protein Id</th>";
            }
            elseif (isset($_GET["nameAntigen"])){
            	echo "<th>Antigen Name</th><br><th>Antigen Id</th>";
            }
            elseif (isset($_POST["sequenceName"])){
            	echo "<th>Epitope Id</th><br><th>Sequence</th><br><th>HLA</th><br><th>log</th><br><th>nM</th><br>";
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
		      			} ?>
		      			</td>
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
