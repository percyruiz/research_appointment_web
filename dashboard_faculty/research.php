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
	</head>

	<body>
		<div class="container">
			<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_faculty/dashboard_faculty.php';?>">Back</a>
			<br/>
			<br/>

			<?php

				$remarks = "";
				if(isset($_POST['percentage'])){
					$research_code = $_POST['research_code'];
					$percentage = $_POST['percentage'];
                    $appointment_id = $_POST['appointment_id'];
					$remarks = $_POST['remarks'];

					$query = "UPDATE `researches` SET `percentage`='$percentage' WHERE research_code=$research_code";
					$result = mysql_query($query) or die(mysql_error());

					$query = "UPDATE `appointments` SET
								`percentage`='$percentage',
								`status`='done',
								`remarks`='$remarks'
								WHERE research_code=$research_code AND
                                appointment_id = $appointment_id";
					$result = mysql_query($query) or die(mysql_error());
					if($result){
						echo "<div class=\"alert alert-info\">Update Successful!</div>";
					}
				}
			?>

			<?php 
				if (isset($_GET['id'])){

                    $appointment_id = $_GET['id'];

                    $result = mysql_query("SELECT * FROM `appointments` WHERE appointment_id='$appointment_id' LIMIT 1");
                    $row = mysql_fetch_assoc($result);
                    $research_code = $row['research_code'];
							
					$result = mysql_query("SELECT * FROM `researches` WHERE research_code='$research_code' LIMIT 1");
					$row = mysql_fetch_assoc($result);
					$student_no = $row['student_no'];
					
					$result_student = mysql_query("SELECT * FROM `users` WHERE student_no='$student_no' LIMIT 1");
					$row_student = mysql_fetch_assoc($result_student);

					echo "<table class='table table-striped table-hover' style='width:auto'>";
					echo "	 <thead>";
						echo "   <tr>";
						echo "      <td style='padding: 5px;'>";
						echo 			"<strong>Title</strong>";
						echo "      </td>";
						echo "      <td style='padding: 5px;' align='center'>";
						echo 			$row['research_title'];
						echo "      </td>";
						echo "   </tr>";

						echo "   <tr>";
						echo "      <td style='padding: 5px;'>";
						echo 			"<strong>Research Type</strong>";
						echo "      </td>";
						echo "      <td style='padding: 5px;' align='center'>";
						echo 			$row['research_type'];
						echo "      </td>";
						echo "   </tr>";

						echo "   <tr>";
						echo "      <td style='padding: 5px;'>";
						echo 			"<strong>Group Leader</strong>";
						echo "      </td>";
						echo "      <td style='padding: 5px;' align='center'>";
						echo 			"stud no: [" . $row['student_no'] . "] ". $row_student['lname']. ", ". $row_student['fname'] . " " . $row_student['mname']; 
						echo "      </td>";
						echo "   </tr>";						

						echo "   <tr>";
						echo "      <td style='padding: 5px;'>";
						echo 			"<strong>School Year</strong>";
						echo "      </td>";
						echo "      <td style='padding: 5px;' align='center'>";
						echo 			$row['school_year'];
						echo "      </td>";
						echo "   </tr>";
						
						echo "   <tr>";
						echo "      <td style='padding: 5px;'>";
						echo 			"<strong>Sem Type</strong>";
						echo "      </td>";
						echo "      <td style='padding: 5px;' align='center'>";
						echo 			$row['sem_type'];
						echo "      </td>";
						echo "   </tr>";

						echo "   <tr>";
						echo "      <td style='padding: 5px;'>";
						echo 			"<strong>Comments & Percentage</strong>";
						echo "      </td>";
						echo "      <td style='padding: 5px;'>";
						$percentage =			$row['percentage'];
						echo "		<form action='' method='post' name='research'>
										<input type='hidden' name='research_code' value='$research_code' />
										<input type='hidden' name='appointment_id' value='$appointment_id' />
										<textarea name='remarks' rows=\"10\" cols=\"50\">". $remarks ."</textarea><br/>
										<input name='percentage' min='0' max='100' readonly id='percent' type='number' value='$percentage'/>%
										<input type='submit' id='save' value='save' style='display:none' />
										<input onclick='updatePercentage()' type='button' id='edit_percentage' value='update' />
									</form>";
						echo "      </td>";
						echo "   </tr>";
					echo "<table>";

				}
		    ?>
		</div>
	<br/>
	<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a>
	</body>

	<script>
		function updatePercentage(){
			document.getElementById("percent").readOnly = false;
			document.getElementById("percent").style.borderColor = "#00FF00";
			document.getElementById("edit_percentage").style.display = "none";
			document.getElementById("save").style.display = "inline";
		}
	</script>

</html>
