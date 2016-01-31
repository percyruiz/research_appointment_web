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
   
    // If form submitted, update values into the database.
	if (isset($_POST['research_title'])){
		
	$research = $_POST['research_title'];
	$research_id = $_POST['research_id'];
	$researchtype = $_POST['researchtype'];
	$schoolyear = $_POST['schoolyear'];
	$semester = $_POST['semester'];
	$facultyId = $_POST['adviser'];

	$researchName = stripslashes($research);
    $researchName = mysql_real_escape_string($researchName);
	
	$research_id = stripslashes($research_id);
    $research_id = mysql_real_escape_string($research_id);

	$researchtype = stripslashes($researchtype);
	$researchtype = mysql_real_escape_string($researchtype);

	$schoolyear = stripslashes($schoolyear);
	$schoolyear = mysql_real_escape_string($schoolyear);

	$semester = stripslashes($semester);
	$semester = mysql_real_escape_string($semester);

	$facultyId = stripslashes($facultyId);
	$facultyId = mysql_real_escape_string($facultyId);

		
		$queryUpdate = "UPDATE researches SET research_title='$researchName', research_type='$researchtype', school_year='$schoolyear', 
			sem_type='$semester' WHERE research_id = '$research_id'";
		$resultUpdate = mysql_query($queryUpdate) or die(mysql_error());
		
		if($resultUpdate){
            header("Location: http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/view_research.php");
        }else{
        	echo mysql_error();
        }
		
	}else{
		if($result){
?>

	<form name='registration' method='post'>
    <div class='form'><h4>HERE ARE THE RESULTS.</h4><br/>
	<table class='table' border='1' style='width:100%'>
		<tr>
			<td align='center'>
			<strong>Title</strong>
			</td>
			<td align='center'>
			<strong>Research Type</strong>
			</td>
			<td align='center'>
			<strong>Percentage</strong>
			</td>
			<td align='center'>
			<strong>SY</strong>
			</td>
			<td align='center'>
			<strong>Sem Type</strong>
			</td>
			<td align='center'>
			<strong>Adviser</strong></td>
			<td align='center'>
			<strong>Student No </strong>
			</td>
		</tr>
		<?php 
		while ($row = mysql_fetch_array($result)) 
            {
                echo "   <tr>";
                echo "      <td align='center'>";   
                echo			'<input type="text" name="research_title" value="'.$row['research_title'].'" />';
				echo 			'<input type="hidden" name="research_id" value="'.$row['research_id'].'" />';
                echo "      </td>";
                echo "      <td align='center'>";   
                echo            "<select name='researchtype'>";
				if($row['research_type'] == 'Thesis 1'){
					echo				"<option selected = 'selected' value='Thesis 1'>Thesis 1</option>";
					echo				"<option value='Thesis 2'>Thesis 2</option>";
				}else if($row['research_type'] == 'Thesis 2'){
					echo				"<option value='Thesis 1'>Thesis 1</option>";
					echo				"<option selected = 'selected' value='Thesis 2'>Thesis 2</option>";
				}else{
					echo				"<option value='Thesis 1'>Thesis 1</option>";
					echo				"<option value='Thesis 2'>Thesis 2</option>";
				}
				echo			"</select>";
                echo "      </td>";
                echo "      <td align='center'>";   
                echo            $row['percentage'];
                echo "      </td>";
                echo "      <td align='center'>";   
                echo		'<input type="text" name="schoolyear" value="'.$row['school_year'].'" />';
                echo "      </td>";
                echo "      <td align='center'>";
				echo "		<select name='semester' required>";
				if($row['sem_type'] == 'firstsem'){
					echo	"<option selected='selected' value='firstsem'>1st Sem</option>";
					echo	"<option value='secondsem'>2nd Sem</option>";
					echo	"<option value='summer'>Summer</option>";
				}else if($row['sem_type'] == 'secondsem'){					
					echo	"<option value='firstsem'>1st Sem</option>";
					echo	"<option selected='selected' value='secondsem'>2nd Sem</option>";
					echo	"<option value='summer'>Summer</option>";
				}else{
					echo	"<option value='firstsem'>1st Sem</option>";
					echo	"<option value='secondsem'>2nd Sem</option>";
					echo	"<option selected='selected' value='summer'>Summer</option>";
				}
				echo "		</select>";
                echo "      </td>";
                echo "      <td align='center'>"; 
				
				$facultyId = $row['faculty_id'];
				
				$queryFaculty = "SELECT * FROM `users` WHERE user_id='$facultyId'";
				$resultFaculty = mysql_query($queryFaculty) or die(mysql_error());
				$rows = mysql_num_rows($resultFaculty);

				if($rows > 0){
					//echo "<select name='adviser'>";
					while ($rowFac = mysql_fetch_array($resultFaculty)) 
					{
						$faculty = $rowFac['fname']." ".$rowFac['mname']." ".$rowFac['lname'];
						//$facultyIdFromUsers = $rowFac['user_id'];
						
						//if($facultyIdFromUsers == $row['faculty_id']){
						//	echo "<option selected= 'selected' value='$facultyIdFromUsers'>$faculty</option><br/>";
						//}else{
						//	echo "<option value='$facultyIdFromUsers'>$faculty</option><br/>";
						//}
					}
					//echo "</select><br/>";
				}else{
					echo "Adviser Unavailable";
				}
				echo            $faculty;
                echo "      </td>";
                echo "      <td align='center'>";   
                echo            $row['student_no'];
                echo "      </td>";
                echo "   </tr>";
            }
            
            echo "<table>";
			echo "<input type='submit' name='submit' value='Register' />";
			echo "</form>";
            echo "<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/dashboard_student.php'>Back</a></div>";
        }else{
        	echo mysql_error();
        }
	}?>
</div>
</body>
</html>