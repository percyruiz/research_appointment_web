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


<?php
    // require('db.php');
    //access from root folder
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= "/db.php";
    require($path);
   
    // If form submitted, insert values into the database.
     if (isset($_POST['appointmentdate'])){

        $appointmentdate = $_POST['appointmentdate'];
        $appointmentstart = $_POST['appointmentstart'];
        $appointmentend = $_POST['appointmentend'];

        $appointmentdate = stripslashes($appointmentdate);
        $appointmentdate = mysql_real_escape_string($appointmentdate);

        $appointmentstart = stripslashes($appointmentstart);
        $appointmentstart = mysql_real_escape_string($appointmentstart);

        $appointmentend = stripslashes($appointmentend);
        $appointmentend = mysql_real_escape_string($appointmentend);

        $userid = $_SESSION['userid'];

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
			echo "<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/dashboard_student.php'>Back</a></div>";

		}else{
        
			while ($row = mysql_fetch_array($resultResearchId)) 
			{
				$research_code = $row['research_code'];
				$facultyId = $row['faculty_id'];
			}   

			$queryInsert = "INSERT into `appointments` (
					research_code,
					faculty_id,
					appoint_date, 
					appoint_time_fr, 
					appoint_time_to, 
					status,
					timestamp
					) VALUES (
					'$research_code',
					'$facultyId',
					'$appointmentdate', 
					'$appointmentstart', 
					'$appointmentend', 
					'pending',
					now())";
			$resultInsert = mysql_query($queryInsert);
			if($resultInsert){
				header("Location: http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/view_appointment.php");
			}else{
				echo mysql_error();
			}
		}
    }else{

			$queryAppointment = "SELECT * FROM `appointments`WHERE research_id='$researchId'";
			$resultAppointment = mysql_query($queryAppointment) or die(mysql_error());
			$rows = mysql_num_rows($resultAppointment);
			
			if($rows==0){
				echo "No Appoinment made.<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/insert_appointment.php'>Add Appointment.</a></div>";
				echo "<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/dashboard_student.php'>Back</a></div>";
			}else{
			
				echo "<table class='table' border='1' style='width:100%'>";
				echo "   <tr>";
				echo "      <td align='center'>";   
				echo "          <strong>Date</strong>";
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

					echo "   <tr>";
					echo "      <td align='center'>";   
					echo            $row['appoint_date'];
					echo "      </td>";
					echo "      <td align='center'>";   
					echo            $row['appoint_time_fr'];
					echo "      </td>";
					echo "      <td align='center'>";   
					echo            $row['appoint_time_to'];
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

				if($resultAppointment){
					echo "<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/dashboard_student.php'>Back</a></div>";
				}else{
					echo mysql_error();
				}
			}
		}
    // }else{

?>

<div class="form container">
<h4>Add Appointment</h4>
<form name="registration" action="" method="post">
<input type="date" placeholder="YYYY-MM-DD" name="appointmentdate" data-date-split-input="true" required/> <br/><br/>
<input type="time" name="appointmentstart" placeholder="Start Time" required/> <br/><br/>
<input type="time" name="appointmentend" placeholder="End Time" required/> <br/><br/>
<input type="submit" name="submit" value="Register" />
</form>
<?php echo "<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/dashboard_student.php'>Back</a></div>";?>
</div>
<?php //} ?>
</body>
</html>