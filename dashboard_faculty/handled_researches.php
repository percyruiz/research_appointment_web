<?php
/*
Author: Javed Ur Rehman
Website: https://htmlcssphptutorial.wordpress.com
*/
?>

<?php
//access from root folder
session_start();
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
	<link rel="stylesheet" href="../css/bootstrap/css/bootstrap.css" />
</head>

<body>
<div class="container">

	<ul class="breadcrumb">
		<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_faculty/dashboard_faculty.php';?>">Appointments</a></li>
		<li class="active"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_faculty/handled_researches.php';?>">View Researches Handled</a></li>
		<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/change_password_form.php';?>">Change Password</a></li>
		<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout </a></li>
	</ul>

	<div class="container">
		<h4>Your Advisory Research</h4>
		<?php $user_id = $_SESSION['userid'];

		$query = "SELECT * FROM `researches` WHERE faculty_id='$user_id' ORDER BY `research_title` ASC ";
		$result = mysql_query($query) or die(mysql_error());
		echo "<table class='table table-striped table-hover' style='width:100%'>";
		echo "	 <thead>";
		echo "	 <tr>";
		echo "	 	<th>";
		echo "	 		<strong>TITLE</strong>";
		echo "	 	</th>";
		echo "	 	<th>";
		echo "	 		<strong>RESEARCH TYPE</strong>";
		echo "	 	</th>";
		echo "	 	<th>";
		echo "	 		<strong>SCHOOL YEAR/SEM</strong>";
		echo "	 	</th>";
		echo "	 	<th>";
		echo "	 		<strong>GROUP LEADER</strong>";
		echo "	 	</th>";
		echo "	 </tr>";
		echo "	 </thead>";
		echo "	 <tbody>";
		while ($row = mysql_fetch_array($result)) {

			$research_id = $row['research_id'];
			echo "   <tr>";
			echo "      <td width='30%' style='padding: 5px;'>";
			echo 			"<a href='research.php?id=$research_id'>" .$row['research_title'] . "</a>";
			echo "      </td>";

			echo "      <td width='20%' style='padding: 5px;'>";
			echo 			$row['research_type'];
			echo "      </td>";

			echo "      <td width='10%' style='padding: 5px;'>";
			echo 			$row['school_year'] . "/<br/>" .$row['sem_type'];
			echo "      </td>";

			echo "      <td width='5%' style='padding: 5px;'>";
			$student_no = $row['student_no'];
			$result_student = mysql_query("SELECT * FROM `users` WHERE student_no='$student_no' LIMIT 1");
			$row_student = mysql_fetch_assoc($result_student);
			echo 			$row_student['lname']. ", ". $row_student['fname'] . " " . $row_student['mname'];
			echo "      </td>";
			echo "   </tr>";
		}
		echo "</tbody>";
		echo "</table>";
		?>
	</div>
</div>
</body>
</html>

