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
	require($path);?>

<div  class="container">

	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">ADMIN</a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li class="active"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/dashboard_admin.php';?>">Manage Faculty</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/consultation_history.php';?>">Consultation History</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/student_profiles.php';?>">Manage Student</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/insert_research.php';?>">Add Research</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/view_researches.php';?>">View Monitoring</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/view_groups.php';?>">View Groups</a></li>
					<li> <a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a></li>
				</ul>
			</div>
		</div>
	</nav>

<?php
   
	$userid = $_SESSION['StudentUserid'];
	$queryStudentNum = "SELECT * FROM `users` WHERE user_id='$userid'";
    $resultStudentNum = mysql_query($queryStudentNum) or die(mysql_error());
    $rows = mysql_num_rows($resultStudentNum);
    		
    while ($row = mysql_fetch_array($resultStudentNum)) 
    {
    	$student_no = $row['student_no'];  
    }

    // If form submitted, insert values into the database.
    if (isset($_POST['name'])){

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

	<h4>Add Members</h4>
	<form class="form-horizontal" name="registration" action="" method="post">
	<input class="form-control" type="text" name="name" placeholder="Member name" required /> <br/>
	<input class="btn btn-primary" type="submit" name="submit" value="Register" />
	</form>
</div>
</body>
</html>