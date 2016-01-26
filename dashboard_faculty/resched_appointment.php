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
				<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_faculty/dashboard_faculty.php';?>">Home</a> |    
				<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a>
			</p>
		
			<?php $user_id = $_SESSION['userid']; ?>
			<?php 
				if(isset($_POST['appointmentdate'])){ 
					$appointment_id = $_POST['appointment_id'];

					$queryNotAvail = "SELECT * FROM `appointments` WHERE appoint_date='$appointmentdate' and sched_time_id='$faculty_sched_time_id'";
			        $resultNotAvail = mysql_query($queryNotAvail) or die(mysql_error());
			        $rowsNotAvail = mysql_num_rows($resultNotAvail);

			        if($day != $day_calendar){
			            echo "Date selected is not ". $faculty_sched_time['day'];
			        }else if($rowsNotAvail > 0){
			            echo "Date and time schedule already registered";
			        }else{
						$query = "UPDATE `appointments` SET `status`='$status' WHERE appointment_id=$appointment_id";
						$result = mysql_query($query) or die(mysql_error());
			        }
				}
			?>
			<?php 
				if(isset($_POST['resched'])){ 
					$appointment_id = $_POST['appointment_id'];
                    $result_appointment= mysql_query("SELECT * FROM `appointments` WHERE appointment_id='$appointment_id' LIMIT 1");
                    $appointment= mysql_fetch_assoc($result_appointment);
                    $faculty_id = $appointment['faculty_id'];
				}
			?>
			<div class="form">
                <h4>Add Appointment</h4>
                <form name="registration" action="" method="post">
                    <input value="<?php echo $appointment['appoint_date']?>" type="date" placeholder="YYYY-MM-DD" name="appointmentdate" data-date-split-input="true" required/> <br/><br/>
					<input type='hidden' name='appointment_id' value='$appointment_id'/>
                    <select name="time">
                        <?php
                            $query_sched_time = "SELECT * FROM `faculty_sched_time` WHERE user_id=$faculty_id";
                            $result_sched_time = mysql_query($query_sched_time) or die(mysql_error());
                            while ($row_sched_time = mysql_fetch_array($result_sched_time)) {
                            	if($row_sched_time['id'] == $appointment['sched_time_id']){
                            		echo "<option selected value='". $row_sched_time['id'] ."'>". $row_sched_time['start_time'] . "-" . 
                            		$row_sched_time['end_time'] . " @ " . $row_sched_time['day'] ."</option>";
                            	}else{
                                	echo "<option value='". $row_sched_time['id'] ."'>". $row_sched_time['start_time'] . "-" . 
                                	$row_sched_time['end_time'] . " @ " . $row_sched_time['day'] ."</option>";
                            	}
                            }
                        ?>
                    </select><br/><br/>
                    <input type="submit" name="submit" value="Register" />
                </form>
            </div>
		</div>
	</body>
</html>
