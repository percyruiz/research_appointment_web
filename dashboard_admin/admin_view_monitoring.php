<?php 
//require('db.php');
	$path = $_SERVER['DOCUMENT_ROOT'];
	$path .= "/db.php";
	require($path);
include("auth.php");
?>
<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<title>Dashboard Admin</title>
		<link rel="stylesheet" href="../css/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="../css/bootstrap/css/jquery.dynatable.css" />
		<script src="../js/jquery-1.12.0.min.js"></script>
		<script src="../js/jquery.dynatable.js"></script>
		<script>
			$( document ).ready(function() {
				$('.table').dynatable();
			});
		</script>
	</head>
	<body>

	<?php
	// require('db.php');
	//access from root folder
	$path = $_SERVER['DOCUMENT_ROOT'];
	$path .= "/db.php";
	require($path);

		?>
			<ul class="breadcrumb">
				<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/dashboard_admin.php';?>">Manage Faculty</a></li>
				<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/consultation_history.php';?>">Consultation History</a></li>
				<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/student_profiles.php';?>">Manage Student</a></li>
				<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/insert_research.php';?>">Add Research</a></li>
				<li  class="active"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/admin_view_monitoring.php';?>">View Monitoring</a></li>
				<li> <a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a></li>
			</ul>

	<?php

	$queryMonitoring = "SELECT * FROM `consultations` WHERE status='done'";
	$resultMonitoring = mysql_query($queryMonitoring) or die(mysql_error());

	if($resultMonitoring){
	echo "<div class='form'><h4>GROUP PROJECT MONITORING</h4><br/>";
		echo "<table class='table table-striped table-hover' style='width:100%'>";
			echo "	 <thead>";
			echo "   <tr>";
				echo "      <th>";
					echo "          <strong>DATE</strong>";
					echo "      </th>";
				echo "      <th>";
					echo "          <strong>REMARKS</strong>";
					echo "      </th>";
				echo "      <th>";
					echo "          <strong>PROJECT PERCENTAGE</strong>";
					echo "      </th>";
				echo "      <td align='center'>";
					echo "          <strong>RESEARCH TITLE</strong>";
					echo "      </td>";
				echo "      <th>";
					echo "          <strong>ADVISER</strong>";
					echo "      </th>";
				echo "   </tr>";
			echo "	 </thead>";
			echo "	 <tbody>";
			while ($rowMonitoring = mysql_fetch_array($resultMonitoring))
			{

			echo "   <tr>";
				echo "      <td align='center'>";
					echo           $rowMonitoring['date'];
					echo "      </td>";
				echo "      <td align='center'>";
					echo            $rowMonitoring['remarks'];
					echo "      </td>";
				echo "      <td align='center'>";
					echo            $rowMonitoring['status'];
					echo "      </td>";

				$researchId = $resultMonitoring['research_id'];
				$querySelect = "SELECT * FROM `researches` WHERE  research_id = '$researchId'";
				$result = mysql_query($querySelect) or die(mysql_error());

				$researchTitle = "";
				while ($row = mysql_fetch_array($result)) {
					$researchTitle = $row['research_title'];
				}

				echo "      <td align='center'>";
					echo            $researchTitle;
					echo "      </td>";

				$facultyId = $row['faculty_id'];


				$queryFaculty = "SELECT * FROM `users` WHERE faculty_id='$facultyId'";
				$resultFaculty = mysql_query($queryFaculty) or die(mysql_error());

				while ($rowFaculty = mysql_fetch_array($resultFaculty))
				{
				$faculty = $rowFaculty['fname']." ".$rowFaculty['mname']." ".$rowFaculty['lname'];
				}

				echo "      <td align='center'>";
					echo            $faculty;
					echo "      </td>";
				echo "   </tr>";
			}
			echo "</tbody>";
			echo "</table>";
		}else{
		echo mysql_error();
		}
	?>
	</body>
</html>
