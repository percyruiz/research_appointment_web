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
   
	$userid = $_SESSION['userid'];
	$queryStudentNum = "SELECT * FROM `users` WHERE user_id='$userid'";
    $resultStudentNum = mysql_query($queryStudentNum) or die(mysql_error());
    $rows = mysql_num_rows($resultStudentNum);
    		
    while ($row = mysql_fetch_array($resultStudentNum)) 
    {
    	$student_no = $row['student_no'];  
    }
		
    $querySelect = "SELECT * FROM `researches`WHERE student_no='$student_no'";
    $result = mysql_query($querySelect) or die(mysql_error());
    $rows = mysql_num_rows($result);
		
		if($rows == 0){
			echo "<div class='form'><h3>No existing Research.</h3><br/>Click here to <a href=http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/insert_research.php>Add Research.</a></div>";
			echo "<a href=http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/dashboard_student.php>BACK</a></div>";
		}
   
    // If form submitted, insert values into the database.
    else if (isset($_POST['name'])){

		$name = $_POST['name'];
		
		$name = stripslashes($name);
        $name = mysql_real_escape_string($name);
		
			$queryInsert = "INSERT into `members` (
					user_id, 
					name
					) VALUES (
					'$userid', 
					'$name')";
			$resultInsert = mysql_query($queryInsert);
			if($resultInsert){
				echo "<div class=\"alert alert-info\">Successfully added a member</div>";
			}else{
				echo mysql_error();
			}
    }
?>

<div  class="container">

	<ul class="breadcrumb">
		<li class="active"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/view_research.php';?>">Research</a></li>
		<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/choose_appointment.php';?>">Appointments</a></li>
		<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/insert_members.php';?>">Add Members</a></li>
		<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/view_members.php';?>">View Members</a></li>
		<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/change_password_form.php';?>">Change Password</a></li>
		<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a></li>
	</ul>

	<h4>Add Members</h4>
	<form class="form-horizontal" name="registration" action="" method="post">
	<input class="form-control" type="text" name="name" placeholder="Member name" required /> <br/>
	<input class="btn btn-primary" type="submit" name="submit" value="Register" />
	</form>
</div>
</body>
</html>