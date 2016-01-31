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
<p>
    <a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/dashboard_student.php';?>">Home</a> |    
    <a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a>
</p>
<?php
    // require('db.php');
    //access from root folder
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= "/db.php";
    require($path);

    $userid = $_SESSION['userid'];

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
        $day_calendar = date('D', $timestamp);

        $queryNotAvail = "SELECT * FROM `appointments` WHERE appoint_date='$appointmentdate' and sched_time_id='$faculty_sched_time_id'";
        $resultNotAvail = mysql_query($queryNotAvail) or die(mysql_error());
        $rowsNotAvail = mysql_num_rows($resultNotAvail);

        if($day != $day_calendar){
            echo "Date selected is not ". $faculty_sched_time['day'];
        }else if($rowsNotAvail > 0){
            echo "Date and time schedule already registered";
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
              $facultyId = $row['faculty_id']; 
            }   

            $queryInsert = "INSERT into `appointments` (
                    research_id,
                    faculty_id,
                    appoint_date, 
                    status,
                    sched_time_id
                    ) VALUES (
                    '$researchId',
                    '$facultyId',
                    '$appointmentdate', 
                    'pending',
                    '$faculty_sched_time_id')";
            $resultInsert = mysql_query($queryInsert);
            if($resultInsert){
                echo 'add success';
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
		echo "No Research added.<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/insert_research.php'>Add Research.</a></div>";
	}else{
		while ($row = mysql_fetch_array($resultResearchId)) {
			$researchId = $row['research_id'];
			$researchTitle = $row['research_title'];
			$facultyid = $row['faculty_id'];
		}

		echo "<h4>".$researchTitle."</h4>";

		$queryFacultyName = "SELECT * FROM `users` WHERE user_id='$facultyid'";
		$resultFacultyName = mysql_query($queryFacultyName) or die(mysql_error());
		$rows = mysql_num_rows($resultFacultyName);

		while ($row = mysql_fetch_array($resultFacultyName)){
			$facultyName = $row['fname']." ".$row['mname']." ".$row['lname'];
		}


		$queryAppointment = "SELECT * FROM `appointments`WHERE research_id='$researchId'";
		$resultAppointment = mysql_query($queryAppointment) or die(mysql_error());
		$rows = mysql_num_rows($resultAppointment);
    
    ?>

    <div class="row">
        <div class="col-md-3">
            <div class="form">
                <h4>Add Appointment</h4>
                <form name="registration" action="" method="post">
                    <input type="date" placeholder="YYYY-MM-DD" name="appointmentdate" data-date-split-input="true" required/> <br/><br/>
                    <select name="time">
                        <?php
                            $query_sched_time = "SELECT * FROM `faculty_sched_time` WHERE user_id=$facultyid";
                            $result_sched_time = mysql_query($query_sched_time) or die(mysql_error());
                            while ($row_sched_time = mysql_fetch_array($result_sched_time)) {
                                echo "<option value='". $row_sched_time['id'] ."'>". $row_sched_time['start_time'] . "-" . $row_sched_time['end_time'] . " @ " . $row_sched_time['day'] ."</option>";
                            }
                        ?>
                    </select><br/><br/>
                    <input type="submit" name="submit" value="Register" />
                </form>
            </div>
        </div>
        <div class="col-md-9">
            <?php 
                echo "<table class='table' border='1' style='width:100%'>";
                echo "   <tr>";
                echo "      <td align='center'>";   
                echo "          <strong>Date</strong>";
                echo "      </td>";
                echo "      <td align='center'>";   
                echo "          <strong>Day</strong>";
                echo "      </td>";
                echo "      <td align='center'>";   
                echo "          <strong>Start Time</strong>";
                echo "      </td>";
                echo "      <td align='center'>";   
                echo "          <strong>End Time</strong>";
                echo "      </td>";
                echo "      </td>";
                echo "      <td align='center'>";   
                echo "          <strong>Adviser</strong>";
                echo "      </td>";
                echo "      <td align='center'>";   
                echo "          <strong>Status</strong>";
                echo "      </td>";
                echo "      <td align='center'>";   
                echo "          <strong>Tardy</strong>";
                echo "      </td>";
                echo "      <td align='center'>";   
                echo "          <strong>Appearance</strong>";
                echo "      </td>";
                echo "      <td align='center'>";   
                echo "          <strong>Remarks</strong>";
                echo "      </td>";
                echo "   </tr>";
                while ($row = mysql_fetch_array($resultAppointment)) 
                {
                    
                    $sched_time_id = $row['sched_time_id'];
                    $result_faculty_sched_time = mysql_query("SELECT * FROM `faculty_sched_time` WHERE id='$sched_time_id' LIMIT 1");
                    $faculty_sched_time = mysql_fetch_assoc($result_faculty_sched_time);

                    echo "   <tr>";
                    echo "      <td align='center'>";   
                    echo            $row['appoint_date'];
                    echo "      </td>";
                    echo "      <td align='center'>";   
                    echo            $faculty_sched_time['day'];
                    echo "      </td>";
                    echo "      <td align='center'>";   
                    echo            $faculty_sched_time['start_time'];
                    echo "      </td>";
                    echo "      <td align='center'>";   
                    echo            $faculty_sched_time['end_time'];
                    echo "      </td>";
                    echo "      <td align='center'>";   
                    echo            $facultyName;
                    echo "      </td>";
                    echo "      <td align='center'>";   
                    echo            $row['status'];
                    echo "      </td>";
                    echo "      <td align='center'>";   
                    echo            $row['tardy'];
                    echo "      </td>";
                    echo "      <td align='center'>";   
                    echo            $row['appearance'];
                    echo "      </td>";
                    echo "      <td align='center'>";   
                    echo            $row['remarks'];
                    echo "      </td>";
                    echo "   </tr>";
                }

                echo "<table>";
                ?>
        </div>
    </div>
	<?php } ?>

</div>
</body>
</html>
