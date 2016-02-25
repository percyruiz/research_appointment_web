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
<html xmlns="http://www.w3.org/1999/html">
<head>
<meta charset="utf-8">
<title>Registration</title>
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
				$researchtype = $_POST['researchtype'];
				$schoolyear = $_POST['schoolyear'];
				$semester = $_POST['semester'];
				$facultyId = $_POST['adviser'];
				$panelName1 = $_POST['panelName1'];
				$panelName2 = $_POST['panelName2'];
				$panelName3 = $_POST['panelName3'];

				$researchIdQuery = "SELECT * FROM researches ORDER BY `research_id` DESC LIMIT 1";
				$researchIdResult = mysql_query($researchIdQuery) or die(mysql_error());
				$researchIdCode = 1;
				while($researchIdRow = mysql_fetch_assoc($researchIdResult)) {
					$researchIdCode = $researchIdRow['research_id'] + 1;
				}

				//$researchId= mysql_insert_id();
				$schoolyearForRcode = preg_replace("/[^A-Za-z0-9]/", "", $schoolyear);
				$researchCode = $schoolyearForRcode ."". $researchIdCode;
				$panel1 = $_POST['panel1'];
				$panel2 = $_POST['panel2'];
				$panel3 = $_POST['panel3'];
				
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
					
					$queryInsert = "INSERT into `panels` (
						research_code,
						faculty_id,
						user_type,
						panel_name
						) VALUES (
						'$researchCode',
						'$panel1',
						'LEAD PANEL',
						'$panelName1')";
					$resultInsert = mysql_query($queryInsert);
					
					$queryInsert = "INSERT into `panels` (
						research_code,
						faculty_id,
						user_type,
						panel_name
						) VALUES (
						'$researchCode',
						'$panel2',
						'MEMBER PANEL',
						'$panelName2')";
					$resultInsert = mysql_query($queryInsert);
					
					$queryInsert = "INSERT into `panels` (
						research_code,
						faculty_id,
						user_type,
						panel_name
						) VALUES (
						'$researchCode',
						'$panel3', 
						'MEMBER PANEL',
						'$panelName3')";
					$resultInsert = mysql_query($queryInsert);
					
					$queryInsertStudent = "INSERT into `users` (
						user_type, 
						research_code,
						username,
						research_id
						) VALUES (
						'STUDENT', 
						'$researchCode',
						'$researchCode',
						'$research_id')";
					$resultInsertStudent = mysql_query($queryInsertStudent);
					echo mysql_error();
					echo "<div class=\"alert alert-info\">add successful!</div>";
				}else{
					echo mysql_error();
				}
			}
		?>


		<ul class="breadcrumb">
			<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/dashboard_admin.php';?>">Manage Faculty</a></li>
			<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/consultation_history.php';?>">Consultation History</a></li>
			<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/student_profiles.php';?>">Manage Student</a></li>
			<li  class="active"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/insert_research.php';?>">Add Research</a></li>
			<li> <a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a></li>
		</ul>
		<div class="row">
			<div class="col-md-3">
				<h4>Add Research</h4>
				<form class="form-horizontal" name="registration" action="" method="post">
					<input class="form-control" type="text" name="research" placeholder="Research Title" required /> <br/>
					<select class="form-control" name="researchtype">
						<option value="Thesis 1">Thesis 1</option>
						<option value="Capstone 1">Capstone 1</option>
					</select>
					<br/>
					<?php
							//select adviser
							$queryFaculty = "SELECT * FROM `users` WHERE LOWER(`user_type`)=LOWER('FACULTY')";
							$resultFaculty = mysql_query($queryFaculty) or die(mysql_error());
							$rows = mysql_num_rows($resultFaculty);

							if($rows > 0){
								echo "<select class=\"form-control\" name='adviser'>";
								while ($row = mysql_fetch_array($resultFaculty)) 
								{
									$faculty = $row['fname']." ".$row['mname']." ".$row['lname'];
									$facultyIdAdviser = $row['faculty_id'];
									echo "<option value='$facultyIdAdviser'>$faculty</option><br/>";
								}
								echo "</select><br/>";
							}

							
						echo "<select class=\"form-control\" name = 'schoolyear'>";
							for ($x = 2015; $x < 2030; $x++) {
								$temp = $x+1;
								$value = $x." - ".$temp;
								echo "<option value='$value'>$value</option>";
							}
						echo "</select><br/>";
					?>
					<select class="form-control" name="semester" required>
					  <option value="firstsem">1st Sem</option>
					  <option value="secondsem">2nd Sem</option>
					  <option value="summer">Summer</option>
					</select> <br/>
					
			</div>
			<div class="col-md-9">
				<br/>
				<strong>Lead Panel</strong>
					<?php
							//select panel 1
							$queryLeadPanel = "SELECT * FROM `users` WHERE LOWER(`user_type`)=LOWER('FACULTY')";
							$resultLeadPanel = mysql_query($queryLeadPanel) or die(mysql_error());
							$rows = mysql_num_rows($resultLeadPanel);

							if($rows > 0){
								echo "<select class='form-control' name='panel1'>";
								while ($row = mysql_fetch_array($resultLeadPanel)) 
								{
									$faculty = $row['fname']." ".$row['mname']." ".$row['lname'];
									$facultyIdLead = $row['faculty_id'];
									echo "<option value='$facultyIdLead'>$faculty</option><br/>";
								}
								echo "</select><br/>";

								$queryUserPanel1 = "SELECT * FROM `users` WHERE faculty_id='$facultyIdLead'";
								$resultUserPanel1 = mysql_query($queryUserPanel1) or die(mysql_error());
								$rowsPanel = mysql_num_rows($resultUserPanel1);

								if($rowsPanel > 0){
									while ($row = mysql_fetch_array($resultUserPanel1))
									{
										$faculty = $row['fname']." ".$row['mname']." ".$row['lname'];
										echo "<input type = 'hidden' name = 'panelName1' value='$faculty'>";
									}
								}
							}
							
							echo "<strong>Panel Member</strong>";
							//select panel 2
							$queryMemberPanel1 = "SELECT * FROM `users` WHERE LOWER(`user_type`)=LOWER('FACULTY')";
							$resultMemberPanel1 = mysql_query($queryMemberPanel1 ) or die(mysql_error());
							$rows = mysql_num_rows($resultMemberPanel1);

							if($rows > 0){
								echo "<select class=\"form-control\" name='panel2'>";
								while ($row = mysql_fetch_array($resultMemberPanel1)) 
								{
									$faculty = $row['fname']." ".$row['mname']." ".$row['lname'];
									$facultyIdPanel2 = $row['faculty_id'];
									echo "<option value='$facultyIdPanel2'>$faculty</option><br/>";
								}

								echo "</select><br/>";

								$queryUserPanel2 = "SELECT * FROM `users` WHERE faculty_id='$facultyIdPanel2'";
								$resultUserPanel2 = mysql_query($queryUserPanel2 ) or die(mysql_error());
								$rowsPanel = mysql_num_rows($resultUserPanel2);

								if($rowsPanel > 0){
									while ($row = mysql_fetch_array($resultUserPanel2))
									{
										$faculty = $row['fname']." ".$row['mname']." ".$row['lname'];
										echo "<input type = 'hidden' name = 'panelName2' value='$faculty'>";
									}
								}
							}
							
							echo "<strong>Panel Member</strong>";
							//select panel 3
							$queryMemberPanel2 = "SELECT * FROM `users` WHERE LOWER(`user_type`)=LOWER('FACULTY')";
							$resultMemberPanel2 = mysql_query($queryMemberPanel2) or die(mysql_error());
							$rows = mysql_num_rows($resultMemberPanel2);

							if($rows > 0){
								echo "<select class=\"form-control\" name='panel3'>";
								while ($row = mysql_fetch_array($resultMemberPanel2)) 
								{
									$faculty = $row['fname']." ".$row['mname']." ".$row['lname'];
									$facultyIdPanel3 = $row['faculty_id'];
									echo "<option value='$facultyIdPanel3'>$faculty</option><br/>";
								}
								echo "<input type = 'hidden' name = 'panelName3' value='$faculty'>";
								echo "</select><br/>";

								$queryUserPanel3 = "SELECT * FROM `users` WHERE faculty_id='$facultyIdPanel3'";
								$resultUserPanel3 = mysql_query($queryUserPanel3) or die(mysql_error());
								$rowsPanel = mysql_num_rows($resultUserPanel3);

								if($rowsPanel > 0){
									while ($row = mysql_fetch_array($resultUserPanel3))
									{
										$faculty = $row['fname']." ".$row['mname']." ".$row['lname'];
										echo "<input type = 'hidden' name = 'panelName3' value='$faculty'>";
									}
								}
							}
					?>
					<input class="btn btn-primary" type="submit" name="submit" value="Register" onclick="return validate();"/>


				</form>
				<script type="text/javascript">
					function validate() {
						var adviserName = document.forms["registration"]["adviser"].value;
						var lead = document.forms["registration"]["panel1"].value;
						var panel2 = document.forms["registration"]["panel2"].value;
						var panel3 = document.forms["registration"]["panel3"].value;

						if(lead == panel2 || lead == panel3 || panel2 == panel3 || adviserName == lead || adviserName == panel2 || adviserName == panel3){
							alert("Adviser and Panels should be distinct");
							return false;
						}
						return true;
					}
				</script>
			</div>
		</div>
		
		<h4>Researches Registered</h4>
		<div class="table-responsive">
		<?php
			$query = "SELECT * FROM `researches` ORDER BY `research_id` DESC";
			$result = mysql_query($query) or die(mysql_error());
			echo "<table class='table table-striped table-hover' style='width:100%'>";
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
			echo "	 		<strong>action</strong>";
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
				$resultFaculty = mysql_query("SELECT * FROM `users` WHERE faculty_id='$faculty_id' LIMIT 1");
				$faculty = mysql_fetch_assoc($resultFaculty);
				echo 			$faculty['lname'] . ', ' .$faculty['fname'] . ' ' .  $faculty['mname'];
				echo "      </td>";
				
				echo "      <td style='padding: 5px;'>";
				$researchCode = $row['research_code'];
				$queryPanel = "SELECT * FROM `panels` where `research_code`=$researchCode";
				$resultPanel = mysql_query($queryPanel) or die(mysql_error());
				while ($rowPanel = mysql_fetch_array($resultPanel)) {
					$panel_faculty_id = $rowPanel['faculty_id'];
					echo "<strong>".$rowPanel['user_type'] . ":</strong> ";
					$resultFaculty = mysql_query("SELECT * FROM `users` WHERE faculty_id='$panel_faculty_id' LIMIT 1");
					$faculty = mysql_fetch_assoc($resultFaculty);
					echo 			$faculty['lname'] . ', ' .$faculty['fname'] . ' ' .  $faculty['mname'];
					echo "<br>";
				}
				
				echo "      </td>";
				
				echo "      <td style='padding: 5px;'>";
				echo 			$row['student_no'];
				echo "      </td>";
				
				echo "      <td style='padding: 5px;'>";
				if($row['percentage']==100 && ($row['research_type']!="Thesis 2" || $row['research_type']!="Capstone 2")){
					echo "		<div class='col-md-6'>";
					echo "		<form action='insert_research_2.php'  method='post' name='researchForm'>";
					echo "			<input type='hidden' name='research_id1' value='" .$row['research_id']. "'/>";
					echo "			<input type='hidden' name='researchcodeT1' value='" .$row['research_code']. "'/>";
					echo "			<input type='hidden' name='researchtitleT1' value='" .$row['research_title']. "'/>";
					echo "			<input type='hidden' name='researchtypeR1' value='" .$row['research_type']. "'/>";
					echo "			<input type='hidden' name='student_no' value='" .$row['student_no']. "'/>";
					if($row['research_type']=="Thesis 1"){
						echo "			<input class=\"form-control\" style='color:#0000FF' type='submit' name='register' value='Register as Thesis 2'/>";
					}else if ($row['research_type']=="Capstone 1"){
						echo "			<input class=\"form-control\" style='color:#0000FF' type='submit' name='register' value='Register as Capstone 2'/>";
					}
					echo "		</form>";
					echo "		</div>";
				}
				echo "      </td>";

				echo "   </tr>";
			}
			echo "</tbody>";
			echo "</table>";
		?>
		</div>
		
	</div>
</body>
</html>