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
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/view_research.php';?>"> <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> Research</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/choose_appointment.php';?>"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Appointments</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/insert_members.php';?>"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Members</a></li>
					<li class="active"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/view_members.php';?>"> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> View Members</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_student/view_monitoring.php';?>"> <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> View Monitoring</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/change_password_form.php';?>"> <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Change Password</a></li>
					<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>"> <span class="glyphicon glyphicon-off" aria-hidden="true"></span> Logout</a></li>
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
   
    // If form submitted, insert values into the database.
     // if (isset($_POST['research'])){

        $userid = $_SESSION['userid'];

        $queryMembers = "SELECT * FROM `members` WHERE user_id='$userid'";
       	$resultMembers = mysql_query($queryMembers) or die(mysql_error());
    	$rows = mysql_num_rows($resultMembers);
    	
		if($rows == 0){
			echo "No Members yet.<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/insert_members.php'>Add Members</a>";
			echo "<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/view_research.php'>Back</a></div>";
		}else{

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
				echo "<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/insert_members.php'>Add another member</a>";
				echo "<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/edit_delete_members.php'>Edit or Delete Member</a>";
			}else{
				echo mysql_error();
			}
        }
    // }else{
?>
</div>
</body>
</html>