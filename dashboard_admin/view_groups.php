<?php
//require('db.php');
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/db.php";
require($path);
include("auth.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Dashboard Admin</title>
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

<div class="container">

	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">ADMIN</a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/dashboard_admin.php';?>">Manage Faculty</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/consultation_history.php';?>">Consultation History</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/student_profiles.php';?>">Manage Student</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/insert_research.php';?>">Add Research</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/view_researches.php';?>">View Monitoring</a></li>
					<li  class="active"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/view_groups.php';?>">View Groups</a></li>
					<li> <a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<?php
	// require('db.php');
	//access from root folder
	$path = $_SERVER['DOCUMENT_ROOT'];
	$path .= "/db.php";
	require($path);?>

	<h4>View Groups</h4>

	<div class="row">
		<div class="col-md-9">
			<?php
			$query = "SELECT * FROM `users` WHERE LOWER(`user_type`)=LOWER('STUDENT')";
			$result = mysql_query($query) or die(mysql_error());
			echo "<table class='table table-striped table-hover' style='width:100%'>";
			echo "	 <thead>";
			echo "	 <tr>";
			echo "	 	<th>";
			echo "	 		<strong>Group Leader</strong>";
			echo "	 	</th>";
			echo "	 	<th>";
			echo "	 		<strong>Research Title</strong>";
			echo "	 	</th>";
			echo "	 	<th>";
			echo "	 		<strong>Action</strong>";
			echo "	 	</th>";
			echo "	 </tr>";
			echo "	 </thead>";
			echo "	 <tbody>";
			while ($row = mysql_fetch_array($result)) {
				echo "   <tr>";
				echo "      <td style='padding: 5px;'>";
				echo 			$row['lname']. ", " .$row['fname']. " " .$row['mname'];
				echo "      </td>";

				$researchCode = $row['research_code'];
				$queryResearch = "SELECT * FROM `researches` WHERE research_code = '$researchCode'";
				$resultResearch = mysql_query($queryResearch) or die(mysql_error());
				$title = mysql_fetch_array($resultResearch);


				echo "      <td style='padding: 5px;'>";
				echo 			$title['research_title'];
				echo "      </td>";

				echo "      <td style='padding: 5px;'>";
				echo "		<form action='view_members.php'  method='post' name='groups'>";
				$_SESSION['userID'] = $row['user_id'];
				echo "			<input class=\"form-control\" style='color:#0000FF' type='submit' name='viewgroups' value='View Group'/>";
				echo "		</form>";
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
