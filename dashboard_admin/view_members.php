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

	$StudentUserid = $_SESSION['userID'];
   
    // If form submitted, insert values into the database.
     // if (isset($_POST['research'])){
/*
        $StudentUserid = $_POST['userID'];

        $queryMembers = "SELECT * FROM `members` WHERE user_id='$StudentUserid'";
       	$resultMembers = mysql_query($queryMembers) or die(mysql_error());
    	$rows = mysql_num_rows($resultMembers);

			if($resultMembers){
				echo "<strong>HERE ARE THE MEMBERS.</strong>";
				echo "<table class='table table-striped table-hover table-nonfluid'>";
				echo "	 <thead>";
				echo "   <tr>";
				echo "      <th>";
				echo "          <strong>Name</strong>";
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
					echo "   </tr>";
				}

				echo "</tbody>";
				echo "</table>";

				echo "<form action='insert_members.php'  method='post' name='insertForm'>";
				echo "			<input type='hidden' name='studentUserID' value='" .$StudentUserid. "'/>";
				echo "			<input class=\"form-control\" style='color:#0000FF' type='submit' name='insert' value='Add Member'/>";
				echo "		</form>";

				echo "<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_admin/insert_members.php'>Add another member</a>";
				echo "<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_admin/edit_delete_members.php'>Edit or Delete Member</a>";
			}else{
				echo mysql_error();
			}
*/
	if (isset($_POST['name'])){

		$name = $_POST['name'];

		$name = stripslashes($name);
		$name = mysql_real_escape_string($name);

		$queryInsert = "INSERT into `members` (
						user_id,
						name
						) VALUES (
						'$StudentUserid',
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
		<form class="form-horizontal" name="registration" action="" method="post">
			<input class="form-control" type="text" name="name" placeholder="Member name" required /> <br/>
			<input class="btn btn-primary" type="submit" name="submit" value="Add member" />
		</form>

	</div>
	<div class="col-md-9">
		<strong>Members</strong><br/>
		<?php



		$queryMembers = "SELECT * FROM `members` WHERE user_id='$StudentUserid'";
		$resultMembers = mysql_query($queryMembers) or die(mysql_error());
		$rows = mysql_num_rows($resultMembers);

		$query = "SELECT * FROM `users` WHERE LOWER(`user_type`)=LOWER('FACULTY')";
		$result = mysql_query($query) or die(mysql_error());
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
			echo "			<input type='hidden' name='studentUserID' value='$StudentUserid'/>";
			echo "			<input class=\"form-control\" style='color:#0000FF' type='submit' name='editdelete' value='Edit or Delete member'/>";
			echo "</form>";
			echo "      </td>";
			echo "   </tr>";
		}

		echo "</tbody>";
		echo "</table>";

/*

		echo "<form action='insert_members.php'  method='post' name='insertMember'>";
		echo "			<input type='hidden' name='studentUserID' value='" .$row['user_id']. "'/>";
		echo "			<input class=\"form-control\" style='color:#0000FF' type='submit' name='add' value='Add member'/>";
		echo "</form>";
*/
		?>
	</div>

</div>
</body>
</html>