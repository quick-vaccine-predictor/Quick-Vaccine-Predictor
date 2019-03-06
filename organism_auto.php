<?php
include("globals.inc.php");
$sql = "SELECT idOrganism, nameOrganism FROM Organism WHERE nameOrganism LIKE '%".$_GET['q']."%' limit 5;";
$conn = connectSQL();
$q = $conn->query($sql);
$results = array();
foreach ($q as $row) {
	$results[]= ['id'=>$row['nameOrganism'], 'text'=>$row['nameOrganism']];
}
echo json_encode($results);
?>