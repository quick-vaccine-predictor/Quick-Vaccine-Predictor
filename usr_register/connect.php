<!-- This script is to create the connection with MySQL and the Database    -->
<?php
$dbhost = 'localhost';
$dbuser = 'altairch95';
$dbpass = 'Minimicro21.';
$dbname = 'qvvp';

// Create connection

$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

// Check connection

	if(!$conn){
		die("Database Connection Failed" . mysqli_error($conn));
	}
// Select Database when connected

$select_db = mysqli_select_db($conn, $dbname);

	if(!$select_db){
		die("Database Selection Failed" . mysqli_error($conn));
	} 

?>