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
	<title>View Records</title>
		<link rel="stylesheet" href="../css/bootstrap/css/bootstrap.css" />
	</head>
	<body>

	<div class="container">
	<p>
		<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/dashboard_admin.php';?>">Home</a> |	 
		<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a>
	</p>
	<h4>Manage Users </h4>


	<?php
	// require('db.php');
	//access from root folder
	$path = $_SERVER['DOCUMENT_ROOT'];
	$path .= "/db.php";
	require($path);
   
    // If form submitted, insert values into the database.
    if (isset($_GET['faculty'])){
        $user_id = $_GET['faculty'];
		
        $result_r = mysql_query("SELECT * FROM `users` WHERE user_id='$user_id' LIMIT 1");
		$faculty = mysql_fetch_assoc($result_r);
	}

	if (isset($_POST['time_start'])){
        $time_start = $_POST['time_start'];
        $time_end = $_POST['time_end'];
        $day = $_POST['day'];
		$faculty_id = $faculty['user_id'];

		$query = "INSERT INTO `faculty_sched_time`(`id`, `user_id`, `start_time`, `end_time`, `day`) 
		VALUES (NULL,$faculty_id,'$time_start','$time_end','$day')";

        $result = mysql_query($query);
        if($result){
            echo "add success!";
        }else{
        	echo mysql_error();
        }	
	}
	?>
			<h5><?php echo $faculty['lname'] . ', '. $faculty['fname'] . ' ' . $faculty['mname']?></h5>
			<div class="row">
				<div class="col-md-3">
					<div class="form container">
					<h5>add schedule</h5>
						<form name="add_schedule" action="" method="post">
							<input type="time" name="time_start" placeholder="Start Time" required/> <br/><br/>
							<input type="time" name="time_end" placeholder="End Time" required/> <br/><br/>
							<select name="day">
							  <option value="Monday">Monday</option>
							  <option value="Tuesday">Tuesday</option>
							  <option value="Wednesday">Wednesday</option>
							  <option value="Thursday">Thursday</option>
							  <option value="Friday">Friday</option>
							  <option value="Saturday">Saturday</option>
							  <option value="Sunday">Sunday</option>
							</select><br/><br/>
							<input type="submit" name="submit" value="Add" /><br/><br/>
						</form>
					</div>
					</div>
					<div class="col-md-9">
					<h5><?php echo  $faculty['fname'] . '\'s schedule'; ?></h5>
					<?php
						$query = "SELECT * FROM `faculty_sched_time` WHERE user_id=$user_id";
						$result = mysql_query($query) or die(mysql_error());
						echo "<table class='table' border='1' style='width:100%'>";
						echo "	 <tr>";
						echo "	 	<td align='center'>";	
						echo "	 		<strong>day</strong>";
						echo "	 	</td>";
						echo "	 	<td align='center'>";	
						echo "	 		<strong>start time</strong>";
						echo "	 	</td>";
						echo "	 	<td align='center'>";	
						echo "	 		<strong>end time</strong>";
						echo "	 	</td>";
						echo "	 </tr>";
						while ($row = mysql_fetch_array($result)) {
							echo "   <tr>";
							echo "      <td style='padding: 5px;'>";
							echo 			$row['day'];
							echo "      </td>";

							echo "      <td style='padding: 5px;'>";
							$timeStart = $row['start_time'];
							$queryTimeStart = "SELECT TIME_FORMAT('$timeStart', '%h:%i:%s %p')";
							$resultTimeStart = mysql_query($queryTimeStart) or die(mysql_error());
							$rowTime = mysql_fetch_row($resultTimeStart);
							echo $rowTime[0];
							echo "      </td>";

							echo "      <td style='padding: 5px;'>";
							$timeEnd = $row['end_time'];
							$queryTimeEnd = "SELECT TIME_FORMAT('$timeEnd', '%h:%i:%s %p')";
							$resultTimeEnd = mysql_query($queryTimeEnd) or die(mysql_error());
							$row = mysql_fetch_row($resultTimeEnd);
							echo $rowTime[0];
							echo "      </td>";

							echo "   </tr>";
						}
						echo "<table>";
					?>		 	
				</div>
			</div>
			
		</div>
	</body>
</html>
