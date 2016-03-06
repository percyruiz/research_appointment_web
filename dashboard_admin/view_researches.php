<?php
/*
Author: Javed Ur Rehman
Website: https://htmlcssphptutorial.wordpress.com
*/
?>

<?php
//access from root folder
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/db.php";
require($path);
include("auth.php"); //include auth.php file on all secure pages
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard - View Records</title>
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

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">ADMIN</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/dashboard_admin.php';?>">Manage Faculty</a></li>
                    <li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/consultation_history.php';?>">Consultation History</a></li>
                    <li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/student_profiles.php';?>">Manage Student</a></li>
                    <li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/insert_research.php';?>">Add Research</a></li>
                    <li class="active"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/view_researches.php';?>">View Monitoring</a></li>
                    <li> <a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php
            $query = "SELECT * FROM `researches` ORDER BY `research_title` ASC ";
            $result = mysql_query($query) or die(mysql_error());
        ?>

        <h4>List of Researches</h4>

        <?php $user_id = $_SESSION['userid'];

        $to_pdf = '';
        $to_pdf = $to_pdf . "<table class='table table-striped table-hover' style='width:100%'>";
        $to_pdf = $to_pdf . "	 <thead>";
        $to_pdf = $to_pdf . "	 <tr>";
        $to_pdf = $to_pdf . "	 	<th>";
        $to_pdf = $to_pdf . "	 		<strong>TITLE</strong>";
        $to_pdf = $to_pdf . "	 	</th>";
        $to_pdf = $to_pdf . "	 	<th>";
        $to_pdf = $to_pdf . "	 		<strong>RESEARCH TYPE</strong>";
        $to_pdf = $to_pdf . "	 	</th>";
        $to_pdf = $to_pdf . "	 	<th>";
        $to_pdf = $to_pdf . "	 		<strong>SCHOOL YEAR/SEM</strong>";
        $to_pdf = $to_pdf . "	 	</th>";
        $to_pdf = $to_pdf . "	 	<th>";
        $to_pdf = $to_pdf . "	 		<strong>GROUP LEADER</strong>";
        $to_pdf = $to_pdf . "	 	</th>";
        $to_pdf = $to_pdf . "	 </tr>";
        $to_pdf = $to_pdf . "	 </thead>";
        $to_pdf = $to_pdf . "	 <tbody>";
        while ($row = mysql_fetch_array($result)) {

            $research_code = $row['research_code'];
            $to_pdf = $to_pdf . "   <tr>";
            $to_pdf = $to_pdf . "      <td width='30%' style='padding: 5px;'>";
            $to_pdf = $to_pdf . 			"<a href='research_monitoring.php?id=$research_code'>" .$row['research_title'] . "</a>";
            $to_pdf = $to_pdf . "      </td>";

            $to_pdf = $to_pdf . "      <td width='20%' style='padding: 5px; align:center'>";
            $to_pdf = $to_pdf . 			$row['research_type'];
            $to_pdf = $to_pdf . "      </td>";

            $to_pdf = $to_pdf . "      <td width='10%' style='padding: 5px;'>";
            $to_pdf = $to_pdf . 			$row['school_year'] . "/<br/>" .$row['sem_type'];
            $to_pdf = $to_pdf . "      </td>";

            $to_pdf = $to_pdf . "      <td width='5%' style='padding: 5px;'>";
            $student_no = $row['student_no'];
            $result_student = mysql_query("SELECT * FROM `users` WHERE student_no='$student_no' LIMIT 1");
            $row_student = mysql_fetch_assoc($result_student);
            $to_pdf = $to_pdf . 			$row_student['lname']. ", ". $row_student['fname'] . " " . $row_student['mname'];
            $to_pdf = $to_pdf . "      </td>";
            $to_pdf = $to_pdf . "   </tr>";
        }
        $to_pdf = $to_pdf . "</tbody>";
        $to_pdf = $to_pdf . "</table>";
        echo $to_pdf;
        ?>
    </div>
</div>
</body>
</html>

