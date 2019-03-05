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
            	echo "<th>Epitope Id</th><th>Sequence</th><th>HLA</th><th>log</th><th>nM</th><th>Binder</th><th>Add</th>";
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
		      			<td class='text-center'><?php 
		      			$th_nM_SB = floatval($_GET["sbaff"]);
		      			$th_nM_WB = floatval($_GET["wbaff"]);
		      			$th_log_SB = floatval($_GET["sblog"]);
		      			$th_log_WB = floatval($_GET["wblog"]);
		      			if ($row["nMAff"] <= $th_nM_SB and $row["logAff"] >= $th_log_SB){
		      				echo "Strong Binder";
		      			}
		      			elseif ($row["nMAff"] <= $th_nM_WB and $row["logAff"] >= $th_log_WB) {
		      				echo "Weak Binder";
		      			}
		      			?>
						</td>
		                <td>
						<!-- Trigger the modal with a button -->
						<button type="button" class="btn" data-toggle="modal" data-target="#myModal">Add</button>
						<!-- Modal -->
						<div class="modal fade" id="myModal" role="dialog">
							<div class="modal-dialog">
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">
												idEpitope: <?php echo $_SESSION["idEpitope"];?> 
												idHLA: <?php echo $_SESSION["idHLA"];?> 
												seqEpitope: <?php echo $_SESSION["seqEpitope"];?> 
											</h4>
									</div>
									<div class="modal-body">
										<p>
										<form action="addlinker.php" method="post">
											nameVaccine: <input type="text" name="nVaccine" /><br><br>
											<input id='<?php echo $_SESSION["idEpitope"]?>' type='submit' name='addbutton' value="myVaccine">
										</form>
										<form action="addlinker.php" method="GET">
											<div class="form-group">
												<label>Insert <?php echo $_SESSION["seqEpitope"];?> into an existing vaccine:</label> <br>
												<select name="vaccine[]" size="8">
													<?php
														$conn = connectSQL();
														$idUser = $_SESSION["idUser"];
														$sql = "SELECT idVaccine, nameVaccine from Vaccine WHERE idUser = '$idUser'";
														$vaccineTable = $conn->query($sql);
														$conn->close();
														$allnameVaccine = array();
														foreach ($vaccineTable as $vaccinerow) {
															if (!in_array($vaccinerow["nameVaccine"], $allnameVaccine)) {
																array_push($allnameVaccine,$vaccinerow["nameVaccine"] );
																$nameVaccine = $vaccinerow["nameVaccine"];
													?>
													<option selected name="<?php print $nameVaccine ?>"  value="<?php print $nameVaccine ?>"><?php print $nameVaccine. "\n"?></option>																		
													<?php }               
															} ?>  
													<input id='<?php echo $nameVaccine?>' type='submit' name='namevac' value="myVaccine">
												</select>
												<br>
											</div>
										</form>
										</p>	
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<a href="addindex.php">
						<button 
						<?php 
							$_SESSION["idEpitope"] =  $row["idEpitope"]; 
							$_SESSION["idHLA"] = $row["idHLA"];
							$_SESSION["seqEpitope"] = $row["seqEpitope"];
						?>
						id='<?php echo $row["idEpitope"].'.'.$row["nameHLA"]?>' target="_blank" type='submit' name='addintobutton'>add</button></a> 
		            	</td>
		      			<?php }  ?>
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
