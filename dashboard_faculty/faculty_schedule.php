<?php
//require('db.php');
session_start();
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

	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">FACULTY</a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_faculty/dashboard_faculty.php';?>"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Appointments</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_faculty/handled_researches.php';?>"> <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> View Researches Handled</a></li>
					<li class="active"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_faculty/faculty_schedule.php';?>"> <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Manage Schedule</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/change_password_form.php';?>"> <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Change Password</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>"> <span class="glyphicon glyphicon-off" aria-hidden="true"></span> Logout </a></li>
				</ul>
			</div>
		</div>
	</nav>

	<h4>Manage Schedule</h4>

	<?php

    $user_id = $_SESSION['userid'];
	// If form submitted, insert values into the database.
	$result_r = mysql_query("SELECT * FROM `users` WHERE user_id='$user_id' LIMIT 1");
	$faculty = mysql_fetch_assoc($result_r);
	$faculty_id = $faculty['faculty_id'];

	if (isset($_POST['appointmentdate'])){
		$date = $_POST['appointmentdate'];

		$split = explode("-",$date);
		$schedule_year = $split[0];
		$schedule_month = $split[1];
		$schedule_date = $split[2];

		$timestamp = strtotime($date);
		$day = date('l', $timestamp);
		$schedule_month = date('M', $timestamp);

		$faculty_id = $faculty['faculty_id'];

		$query = "INSERT INTO `sched_date`(`date_id`, `faculty_id`, `schedule_month`, `schedule_day`, `schedule_year`,`day`)
		VALUES (NULL,'$faculty_id','$schedule_month','$schedule_date','$schedule_year','$day')";

		$result = mysql_query($query);
		if($result){
			echo "<div class=\"alert alert-info\">Added Successfully!</div>";
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
					<input class="form-control" type="date" placeholder="YYYY-MM-DD" name="appointmentdate" data-date-split-input="true" required/> <br/>
					<input class="btn btn-default" type="submit" name="submit" value="Add" /><br/><br/>
				</form>
			</div>
		</div>
		<div class="col-md-9">
			<h5><?php echo 'your schedule'; ?></h5>
			<?php
			$query = "SELECT * FROM `sched_date` WHERE faculty_id=$faculty_id";
			$result = mysql_query($query) or die(mysql_error());
			echo "<table class='table table-striped table-hover' style='width:100%'>";
			echo "	 <thead>";
			echo "	 <tr>";
			echo "	 	<th align='center'>";
			echo "	 		<strong>Month</strong>";
			echo "	 	</th>";
			echo "	 	<th align='center'>";
			echo "	 		<strong>Date</strong>";
			echo "	 	</th>";
			echo "	 	<th align='center'>";
			echo "	 		<strong>Year</strong>";
			echo "	 	</th>";
			echo "	 	<th align='center'>";
			echo "	 		<strong>Day</strong>";
			echo "	 	</th>";
			echo "	 	<th align='center'>";
			echo "	 		<strong>Schedule</strong>";
			echo "	 	</th>";
			echo "	 </tr>";
			echo "	 </thead>";
			echo "	 <tbody>";
			while ($row = mysql_fetch_array($result)) {
				echo "   <tr>";
				echo "      <td style='padding: 5px;'>";
				echo 			$row['schedule_month'];
				echo "      </td>";

				echo 	"      <td style='padding: 5px;'>";
				echo 			$row['schedule_day'];

				echo "      </td>";
				echo "      <td style='padding: 5px;'>";
				echo 			$row['schedule_year'];
				echo "      </td>";

				echo "      <td style='padding: 5px;'>";
				echo 			$row['day'];
				echo "      </td>";

				echo "      <td style='padding: 5px;'>";
				echo "<a href='http://" . $_SERVER['SERVER_NAME'] ."/dashboard_faculty/faculty_timeschedule.php?datesched=". $row['date_id'] ."'>Set time</a>";
				echo "      </td>";

				echo "   </tr>";
			}
			echo "</tbody>";
			echo "</table>";
			?>
		</div>
	</div>

</div>
</body>
</html>
