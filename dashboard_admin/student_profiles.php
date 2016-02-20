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
		?>


		<ul class="breadcrumb">
			<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/dashboard_admin.php';?>">Manage Faculty</a></li>
			<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/consultation_history.php';?>">Consultation History</a></li>
			<li class="active"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/student_profiles.php';?>">Manage Student</a></li>
			<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/insert_research.php';?>">Add Research</a></li>
			<li> <a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a></li>
		</ul>

		<div class="row">
			<div class="col-md-9">
				<h4>Student Profiles</h4>
				<?php
					$query = "SELECT * FROM `users` WHERE LOWER(`user_type`) = LOWER('STUDENT')";
					$result = mysql_query($query) or die(mysql_error());
					echo "<table class='table table-striped table-hover' style='width:100%'>";
					echo "	 <thead>";
					echo "	 <tr>";
					echo "	 	<th align='center'>";
					echo "	 		<strong>Name</strong>";
					echo "	 	</th>";
					echo "	 	<th align='center'>";
					echo "	 		<strong>Username/Research Code</strong>";
					echo "	 	</th>";
					echo "	 	<th align='center'>";
					echo "	 		<strong>Password</strong>";
					echo "	 	</th>";
					echo "	 </thead>";
					echo "	 <tbody>";
					while ($row = mysql_fetch_array($result)) {
						echo "   <tr>";

						echo "      <td style='padding: 5px;'>";
						$user = $row['fname']." ".$row['mname']." ".$row['lname'];
						echo 			$user;
						echo "      </td>";
						
						echo "      <td style='padding: 5px;'>";
						echo 			$row['username'];
						echo "      </td>";
						
						echo "      <td style='padding: 5px;'>";
						$password = $row['password'];
						echo 			md5($password);
						echo "      </td>";

						echo "   </tr>";
					}
					echo "</tbody>";
					echo "</table>";
				?>
			</div>
		</div>
	</div>
</body>
</html>