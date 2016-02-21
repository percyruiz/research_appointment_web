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

    if (isset($_POST['appointmentdate'])){

        $appointmentdate = $_POST['appointmentdate'];
        $sched_id = $_POST['time'];
        $result_faculty_sched_time = mysql_query("SELECT * FROM `faculty_sched_time` WHERE id='$sched_id' LIMIT 1");
        $faculty_sched_time = mysql_fetch_assoc($result_faculty_sched_time);
        $faculty_sched_time_id = $faculty_sched_time['id'];

        $datePieces = explode("-", $appointmentdate);
        $year = $datePieces[0];
        $month =  $datePieces[1];
        $day = $faculty_sched_time['day'];

        $timestamp = strtotime($appointmentdate);
        $day_calendar = date('l', $timestamp);

        $queryNotAvail = "SELECT * FROM `appointments` WHERE appoint_date='$appointmentdate' AND sched_time_id='$faculty_sched_time_id'";
        $resultNotAvail = mysql_query($queryNotAvail) or die(mysql_error());
        $rowsNotAvail = mysql_num_rows($resultNotAvail);

        if($day != $day_calendar){
            echo "<div class=\"alert alert-danger\">Date selected is not ". $faculty_sched_time['day'] . "</div>";
        }else if($rowsNotAvail > 0){
            echo "<div class=\"alert alert-danger\">Date and time schedule already registered</div>";
        }else{
            $appointmentdate = stripslashes($appointmentdate);
            $appointmentdate = mysql_real_escape_string($appointmentdate);

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
                $researchId = $row['research_id'];
                $researchCode = $row['research_code'];
            }   

            $queryInsert = "INSERT into `appointments` (
                    research_id,
                    faculty_id,
                    appoint_date, 
                    status,
                    sched_time_id,
                    research_code
                    ) VALUES (
                    '$researchId',
                    '$faculty_id',
                    '$appointmentdate', 
                    'pending',
                    '$faculty_sched_time_id',
                    '$researchCode')";
            $resultInsert = mysql_query($queryInsert);
            if($resultInsert){
				$insertConsultation = "INSERT into `consultations` (
								date,
								research_id,
								status
								) VALUES (
								'$appointmentdate',
								'$researchId',
								'pending/requested')";
				$insertConsultation = mysql_query($insertConsultation);
                echo '<div class="alert alert-info">Added Successfully!</div>';
            }else{
                echo mysql_error();
            }
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
			$researchId = $row['research_id'];
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


		$queryAppointment = "SELECT * FROM `appointments` WHERE `research_id`='$researchId' AND `faculty_id`='$faculty_id' ORDER BY `appointment_id` DESC";
		$resultAppointment = mysql_query($queryAppointment) or die(mysql_error());
		$rows = mysql_num_rows($resultAppointment);
    
    ?>

    <div class="row">
        <div class="col-md-3">
            <div class="form">
                <h4>Add Appointment</h4>
                <form class="form-horizontal" name="registration" action="" method="post">
                    <input class="form-control" type="date" placeholder="YYYY-MM-DD" name="appointmentdate" data-date-split-input="true" required/> <br/>
                    <select class="form-control" name="time">
                        <?php
                            $query_sched_time = "SELECT * FROM `faculty_sched_time` WHERE user_id=$facultyid";
                            $result_sched_time = mysql_query($query_sched_time) or die(mysql_error());
                            while ($row_sched_time = mysql_fetch_array($result_sched_time)) {
                                echo "<option value='". $row_sched_time['id'] ."'>". $row_sched_time['start_time'] . "-" . $row_sched_time['end_time'] . " @ " . $row_sched_time['day'] ."</option>";
                            }
                        ?>
                    </select><br/>
                    <input type='hidden' name='faculty_id' value='<?php echo $faculty_id;?>'/>
                    <input class="btn btn-primary" type="submit" name="submit" value="Register" />
                </form>
            </div>
        </div>
        <div class="col-md-9">
            <strong><?php echo $facultyName . ' - consultations ';?></strong>
            <?php 
                echo "<table class='table table-striped table-hover' style='width:100%'>";
                echo "<thead>";
                echo "   <tr>";
                echo "      <th align='center'>";
                echo "          <strong>Date</strong>";
                echo "      </th>";
                echo "      <th align='center'>";
                echo "          <strong>Day</strong>";
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
                    
                    $sched_time_id = $row['sched_time_id'];
                    $result_faculty_sched_time = mysql_query("SELECT * FROM `faculty_sched_time` WHERE id='$sched_time_id' LIMIT 1");
                    $faculty_sched_time = mysql_fetch_assoc($result_faculty_sched_time);
					
					$timeStart = $faculty_sched_time['start_time'];
					$queryTimeStart = "SELECT TIME_FORMAT('$timeStart', '%h:%i:%s %p')";
					$resultTimeStart = mysql_query($queryTimeStart) or die(mysql_error());
					$rowStartTime = mysql_fetch_row($resultTimeStart);
					
					$timeEnd = $faculty_sched_time['end_time'];
					$queryTimeEnd = "SELECT TIME_FORMAT('$timeEnd', '%h:%i:%s %p')";
					$resultTimeEnd = mysql_query($queryTimeEnd) or die(mysql_error());
					$rowEndTime = mysql_fetch_row($resultTimeEnd);

                    echo "   <tr>";
                    echo "      <td>";
                    echo            $row['appoint_date'];
                    echo "      </td>";
                    echo "      <td>";
                    echo            $faculty_sched_time['day'];
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
