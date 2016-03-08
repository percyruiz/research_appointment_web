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
	<title>Dashboard Admin</title>
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
	<?php
		// require('db.php');
		//access from root folder
		$path = $_SERVER['DOCUMENT_ROOT'];
		$path .= "/db.php";
		require($path);
	?>
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="#">ADMIN</a>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
							<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/dashboard_admin.php';?>">Manage Faculty</a></li>
							<li class="active"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/consultation_history.php';?>">Consultation History</a></li>
							<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/student_profiles.php';?>">Manage Student</a></li>
							<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/insert_research.php';?>">Add Research</a></li>
							<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/view_researches.php';?>">View Monitoring</a></li>
							<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/view_groups.php';?>">View Groups</a></li>
							<li> <a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a></li>
						</ul>
					</div>
				</div>
			</nav>

			<h4>Consultation History</h4>

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
				<input class="btn btn-primary" type="submit" name="submit" value="Filter" /><br/><br/>
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

                $query = "SELECT * FROM `appointments` ORDER BY `appointment_id` DESC";
                $result = mysql_query($query) or die(mysql_error());
				$to_pdf = "";
				$to_pdf = $to_pdf . "<table class='table table-striped table-hover' style='width:100%'>";
				$to_pdf = $to_pdf . "	 <thead>";
				$to_pdf = $to_pdf . "	 <tr>";
				$to_pdf = $to_pdf . "	 	<th align='center'>";
				$to_pdf = $to_pdf . "	 		<strong>ID</strong>";
				$to_pdf = $to_pdf . "	 	</th>";
				$to_pdf = $to_pdf . "	 	<th align='center'>";
				$to_pdf = $to_pdf . "	 		<strong>RESEARCH TITLE</strong>";
				$to_pdf = $to_pdf . "	 	</th>";
				$to_pdf = $to_pdf . "	 	<th align='center'>";
				$to_pdf = $to_pdf . "	 		<strong>FACULTY</strong>";
				$to_pdf = $to_pdf . "	 	</th>";
				$to_pdf = $to_pdf . "	 	<th align='center'>";
				$to_pdf = $to_pdf . "	 		<strong>DATE</strong>";
				$to_pdf = $to_pdf . "	 	</th>";
				$to_pdf = $to_pdf . "      <th align='center'>";
				$to_pdf = $to_pdf . "          <strong>START TIME</strong>";
				$to_pdf = $to_pdf . "      </th>";
				$to_pdf = $to_pdf . "      <th align='center'>";
				$to_pdf = $to_pdf . "          <strong>END TIME</strong>";
				$to_pdf = $to_pdf . "	 	<th align='center'>";
				$to_pdf = $to_pdf . "	 		<strong>REMARKS</strong>";
				$to_pdf = $to_pdf . "	 	</th>";
				$to_pdf = $to_pdf . "	 	<th align='center'>";
				$to_pdf = $to_pdf . "	 		<strong>STATUS</strong>";
				$to_pdf = $to_pdf . "	 	</th>";
				$to_pdf = $to_pdf . "	 </tr>";
				$to_pdf = $to_pdf . "	 </thead>";
				$to_pdf = $to_pdf . "	 <tbody>";
				while ($row = mysql_fetch_array($result)) {
                    $dateNow = strtotime($row['appoint_date']);
                    if( !$hasFilter || ($hasFilter && $date2>=$dateNow && $date1<=$dateNow) ) {
                        $research_code = $row['research_code'];

                        $querySelectResearch = mysql_query("SELECT * FROM `researches` WHERE research_code='$research_code' LIMIT 1");
                        $resultSelectResearch = mysql_fetch_assoc($querySelectResearch);
                        $research_name = $resultSelectResearch['research_title'];
                        $faculty_id = $resultSelectResearch['faculty_id'];

                        $to_pdf = $to_pdf . "   <tr>";
                        $to_pdf = $to_pdf . "      <td style='padding: 5px;'>";
                        $to_pdf = $to_pdf . $row['appointment_id'];
                        $to_pdf = $to_pdf . "      </td>";

                        $to_pdf = $to_pdf . "      <td style='padding: 5px;'>";
                        $to_pdf = $to_pdf . $research_name;
                        $to_pdf = $to_pdf . "      </td>";

                        $to_pdf = $to_pdf . "      <td style='padding: 5px;'>";
                        $faculty = $row['faculty_id'];
                        $resultSelectFaculty = mysql_query("SELECT * FROM `users` WHERE faculty_id='$faculty' LIMIT 1");
                        $rowFaculty = mysql_fetch_assoc($resultSelectFaculty);

                        $to_pdf = $to_pdf . $rowFaculty['lname'] . ", " . $rowFaculty['fname'] . " " . $rowFaculty['mname'];
                        $to_pdf = $to_pdf . "      </td>";

                        $to_pdf = $to_pdf . "      <td style='padding: 5px;'>";
                        $to_pdf = $to_pdf . $row['appoint_date'];
                        $to_pdf = $to_pdf . "      </td>";

                        $timeStart = $row['appoint_time_fr'];
                        $queryTimeStart = "SELECT TIME_FORMAT('$timeStart', '%h:%i:%s %p')";
                        $resultTimeStart = mysql_query($queryTimeStart) or die(mysql_error());
                        $rowStartTime = mysql_fetch_row($resultTimeStart);

                        $timeEnd = $row['appoint_time_to'];
                        $queryTimeEnd = "SELECT TIME_FORMAT('$timeEnd', '%h:%i:%s %p')";
                        $resultTimeEnd = mysql_query($queryTimeEnd) or die(mysql_error());
                        $rowEndTime = mysql_fetch_row($resultTimeEnd);

                        $to_pdf = $to_pdf . "      <td>";
                        $to_pdf = $to_pdf . $rowStartTime[0];
                        $to_pdf = $to_pdf . "      </td>";
                        $to_pdf = $to_pdf . "      <td>";
                        $to_pdf = $to_pdf . $rowEndTime[0];
                        $to_pdf = $to_pdf . "      </td>";

                        $to_pdf = $to_pdf . "      <td style='padding: 5px;'>";
                        $to_pdf = $to_pdf . $row['remarks'];
                        $to_pdf = $to_pdf . "      </td>";

                        $to_pdf = $to_pdf . "      <td style='padding: 5px;'>";
                        $to_pdf = $to_pdf . $row['status'];
                        $to_pdf = $to_pdf . "      </td>";
                        $to_pdf = $to_pdf . "   </tr>";
                    }
				}
				$to_pdf = $to_pdf . "</tbody>";
				$to_pdf = $to_pdf . "</table>";

				echo $to_pdf;
			?>
			<form class="form-horizontal" name="to_pdf" action="../to_pdf.php" method="post">
				<input type="hidden" name="to_pdf" value="<?php echo '<br/><br/>Consultation History <br/><br/>' . $to_pdf?>"/>
				<input class="btn btn-primary" type="submit" name="submit" value="Generate PDF" /><br/><br/>
			</form>
		</div>
	</body>
</html>
