<?php

//Insert your database details here
$servername = "";
$username = "";
$password = "";
$dbname = "";

$token = $_GET['token'];

$conn = mysql_connect($servername, $username, $password);
if (!$conn)
{
    die('Could not connect: ' . mysql_error());
}
$con_result = mysql_select_db($dbname, $conn);
if(!$con_result)
{
	die('Could not connect to specific database: ' . mysql_error());	
}

        $sql = "INSERT INTO `iosfinal` (`id`, `token`) VALUES (' ', '$token')";
	$result = mysql_query($sql);
	if (!$result) {
		die('Invalid query: ' . mysql_error());
	}
	echo "<h1>THE DATA HAS BEEN SENT.</h1>";
	mysql_close($conn);
?>