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
            $path = $_SERVER['DOCUMENT_ROOT'];
            $path .= "/db.php";
            require($path);

            $userid = $_SESSION['userid'];
        ?>

        <h4>Choose Faculty</h4>

        <?php
            //select student
            $result_r = mysql_query("SELECT * FROM `users` WHERE user_id='$userid' LIMIT 1");
            $student = mysql_fetch_assoc($result_r);
            $student_no = $student['student_no'];

            //select research
            $result_r = mysql_query("SELECT * FROM `researches` WHERE student_no='$student_no' LIMIT 1");
            $research = mysql_fetch_assoc($result_r);
            $faculty_id = $research['faculty_id'];
            $research_id = $research['research_id'];

            //select faculty
            $result_r = mysql_query("SELECT * FROM `users` WHERE user_id='$faculty_id' LIMIT 1");
            $faculty = mysql_fetch_assoc($result_r);
            $fname = $faculty['fname'];
            $lname = $faculty['lname'];
            $mname = $faculty['mname'];

            //select faculty
            $queryPanel = "SELECT * FROM `panels` WHERE research_id='$research_id'";
            $resultPanel = mysql_query($queryPanel) or die(mysql_error());

        ?>

        <h6>ADVISER</h6>
        <form action='insert_appointment.php' method='post' name='insert_appointment'>
            <input type='hidden' name='consultation_type' value='advisee'/>
            <input type='hidden' name='faculty_id' value='<?php echo $faculty_id;?>'/>
            <input type='submit' name='status' value='<?php echo $lname . ", " . $fname . " " . $mname;?>'/>
        </form><br/>

        <h6>PANELS</h6>
        <?php
            while ($row = mysql_fetch_array($resultPanel)) {
                $panel_id = $row['user_id'];
                $result_r = mysql_query("SELECT * FROM `users` WHERE `user_id`='$panel_id' LIMIT 1");
                $panel = mysql_fetch_assoc($result_r);
                ?>

                <form action='insert_appointment.php' method='post' name='insert_appointment'>
                    <input type='hidden' name='consultation_type' value='panel'/>
                    <input type='hidden' name='faculty_id' value='<?php echo $panel_id;?>'/>
                    <input type='submit' name='status' value='<?php echo $row['role'] . ': ' . $panel['lname'] . ", " . $panel['fname'] . " " . $panel['mname'];?>'/>
                </form><br/>
        <?php
            }
        ?>

    </div>
</body>
</html>
