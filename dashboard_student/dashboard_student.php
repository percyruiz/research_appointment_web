<?php
/*
Author: Javed Ur Rehman
Website: https://htmlcssphptutorial.wordpress.com
*/
?>

<?php 
session_start();
	//require('db.php');
	//access from root folder
	$path = $_SERVER['DOCUMENT_ROOT'];
	$path .= "/db.php";
	require($path);
include("auth.php"); //include auth.php file on all secure pages 
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Dashboard - View Records</title>
</head>
<body>
	<div class="form">
		<p>Welcome to Student Dashboard.</p>
		<p><a href="insert_research.php">Register Research</a></p>
		<p><a href="view_research.php">View Research</a></p>
		<p><a href="insert_appointment.php">Manage Appointment</a><p>
		<p><a href="insert_members.php">Insert Members</a><p>
		<p><a href="view_members.php">View Members</a><p>
		<p><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a></p>
	</div>
</body>
</html>
