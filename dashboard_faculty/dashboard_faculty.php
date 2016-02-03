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
			<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a>
			<div class="container">
				<h4>Your appointments</h4>
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
						
						$querySelectAppointment = mysql_query("SELECT * FROM `appointments` WHERE appointment_id='$appointment_id' LIMIT 1");
						$resultSelectAppointment = mysql_fetch_assoc($querySelectAppointment);
						$date = $resultSelectAppointment['appoint_date'];
						$research_id = $resultSelectAppointment['research_id'];
						$faculty_id = $resultSelectAppointment['faculty_id'];
						
						$querySelectFaculty = mysql_query("SELECT * FROM `users` WHERE user_id='$faculty_id' LIMIT 1");
						$resultSelectFaculty = mysql_fetch_assoc($querySelectFaculty);
						$sign = $resultSelectFaculty['lname'] . ", " . $resultSelectFaculty['fname'] . " " . $resultSelectFaculty['mname'];
						
						if($result){
							$insertConsultation = "INSERT into `consultations` (
											date,
											research_id,
											status,
											sign
											) VALUES (
											'$date',
											'$research_id',
											'$status',
											'$sign')";
							$insertConsultation = mysql_query($insertConsultation);
						}
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
					echo "	 		<strong>DAY</strong>";
					echo "	 	</td>";
					echo "	 	<td align='center'>";	
					echo "	 		<strong>ACTION</strong>";
					echo "	 	</td>";
					echo "	 </tr>";
					while ($row = mysql_fetch_array($result)) {
						
						$research_id = $row['research_id'];

						$sched_time_id = $row['sched_time_id'];
						$result_faculty_sched_time = mysql_query("SELECT * FROM `faculty_sched_time` WHERE id='$sched_time_id' LIMIT 1");
						$faculty_sched_time = mysql_fetch_assoc($result_faculty_sched_time);
						$result_r = mysql_query("SELECT * FROM `researches` WHERE research_id='$research_id' LIMIT 1");
						$row_researches = mysql_fetch_assoc($result_r);
						$appointment_id = $row['appointment_id'];
						echo "   <tr>";
						echo "      <td width='35%' style='padding: 5px;'>";
						echo 			"<a href='research.php?id=$research_id'>" .$row_researches['research_title'] . "</a>";
						echo "      </td>";

						echo "      <td width='20%' style='padding: 5px;'>";
						echo 			$row['appoint_date'];
						echo "      </td>";

						echo "      <td width='10%' style='padding: 5px;'>";
						echo 			$faculty_sched_time['start_time'];
						echo "      </td>";

						echo "      <td width='10%' style='padding: 5px;'>";
						echo 			$faculty_sched_time['end_time'];
						echo "      </td>";

						echo "      <td width='10%' style='padding: 5px;'>";
						echo 			$faculty_sched_time['day'];
						echo "      </td>";

						echo "      <td width='15%' align='center'>";
										if($row['status']=='pending'){
											echo "	<div class='row'>
														<div class='col-md-6'>
															<form action='' method='post' name='dashboard_faculty'>
															<input type='hidden' name='appointment_id' value='$appointment_id'/> 
															<input style='color:#0000FF' type='submit' name='status' value='accept'/> 
															</form>
														</div> ";
											echo "		<div class='col-md-6'>
															<form action='resched_appointment.php' method='post' name='resched_appointment'>
																<input type='hidden' name='appointment_id' value='$appointment_id'/> 
																<input type='hidden' name='faculty_sched_time_id' value='$sched_time_id'/> 
																<input style='color:#FF0000' type='submit' name='status' value='resched'/> 
															</form>
														</div>
													</div>";
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
		</div>
	</body>
</html>

