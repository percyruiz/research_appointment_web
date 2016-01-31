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

<div class="container">
<?php
	// require('db.php');
	//access from root folder
	$path = $_SERVER['DOCUMENT_ROOT'];
	$path .= "/db.php";
	require($path);
   
	$userid = $_SESSION['userid'];

	$queryStudentNum = "SELECT * FROM `users` WHERE user_id='$userid'";
	$resultStudentNum = mysql_query($queryStudentNum) or die(mysql_error());
    $rows = mysql_num_rows($resultStudentNum);
    		
    while ($row = mysql_fetch_array($resultStudentNum)) 
    {
    	$student_no = $row['student_no'];  
    }
	
	$queryResearchId = "SELECT * FROM researches WHERE student_no='$student_no'";
	$resultResearchId = mysql_query($queryResearchId) or die(mysql_error());
	
	while ($row = mysql_fetch_array($resultResearchId))	{
		$researchId = $row['research_id'];  
	}
	
	if($resultResearchId){
		$queryDeleteResarch = "DELETE FROM researches WHERE research_id = '$researchId'";
		$resultDeleteResarch = mysql_query($queryDeleteResarch) or die(mysql_error());
		
		if($resultDeleteResarch){
			$queryDeleteAppointment = "DELETE FROM appointments WHERE research_id = '$researchId'";
			$resultDeleteAppointment = mysql_query($queryDeleteAppointment) or die(mysql_error());
			if($resultDeleteAppointment){
				echo "<div class='form'><h3>Research has been successfully deleted.</h3><br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/dashboard_student.php'>MAIN MENU</a></div></div>";
			}else{
				echo mysql_error();
			}
		}else{
			echo mysql_error();
		}
	}
	else{
		echo mysql_error();
	}
	
	
	
?>
</div>
</body>
</html>