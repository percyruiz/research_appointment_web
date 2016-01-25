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
<?php
	// require('db.php');
	//access from root folder
	$path = $_SERVER['DOCUMENT_ROOT'];
	$path .= "/db.php";
	require($path);
   
    // If form submitted, insert values into the database.
     // if (isset($_POST['research'])){

        $userid = $_SESSION['userid'];

        $queryStudentNum = "SELECT * FROM `users` WHERE user_id='$userid'";
       	$resultStudentNum = mysql_query($queryStudentNum) or die(mysql_error());
    	$rows = mysql_num_rows($resultStudentNum);
    		
    	while ($row = mysql_fetch_array($resultStudentNum)) 
    	{
    		$student_no = $row['student_no'];
    	}
		
        $queryResearchId = "SELECT * FROM `researches`WHERE student_no='$student_no'";
        $resultResearchId = mysql_query($queryResearchId) or die(mysql_error());
        $rows = mysql_num_rows($resultResearchId);
        
		if($rows == 0){
			echo "No Research added.<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/insert_research.php'>Add Research.</a></div>";
			echo "<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/dashboard_student.php'>Back</a></div>";
		}else{
		
			while ($row = mysql_fetch_array($resultResearchId)) 
			{
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
</div>
</body>
</html>