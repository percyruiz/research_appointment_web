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
	<div  class="container">

		<?php
			// require('db.php');
			//access from root folder
			$path = $_SERVER['DOCUMENT_ROOT'];
			$path .= "/db.php";
			require($path);
			
			$userid = $_SESSION['userid'];

			if (isset($_POST['research'])){

				$research = $_POST['research'];
				$researchtype = "Thesis 1";
				$schoolyear = $_POST['schoolyear'];
				$semester = $_POST['semester'];
				$facultyId = $_POST['adviser'];
				$researchCode = $_POST['research_code'];

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
						research_code
						) VALUES (
						'$research', 
						'$researchtype', 
						'$schoolyear', 
						'$semester', 
						'$facultyId',
						'$researchCode')";
				$resultInsert = mysql_query($queryInsert);
				$research_id = mysql_insert_id();
				if($resultInsert){
					$queryInsertStudent = "INSERT into `users` (
						user_type, 
						research_code,
						username,
						research_id,
						faculty_id
						) VALUES (
						'STUDENT', 
						'$researchCode',
						'$researchCode',
						'$research_id',
						'$facultyId')";
					$resultInsertStudent = mysql_query($queryInsertStudent);
					echo mysql_error();
					echo "add successful!";
				}else{
					echo mysql_error();
				}
			}
		?>


		<p>
			<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/index.php';?>">Home</a> |	 
			<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/consultation_history.php';?>">Consultation History</a> |
			<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/dashboard_admin.php';?>">Manage Faculty</a> |	 
			<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/insert_research.php';?>">Add Research</a> |
			<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a>
		</p>
		<div class="row">
			<div class="col-md-3">
				<h4>Add Research</h4>
				<form name="registration" action="" method="post">
					<input type="text" name="research_code" placeholder="Research Code" required /> <br/><br/>
					<input type="text" name="research" placeholder="Research Title" required /> <br/><br/>
					<?php
							$queryFaculty = "SELECT * FROM `users` WHERE user_type='FACULTY'";
							$resultFaculty = mysql_query($queryFaculty) or die(mysql_error());
							$rows = mysql_num_rows($resultFaculty);

							if($rows > 0){
								echo "<select name='adviser'>";
								while ($row = mysql_fetch_array($resultFaculty)) 
								{
									$faculty = $row['fname']." ".$row['mname']." ".$row['lname'];
									$facultyId = $row['user_id'];
									echo "<option value='$facultyId'>$faculty</option><br/>";
								}
								echo "</select><br/><br/>";
							}

					?>
					<input type="text" name="schoolyear" placeholder="School Year" required/> <br/><br/>
					<select name="semester" required>
					  <option value="firstsem">1st Sem</option>
					  <option value="secondsem">2nd Sem</option>
					  <option value="summer">Summer</option>
					</select> <br/><br/>
					<input type="submit" name="submit" value="Register" />
				</form>
			</div>
			<div class="col-md-9">
				<h4>Researches Registered</h4>
				<?php
					$query = "SELECT * FROM `researches`";
					$result = mysql_query($query) or die(mysql_error());
					echo "<table class='table' border='1' style='width:100%'>";
					echo "	 <tr>";
					echo "	 	<td align='center'>";	
					echo "	 		<strong>id</strong>";
					echo "	 	</td>";
					echo "	 	<td align='center'>";	
					echo "	 		<strong>research code</strong>";
					echo "	 	</td>";
					echo "	 	<td align='center'>";	
					echo "	 		<strong>research title</strong>";
					echo "	 	</td>";
					echo "	 	<td align='center'>";	
					echo "	 		<strong>research type</strong>";
					echo "	 	</td>";
					echo "	 	<td align='center'>";	
					echo "	 		<strong>percentage</strong>";
					echo "	 	</td>";
					echo "	 	<td align='center'>";	
					echo "	 		<strong>school year</strong>";
					echo "	 	</td>";
					echo "	 	<td align='center'>";	
					echo "	 		<strong>sem type</strong>";
					echo "	 	</td>";
					echo "	 	<td align='center'>";	
					echo "	 		<strong>faculty</strong>";
					echo "	 	</td>";
					echo "	 	<td align='center'>";	
					echo "	 		<strong>student no</strong>";
					echo "	 	</td>";
					echo "	 	<td align='center'>";	
					echo "	 		<strong>action</strong>";
					echo "	 	</td>";
					echo "	 </tr>";
					while ($row = mysql_fetch_array($result)) {
						echo "   <tr>";
						echo "      <td style='padding: 5px;'>";
						echo 			$row['research_id'];
						echo "      </td>";
						
						echo "      <td style='padding: 5px;'>";
						echo 			$row['research_code'];
						echo "      </td>";

						echo "      <td style='padding: 5px;'>";
						echo 			$row['research_title'];
						echo "      </td>";

						echo "      <td style='padding: 5px;'>";
						echo 			$row['research_type'];
						echo "      </td>";

						echo "      <td style='padding: 5px;'>";
						echo 			$row['percentage'];
						echo "      </td>";

						echo "      <td style='padding: 5px;'>";
						echo 			$row['school_year'];
						echo "      </td>";

						echo "      <td style='padding: 5px;'>";
						echo 			$row['sem_type'];
						echo "      </td>";
						
						echo "      <td style='padding: 5px;'>";
						echo 			$row['faculty_id'];
						echo "      </td>";
						
						echo "      <td style='padding: 5px;'>";
						echo 			$row['student_no'];
						echo "      </td>";
						
						echo "      <td style='padding: 5px;'>";
						echo 			"<a href=''>link here bitch</a>";
						echo "      </td>";

						echo "   </tr>";
					}
					echo "<table>";
				?>
			</div>
		</div>
	</div>
</body>
</html>