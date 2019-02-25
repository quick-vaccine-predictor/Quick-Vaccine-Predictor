<?php
session_start();
include("globals.inc.php");
$array = $_SESSION["array"];
download_send_headers("data_export_" . date("Y-m-d") . ".csv");
echo array2csv($array);
die();
?>