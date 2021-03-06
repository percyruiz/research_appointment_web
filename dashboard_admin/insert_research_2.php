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

				$queryUserPanel1 = "SELECT * FROM `users` WHERE faculty_id='$panel1'";
				$resultUserPanel1 = mysql_query($queryUserPanel1) or die(mysql_error());
				$rowsPanel = mysql_num_rows($resultUserPanel1);

				if($rowsPanel > 0){
					while ($row = mysql_fetch_array($resultUserPanel1))
					{
						$panelName1 = $row['fname']." ".$row['mname']." ".$row['lname'];
					}
				}

				$queryUserPanel2 = "SELECT * FROM `users` WHERE faculty_id='$panel2'";
				$resultUserPanel2 = mysql_query($queryUserPanel2) or die(mysql_error());
				$rowsPanel = mysql_num_rows($resultUserPanel2);

				if($rowsPanel > 0){
					while ($row = mysql_fetch_array($resultUserPanel2))
					{
						$panelName2 = $row['fname']." ".$row['mname']." ".$row['lname'];
					}
				}

				$queryUserPanel3 = "SELECT * FROM `users` WHERE faculty_id='$panel3'";
				$resultUserPanel3 = mysql_query($queryUserPanel3) or die(mysql_error());
				$rowsPanel = mysql_num_rows($resultUserPanel3);

				if($rowsPanel > 0){
					while ($row = mysql_fetch_array($resultUserPanel3))
					{
						$panelName3 = $row['fname']." ".$row['mname']." ".$row['lname'];
					}
				}

				$queryStudentNum = "SELECT * FROM `users` WHERE user_id='$userid'";
				$resultStudentNum = mysql_query($queryStudentNum) or die(mysql_error());
					$rows = mysql_num_rows($resultStudentNum);
					
					while ($row = mysql_fetch_array($resultStudentNum)) 
					{
						$student_no = $row['student_no'];  
					}

				$queryUpdateResearch1 = "UPDATE `researches` SET `research_type`='$researchtypeR2', `school_year`='$schoolyear',
					`sem_type`='$semester', `faculty_id`='$facultyId', `percentage`='0'  WHERE research_code='$researchCode'";
				echo mysql_error();
				$resultUpdateResearch1 = mysql_query($queryUpdateResearch1);


				
				if($resultUpdateResearch1){

					$queryPanels = "SELECT * FROM `panels` WHERE research_code=$researchCode";

					$result = mysql_query($queryPanels) or die(mysql_error());

					$panel_id_array = array($panel1,$panel2,$panel3);
					$panel_type_array = array("LEAD PANEL","MEMBER PANEL","MEMBER PANEL");
					$panelName_type_array = array($panelName1,$panelName2,$panelName3);

					$col=0;
					$row=0;
					$i = 0;
					while ($rowResult = mysql_fetch_array($result)){
						$panelId = $rowResult['panel_id'];
						$queryUpdatePanel1 = "UPDATE `panels` SET `faculty_id` = '$panel_id_array[$i]', `user_type`='$panel_type_array[$i]', `panel_name`='$panelName_type_array[$i]' WHERE panel_id=$panelId";
						echo mysql_error();
						$resultUpdate = mysql_query($queryUpdatePanel1);
						if($resultUpdate){
							$row++;
							$col=0;
							$i++;
						}
					}


                    echo "<div class=\"alert alert-info\">update successful!</div>";
					header("Location: http://". $_SERVER['SERVER_NAME'] ."/dashboard_admin/insert_research.php");
				}else{
					echo mysql_error();
				}
			}
		?>


		<ul class="breadcrumb">
			<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/dashboard_admin.php';?>">Manage Faculty</a></li>
			<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/consultation_history.php';?>">Consultation History</a></li>
			<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/student_profiles.php';?>">Manage Student</a></li>
			<li class="active"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/insert_research.php';?>">Add Research</a></li>
			<li> <a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a></li>
		</ul>
		<div class="row">
			<div class="col-md-3">
				<h4>Add Research 2</h4>
				<form class="form-horizontal" name="registration" action="" method="post">
				<?php
					echo "<input type='hidden' name='student_no' value='" .$student_num. "' readonly /> ";

					echo "<input type='hidden' name='research_id1' value='" .$research_id1. "' readonly /> ";
					echo "Code: <input class=\"form-control\" type='text' name='research_code' value='" .$researchcodeT1. "' readonly /> <br/>";
					echo "<input class=\"form-control\" type='text' name='researchTitle2' value='" .$researchtitleT1. "' readonly /> <br/>";
					echo "<input class=\"form-control\" type='text' name='researchtypeR2' value='" .$researchtype. "' readonly /> <br/>";

							$queryFaculty = "SELECT * FROM `users` WHERE LOWER(`user_type`)=LOWER('FACULTY')";
							$resultFaculty = mysql_query($queryFaculty) or die(mysql_error());
							$rows = mysql_num_rows($resultFaculty);

							if($rows > 0){
								echo "<select class=\"form-control\" name='adviser'>";
								while ($row = mysql_fetch_array($resultFaculty)) 
								{
									$faculty = $row['fname']." ".$row['mname']." ".$row['lname'];
									$facultyId = $row['faculty_id'];
									echo "<option value='$facultyId'>$faculty</option><br/>";
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
				$queryLeadPanel = "SELECT * FROM `users` WHERE LOWER(`user_type`)=LOWER('FACULTY') AND panel_type='lead'";
				$resultLeadPanel = mysql_query($queryLeadPanel) or die(mysql_error());
				$rows = mysql_num_rows($resultLeadPanel);

				if($rows > 0){
					echo "<select class=\"form-control\" name='panel1'>";
					while ($row = mysql_fetch_array($resultLeadPanel))
					{
						$faculty = $row['fname']." ".$row['mname']." ".$row['lname'];
						$facultyId = $row['faculty_id'];
						echo "<option value='$facultyId'>$faculty</option><br/>";
					}
					echo "</select><br/>";
				}

				echo "<strong>Panel Member</strong>";
				//select panel 2
				$queryMemberPanel1 = "SELECT * FROM `users` WHERE LOWER(`user_type`)=LOWER('FACULTY') AND panel_type='panel'";
				$resultMemberPanel1 = mysql_query($queryMemberPanel1 ) or die(mysql_error());
				$rows = mysql_num_rows($resultMemberPanel1);

				if($rows > 0){
					echo "<select class=\"form-control\" name='panel2'>";
					while ($row = mysql_fetch_array($resultMemberPanel1))
					{
						$faculty = $row['fname']." ".$row['mname']." ".$row['lname'];
						$facultyId = $row['faculty_id'];
						echo "<option value='$facultyId'>$faculty</option><br/>";
					}
					echo "</select><br/>";
				}

				echo "<strong>Panel Member</strong>";
				//select panel 3
				$queryMemberPanel2 = "SELECT * FROM `users` WHERE LOWER(`user_type`)=LOWER('FACULTY') AND panel_type='panel'";
				$resultMemberPanel2 = mysql_query($queryMemberPanel2) or die(mysql_error());
				$rows = mysql_num_rows($resultMemberPanel2);

				if($rows > 0){
					echo "<select class=\"form-control\" name='panel3'>";
					while ($row = mysql_fetch_array($resultMemberPanel2))
					{
						$faculty = $row['fname']." ".$row['mname']." ".$row['lname'];
						$facultyId = $row['faculty_id'];
						echo "<option value='$facultyId'>$faculty</option><br/>";
					}
					echo "</select><br/>";
				}
				?>
				<input class="btn btn-primary" type="submit" name="submit" value="Register" onclick="return validate()";/>
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

					echo "   </tr>";
				}
				echo "   </tbody>";
				echo "<table>";
				?>
		</div>

	</div>
</body>
</html>