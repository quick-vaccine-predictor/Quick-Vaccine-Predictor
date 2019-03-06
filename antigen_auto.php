<?php
include("globals.inc.php");
$sql = "SELECT idAntigen, nameAntigen FROM Antigen WHERE nameAntigen LIKE '%".$_GET['q']."%' limit 5;";
$conn = connectSQL();
$q = $conn->query($sql);
$results = array();
foreach ($q as $row) {
	$results[]= ['id'=>$row['nameAntigen'], 'text'=>$row['nameAntigen']];
}
echo json_encode($results);
?>