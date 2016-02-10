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
		
        $querySelect = "SELECT * FROM `researches`WHERE student_no='$student_no'";
        $result = mysql_query($querySelect) or die(mysql_error());
        $rows = mysql_num_rows($result);

        if($result){
            echo "<div class='form'><h4>HERE ARE THE RESULTS.</h4><br/>";
            echo "<table class='table' border='1' style='width:100%'>";
            echo "   <tr>";
            echo "      <td align='center'>";   
            echo "          <strong>Title</strong>";
            echo "      </td>";
            echo "      <td align='center'>";   
            echo "          <strong>Research Type</strong>";
            echo "      </td>";
            echo "      <td align='center'>";   
            echo "          <strong>Percentage</strong>";
            echo "      </td>";
            echo "      <td align='center'>";   
            echo "          <strong>SY</strong>";
            echo "      </td>";
            echo "      <td align='center'>";   
            echo "          <strong>Sem Type</strong>";
            echo "      </td>";
            echo "      <td align='center'>";   
            echo "          <strong>Adviser</strong>";
            echo "      </td>";
            echo "      <td align='center'>";   
            echo "          <strong>Student No</strong>";
            echo "      </td>";
			echo "      <td align='center'>";   
            echo "          <strong>Panels</strong>";
            echo "      </td>";
            echo "   </tr>";
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
				
				$queryFaculty = "SELECT * FROM `users` WHERE user_id='$facultyId'";
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
				
				$researchId = $row['research_id'];
				
				$queryPanel = "SELECT * FROM `panels` where `research_id`=$researchId";
				$resultPanel = mysql_query($queryPanel) or die(mysql_error());
				while ($rowPanel = mysql_fetch_array($resultPanel)) {
					$panel_faculty_id = $rowPanel['user_id'];
					echo "<strong>".$rowPanel['role'] . ":</strong> ";
					$resultFaculty = mysql_query("SELECT * FROM `users` WHERE user_id='$panel_faculty_id' LIMIT 1");
					$faculty = mysql_fetch_assoc($resultFaculty);
					echo 			$faculty['lname'] . ', ' .$faculty['fname'] . ' ' .  $faculty['mname'];
					echo "<br/>";
				}
					
				echo "      </td>";
				echo "   </tr>";
			}
            
            echo "</table>";
			
			/*
			if($rows == 0){
				echo "<br/>No Research Researh.<a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/insert_research.php'><br/>Add Research.</a></div>";
			}else{
				echo "<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/update_research.php'>Edit Research</a></div>";
				echo "<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/delete_research.php'>Delete Research</a></div>";
			}
			*/
            echo "<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/dashboard_student.php'>Back</a></div>";
        }else{
        	echo mysql_error();
        }
    // }else{
?>
</div>
</body>
</html>