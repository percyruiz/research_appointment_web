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

	<div class="container">
	<?php
		// require('db.php');
		//access from root folder
		$path = $_SERVER['DOCUMENT_ROOT'];
		$path .= "/db.php";
		require($path);
	?>
			<ul class="breadcrumb">
				<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/dashboard_admin.php';?>">Manage Faculty</a></li>
				<li class="active"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/consultation_history.php';?>">Consultation History</a></li>
				<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/student_profiles.php';?>">Manage Student</a></li>
				<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/insert_research.php';?>">Add Research</a></li>
				<li> <a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a></li>
			</ul>

			<h4>Consultation History</h4>
			<?php
				$query = "SELECT * FROM `appointments` ORDER BY `appointment_id` DESC";
				$result = mysql_query($query) or die(mysql_error());
				echo "<table class='table table-striped table-hover' style='width:100%'>";
				echo "	 <thead>";
				echo "	 <tr>";
				echo "	 	<th align='center'>";
				echo "	 		<strong>ID</strong>";
				echo "	 	</th>";
				echo "	 	<th align='center'>";
				echo "	 		<strong>RESEARCH TITLE</strong>";
				echo "	 	</th>";
				echo "	 	<th align='center'>";
				echo "	 		<strong>FACULTY</strong>";
				echo "	 	</th>";
				echo "	 	<th align='center'>";
				echo "	 		<strong>DATE</strong>";
				echo "	 	</th>";
				echo "	 	<th align='center'>";
				echo "	 		<strong>REMARKS</strong>";
				echo "	 	</th>";
				echo "	 	<th align='center'>";
				echo "	 		<strong>STATUS</strong>";
				echo "	 	</th>";
				echo "	 </tr>";
				echo "	 </thead>";
				echo "	 <tbody>";
				while ($row = mysql_fetch_array($result)) {
					$research_id = $row['research_id'];
					
					$querySelectResearch = mysql_query("SELECT * FROM `researches` WHERE research_id='$research_id' LIMIT 1");
					$resultSelectResearch = mysql_fetch_assoc($querySelectResearch);
					$research_name = $resultSelectResearch['research_title'];
					$faculty_id = $resultSelectResearch['faculty_id'];
						
					echo "   <tr>";
					echo "      <td style='padding: 5px;'>";
					echo 			$row['appointment_id'];
					echo "      </td>";

					echo "      <td style='padding: 5px;'>";
					echo 			$research_name;
					echo "      </td>";

					echo "      <td style='padding: 5px;'>";
					$faculty = $row['faculty_id'];
					$resultSelectFaculty = mysql_query("SELECT * FROM `users` WHERE faculty_id='$faculty' LIMIT 1");
					$rowFaculty= mysql_fetch_assoc($resultSelectFaculty);

					echo 			$rowFaculty['lname'] .", ". $rowFaculty['fname']. " ". $rowFaculty['mname'] ;
					echo "      </td>";

					echo "      <td style='padding: 5px;'>";
					echo 			$row['appoint_date'];
					echo "      </td>";

					echo "      <td style='padding: 5px;'>";
					echo 			$row['status'];
					echo "      </td>";
					echo "   </tr>";
				}
				echo "</tbody>";
				echo "</table>";
			?>		
		</div>
	</body>
</html>
