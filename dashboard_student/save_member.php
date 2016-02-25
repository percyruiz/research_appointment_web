<?php
/*
Author: Javed Ur Rehman
Website: https://htmlcssphptutorial.wordpress.com
*/
?>
<?php 
session_start();
include("auth.php"); //include auth.php file on all secure pages ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Registration</title>
<link rel="stylesheet" href="../css/bootstrap/css/bootstrap.css" />
</head>
<body>


<?php
	// require('db.php');
	//access from root folder
	$path = $_SERVER['DOCUMENT_ROOT'];
	$path .= "/db.php";
	require($path);

	$membername = $_SESSION['membername'];
	$member_id = $_SESSION['member_id'];
    
	$queryUpdate = "UPDATE `members` SET name=$membername WHERE member_id = $member_id";
	$resultUpdate = mysql_query($queryUpdate) or die(mysql_error());
	
	if($resultUpdate){
		header("Location: http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/edit_delete_members.php");
	}else{
		echo mysql_error();
	}
	
	
?>
</div>
</body>
</html>