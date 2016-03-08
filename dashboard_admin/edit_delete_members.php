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

	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">STUDENT</a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/dashboard_admin.php';?>">Manage Faculty</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/consultation_history.php';?>">Consultation History</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/student_profiles.php';?>">Manage Student</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/insert_research.php';?>">Add Research</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/view_researches.php';?>">View Monitoring</a></li>
					<li  class="active"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/view_groups.php';?>">View Groups</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a></li>
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

        $uID = $_POST['uID'];

				if (isset($_POST['name'])) {
					$membername = $_POST['name'];
					$member_id = $_POST['memberid'];

					$membername = stripslashes($membername);
					$membername = mysql_real_escape_string($membername);

					$membername = $_POST['name'];
					$member_id = $_POST['memberid'];

					if($_POST['action'] == 'SAVE') {
						$queryUpdate = "UPDATE members SET name='$membername' WHERE member_id = '$member_id'";
						$resultUpdate = mysql_query($queryUpdate) or die(mysql_error());

						if ($resultUpdate) {
							echo "<div class=\"alert alert-info\">Successfully Edited Member</div>";
						} else {
							echo mysql_error();
						}
					}else{
						$queryDelete = "DELETE FROM members WHERE member_id = '$member_id'";
						$resultDelete = mysql_query($queryDelete) or die(mysql_error());

						if ($resultDelete) {
							echo "<div class=\"alert alert-info\">Successfully Deleted Member</div>";
						} else {
							echo mysql_error();
						}
					}
				}
?>

	<div class="col-md-9">
		<?php



		$query = "SELECT * FROM `users` WHERE user_id='$uID'";
		$result = mysql_query($query) or die(mysql_error());
		while ($row = mysql_fetch_array($result)) {
			echo "<strong>LEADER: </strong>";
			echo $row['lname'] . ", " . $row['fname'] . " " . $row['mname']. "</br>";

			$researchCode = $row['research_code'];
			$queryResearch = "SELECT * FROM `researches` WHERE research_code = '$researchCode'";
			$resultResearch = mysql_query($queryResearch) or die(mysql_error());
			$title = mysql_fetch_array($resultResearch);

			echo "<strong>RESEARCH TITLE: </strong>";
			echo $title['research_title'];
		}

		echo "<br/><br/><strong>Members</strong><br/><br/>";
		$queryMembers = "SELECT * FROM `members` WHERE user_id='$uID'";
		$resultMembers = mysql_query($queryMembers) or die(mysql_error());
		$rows = mysql_num_rows($resultMembers);

		echo "<table class='table table-striped table-hover' style='width:70%'>";
		echo "	 <thead>";
		echo "   <tr>";
		echo "      <th>";
		echo "          <strong>Name</strong>";
		echo "      </th>";
		echo "      <th>";
		echo "          <strong>Action to do</strong>";
		echo "      </th>";
		echo "   </tr>";
		echo "	 </thead>";
		echo "	 <tbody>";
		while ($row = mysql_fetch_array($resultMembers))
		{
			echo "   <tr>";
			echo "      <td align='center'>";
			echo "		<form method='post' name='saveForm'>";
			echo "		<input class=\"form-control\" type='text' name='name' value='". $row['name'] ."'>";
			echo "      </td>";
			echo "      <td align='center'>";

			echo '			<input type="hidden" name="memberid" value='.$row['member_id'].'/>';
			echo '			<input type="hidden" name="uID" value='.$uID.'/>';
			echo "			<input class=\"btn btn-primary\" type='submit' name='action' value='SAVE'/>";
			echo "			<input class=\"btn btn-primary\" type='submit' name='action' value='DELETE'/>";
			echo "		</form>";
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