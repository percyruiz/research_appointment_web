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
        <li class="active"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/view_research.php';?>">Research</a></li>
        <li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/choose_appointment.php';?>">Appointments</a></li>
        <li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/insert_members.php';?>">Add Members</a></li>
        <li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/view_members.php';?>">View Members</a></li>
        <li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/view_monitoring.php';?>">View Monitoring</a></li>
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

        if($result){
            echo "<div class='form'><h4>HERE ARE THE RESULTS.</h4><br/>";
            echo "<table class='table table-striped table-hover' style='width:100%'>";
            echo "	 <thead>";
            echo "   <tr>";
            echo "      <th>";
            echo "          <strong>Title</strong>";
            echo "      </th>";
            echo "      <th>";
            echo "          <strong>Research Type</strong>";
            echo "      </th>";
            echo "      <th>";
            echo "          <strong>Percentage</strong>";
            echo "      </th>";
            echo "      <td align='center'>";   
            echo "          <strong>SY</strong>";
            echo "      </td>";
            echo "      <th>";
            echo "          <strong>Sem Type</strong>";
            echo "      </th>";
            echo "      <th>";
            echo "          <strong>Adviser</strong>";
            echo "      </th>";
            echo "      <th>";
            echo "          <strong>Student No</strong>";
            echo "      </th>";
			echo "      <th>";
            echo "          <strong>Panels</strong>";
            echo "      </th>";
            echo "   </tr>";
            echo "	 </thead>";
            echo "	 <tbody>";
            while ($row = mysql_fetch_array($result)) 
            {
                echo "   <tr>";
                echo "      <td align='center'>";   
                echo           $row['research_title'];
                echo "      </td>";
                echo "      <td align='center'>";   
                echo            $row['research_type'];
                echo "      </td>";
                echo "      <td align='center'>";   
                echo            $row['percentage'];
                echo "      </td>";
                echo "      <td align='center'>";   
                echo            $row['school_year'];
                echo "      </td>";
                echo "      <td align='center'>";   
                echo            $row['sem_type'];
                echo "      </td>";
                echo "      <td align='center'>";
				
				$facultyId = $row['faculty_id'];
				
				$queryFaculty = "SELECT * FROM `users` WHERE faculty_id='$facultyId'";
				$resultFaculty = mysql_query($queryFaculty) or die(mysql_error());
				$rows = mysql_num_rows($resultFaculty);

				if($rows > 0){
					while ($rowFac = mysql_fetch_array($resultFaculty)) 
					{
						$faculty = $rowFac['fname']." ".$rowFac['mname']." ".$rowFac['lname'];
					}
				}else{
					echo "Adviser Unavailable";
				}
				
                echo            $faculty;
                echo "      </td>";
                echo "      <td align='center'>";   
                echo            $row['student_no'];
                echo "      </td>";
				echo "      <td align='center'>";

                $research_code = $row['research_code'];
				
				$queryPanel = "SELECT * FROM `panels` where `research_code`=$research_code";
				$resultPanel = mysql_query($queryPanel) or die(mysql_error());
				while ($rowPanel = mysql_fetch_array($resultPanel)) {
					$panel_faculty_id = $rowPanel['faculty_id'];
					echo "<strong>".$rowPanel['user_type'] . ":</strong> ";
					$resultFaculty = mysql_query("SELECT * FROM `users` WHERE faculty_id='$panel_faculty_id' LIMIT 1");
					$faculty = mysql_fetch_assoc($resultFaculty);
					echo 			$faculty['lname'] . ', ' .$faculty['fname'] . ' ' .  $faculty['mname'];
					echo "<br/>";
				}
					
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