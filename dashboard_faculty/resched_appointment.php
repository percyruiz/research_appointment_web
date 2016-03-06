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

			<ul class="breadcrumb">
				<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_faculty/dashboard_faculty.php';?>">Back</a></li>
				<li class="active"> <a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a></li>
			</ul>
		
			<?php $user_id = $_SESSION['userid']; ?>
			<?php 
				if(isset($_POST['appointment_id'])){ 
					$resched_appointment_id = $_POST['appointment_id'];
					
					$result_appointment = mysql_query("SELECT * FROM `appointments` WHERE appointment_id='$resched_appointment_id' LIMIT 1");
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
					$faculty_id = $_POST['faculty_id'];
					$resched_time = $_POST['time'];
					$resched_remark = $_POST['remarks'];
					$resched_remark = "RESCHEDULED - " . $resched_remark;

					$queryNotAvail = "SELECT * FROM `appointments` WHERE sched_time_id='$resched_time' AND NOT appointment_id='$resched_appointment_id'";
					$resultNotAvail = mysql_query($queryNotAvail) or die(mysql_error());
					$rowsNotAvail = mysql_num_rows($resultNotAvail);

					$resultGetAppo = mysql_query("SELECT * FROM `appointments` WHERE appointment_id='$resched_appointment_id' LIMIT 1");
					$row_appointment = mysql_fetch_assoc($resultGetAppo);
					$sched_time_id = $row_appointment['sched_time_id'];

					$queryUpdate = "UPDATE `sched_time` SET `is_taken`='no' WHERE time_id='$sched_time_id'";
					$resultUpdate = mysql_query($queryUpdate);

					if($rowsNotAvail==0){
						$query_sched_time = "SELECT *
                                FROM `sched_time`
                                INNER JOIN `sched_date`
                                ON sched_time.date_id=sched_date.date_id
                                WHERE sched_time.time_id='$resched_time'";
						$result_sched_time = mysql_query($query_sched_time) or die(mysql_error());

						while ($row = mysql_fetch_array($result_sched_time))
						{
							$schedule_day = $row['schedule_day'];
							$schedule_month = $row['schedule_month'];
							$schedule_year = $row['schedule_year'];
							$appoint_date = $schedule_month . " " . $schedule_day . " " . $schedule_year;
							$day = $row['day'];
							$schedule_time_fr = $row['schedule_time_fr'];
							$schedule_time_to = $row['schedule_time_to'];
						}

						$query = "UPDATE `appointments` SET
									`appoint_date`='$appoint_date',
									`sched_time_id`='$resched_time',
									`remarks`='$resched_remark',
									`appoint_time_fr`='$schedule_time_fr',
									`appoint_time_to`='$schedule_time_to',
									`status`='rescheduled'
									WHERE appointment_id=$resched_appointment_id";
						$result = mysql_query($query) or die(mysql_error());
						if($result) {

							$queryUpdate = "UPDATE `sched_time` SET `is_taken`='yes' WHERE time_id='$resched_time'";
							$resultUpdate = mysql_query($queryUpdate);

							echo "<div class=\"alert alert-info\">Update Succesful!</div>";
						}

					}else{
						echo "<div class=\"alert alert-danger\">Date and time schedule already registered</div>";
					}

				}
			?>
			
			<div class="form">
                <h4>Reschedule Appointment</h4>
                <form class="form-horizontal" name="resched" action="" method="post">
					<input type='hidden' name='resched_appointment_id' value='<?php echo "$resched_appointment_id"; ?>'/>
					<input type='hidden' name='faculty_id' value='<?php echo "$faculty_id"; ?>'/>
					<select class="form-control" name="time">
						<?php
						$query_sched_time = "SELECT *
                                FROM `sched_time`
                                INNER JOIN `sched_date`
                                ON sched_time.date_id=sched_date.date_id
                                WHERE faculty_id='$faculty_id'";
						$result_sched_time = mysql_query($query_sched_time) or die(mysql_error());
						while ($row_sched_time = mysql_fetch_array($result_sched_time)) {

							$timeStart = $row_sched_time['schedule_time_fr'];
							$queryTimeStart = "SELECT TIME_FORMAT('$timeStart', '%h:%i:%s %p')";
							$resultTimeStart = mysql_query($queryTimeStart) or die(mysql_error());
							$rowTimeStart = mysql_fetch_row($resultTimeStart);

							$timeEnd = $row_sched_time['schedule_time_to'];
							$queryTimeEnd = "SELECT TIME_FORMAT('$timeEnd', '%h:%i:%s %p')";
							$resultTimeEnd = mysql_query($queryTimeEnd) or die(mysql_error());
							$rowTimeEnd = mysql_fetch_row($resultTimeEnd);

							if($row_sched_time['time_id']==$resched_time) {
								echo "<option selected value='";
							}else{
								echo "<option value='";
							}
							echo $row_sched_time['time_id'] . "'>" . $rowTimeStart[0] .
								" - " . $rowTimeEnd[0] . " @ " . $row_sched_time['schedule_month'] .
								" " . $row_sched_time['schedule_day'] .
								" " . $row_sched_time['schedule_year'] .
								" " . $row_sched_time['day'] . "</option>";
						}
						?>

					</select><br/>
					<textarea name='remarks' rows="4" cols="30"><?php echo substr($resched_remark, 14, strlen($resched_remark)-1);?></textarea>
					<br/><br/>
                    <input class="btn btn-primary" type="submit" name="submit" value="Update" />
                </form>
            </div>
		</div>
	</body>
</html>
