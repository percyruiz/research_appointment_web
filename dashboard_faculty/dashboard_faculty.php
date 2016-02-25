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
					echo "	 		<strong>TYPE</strong>";
					echo "	 	</th>";
					echo "	 	<th>";
					echo "	 		<strong>DATE REQUEST FILED</strong>";
					echo "	 	</th>";
					echo "	 	<th>";
					echo "	 		<strong>ACTION</strong>";
					echo "	 	</th>";
					echo "	 </tr>";
					echo "	 </thead>";
					echo "	 <tbody>";

					$to_pdf = '';
					$to_pdf = $to_pdf . "<table class='table table-striped table-hover' style='width:100%'>";
					$to_pdf = $to_pdf . "	 <thead>";
					$to_pdf = $to_pdf . "	 <tr>";
					$to_pdf = $to_pdf . "	 	<th>";
					$to_pdf = $to_pdf . "	 		<strong>TITLE</strong>";
					$to_pdf = $to_pdf . "	 	</th>";
					$to_pdf = $to_pdf . "	 	<th>";
					$to_pdf = $to_pdf . "	 		<strong>DATE</strong>";
					$to_pdf = $to_pdf . "	 	</th>";
					$to_pdf = $to_pdf . "	 	<th>";
					$to_pdf = $to_pdf . "	 		<strong>START</strong>";
					$to_pdf = $to_pdf . "	 	</th>";
					$to_pdf = $to_pdf . "	 	<th>";
					$to_pdf = $to_pdf . "	 		<strong>END</strong>";
					$to_pdf = $to_pdf . "	 	</th>";
					$to_pdf = $to_pdf . "	 	<th>";
					$to_pdf = $to_pdf . "	 		<strong>TYPE</strong>";
					$to_pdf = $to_pdf . "	 	</th>";
					$to_pdf = $to_pdf . "	 </tr>";
					$to_pdf = $to_pdf . "	 </thead>";
					$to_pdf = $to_pdf . "	 <tbody>";
					while ($row = mysql_fetch_array($result)) {
						
						$research_code = $row['research_code'];

						$result_r = mysql_query("SELECT * FROM `researches` WHERE research_code='$research_code' LIMIT 1");
						$row_researches = mysql_fetch_assoc($result_r);
						$appointment_id = $row['appointment_id'];
						echo "   <tr>";
						$to_pdf = $to_pdf . "   <tr>";
						echo "      <td width='30%' style='padding: 5px;'>";
						echo 			"<a href='research.php?id=$research_code'>" .$row_researches['research_title'] . "</a>";
						echo "      </td>";
						$to_pdf = $to_pdf . "      <td width='30%' style='padding: 5px;'>";
						$to_pdf = $to_pdf . 			$row_researches['research_title'];
						$to_pdf = $to_pdf . "      </td>";

						echo "      <td width='15%' style='padding: 5px;'>";
						echo 			$row['appoint_date'];
						echo "      </td>";
						$to_pdf = $to_pdf . "      <td width='15%' style='padding: 5px;'>";
						$to_pdf = $to_pdf . 			$row['appoint_date'];
						$to_pdf = $to_pdf . "      </td>";

						echo "      <td width='10%' style='padding: 5px;'>";
						$to_pdf = $to_pdf . "      <td width='10%' style='padding: 5px;'>";
						$timeStart=$row['appoint_time_fr'];
						$queryTimeStart = "SELECT TIME_FORMAT('$timeStart', '%h:%i:%s %p')";
						$resultTimeStart = mysql_query($queryTimeStart) or die(mysql_error());
						$rowStartTime = mysql_fetch_row($resultTimeStart);
						echo 		$rowStartTime[0];
						echo "      </td>";
						$to_pdf = $to_pdf . 		$rowStartTime[0];
						$to_pdf = $to_pdf . "      </td>";

						echo "      <td width='10%' style='padding: 5px;'>";
						$to_pdf = $to_pdf . "      <td width='10%' style='padding: 5px;'>";
						$timeEnd = $row['appoint_time_to'];
						$queryTimeEnd = "SELECT TIME_FORMAT('$timeEnd', '%h:%i:%s %p')";
						$resultTimeEnd = mysql_query($queryTimeEnd) or die(mysql_error());
						$rowEndTime = mysql_fetch_row($resultTimeEnd);
						echo 		$rowEndTime[0];
						echo "      </td>";
						$to_pdf = $to_pdf . 		$rowEndTime[0];
						$to_pdf = $to_pdf . "      </td>";

						echo "      <td width='5%' style='padding: 5px;'>";
						$to_pdf = $to_pdf . "      <td width='5%' style='padding: 5px;'>";
						$queryPanel = mysql_query("SELECT * FROM `panels` WHERE research_code='$research_code' AND faculty_id='$faculty_id' LIMIT 1");
						$resultQueryPanel = mysql_fetch_assoc($queryPanel);
						if($resultQueryPanel){
							echo 			"panel";
							$to_pdf = $to_pdf . 			"panel";
						}else{
							echo 			"advisee";
							$to_pdf = $to_pdf . 			"advisee";
						}
						echo "      </td>";
						$to_pdf = $to_pdf . "      </td>";

						echo "      <td width='15%' style='padding: 5px;'>";
						echo 			$row['timestamp'];
						echo "      </td>";

						echo "      <td width='20%' align='center'>";
										if($row['status']=='pending'){
											echo "	<div class='row'>
														<div class='col-md-6'>
															<form action='' method='post' name='dashboard_faculty'>";
															date_default_timezone_set("Asia/Singapore");
															$d=strtotime($row['appoint_date']);
															echo date("his"). "</br>";

															$timeStartExp=$row['appoint_time_fr'];
															$queryTimeStartExp = "SELECT TIME_FORMAT('$timeStartExp', '%T')";

															$resultTimeStartExp = mysql_query($queryTimeStartExp) or die(mysql_error());
															$rowStartTimeExp = mysql_fetch_row($resultTimeStartExp);
															$timeStartToCompare = preg_replace("/[^A-Za-z0-9]/", "", $rowStartTimeExp[0]);

															$requestedDateTime = date("Ymd", $d). "" .$timeStartToCompare;
															$rightNow = date("Ymd"). "" .date("his");

															if($requestedDateTime > $rightNow){
																echo "<input type = 'hidden' name = 'appointment_id' value = '$appointment_id' />
																<input class=\"btn btn-primary\" style='color:#0000FF' type='submit' name='status' value='accepted'/>";
															}
															else {
																echo "Requested Date already past";
															}

											echo "				</form>
														</div> ";
											echo "		<div class='col-md-6'>
															<form action='resched_appointment.php' method='post' name='resched_appointment'>
																<input type='hidden' name='appointment_id' value='$appointment_id'/>
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
						$to_pdf = $to_pdf . "      </td>";
						$to_pdf = $to_pdf . "   </tr>";
					}
					echo "</tbody>";
					echo "</table>";
					$to_pdf = $to_pdf . "</tbody>";
					$to_pdf = $to_pdf . "</table>";
				?>
				<form class="form-horizontal" name="to_pdf" action="../to_pdf.php" method="post">
					<input type="hidden" name="to_pdf" value="<?php echo '<br/><br/>Appointments <br/><br/>' . $to_pdf?>"/>
					<input class="btn btn-primary" type="submit" name="submit" value="Generate PDF" /><br/><br/>
				</form>
			</div>
		</div>
	</body>
</html>

