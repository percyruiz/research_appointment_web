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
   
    // If form submitted, insert values into the database.
     if (isset($_POST['name'])){

		$name = $_POST['name'];
		
		$name = stripslashes($name);
        $name = mysql_real_escape_string($name);

        $userid = $_SESSION['userid'];
		
		$queryStudentNum = "SELECT * FROM `users` WHERE user_id='$userid'";
       	$resultStudentNum = mysql_query($queryStudentNum) or die(mysql_error());
		
		
		$queryResearch = "SELECT * FROM `researches` WHERE student_no='resultStudentNum'";
		$resultResearch = mysql_query($queryResearch) or die(mysql_error());
		$rows = mysql_num_rows($resultResearch);
		if($rows == 0){
			echo "<div class='form'><h3>No existing Research.</h3><br/>Click here to <a href=http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/insert_research.php>Add Research.</a></div>";
			echo "<a href=http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/dashboard_student.php>BACK</a></div>";
		}else{
		
			$queryInsert = "INSERT into `members` (
					user_id, 
					name
					) VALUES (
					'$userid', 
					'$name')";
			$resultInsert = mysql_query($queryInsert);
			if($resultInsert){
				echo "<div class='form'><h3>You successfully added member.</h3><br/>Click here to <a href=http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/insert_members.php>Add another member.</a></div>";
				echo "<a href=http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/dashboard_student.php>BACK</a></div>";
			}else{
				echo mysql_error();
			}
		}
    }else{
?>

<div  class="container">
<h4>Add Members</h4>
<form name="registration" action="" method="post">
<input type="text" name="name" placeholder="Member name" required /> <br/><br/>
<input type="submit" name="submit" value="Register" />
</form>
<?php echo "<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/dashboard_student.php'>Back</a></div>";?>
</div>
<?php } ?>
</body>
</html>