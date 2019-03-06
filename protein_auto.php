<?php
include("globals.inc.php");
$sql = "SELECT idProtein, nameProtein FROM Protein WHERE nameProtein LIKE '%".$_GET['q']."%' limit 5;";
$conn = connectSQL();
$q = $conn->query($sql);
$results = array();
foreach ($q as $row) {
	$results[]= ['id'=>$row['nameProtein'], 'text'=>$row['nameProtein']];
}
echo json_encode($results);
?>