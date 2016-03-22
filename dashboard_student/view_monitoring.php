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

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">STUDENT</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/view_research.php';?>"> <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> Research</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/choose_appointment.php';?>"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Appointments</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/insert_members.php';?>"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Members</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/view_members.php';?>"> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> View Members</a></li>
					<li class="active"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/view_monitoring.php';?>"> <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> View Monitoring</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/change_password_form.php';?>"> <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Change Password</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>"> <span class="glyphicon glyphicon-off" aria-hidden="true"></span> Logout</a></li>
				</ul>
            </div>
        </div>
    </nav>
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
        <input placeholder="year" class="form-control-static small" style="width:70px" type="number" name="year1"/> to
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
        <input placeholder="year" class="form-control-static small" style="width:70px" type="number" name="year2"/>
        <input class="btn btn-primary" type="submit" name="submit" value="Filter" /><br/><br/>
    </form>

<?php
        // require('db.php');
        //access from root folder
        $path = $_SERVER['DOCUMENT_ROOT'];
        $path .= "/db.php";
        require($path);

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

                $dateNow = strtotime($rowMonitoring['appoint_date']);
                if( !$hasFilter || ($hasFilter && $date2>=$dateNow && $date1<=$dateNow) ) {

                    echo "   <tr>";
                    echo "      <td>";
                    echo $rowMonitoring['appoint_date'];
                    echo "      </td>";

                    $time_fr = $rowMonitoring['appoint_time_fr'];
                    $time_to = $rowMonitoring['appoint_time_to'];
                    $time_min = (strtotime($time_to) - strtotime($time_fr)) / 60;

                    echo "      <td>";
                    echo $time_min . " mins";
                    echo "      </td>";
                    echo "      <td>";
                    echo $rowMonitoring['remarks'];
                    echo "      </td>";
                    echo "      <td>";
                    echo $rowMonitoring['percentage'] . "%";
                    echo "      </td>";

                    $facultyId = $rowMonitoring['faculty_id'];

                    $queryFaculty = "SELECT * FROM `users` WHERE faculty_id='$facultyId'";
                    $resultFaculty = mysql_query($queryFaculty) or die(mysql_error());

                    while ($rowFaculty = mysql_fetch_array($resultFaculty)) {
                        $faculty = $rowFaculty['fname'] . " " . $rowFaculty['mname'] . " " . $rowFaculty['lname'];
                    }

                    echo "      <td>";
                    echo $faculty;
                    echo "      </td>";
                    echo "   </tr>";
                }
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