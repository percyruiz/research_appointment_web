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
			$researchcodeT1 = $_POST['researchcodeT1'];
			$researchtitleT1 = $_POST['researchtitleT1'];
			$researchtypeR1 = $_POST['researchtypeR1'];
			$student_num = $_POST['student_no'];
			$research_id1 = $_POST['research_id1'];

			$researchtypeT1 = "Thesis 1";

			if($researchtypeR1 == $researchtypeT1){
				$researchtype = "Thesis 2";
			}else{
				$researchtype = "Capstone 2";
			}
			
			if (isset($_POST['researchTitle2'])){

				$researchTitle2 = $_POST['researchTitle2'];
				$researchtypeR2 = $_POST['researchtypeR2'];
				$schoolyear = $_POST['schoolyear'];
				$semester = $_POST['semester'];
				$facultyId = $_POST['adviser'];
				$researchCode = $_POST['research_code'];
				
				$student_num = $_POST['student_no'];
				$research_id1 = $_POST['research_id1'];

				$panel1 = $_POST['panel1'];
				$panel2 = $_POST['panel2'];
				$panel3 = $_POST['panel3'];

				$researchTitle2 = stripslashes($researchTitle2);
				$researchTitle2 = mysql_real_escape_string($researchTitle2);

				$researchtypeR2 = stripslashes($researchtypeR2);
				$researchtypeR2 = mysql_real_escape_string($researchtypeR2);
				
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
						research_code,
						student_no,
						on_going
						) VALUES (
						'$researchTitle2', 
						'$researchtypeR2',
						'$schoolyear', 
						'$semester', 
						'$facultyId',
						'$researchCode',
						'$student_num',
						'1')";
				$resultInsert = mysql_query($queryInsert);
				$research_id = mysql_insert_id();
				
				$queryUpdateResearch1 = "UPDATE `researches` SET `on_going`= 0 WHERE research_id=$research_id1";
				echo mysql_error();
				$resultUpdateResearch1 = mysql_query($queryUpdateResearch1);
				
				if($resultInsert){

					$queryInsert = "INSERT into `panels` (
						research_id,
						user_id,
						role
						) VALUES (
						'$research_id',
						'$panel1',
						'LEAD PANEL')";
					$resultInsert = mysql_query($queryInsert);

					$queryInsert = "INSERT into `panels` (
						research_id,
						user_id,
						role
						) VALUES (
						'$research_id',
						'$panel2',
						'MEMBER PANEL')";
					$resultInsert = mysql_query($queryInsert);

					$queryInsert = "INSERT into `panels` (
						research_id,
						user_id,
						role
						) VALUES (
						'$research_id',
						'$panel3',
						'MEMBER PANEL')";
					$resultInsert = mysql_query($queryInsert);


					echo "Add Success";
					header("Location: http://". $_SERVER['SERVER_NAME'] ."/dashboard_admin/insert_research.php");
				}else{
					echo mysql_error();
				}
			}
		?>


		<p>
			<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/index.php';?>">Home</a> |	 
			<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/consultation_history.php';?>">Consultation History</a> |
			<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/dashboard_admin.php';?>">Manage Faculty</a> |
			<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/student_profiles.php';?>">Manage Student</a> |			
			<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/insert_research.php';?>">Add Research</a> |
			<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a>
		</p>
		<div class="row">
			<div class="col-md-3">
				<h4>Add Research 2</h4>
				<form name="registration" action="" method="post">
				<?php
					echo "<input type='hidden' name='student_no' value='" .$student_num. "' readonly /> ";
					echo "<input type='hidden' name='research_id1' value='" .$research_id1. "' readonly /> ";
					echo "<input type='text' name='research_code' value='" .$researchcodeT1. "' readonly /> <br/><br/>";
					echo "<input type='text' name='researchTitle2' value='" .$researchtitleT1. "' readonly /> <br/><br/>";
					echo "<input type='text' name='researchtypeR2' value='" .$researchtype. "' readonly /> <br/><br/>";
					
							$queryFaculty = "SELECT * FROM `users` WHERE LOWER(`user_type`)=LOWER('FACULTY')";
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

							
						echo "<select name = 'schoolyear'>";
							for ($x = 2015; $x < 2030; $x++) {
								$temp = $x+1;
								$value = $x." - ".$temp;
								echo "<option value='$value'>$value</option>";
							}
						echo "</select><br/><br/>";
					?>
					<select name="semester" required>
					  <option value="firstsem">1st Sem</option>
					  <option value="secondsem">2nd Sem</option>
					  <option value="summer">Summer</option>
					</select> <br/><br/>
			</div>
			<div class="col-md-9">
				<br/><br/><br/>
				<strong>Lead Panel</strong>
				<?php
				//select panel 1
				$queryLeadPanel = "SELECT * FROM `users` WHERE LOWER(`user_type`)=LOWER('FACULTY')";
				$resultLeadPanel = mysql_query($queryLeadPanel) or die(mysql_error());
				$rows = mysql_num_rows($resultLeadPanel);

				if($rows > 0){
					echo "<select name='panel1'>";
					while ($row = mysql_fetch_array($resultLeadPanel))
					{
						$faculty = $row['fname']." ".$row['mname']." ".$row['lname'];
						$facultyId = $row['user_id'];
						echo "<option value='$facultyId'>$faculty</option><br/>";
					}
					echo "</select><br/><br/>";
				}

				echo "<strong>Panel Member</strong>";
				//select panel 2
				$queryMemberPanel1 = "SELECT * FROM `users` WHERE LOWER(`user_type`)=LOWER('FACULTY')";
				$resultMemberPanel1 = mysql_query($queryMemberPanel1 ) or die(mysql_error());
				$rows = mysql_num_rows($resultMemberPanel1);

				if($rows > 0){
					echo "<select name='panel2'>";
					while ($row = mysql_fetch_array($resultMemberPanel1))
					{
						$faculty = $row['fname']." ".$row['mname']." ".$row['lname'];
						$facultyId = $row['user_id'];
						echo "<option value='$facultyId'>$faculty</option><br/>";
					}
					echo "</select><br/><br/>";
				}

				echo "<strong>Panel Member</strong>";
				//select panel 3
				$queryMemberPanel2 = "SELECT * FROM `users` WHERE LOWER(`user_type`)=LOWER('FACULTY')";
				$resultMemberPanel2 = mysql_query($queryMemberPanel2) or die(mysql_error());
				$rows = mysql_num_rows($resultMemberPanel2);

				if($rows > 0){
					echo "<select name='panel3'>";
					while ($row = mysql_fetch_array($resultMemberPanel2))
					{
						$faculty = $row['fname']." ".$row['mname']." ".$row['lname'];
						$facultyId = $row['user_id'];
						echo "<option value='$facultyId'>$faculty</option><br/>";
					}
					echo "</select><br/><br/>";
				}
				?>
				<input type="submit" name="submit" value="Register" />
				</form>
			</div>
		</div>

		<h4>Researches Registered</h4>
		<div class="table-responsive">
				<?php
					$query = "SELECT * FROM `researches`";
					$result = mysql_query($query) or die(mysql_error());
					echo "<table class='table' border='1' style='width:100%'>";
				echo "   <thead>";
				echo "	 <tr>";
				echo "	 	<th align='center'>";
				echo "	 		<strong>id</strong>";
				echo "	 	</th>";
				echo "	 	<th align='center'>";
				echo "	 		<strong>research code</strong>";
				echo "	 	</th>";
				echo "	 	<th align='center'>";
				echo "	 		<strong>research title</strong>";
				echo "	 	</th>";
				echo "	 	<th align='center'>";
				echo "	 		<strong>research type</strong>";
				echo "	 	</th>";
				echo "	 	<th align='center'>";
				echo "	 		<strong>percentage</strong>";
				echo "	 	</th>";
				echo "	 	<th align='center'>";
				echo "	 		<strong>school year</strong>";
				echo "	 	</th>";
				echo "	 	<th align='center'>";
				echo "	 		<strong>sem type</strong>";
				echo "	 	</th>";
				echo "	 	<th align='center'>";
				echo "	 		<strong>faculty</strong>";
				echo "	 	</th>";
				echo "	 	<th align='center'>";
				echo "	 		<strong>panels</strong>";
				echo "	 	</th>";
				echo "	 	<th align='center'>";
				echo "	 		<strong>student no</strong>";
				echo "	 	</th>";
				echo "	 	<th align='center'>";
				echo "	 		<strong>on going</strong>";
				echo "	 	</th>";
				echo "	 </tr>";
				echo "   </thead>";
				echo "   <tbody>";
				while ($row = mysql_fetch_array($result)) {
					echo "   <tr>";
					echo "      <td style='padding: 5px;'>";
					$research_id = $row['research_id'];
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
					$faculty_id = $row['faculty_id'];
					$resultFaculty = mysql_query("SELECT * FROM `users` WHERE user_id='$faculty_id' LIMIT 1");
					$faculty = mysql_fetch_assoc($resultFaculty);
					echo 			$faculty['lname'] . ', ' .$faculty['fname'] . ' ' .  $faculty['mname'];
					echo "      </td>";

					echo "      <td style='padding: 5px;'>";
					$queryPanel = "SELECT * FROM `panels` where `research_id`=$research_id";
					$resultPanel = mysql_query($queryPanel) or die(mysql_error());
					while ($rowPanel = mysql_fetch_array($resultPanel)) {
						$panel_faculty_id = $rowPanel['user_id'];
						echo "<strong>".$rowPanel['role'] . ":</strong> ";
						$resultFaculty = mysql_query("SELECT * FROM `users` WHERE user_id='$panel_faculty_id' LIMIT 1");
						$faculty = mysql_fetch_assoc($resultFaculty);
						echo 			$faculty['lname'] . ', ' .$faculty['fname'] . ' ' .  $faculty['mname'];
						echo "<br>";
					}

					echo "      </td>";

					echo "      <td style='padding: 5px;'>";
					echo 			$row['student_no'];
					echo "      </td>";

					echo "      <td style='padding: 5px;'>";
					if($row['on_going']==1){
						echo 	"YES";
					}else{
						echo 	"NO";
					}
					echo "      </td>";

					echo "   </tr>";
					echo "   </tbody>";
				}
					echo "<table>";
				?>
		</div>

	</div>
</body>
</html>