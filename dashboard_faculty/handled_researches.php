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
	<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout |</a>
	<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/change_password_form.php';?>">Change Password</a>

	<div class="container">
		<h4>Your appointments</h4>
		<?php $user_id = $_SESSION['userid'];

		$query = "SELECT * FROM `researches` WHERE faculty_id='$user_id' ORDER BY `research_title` ASC ";
		$result = mysql_query($query) or die(mysql_error());
		echo "<table class='table' border='1' style='width:100%'>";
		echo "	 <tr>";
		echo "	 	<td align='center'>";
		echo "	 		<strong>TITLE</strong>";
		echo "	 	</td>";
		echo "	 	<td align='center'>";
		echo "	 		<strong>RESEARCH TYPE</strong>";
		echo "	 	</td>";
		echo "	 	<td align='center'>";
		echo "	 		<strong>SCHOOL YEAR/SEM</strong>";
		echo "	 	</td>";
		echo "	 	<td align='center'>";
		echo "	 		<strong>GROUP LEADER</strong>";
		echo "	 	</td>";
		echo "	 </tr>";
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
		echo "<table>";
		?>
	</div>
</div>
</body>
</html>

