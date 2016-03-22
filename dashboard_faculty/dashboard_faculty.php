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
	date_default_timezone_set("Asia/Singapore");
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

			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="#">FACULTY</a>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
                            <li class="active"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_faculty/dashboard_faculty.php';?>"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Appointments</a></li>
                            <li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_faculty/handled_researches.php';?>"> <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> View Researches Handled</a></li>
                            <li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_faculty/faculty_schedule.php';?>"> <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Manage Schedule</a></li>
                            <li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/change_password_form.php';?>"> <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Change Password</a></li>
                            <li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>"> <span class="glyphicon glyphicon-off" aria-hidden="true"></span> Logout </a></li>
						</ul>
					</div>
				</div>
			</nav>

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
						if($_POST['status'] == 'accepted'){
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

				<form class="form" name="filter" action="" method="post">
					<select class="form-control-static" name="month1">
						<option value="None">Select</option>
						<option value="Jan">January</option>
						<option value="Feb">February</option>
						<option value="Mar">March</option>
						<option value="Apr">April</option>
						<option value="May">May</option>
						<option value="Jun">June</option>
						<option value="Jul">July</option>
						<option value="Aug">August</option>
						<option value="Sep">September</option>
						<option value="Oct">October</option>
						<option value="Nov">November</option>
						<option value="Dec">December</option>
					</select>
					<input placeholder="day"  class="form-control-static small" style="width:70px" type="number" name="day1"/>
					<input placeholder="year" class="form-control-static small" style="width:70px" type="number" name="year1"/> to <br>
					<select class="form-control-static" name="month2">
						<option value="None">Select</option>
						<option value="Jan">January</option>
						<option value="Feb">February</option>
						<option value="Mar">March</option>
						<option value="Apr">April</option>
						<option value="May">May</option>
						<option value="Jun">June</option>
						<option value="Jul">July</option>
						<option value="Aug">August</option>
						<option value="Sep">September</option>
						<option value="Oct">October</option>
						<option value="Nov">November</option>
						<option value="Dec">December</option>
					</select>
					<input placeholder="day"  class="form-control-static small" style="width:70px" type="number" name="day2"/>
					<input placeholder="year" class="form-control-static small" style="width:70px" type="number" name="year2"/><br/>
					<input class="btn btn-default" type="submit" name="submit" value="Filter" /><br/><br/>
				</form>

				<?php

					if(isset($_POST['month1'])){
						$hasFilter = true;
						$month1 = $_POST['month1'];
						$month2 = $_POST['month2'];
						$day1 = $_POST['day1'];
						$day2 = $_POST['day2'];
						$year1 = $_POST['year1'];
						$year2 = $_POST['year2'];
						$date1 = strtotime($month1. " ".$day1. " " .$year1);
						$date2 = strtotime($month2. " ".$day2. " " .$year2);
						echo "<strong> FILTERED: ". $month1 . " " . $day1 . " " . $year1 . " - " . $month2 . " " . $day2 . " " . $year2 . "</strong><br/><br/>";
                        if($date1=="" || $date2==""){
                            $hasFilter = false;
                        }
					}else {
						$hasFilter = false;
					}

					$queryAllAppointments = "SELECT * from `appointments` ORDER BY `appointment_id` DESC";
					$resultAllAppontments = mysql_query($queryAllAppointments) or die(mysql_error());

					$rightNow = date("Ymd");

					while ($rowAllAppointments = mysql_fetch_array($resultAllAppontments)) {
						$requestedDate = date("Ymd", strtotime($rowAllAppointments['appoint_date']));
						if($rightNow > $requestedDate){
							if($rowAllAppointments['status'] == 'accepted' || $rowAllAppointments['status'] == 'rescheduled'){
								$status = 'done';
								$appointment_id = $rowAllAppointments['appointment_id'];
								$queryUpdateAppointments = "UPDATE `appointments` SET `status`='$status' WHERE appointment_id=$appointment_id";
								$result = mysql_query($queryUpdateAppointments) or die(mysql_error());
							}else if ($rowAllAppointments['status'] == 'pending'){
								$status = 'expired';

								$appointment_id = $rowAllAppointments['appointment_id'];
								$queryUpdateAppointments = "UPDATE `appointments` SET `status`='$status' WHERE appointment_id=$appointment_id";
								$result = mysql_query($queryUpdateAppointments) or die(mysql_error());
							}
						}
					}

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
                    echo "	 		<strong>PERCENTAGE</strong>";
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
                    $to_pdf = $to_pdf .	"       <th>";
                    $to_pdf = $to_pdf .	"           <strong>DATE REQUEST FILED</strong>";
                    $to_pdf = $to_pdf .	"       </th>";
                    $to_pdf = $to_pdf .	"       <th>";
                    $to_pdf = $to_pdf .	"           <strong>PERCENTAGE</strong>";
                    $to_pdf = $to_pdf .	"       </th>";
					$to_pdf = $to_pdf . "	 </tr>";
					$to_pdf = $to_pdf . "	 </thead>";
					$to_pdf = $to_pdf . "	 <tbody>";
					while ($row = mysql_fetch_array($result)) {
						$dateNow = strtotime($row['appoint_date']);
						if (!$hasFilter || ($hasFilter &&  $date2 >= $dateNow && $date1 <= $dateNow)) {
							$research_code = $row['research_code'];

							$result_r = mysql_query("SELECT * FROM `researches` WHERE research_code='$research_code' LIMIT 1");
							$row_researches = mysql_fetch_assoc($result_r);
							$appointment_id = $row['appointment_id'];
							echo "   <tr>";
							$to_pdf = $to_pdf . "   <tr>";
							echo "      <td width='30%' style='padding: 5px;'>";
							if ($row['status'] == 'done') {
								echo $row_researches['research_title'];
							} else {
								echo "<a href='research.php?id=$appointment_id'>" . $row_researches['research_title'] . "</a>";
							}
							echo "      </td>";
							$to_pdf = $to_pdf . "      <td width='30%' style='padding: 5px;'>";
							$to_pdf = $to_pdf . $row_researches['research_title'];
							$to_pdf = $to_pdf . "      </td>";

							echo "      <td width='15%' style='padding: 5px;'>";
							echo $row['appoint_date'];
							echo "      </td>";
							$to_pdf = $to_pdf . "      <td width='15%' style='padding: 5px;'>";
							$to_pdf = $to_pdf . $row['appoint_date'];
							$to_pdf = $to_pdf . "      </td>";

							echo "      <td width='10%' style='padding: 5px;'>";
							$to_pdf = $to_pdf . "      <td width='10%' style='padding: 5px;'>";
							$timeStart = $row['appoint_time_fr'];
							$queryTimeStart = "SELECT TIME_FORMAT('$timeStart', '%h:%i:%s %p')";
							$resultTimeStart = mysql_query($queryTimeStart) or die(mysql_error());
							$rowStartTime = mysql_fetch_row($resultTimeStart);
							echo $rowStartTime[0];
							echo "      </td>";
							$to_pdf = $to_pdf . $rowStartTime[0];
							$to_pdf = $to_pdf . "      </td>";

							echo "      <td width='10%' style='padding: 5px;'>";
							$to_pdf = $to_pdf . "      <td width='10%' style='padding: 5px;'>";
							$timeEnd = $row['appoint_time_to'];
							$queryTimeEnd = "SELECT TIME_FORMAT('$timeEnd', '%h:%i:%s %p')";
							$resultTimeEnd = mysql_query($queryTimeEnd) or die(mysql_error());
							$rowEndTime = mysql_fetch_row($resultTimeEnd);
							echo $rowEndTime[0];
							echo "      </td>";
							$to_pdf = $to_pdf . $rowEndTime[0];
							$to_pdf = $to_pdf . "      </td>";

							echo "      <td width='5%' style='padding: 5px;'>";
							$to_pdf = $to_pdf . "      <td width='5%' style='padding: 5px;'>";
							$queryPanel = mysql_query("SELECT * FROM `panels` WHERE research_code='$research_code' AND faculty_id='$faculty_id' LIMIT 1");
							$resultQueryPanel = mysql_fetch_assoc($queryPanel);
							if ($resultQueryPanel) {
								echo "panel";
								$to_pdf = $to_pdf . "panel";
							} else {
								echo "advisee";
								$to_pdf = $to_pdf . "advisee";
							}
							echo "      </td>";
							$to_pdf = $to_pdf . "      </td>";

							echo "      <td width='10%' style='padding: 5px;'>";
							echo $row['timestamp'];
							echo "      </td>";

							$to_pdf = $to_pdf . "      <td width='15%' style='padding: 5px;'>";
							$to_pdf = $to_pdf . $row['timestamp'];
							$to_pdf = $to_pdf . "      </td>";

							echo "      <td width='5%' style='padding: 5px;'>";
							echo $row['percentage'] . "%";
							echo "      </td>";

							$to_pdf = $to_pdf . "      <td width='15%' style='padding: 5px;'>";
							$to_pdf = $to_pdf . $row['percentage'] . "%";
							$to_pdf = $to_pdf . "      </td>";

							echo "      <td width='20%' align='center'>";
							if ($row['status'] == 'pending') {
								echo "	<div class='row'>
														<div class='col-md-6'>
															<form action='' method='post' name='dashboard_faculty'>";

								$d = strtotime($row['appoint_date']);

								$timeStartExp = $row['appoint_time_fr'];
								$queryTimeStartExp = "SELECT TIME_FORMAT('$timeStartExp', '%T')";

								$resultTimeStartExp = mysql_query($queryTimeStartExp) or die(mysql_error());
								$rowStartTimeExp = mysql_fetch_row($resultTimeStartExp);
								$timeStartToCompare = preg_replace("/[^A-Za-z0-9]/", "", $rowStartTimeExp[0]);

								$requestedDateTime = date("Ymd", $d) . "" . $timeStartToCompare;
								$rightNow = date("Ymd") . "" . date("his");

								if ($requestedDateTime > $rightNow) {
									echo "<input type = 'hidden' name = 'appointment_id' value = '$appointment_id' />
																<input class=\"btn btn-default\" style='color:#0000FF' type='submit' name='status' value='accepted'/>";
								} else {
									echo "Requested Date already past";
								}

								echo "				</form>
														</div> ";
								echo "		<div class='col-md-6'>
															<form action='resched_appointment.php' method='post' name='resched_appointment'>
																<input type='hidden' name='appointment_id' value='$appointment_id'/>
																<input class=\"btn btn-default\" style='color:#FF0000' type='submit' name='status' value='resched'/>
															</form>
														</div>
													</div>";
							} else if ($row['status'] == 'done') {
								echo "Done";
							} else if ($row['status'] == 'expired') {
								echo "Requested Date already past";
							} else {
								echo "	<form  action='' method='post' name='dashboard_faculty'>
														<input type='hidden' name='appointment_id' value='$appointment_id'/> 
														<input class=\"btn btn-default\" style='color:#FF0000' type='submit' name='status' value='remove'/>
													</form> ";
							}
							echo "      </td>";
							echo "   </tr>";
							$to_pdf = $to_pdf . "      </td>";
							$to_pdf = $to_pdf . "   </tr>";
						}
					}
					echo "</tbody>";
					echo "</table>";
					$to_pdf = $to_pdf . "</tbody>";
					$to_pdf = $to_pdf . "</table>";
				?>
				<form class="form-horizontal" name="to_pdf" action="../to_pdf.php" method="post">
					<input type="hidden" name="to_pdf" value="<?php echo '<br/><br/>Appointments <br/><br/>' . $to_pdf?>"/>
					<input class="btn btn-default" type="submit" name="submit" value="Generate PDF" /><br/><br/>
				</form>
			</div>
		</div>
	</body>
</html>

