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
   
    // If form submitted, insert values into the database.
     // if (isset($_POST['research'])){

        $userid = $_SESSION['userid'];

        $queryMembers = "SELECT * FROM `members` WHERE user_id='$userid'";
       	$resultMembers = mysql_query($queryMembers) or die(mysql_error());
    	$rows = mysql_num_rows($resultMembers);
    	
		if($rows == 0){
			echo "No Members yet.<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/insert_members.php'>Add Members</a></div>";
			echo "<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/dashboard_student.php'>Back</a></div>";
		}else{

			if($resultMembers){
				echo "<div class='form'><h4>HERE ARE THE MEMBERS.</h4><br/>";
				echo "<table class='table' border='1' style='width:100%'>";
				echo "   <tr>";
				echo "      <td align='center'>";   
				echo "          <strong>Name</strong>";
				echo "      </td>";
				echo "   </tr>";
				while ($row = mysql_fetch_array($resultMembers)) 
				{
					echo "   <tr>";
					echo "      <td align='center'>";   
					echo           $row['name'];
					echo "      </td>";
					echo "   </tr>";
				}
				
				echo "<table>";
				echo "<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/dashboard_student.php'>Back</a></div>";
			}else{
				echo mysql_error();
			}
        }
    // }else{
?>
</div>
</body>
</html>