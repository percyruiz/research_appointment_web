<?php
/*
Author: Javed Ur Rehman
Website: https://htmlcssphptutorial.wordpress.com
*/
?>
<?php 
session_start();
include("auth.php"); //include auth.php file on all secure pages ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Registration</title>
<link rel="stylesheet" href="../css/bootstrap/css/bootstrap.css" />
</head>
<body>

<div class="container">
    <ul class="breadcrumb">
        <li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/view_research.php';?>">Back</a></li>
        <li> <a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a></li>
    </ul>

<?php
    //access from root folder
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= "/db.php";
    require($path);

    $userid = $_SESSION['userid'];

    if(isset($_POST['faculty_id'])){
        $faculty_id = $_POST['faculty_id'];
    }

    if (isset($_POST['time'])){

        $sched_time_id = $_POST['time'];

        $queryNotAvail = "SELECT * FROM `appointments` WHERE sched_time_id='$sched_time_id'";
        $resultNotAvail = mysql_query($queryNotAvail) or die(mysql_error());
        $rowsNotAvail = mysql_num_rows($resultNotAvail);

        if($rowsNotAvail == 0){
            $userid = $_SESSION['userid'];

            $queryStudentNum = "SELECT * FROM `users` WHERE user_id='$userid'";
            $resultStudentNum = mysql_query($queryStudentNum) or die(mysql_error());
            $rows = mysql_num_rows($resultStudentNum);

            while ($row = mysql_fetch_array($resultStudentNum)) {
                $student_no = $row['student_no'];
            }

            $queryResearchId = "SELECT * FROM `researches` WHERE student_no='$student_no'";
            $resultResearchId = mysql_query($queryResearchId) or die(mysql_error());
            $rows = mysql_num_rows($resultResearchId);

            while ($row = mysql_fetch_array($resultResearchId))
            {
                $researchCode = $row['research_code'];
                $percentage = $row['percentage'];
            }

            $query_sched_time = "SELECT *
                                FROM `sched_time`
                                INNER JOIN `sched_date`
                                ON sched_time.date_id=sched_date.date_id
                                WHERE sched_time.time_id='$sched_time_id'";
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

            $queryInsert = "INSERT into `appointments` (
                    appoint_date,
                    appoint_time_fr,
                    appoint_time_to,
                    faculty_id,
                    status,
                    sched_time_id,
                    research_code,
                    timestamp,
                    percentage
                    ) VALUES (
                    '$appoint_date',
                    '$schedule_time_fr',
                    '$schedule_time_to',
                    '$faculty_id',
                    'pending',
                    '$sched_time_id',
                    '$researchCode',
                    now(),
                    '$percentage')";
            $resultInsert = mysql_query($queryInsert);

            $queryUpdate = "UPDATE `sched_time` SET `is_taken`='yes' WHERE time_id='$sched_time_id'";
            $resultUpdate = mysql_query($queryUpdate);


            echo '<div class="alert alert-info">Added Successfully!</div>';
        }else{
            echo "<div class=\"alert alert-danger\">Date and time schedule already registered</div>";
        }
    }

    $queryStudentNum = "SELECT * FROM `users` WHERE user_id='$userid'";
    $resultStudentNum = mysql_query($queryStudentNum) or die(mysql_error());
    $rows = mysql_num_rows($resultStudentNum);
        
    while ($row = mysql_fetch_array($resultStudentNum)) 
    {
        $student_no = $row['student_no'];
    }

    $queryResearchId = "SELECT * FROM `researches` WHERE student_no='$student_no'";
    $resultResearchId = mysql_query($queryResearchId) or die(mysql_error());
    $rows = mysql_num_rows($resultResearchId);
	
	if($rows == 0){
		//echo "No Research added.<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/insert_research.php'>Add Research.</a></div>";
	}else{
		while ($row = mysql_fetch_array($resultResearchId)) {
			$researchCode = $row['research_code'];
			$researchTitle = $row['research_title'];
			$facultyid = $faculty_id;
		}

		echo "<h4>".$researchTitle."</h4>";

		$queryFacultyName = "SELECT * FROM `users` WHERE faculty_id='$facultyid'";
		$resultFacultyName = mysql_query($queryFacultyName) or die(mysql_error());
		$rows = mysql_num_rows($resultFacultyName);

		while ($row = mysql_fetch_array($resultFacultyName)){
			$facultyName = $row['lname'] . ', ' .$row['fname']." ".$row['mname'];
		}


		$queryAppointment = "SELECT * FROM `appointments` WHERE `research_code`='$researchCode' AND `faculty_id`='$faculty_id' ORDER BY `appointment_id` DESC";
		$resultAppointment = mysql_query($queryAppointment) or die(mysql_error());
		$rows = mysql_num_rows($resultAppointment);
    
    ?>

    <div class="row">
        <div class="col-md-5">
            <div class="form">
                <h4>Add Appointment</h4>
                <form class="form-horizontal" name="registration" action="" method="post">
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

                                echo "<option value='". $row_sched_time['time_id'] ."'>". $rowTimeStart[0] .
                                    " - " . $rowTimeEnd[0] . " @ " . $row_sched_time['schedule_month'] .
                                    " ". $row_sched_time['schedule_day'] .
                                    " ". $row_sched_time['schedule_year'] .
                                    " ". $row_sched_time['day'] . "</option>";
                            }
                    ?>

                    </select><br/>
                    <input type='hidden' name='faculty_id' value='<?php echo $faculty_id;?>'/>
                    <input class="btn btn-primary" type="submit" name="submit" value="Register" />
                </form>
            </div>
        </div>
        <div class="col-md-7">
            <strong><?php echo $facultyName . ' - consultations ';?></strong>
            <?php

                $queryAllAppointments = "SELECT * from `appointments`";
                $resultAllAppontments = mysql_query($queryAllAppointments) or die(mysql_error());

                $rightNow = date("Ymd");

                while ($rowAllAppointments = mysql_fetch_array($resultAllAppontments)) {
                    $requestedDate = date("Ymd", strtotime($rowAllAppointments['appoint_date']));
                    if($rightNow > $requestedDate){
                        if($rowAllAppointments == 'accepted'){
                            $status = 'done';

                            $appointment_id = $rowAllAppointments['appointment_id'];
                            $queryUpdateAppointments = "UPDATE `appointments` SET `status`='$status' WHERE appointment_id=$appointment_id";
                            $result = mysql_query($queryUpdateAppointments) or die(mysql_error());
                        }else if ($rowAllAppointments == 'pending'){
                            $status = 'expired';

                            $appointment_id = $rowAllAppointments['appointment_id'];
                            $queryUpdateAppointments = "UPDATE `appointments` SET `status`='$status' WHERE appointment_id=$appointment_id";
                            $result = mysql_query($queryUpdateAppointments) or die(mysql_error());
                        }
                    }
                }

                echo "<table class='table table-striped table-hover' style='width:100%'>";
                echo "<thead>";
                echo "   <tr>";
                echo "      <th align='center'>";
                echo "          <strong>Date</strong>";
                echo "      </th>";
                echo "      <th align='center'>";
                echo "          <strong>Start Time</strong>";
                echo "      </th>";
                echo "      <th align='center'>";
                echo "          <strong>End Time</strong>";
                echo "      </th>";
                echo "      </th>";
                echo "      <th align='center'>";
                echo "          <strong>Adviser</strong>";
                echo "      </th>";
                echo "      <th align='center'>";
                echo "          <strong>Status</strong>";
                echo "      </th>";
                echo "      <th align='center'>";
                echo "          <strong>Remarks</strong>";
                echo "      </th>";
                echo "   </tr>";
                echo "</thead>";
                echo "<tbody>";
                while ($row = mysql_fetch_array($resultAppointment)) 
                {

					
					$timeStart = $row['appoint_time_fr'];
					$queryTimeStart = "SELECT TIME_FORMAT('$timeStart', '%h:%i:%s %p')";
					$resultTimeStart = mysql_query($queryTimeStart) or die(mysql_error());
					$rowStartTime = mysql_fetch_row($resultTimeStart);
					
					$timeEnd = $row['appoint_time_to'];
					$queryTimeEnd = "SELECT TIME_FORMAT('$timeEnd', '%h:%i:%s %p')";
					$resultTimeEnd = mysql_query($queryTimeEnd) or die(mysql_error());
					$rowEndTime = mysql_fetch_row($resultTimeEnd);

                    echo "   <tr>";
                    echo "      <td>";
                    echo            $row['appoint_date'];
                    echo "      </td>";
                    echo "      <td>";
                    echo            $rowStartTime[0];
                    echo "      </td>";
                    echo "      <td>";
                    echo            $rowEndTime[0];
                    echo "      </td>";
                    echo "      <td>";
                    echo            $facultyName;
                    echo "      </td>";
                    echo "      <td>";
                    echo            $row['status'];
                    echo "      </td>";
                    echo "      <td>";
                    echo            $row['remarks'];
                    echo "      </td>";
                    echo "   </tr>";
                }
                echo "</tbody>";
                echo "<table>";
                ?>
        </div>
    </div>
	<?php } ?>

</div>
</body>
</html>
