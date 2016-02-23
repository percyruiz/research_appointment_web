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
		<ul class="breadcrumb">
			<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/dashboard_admin.php';?>">Back</a></li>
			<li> <a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a></li>
		</ul>
	<h4>Manage Faculty Availability</h4>

	<?php
	// require('db.php');
	//access from root folder
	$path = $_SERVER['DOCUMENT_ROOT'];
	$path .= "/db.php";
	require($path);
	if (isset($_GET['datesched'])){
			$date_id = $_GET['datesched'];
			$result_r = mysql_query("SELECT * FROM `sched_date` WHERE date_id = '$date_id' LIMIT 1");
		  	$datesched = mysql_fetch_assoc($result_r);
		}
	if (isset($_POST['scheduletimefr'])){
		$schedule_time_fr = $_POST['scheduletimefr'];
		$schedule_time_to = $_POST['scheduletimeto'];
		$date_id = $datesched['date_id'];

		$query = "INSERT INTO `sched_time`(`time_id`, `date_id`, `schedule_time_fr`, `schedule_time_to`, `is_taken`)
		VALUES (NULL, '$date_id' ,'$schedule_time_fr','$schedule_time_to','no')";
  		$result = mysql_query($query);
		if($result){
			echo "<div class=\"alert alert-info\">Added Successfully!</div>";
		}else{
			echo mysql_error();
		}
	}
	?>
			<div class="row">
				<div class="col-md-3">
					<div class="form container">
					<h5>add schedule</h5>
						<form name="set_schedule" action="" method="post">
							<input class="form-control" type="time" name="scheduletimefr" placeholder="Start Time" required/> <br/>
							<input class="form-control" type="time" name="scheduletimeto" placeholder="End Time" required/> <br/>
							<input class="btn btn-primary" type="submit" name="submit" value="Set" /><br/><br/>
						</form>
					</div>
					</div>
					<div class="col-md-9">
					<!-- <h5><?php echo  $faculty['fname'] . '\'s schedule'; ?></h5> -->
					<?php
						$query = "SELECT * FROM `sched_time` WHERE date_id = $date_id";
						$result = mysql_query($query) or die(mysql_error());
						echo "<table class='table' border='1' style='width:100%'>";
						echo "	 <tr>";

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
							$timeStart = $row['schedule_time_fr'];
							$queryTimeStart = "SELECT TIME_FORMAT('$timeStart', '%h:%i:%s %p')";
							$resultTimeStart = mysql_query($queryTimeStart) or die(mysql_error());
							$rowTime = mysql_fetch_row($resultTimeStart);
							echo 			$rowTime[0];
							echo "      </td>";

							echo "      <td style='padding: 5px;'>";
							$timeEnd = $row['schedule_time_to'];
							$queryTimeEnd = "SELECT TIME_FORMAT('$timeEnd', '%h:%i:%s %p')";
							$resultTimeEnd = mysql_query($queryTimeEnd) or die(mysql_error());
							$rowTime = mysql_fetch_row($resultTimeEnd);
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
