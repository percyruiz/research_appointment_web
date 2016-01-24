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
     if (isset($_POST['research'])){

		    $research = $_POST['research'];
        $researchtype = $_POST['researchtype'];
        $schoolyear = $_POST['schoolyear'];
        $semester = $_POST['semester'];
        $facultyId = $_POST['adviser'];
        echo $facultyId . "kingina";

		    $research = stripslashes($research);
        $research = mysql_real_escape_string($research);

        $researchtype = stripslashes($researchtype);
        $researchtype = mysql_real_escape_string($researchtype);

        $schoolyear = stripslashes($schoolyear);
        $schoolyear = mysql_real_escape_string($schoolyear);

        $semester = stripslashes($semester);
        $semester = mysql_real_escape_string($semester);

        $facultyId = stripslashes($facultyId);
        $facultyId = mysql_real_escape_string($facultyId);

        $userid = $_SESSION['userid'];

        $queryStudentNum = "SELECT * FROM `users` WHERE user_id='$userid'";
       	$resultStudentNum = mysql_query($queryStudentNum) or die(mysql_error());
    		$rows = mysql_num_rows($resultStudentNum);
    		
    		while ($row = mysql_fetch_array($resultStudentNum)) 
    		{
    			$student_no = $row['student_no'];  
    		}
		
        $queryInsert = "INSERT into `researches` (
				research_title, 
				research_type, 
				school_year, 
				sem_type,
                faculty_id, 
				student_no
				) VALUES (
				'$research', 
				'$researchtype', 
				'$schoolyear', 
				'$semester', 
                '$facultyId',
				'$student_no')";
        $resultInsert = mysql_query($queryInsert);
        if($resultInsert){
            header("Location: http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/view_research.php");
        }else{
        	echo mysql_error();
        }
    }else{
?>

<div  class="container">
<h4>Register your Research</h4>
<form name="registration" action="" method="post">
<input type="text" name="research" placeholder="Research" required /> <br/><br/>
<select name="researchtype">
  <option value="Thesis 1">Thesis 1</option>
  <option value="Thesis 2">Thesis 2</option>
</select> <br/><br/>
<?php
        $queryFaculty = "SELECT * FROM `users` WHERE user_type='FACULTY'";
        $resultFaculty = mysql_query($queryFaculty) or die(mysql_error());
        $rows = mysql_num_rows($resultFaculty);

        echo "<select name='adviser'>";
        while ($row = mysql_fetch_array($resultFaculty)) 
        {
            $faculty = $row['fname']." ".$row['mname']." ".$row['lname'];
            $facultyId = $row['user_id'];
            echo "<option value='$facultyId'>$faculty</option><br/>";
        }
        echo "</select><br/>";


?>
<input type="text" name="schoolyear" placeholder="School Year" required/> <br/><br/>
<select name="semester" required>
  <option value="firstsem">1st Sem</option>
  <option value="secondsem">2nd Sem</option>
  <option value="summer">Summer</option>
</select> <br/><br/>
<input type="submit" name="submit" value="Register" />
</form>
<?php echo "<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/dashboard_student.php'>Back</a></div>";?>
</div>
<?php } ?>
</body>
</html>