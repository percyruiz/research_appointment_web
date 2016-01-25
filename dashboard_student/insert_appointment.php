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
			  $researchId = $row['research_id']; 
			  $facultyId = $row['faculty_id']; 
			}	

			$queryInsert = "INSERT into `appointments` (
					research_id,
					faculty_id,
					appoint_date, 
					appoint_time_fr, 
					appoint_time_to, 
					status
					) VALUES (
					'$researchId',
					'$facultyId',
					'$appointmentdate', 
					'$appointmentstart', 
					'$appointmentend', 
					'pending')";
			$resultInsert = mysql_query($queryInsert);
			if($resultInsert){
				header("Location: http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/view_appointment.php");
			}else{
				echo mysql_error();
			}
		}
    }else{
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
<?php } ?>
</body>
</html>