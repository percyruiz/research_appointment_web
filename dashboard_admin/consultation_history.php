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
			<p>
				<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/index.php';?>">Home</a> |	 
				<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/consultation_history.php';?>">Consultation History</a> |
				<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/dashboard_admin.php';?>">Manage Faculty</a> |
				<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/student_profiles.php';?>">Manage Student</a> |
				<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/insert_research.php';?>">Add Research</a> |
				<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a>
			</p>

			<h4>Consultation History</h4>
			<?php
				$query = "SELECT * FROM `consultations`";
				$result = mysql_query($query) or die(mysql_error());
				echo "<table class='table' border='1' style='width:100%'>";
				echo "	 <tr>";
				echo "	 	<td align='center'>";	
				echo "	 		<strong>id</strong>";
				echo "	 	</td>";
				echo "	 	<td align='center'>";	
				echo "	 		<strong>research title</strong>";
				echo "	 	</td>";
				echo "	 	<td align='center'>";	
				echo "	 		<strong>date</strong>";
				echo "	 	</td>";
				echo "	 	<td align='center'>";	
				echo "	 		<strong>remarks</strong>";
				echo "	 	</td>";
				echo "	 	<td align='center'>";	
				echo "	 		<strong>status</strong>";
				echo "	 	</td>";
				echo "	 	<td align='center'>";	
				echo "	 		<strong>sign</strong>";
				echo "	 	</td>";
				echo "	 </tr>";
				while ($row = mysql_fetch_array($result)) {
					$research_id = $row['research_id'];
					
					$querySelectResearch = mysql_query("SELECT * FROM `researches` WHERE research_id='$research_id' LIMIT 1");
					$resultSelectResearch = mysql_fetch_assoc($querySelectResearch);
					$research_name = $resultSelectResearch['research_title'];
					$faculty_id = $resultSelectResearch['faculty_id'];
						
					echo "   <tr>";
					echo "      <td style='padding: 5px;'>";
					echo 			$row['consultation_id'];
					echo "      </td>";

					echo "      <td style='padding: 5px;'>";
					echo 			$research_name;
					echo "      </td>";

					echo "      <td style='padding: 5px;'>";
					echo 			$row['date'];
					echo "      </td>";

					echo "      <td style='padding: 5px;'>";
					echo 			$row['remarks'];
					echo "      </td>";

					echo "      <td style='padding: 5px;'>";
					echo 			$row['status'];
					echo "      </td>";

					echo "      <td style='padding: 5px;'>";
					echo 			$row['sign'];
					echo "      </td>";

					echo "   </tr>";
				}
				echo "<table>";
			?>		
		</div>
	</body>
</html>
