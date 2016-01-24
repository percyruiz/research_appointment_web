<?php
/*
Author: Javed Ur Rehman
Website: https://htmlcssphptutorial.wordpress.com
*/
?>

<?php
	session_start();
	include("auth.php"); //include auth.php file on all secure pages 
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Welcome Home</title>
</head>
<body>
<div class="form">
<p>Welcome <?php echo $_SESSION['username']; ?>!</p>
<p>USER TYPE: <?php echo $_SESSION['usertype']; ?></p>

	<?php if (strcmp($_SESSION['usertype'],"STUDENT")==0){?>
		<p><a href="/dashboard_student/dashboard_student.php">Student Dashboard</a></p>
	<?php } else if (strcmp($_SESSION['usertype'],"FACULTY")==0){?>
		<p><a href="/dashboard_faculty/dashboard_faculty.php">Faculty Dashboard</a></p>
	<?php }?>
<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a>
</div>
</body>
</html>
