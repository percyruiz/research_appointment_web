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
					<li class="active"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/view_groups.php';?>">View Groups</a></li>
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
	if (isset($_POST['name'])){
		$uID = $_POST['uID'];

		$name = $_POST['name'];

		$name = stripslashes($name);
		$name = mysql_real_escape_string($name);

		$queryInsert = "INSERT into `members` (
						user_id,
						name
						) VALUES (
						'$uID',
						'$name')";
		$resultInsert = mysql_query($queryInsert);
		if($resultInsert){
			echo "<div class=\"alert alert-info\">Successfully added a member</div>";
		}else{
			echo mysql_error();
		}
	}
?>


	<div class="col-md-3">
		<h4>Add Member</h4>
		<?php
		echo  "<form class=\"form-horizontal\" name='registration' action='' method='post'>";
		echo 	"<input class=\"form-control\" type='text' name='name' placeholder='Member name' required /> <br/>";
		echo 	"<input class=\"btn btn-primary\" type='submit' name='submit' value='Add member' />";
		echo "	<input type='hidden' name='uID' value='$uID'/>";
		echo "</form>";
		?>

	</div>
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

		echo"<br/><br/><strong>Members</strong><br/><br/>";


		$queryMembers = "SELECT * FROM `members` WHERE user_id='$uID'";
		$resultMembers = mysql_query($queryMembers) or die(mysql_error());
		$rows = mysql_num_rows($resultMembers);

		echo "<table class='table table-striped table-hover table-nonfluid'>";
		echo "	 <thead>";
		echo "   <tr>";
		echo "      <th>";
		echo "          <strong>Name</strong>";
		echo "      </th>";
		echo "      <th>";
		echo "          <strong>Action</strong>";
		echo "      </th>";
		echo "   </tr>";
		echo "	 </thead>";
		echo "	 <tbody>";
		while ($row = mysql_fetch_array($resultMembers))
		{
			echo "   <tr>";
			echo "      <td align='center'>";
			echo           $row['name'];
			echo "      </td>";
			echo "      <td align='center'>";
			echo "<form action='edit_delete_members.php'  method='post' name='modifyMembers'>";
			echo "			<input type='hidden' name='uID' value='$uID'/>";
			echo "			<input class=\"form-control\" style='color:#0000FF' type='submit' name='editdelete' value='Edit or Delete member'/>";
			echo "</form>";
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