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

	//$membername = $_POST['membername'];
	$memberid = $_POST['memberid'];
    
	$queryDelete = "DELETE FROM members WHERE member_id = '$memberid'";
	$resultDelete = mysql_query($queryDelete) or die(mysql_error());
	
	if($resultDelete){
		header("Location: http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/edit_delete_members.php");
	}else{
		echo mysql_error();
	}
	
	
?>
</div>
</body>
</html>