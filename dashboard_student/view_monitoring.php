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
        <li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/view_research.php';?>">Research</a></li>
        <li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/choose_appointment.php';?>">Appointments</a></li>
        <li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/insert_members.php';?>">Add Members</a></li>
        <li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/view_members.php';?>">View Members</a></li>
        <li class="active"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/view_monitoring.php';?>">View Monitoring</a></li>
        <li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/change_password_form.php';?>">Change Password</a></li>
        <li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a></li>
    </ul>

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
		
        $querySelect = "SELECT * FROM `researches`WHERE student_no='$student_no'";
        $result = mysql_query($querySelect) or die(mysql_error());
        $rows = mysql_num_rows($result);
        while ($row = mysql_fetch_array($result)) {
            $researchCode = $row['research_code'];
            $researchTitle = $row['research_title'];
        }

        $queryMonitoring = "SELECT * FROM `appointments` WHERE research_code='$researchCode' AND status='done' ORDER BY appointment_id ASC";
        $resultMonitoring = mysql_query($queryMonitoring) or die(mysql_error());

        if($resultMonitoring){
            echo "<div class='row'>";
			echo "<div class='col-md-12'>";
			echo "	<h5> $researchTitle - Monitoring</h5>";

            echo "<table class='table table-striped table-hover' style='width:100%'>";
            echo "	 <thead>";
            echo "   <tr>";
            echo "      <th>";
            echo "          <strong>DATE</strong>";
            echo "      </th>";
            echo "      <th>";
            echo "          <strong>DURATION</strong>";
            echo "      </th>";
            echo "      <th>";
            echo "          <strong>COMMENTS</strong>";
            echo "      </th>";
            echo "      <th>";
            echo "          <strong>PROJECT PERCENTAGE</strong>";
            echo "      </th>";
            echo "      <th>";
            echo "          <strong>SIGNED BY</strong>";
            echo "      </th>";
            echo "   </tr>";
            echo "	 </thead>";
            echo "	 <tbody>";
            while ($rowMonitoring = mysql_fetch_array($resultMonitoring))
            {

                echo "   <tr>";
                echo "      <td>";
                echo           $rowMonitoring['appoint_date'];
                echo "      </td>";

                $time_fr = $rowMonitoring['appoint_time_fr'];
                $time_to = $rowMonitoring['appoint_time_to'];
                $time_min = (strtotime($time_to) - strtotime($time_fr)) / 60;

                echo "      <td>";
                echo           $time_min . " mins";
                echo "      </td>";
                echo "      <td>";
                echo            $rowMonitoring['remarks'];
                echo "      </td>";
                echo "      <td>";
                echo            $rowMonitoring['percentage']."%";
                echo "      </td>";

                $facultyId = $rowMonitoring['faculty_id'];

                $queryFaculty = "SELECT * FROM `users` WHERE faculty_id='$facultyId'";
                $resultFaculty = mysql_query($queryFaculty) or die(mysql_error());

                while ($rowFaculty = mysql_fetch_array($resultFaculty))
                {
                    $faculty = $rowFaculty['fname']." ".$rowFaculty['mname']." ".$rowFaculty['lname'];
                }

                echo "      <td>";
                echo            $faculty;
                echo "      </td>";
				echo "   </tr>";
			}
            echo "</tbody>";
            echo "</table>";
        }else{
        	echo mysql_error();
        }
    // }else{
?>
</div>
</body>
</html>