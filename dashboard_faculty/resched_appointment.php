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
			<p>
				<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_faculty/dashboard_faculty.php';?>">Back</a> |
				<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a>
			</p>
		
			<?php $user_id = $_SESSION['userid']; ?>
			<?php 
				if(isset($_POST['appointment_id'])){ 
					$resched_appointment_id = $_POST['appointment_id'];
					$faculty_sched_time_id = $_POST['faculty_sched_time_id'];
					
					$result_appointment = mysql_query("SELECT * FROM `appointments` WHERE appointment_id='$resched_appointment_id' and sched_time_id='$faculty_sched_time_id' LIMIT 1");
					$row_appointment = mysql_fetch_assoc($result_appointment);
					$faculty_id = $row_appointment['faculty_id'];
					
					$resched_date = $row_appointment['appoint_date'];
					$resched_time = $row_appointment['sched_time_id'];
					$resched_remark = $row_appointment['remarks'];
				}
			?>
			<?php 
				if(isset($_POST['resched_appointment_id'])){ 
					$resched_appointment_id = $_POST['resched_appointment_id'];
					$resched_time = $_POST['resched_time'];
					$resched_date = $_POST['resched_date'];
					$faculty_id = $_POST['faculty_id'];
					$resched_remark = $_POST['remarks'];
					$resched_remark = "RESCHEDULED - " . $resched_remark;
					
					$result_faculty_sched_time = mysql_query("SELECT * FROM `faculty_sched_time` WHERE id='$resched_time' LIMIT 1");
					$faculty_sched_time = mysql_fetch_assoc($result_faculty_sched_time);
					$faculty_sched_time_id = $faculty_sched_time['id'];

					$datePieces = explode("-", $resched_date);
					$year = $datePieces[0];
					$month =  $datePieces[1];
					$day = $faculty_sched_time['day'];

					$timestamp = strtotime($resched_date);
					$day_calendar = date('l', $timestamp);

					$queryNotAvail = "SELECT * FROM `appointments` WHERE appoint_date='$resched_date' and sched_time_id='$faculty_sched_time_id'
										AND NOT appointment_id='$resched_appointment_id'";
					$resultNotAvail = mysql_query($queryNotAvail) or die(mysql_error());
					$rowsNotAvail = mysql_num_rows($resultNotAvail);
					if($day != $day_calendar){
						echo "Date selected is not ". $faculty_sched_time['day'];
					}else if(date("Y-m-d") > $resched_date){
						echo "Date selected is less than date today!";
					}
					else if($rowsNotAvail > 0){
						echo "Date and time schedule already registered";
					}else{
						$query = "UPDATE `appointments` SET `appoint_date`='$resched_date', `sched_time_id`='$faculty_sched_time_id', `remarks`='$resched_remark' WHERE appointment_id=$resched_appointment_id";
						$result = mysql_query($query) or die(mysql_error());
						if($result){
							echo "Update Succesful!";
							
							$querySelectAppointment = mysql_query("SELECT * FROM `appointments` WHERE appointment_id='$resched_appointment_id' LIMIT 1");
							$resultSelectAppointment = mysql_fetch_assoc($querySelectAppointment);
							$research_id = $resultSelectAppointment['research_id'];
							
							$querySelectFaculty = mysql_query("SELECT * FROM `users` WHERE user_id='$faculty_id' LIMIT 1");
							$resultSelectFaculty = mysql_fetch_assoc($querySelectFaculty);
							$sign = $resultSelectFaculty['lname'] . ", " . $resultSelectFaculty['fname'] . " " . $resultSelectFaculty['mname'];
							
							$insertConsultation = "INSERT into `consultations` (
								date,
								research_id,
								status,
								sign,
								remarks
								) VALUES (
								'$resched_date',
								'$research_id',
								'resched',
								'$sign',
								'$resched_remark')";
							$insertConsultation = mysql_query($insertConsultation);
						}
					}
				}
			?>
			
			<div class="form">
                <h4>Reschedule Appointment</h4>
                <form name="resched" action="" method="post">
                    <input value="<?php echo $resched_date?>" type="date" placeholder="YYYY-MM-DD" name="resched_date" data-date-split-input="true" required/> <br/><br/>
					<input type='hidden' name='resched_appointment_id' value='<?php echo "$resched_appointment_id"; ?>'/>
					<input type='hidden' name='faculty_id' value='<?php echo "$faculty_id"; ?>'/>
                    <select name="resched_time">
                        <?php
                            $query_sched_time = "SELECT * FROM `faculty_sched_time` WHERE user_id=$faculty_id";
                            $result_sched_time = mysql_query($query_sched_time) or die(mysql_error());
                            while ($row_sched_time = mysql_fetch_array($result_sched_time)) {
                            	$timeStart = $row_sched_time['start_time'];
								$queryTimeStart = "SELECT TIME_FORMAT('$timeStart', '%h:%i:%s %p')";
								$resultTimeStart = mysql_query($queryTimeStart) or die(mysql_error());
								$rowStartTime = mysql_fetch_row($resultTimeStart);
								
								$timeEnd = $row_sched_time['end_time'];
								$queryTimeEnd = "SELECT TIME_FORMAT('$timeEnd', '%h:%i:%s %p')";
								$resultTimeEnd = mysql_query($queryTimeEnd) or die(mysql_error());
								$rowEndTime = mysql_fetch_row($resultTimeEnd);
								
								if($row_sched_time['id'] == $resched_time){
                            		echo "<option selected value='". $row_sched_time['id'] ."'>". $rowStartTime[0] . "-" . 
                            		$rowEndTime[0] . " @ " . $row_sched_time['day'] ."</option>";
                            	}else{
                                	echo "<option value='". $row_sched_time['id'] ."'>". $rowStartTime[0] . "-" . 
                                	$rowEndTime[0] . " @ " . $row_sched_time['day'] ."</option>";
                            	}
                            }
                        ?>
                    </select><br/><br/>
					<textarea name='remarks' rows="4" cols="30"><?php echo substr($resched_remark, 14, strlen($resched_remark)-1);?></textarea>
					<br/><br/>
                    <input type="submit" name="submit" value="Update" />
                </form>
            </div>
		</div>
	</body>
</html>
