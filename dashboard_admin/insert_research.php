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

        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">ADMIN</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/dashboard_admin.php';?>"> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Manage Faculty</a></li>
						<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/consultation_history.php';?>"> <span class="glyphicon glyphicon-time" aria-hidden="true"></span> Consultation History</a></li>
						<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/student_profiles.php';?>"> <span class="glyphicon glyphicon-education" aria-hidden="true"></span> Manage Student</a></li>
						<li class="active"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/insert_research.php';?>"> <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> Add Research</a></li>
						<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/view_researches.php';?>"> <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> View Monitoring</a></li>
						<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/view_groups.php';?>"> <span class="glyphicon glyphicon-tower" aria-hidden="true"></span> View Groups</a></li>
						<li> <a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>"> <span class="glyphicon glyphicon-off" aria-hidden="true"></span> Logout</a></li>
					</ul>
                </div>
            </div>
        </nav>

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
							$queryLeadPanel = "SELECT * FROM `users` WHERE LOWER(`user_type`)=LOWER('FACULTY') AND panel_type='lead'";
							$resultLeadPanel = mysql_query($queryLeadPanel) or die(mysql_error());
							$rows = mysql_num_rows($resultLeadPanel);

							if($rows > 0){
								echo "<select class='form-control' name='panel1'>";
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
					<input class="btn btn-default" type="submit" name="submit" value="Register" onclick="return validate();"/>


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
			$to_pdf = "";
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

			$to_pdf = $to_pdf . "<table class='table table-striped table-hover' style='width:100%'>";
			$to_pdf = $to_pdf . "   <thead>";
			$to_pdf = $to_pdf . "	 <tr>";
			$to_pdf = $to_pdf . "	 	<th align='center'>";
			$to_pdf = $to_pdf . "	 		<strong>id</strong>";
			$to_pdf = $to_pdf . "	 	</th>";
			$to_pdf = $to_pdf . "	 	<th align='center'>";
			$to_pdf = $to_pdf . "	 		<strong>research code</strong>";
			$to_pdf = $to_pdf . "	 	</th>";
			$to_pdf = $to_pdf . "	 	<th align='center'>";
			$to_pdf = $to_pdf . "	 		<strong>research title</strong>";
			$to_pdf = $to_pdf . "	 	</th>";
			$to_pdf = $to_pdf . "	 	<th align='center'>";
			$to_pdf = $to_pdf . "	 		<strong>research type</strong>";
			$to_pdf = $to_pdf . "	 	</th>";
			$to_pdf = $to_pdf . "	 	<th align='center'>";
			$to_pdf = $to_pdf . "	 		<strong>percentage</strong>";
			$to_pdf = $to_pdf . "	 	</th>";
			$to_pdf = $to_pdf . "	 	<th align='center'>";
			$to_pdf = $to_pdf . "	 		<strong>school year</strong>";
			$to_pdf = $to_pdf . "	 	</th>";
			$to_pdf = $to_pdf . "	 	<th align='center'>";
			$to_pdf = $to_pdf . "	 		<strong>sem type</strong>";
			$to_pdf = $to_pdf . "	 	</th>";
			$to_pdf = $to_pdf . "	 	<th align='center'>";
			$to_pdf = $to_pdf . "	 		<strong>faculty</strong>";
			$to_pdf = $to_pdf . "	 	</th>";
			$to_pdf = $to_pdf . "	 	<th align='center'>";
			$to_pdf = $to_pdf . "	 		<strong>panels</strong>";
			$to_pdf = $to_pdf . "	 	</th>";
			$to_pdf = $to_pdf . "	 	<th align='center'>";
			$to_pdf = $to_pdf . "	 		<strong>student no</strong>";
			$to_pdf = $to_pdf . "	 	</th>";
			$to_pdf = $to_pdf . "	 </tr>";
			$to_pdf = $to_pdf . "   </thead>";
			$to_pdf = $to_pdf . "   <tbody>";

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

				$to_pdf = $to_pdf . "   <tr>";
				$to_pdf = $to_pdf . "      <td style='padding: 5px;'>";
				$to_pdf = $to_pdf . 			$row['research_id'];
				$to_pdf = $to_pdf . "      </td>";

				$to_pdf = $to_pdf . "      <td style='padding: 5px;'>";
				$to_pdf = $to_pdf . 			$row['research_code'];
				$to_pdf = $to_pdf . "      </td>";

				$to_pdf = $to_pdf . "      <td style='padding: 5px;'>";
				$to_pdf = $to_pdf . 			$row['research_title'];
				$to_pdf = $to_pdf . "      </td>";

				$to_pdf = $to_pdf . "      <td style='padding: 5px;'>";
				$to_pdf = $to_pdf . 			$row['research_type'];
				$to_pdf = $to_pdf . "      </td>";

				$to_pdf = $to_pdf . "      <td style='padding: 5px;'>";
				$to_pdf = $to_pdf . 			$row['percentage'];
				$to_pdf = $to_pdf . "      </td>";

				$to_pdf = $to_pdf . "      <td style='padding: 5px;'>";
				$to_pdf = $to_pdf . 			$row['school_year'];
				$to_pdf = $to_pdf . "      </td>";

				$to_pdf = $to_pdf . "      <td style='padding: 5px;'>";
				$to_pdf = $to_pdf . 			$row['sem_type'];
				$to_pdf = $to_pdf . "      </td>";
				
				echo "      <td style='padding: 5px;'>";
				$faculty_id = $row['faculty_id'];
				$resultFaculty = mysql_query("SELECT * FROM `users` WHERE faculty_id='$faculty_id' LIMIT 1");
				$faculty = mysql_fetch_assoc($resultFaculty);
				echo 			$faculty['lname'] . ', ' .$faculty['fname'] . ' ' .  $faculty['mname'];
				echo "      </td>";
				$to_pdf = $to_pdf . "      <td style='padding: 5px;'>";
				$to_pdf = $to_pdf . 			$faculty['lname'] . ', ' .$faculty['fname'] . ' ' .  $faculty['mname'];
				$to_pdf = $to_pdf . "      </td>";
				
				echo "      <td style='padding: 5px;'>";
				$to_pdf = $to_pdf . "      <td style='padding: 5px;'>";
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

					$to_pdf = $to_pdf . "<strong>".$rowPanel['user_type'] . ":</strong> ";
					$to_pdf = $to_pdf . 			$faculty['lname'] . ', ' .$faculty['fname'] . ' ' .  $faculty['mname'];
					$to_pdf = $to_pdf . "<br>";
				}
				
				echo "      </td>";
				$to_pdf = $to_pdf . "      </td>";
				
				echo "      <td style='padding: 5px;'>";
				echo 			$row['student_no'];
				echo "      </td>";

				$to_pdf = $to_pdf . "      <td style='padding: 5px;'>";
				$to_pdf = $to_pdf . 			$row['student_no'];
				$to_pdf = $to_pdf . "      </td>";
				
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
				$to_pdf = $to_pdf . "      </td>";
				$to_pdf = $to_pdf . "   </tr>";
			}
			echo "</tbody>";
			echo "</table>";
			$to_pdf = $to_pdf . "</tbody>";
			$to_pdf = $to_pdf . "</table>";
		?>
		<form class="form-horizontal" name="to_pdf" action="../to_pdf.php" method="post">
			<input type="hidden" name="to_pdf" value="<?php echo '<br/><br/>Researches <br/><br/>' . $to_pdf?>"/>
			<input class="btn btn-default" type="submit" name="submit" value="Generate PDF" /><br/><br/>
		</form>
		</div>
		
	</div>
</body>
</html>