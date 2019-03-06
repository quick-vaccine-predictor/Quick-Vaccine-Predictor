<?php
include("globals.inc.php");
$coords = $_REQUEST["coords"];
$fasta = ">".$coords."\n".$_SESSION["proteosome"][$_REQUEST["frame"]][$_REQUEST["coords"]];
header("Content-type: text/plain");
header("Content-Disposition: attachment; filename=fasta_$coords.txt");
echo $fasta;

?>

