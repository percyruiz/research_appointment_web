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
			<h4>Welcome to Faculty Dashboard.</h4>
			<?php $user_id = $_SESSION['userid']; ?>
			<?php 
				if(isset($_POST['status'])){ 
					if($_POST['status'] == 'accept'){
						$status = $_POST['status'];	
					}else{
						$status = "pending";
					}
					
					$appointment_id = $_POST['appointment_id'];
					$query = "UPDATE `appointments` SET `status`='$status' WHERE appointment_id=$appointment_id";
					$result = mysql_query($query) or die(mysql_error());
				}
			?>

			<?php
				$query = "SELECT * FROM `appointments` WHERE faculty_id='$user_id'";
				$result = mysql_query($query) or die(mysql_error());
				echo "<table class='table' border='1' style='width:100%'>";
				echo "	 <tr>";
				echo "	 	<td align='center'>";	
				echo "	 		<strong>TITLE</strong>";
				echo "	 	</td>";
				echo "	 	<td align='center'>";	
				echo "	 		<strong>DATE</strong>";
				echo "	 	</td>";
				echo "	 	<td align='center'>";	
				echo "	 		<strong>START</strong>";
				echo "	 	</td>";
				echo "	 	<td align='center'>";	
				echo "	 		<strong>END</strong>";
				echo "	 	</td>";
				echo "	 	<td align='center'>";	
				echo "	 		<strong>ACTION</strong>";
				echo "	 	</td>";
				echo "	 </tr>";
				while ($row = mysql_fetch_array($result)) {
					
					$research_id = $row['research_id'];
						
					$result_r = mysql_query("SELECT * FROM `researches` WHERE research_id='$research_id' LIMIT 1");
					$row_researches = mysql_fetch_assoc($result_r);
					$appointment_id = $row['appointment_id'];
					echo "   <tr>";
					echo "      <td style='padding: 5px;'>";
					echo 			"<a href='research.php?id=$research_id'>" .$row_researches['research_title'] . "</a>";
					echo "      </td>";

					echo "      <td style='padding: 5px;'>";
					echo 			$row['appoint_date'];
					echo "      </td>";

					echo "      <td style='padding: 5px;'>";
					echo 			$row['appoint_time_fr'];
					echo "      </td>";

					echo "      <td style='padding: 5px;'>";
					echo 			$row['appoint_time_to'];
					echo "      </td>";

					echo "      <td align='center'>";
									if($row['status']=='pending'){
										echo "	<form action='' method='post' name='dashboard_faculty'>
													<input type='hidden' name='appointment_id' value='$appointment_id'/> 
													<input style='color:#0000FF' type='submit' name='status' value='accept'/> 
												</form> ";
									}else{
										echo "	<form action='' method='post' name='dashboard_faculty'>
													<input type='hidden' name='appointment_id' value='$appointment_id'/> 
													<input style='color:#FF0000' type='submit' name='status' value='remove'/> 
												</form> ";
									}
					echo "      </td>";
					echo "   </tr>";
				}
				echo "<table>";
			?>
		</div>
	
	<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a>
	</body>
</html>
