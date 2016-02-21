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

			<ul class="breadcrumb">
				<li class="active"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_faculty/dashboard_faculty.php';?>">Appointments</a></li>
				<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_faculty/handled_researches.php';?>">View Researches Handled</a></li>
				<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/change_password_form.php';?>">Change Password</a></li>
				<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout </a></li>
			</ul>

			<div class="container">
				<h4>Your appointments</h4>
				<?php
					$user_id = $_SESSION['userid'];
					$querySelectFaculty = mysql_query("SELECT * FROM `users` WHERE user_id='$user_id' LIMIT 1");
					$resultSelectFaculty = mysql_fetch_assoc($querySelectFaculty);
					$faculty_id = $resultSelectFaculty['faculty_id'];
				?>
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
						
						$querySelectFaculty = mysql_query("SELECT * FROM `users` WHERE faculty_id='$faculty_id' LIMIT 1");
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
					$query = "SELECT * FROM `appointments` WHERE faculty_id='$faculty_id' ORDER BY appointment_id DESC";
					$result = mysql_query($query) or die(mysql_error());
					echo "<table class='table table-striped table-hover' style='width:100%'>";
					echo "	 <thead>";
					echo "	 <tr>";
					echo "	 	<th>";
					echo "	 		<strong>TITLE</strong>";
					echo "	 	</th>";
					echo "	 	<th>";
					echo "	 		<strong>DATE</strong>";
					echo "	 	</th>";
					echo "	 	<th>";
					echo "	 		<strong>START</strong>";
					echo "	 	</th>";
					echo "	 	<th>";
					echo "	 		<strong>END</strong>";
					echo "	 	</th>";
					echo "	 	<th>";
					echo "	 		<strong>DAY</strong>";
					echo "	 	</th>";
					echo "	 	<th>";
					echo "	 		<strong>TYPE</strong>";
					echo "	 	</th>";
					echo "	 	<th>";
					echo "	 		<strong>ACTION</strong>";
					echo "	 	</th>";
					echo "	 </tr>";
					echo "	 </thead>";
					echo "	 <tbody>";
					while ($row = mysql_fetch_array($result)) {
						
						$research_code = $row['research_code'];

						$sched_time_id = $row['sched_time_id'];
						$result_faculty_sched_time = mysql_query("SELECT * FROM `faculty_sched_time` WHERE id='$sched_time_id' LIMIT 1");
						$faculty_sched_time = mysql_fetch_assoc($result_faculty_sched_time);
						$result_r = mysql_query("SELECT * FROM `researches` WHERE research_code='$research_code' LIMIT 1");
						$row_researches = mysql_fetch_assoc($result_r);
						$appointment_id = $row['appointment_id'];
						echo "   <tr>";
						echo "      <td width='30%' style='padding: 5px;'>";
						echo 			"<a href='research.php?id=$research_code'>" .$row_researches['research_title'] . "</a>";
						echo "      </td>";

						echo "      <td width='15%' style='padding: 5px;'>";
						echo 			$row['appoint_date'];
						echo "      </td>";

						echo "      <td width='10%' style='padding: 5px;'>";
						$timeStart=$faculty_sched_time['start_time'];
						$queryTimeStart = "SELECT TIME_FORMAT('$timeStart', '%h:%i:%s %p')";
						$resultTimeStart = mysql_query($queryTimeStart) or die(mysql_error());
						$rowStartTime = mysql_fetch_row($resultTimeStart);
						echo 		$rowStartTime[0];
						echo "      </td>";

						echo "      <td width='10%' style='padding: 5px;'>";
						$timeEnd = $faculty_sched_time['end_time'];
						$queryTimeEnd = "SELECT TIME_FORMAT('$timeEnd', '%h:%i:%s %p')";
						$resultTimeEnd = mysql_query($queryTimeEnd) or die(mysql_error());
						$rowEndTime = mysql_fetch_row($resultTimeEnd);
						echo 		$rowEndTime[0];
						echo "      </td>";

						echo "      <td width='10%' style='padding: 5px;'>";
						echo 			$faculty_sched_time['day'];
						echo "      </td>";

						echo "      <td width='5%' style='padding: 5px;'>";
						$queryPanel = mysql_query("SELECT * FROM `panels` WHERE research_code='$research_code' AND faculty_id='$faculty_id' LIMIT 1");
						$resultQueryPanel = mysql_fetch_assoc($queryPanel);
						if($resultQueryPanel){
							echo 			"panel";
						}else{
							echo 			"advisee";
						}
						echo "      </td>";

						echo "      <td width='20%' align='center'>";
										if($row['status']=='pending'){
											echo "	<div class='row'>
														<div class='col-md-6'>
															<form action='' method='post' name='dashboard_faculty'>
															<input type='hidden' name='appointment_id' value='$appointment_id'/> 
															<input class=\"btn btn-primary\" style='color:#0000FF' type='submit' name='status' value='accept'/>
															</form>
														</div> ";
											echo "		<div class='col-md-6'>
															<form action='resched_appointment.php' method='post' name='resched_appointment'>
																<input type='hidden' name='appointment_id' value='$appointment_id'/> 
																<input type='hidden' name='faculty_sched_time_id' value='$sched_time_id'/> 
																<input class=\"btn btn-primary\" style='color:#FF0000' type='submit' name='status' value='resched'/>
															</form>
														</div>
													</div>";
										}else{
											echo "	<form  action='' method='post' name='dashboard_faculty'>
														<input type='hidden' name='appointment_id' value='$appointment_id'/> 
														<input class=\"btn btn-primary\" style='color:#FF0000' type='submit' name='status' value='remove'/>
													</form> ";
										}
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

