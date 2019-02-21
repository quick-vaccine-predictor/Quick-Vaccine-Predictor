<!-- This script is to Create the Table of User   -->
<?php

$servername = "localhost";
$username = "altairch95";
$dbname = "qvvp";
$password = "Minimicro21.";


// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if(!$conn){
	die("Database Connection Failed" . mysqli_error($connection));
}

// sql to create table
$sql = "CREATE TABLE User (
		id_user INT NOT NULL PRIMARY KEY AUTO_INCREMENT , 
		mail_user VARCHAR(60) NOT NULL UNIQUE, 
		password VARCHAR(255) NOT NULL UNIQUE
		)";
		
// Check of tabel have been created
if ($conn->query($sql) === TRUE) {
    echo "Table User created successfully\n";
} else {
    echo "Error creating table: " . mysqli_error($conn),"\n";
}

mysqli_close($conn);

?>
