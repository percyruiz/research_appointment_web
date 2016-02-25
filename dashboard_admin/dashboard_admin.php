<?php 
//require('db.php');
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
	<?php
	// require('db.php');
	//access from root folder
	$path = $_SERVER['DOCUMENT_ROOT'];
	$path .= "/db.php";
	require($path);


   
    // If form submitted, insert values into the database.
    if (isset($_POST['username'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
		$facultyId = $_POST['facultyId'];
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
		$email = $_POST['email'];
		$contact = $_POST['contact'];
		$user_type = "FACULTY";
		
		$username = stripslashes($username);
		$username = mysql_real_escape_string($username);

		$password = stripslashes($password);
		$password = mysql_real_escape_string($password);

		$facultyId = stripslashes($facultyId);
		$facultyId = mysql_real_escape_string($facultyId);

		$fname = stripslashes($fname);
		$fname = mysql_real_escape_string($fname);
		$mname = stripslashes($mname);
		$mname = mysql_real_escape_string($mname);
		$lname = stripslashes($lname);
		$lname = mysql_real_escape_string($lname);
		
		$email = stripslashes($email);
		$email = mysql_real_escape_string($email);
		
		$contact = stripslashes($contact);
		$contact = mysql_real_escape_string($contact);
		
		$queryUsername = "SELECT * FROM `users` WHERE username='$username'";
		$resultUsername = mysql_query($queryUsername);
		
		$rows = mysql_num_rows($resultUsername);

		
		if($rows > 0){
			echo "Username is in use. Choose another Username";
		}else{
		
			$query = "INSERT into `users` (
					username, 
					password,
					faculty_id,
					user_type, 
					fname, 
					mname, 
					lname, 
					email, 
					contact
					) VALUES (
					'$username', 
					'".md5($password)."',
					'$facultyId',
					'$user_type', 
					'$fname', 
					'$mname', 
					'$lname', 
					'$email', 
					'$contact')";
			$result = mysql_query($query);
			$user_id = mysql_insert_id();
			if($result){
				/*
				$queryUpdate = "UPDATE `users` set `faculty_id`=$user_id where `user_id`=$user_id";
				mysql_query($queryUpdate);
				*/
				echo "<div class='alert alert-info'> add success! </div>";
			}else{
				echo mysql_error();
			}
		}
    	}
		?>
			<ul class="breadcrumb">
				<li class="active"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/dashboard_admin.php';?>">Manage Faculty</a></li>
				<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/consultation_history.php';?>">Consultation History</a></li>
				<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/student_profiles.php';?>">Manage Student</a></li>
				<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/insert_research.php';?>">Add Research</a></li>
				<li> <a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a></li>
			</ul>

			<h4>Manage Faculty </h4>

			<div class="row">
				<div class="col-md-3">
					<div class="container">
						<strong>add faculty</strong>
						<form class="form-horizontal" name="registration" action="" method="post">
							<input class="form-control" type="text" name="username" placeholder="Username" required /><br/>
							<input class="form-control" type="password" name="password" placeholder="Password" required /><br/>
							<input class="form-control" type="text" name="facultyId" placeholder="Faculty ID" required /><br/>
							<input class="form-control" type="text" name="fname" placeholder="First Name" required /><br/>
							<input class="form-control" type="text" name="mname" placeholder="Middle Name" required /><br/>
							<input class="form-control" type="text" name="lname" placeholder="Last Name" required /><br/>
							<input class="form-control" type="email" name="email" placeholder="Email" required /><br/>
							<input class="form-control" type="text" name="contact" placeholder="Contact Number" required /><br/>
							<input class="btn btn-primary" type="submit" name="submit" value="Register" /><br/><br/>
						</form>
					</div>
				</div>
					<div class="col-md-9">
					<strong>Faculties Table</strong><br/>
					<?php
						$query = "SELECT * FROM `users` WHERE LOWER(`user_type`)=LOWER('FACULTY')";
						$result = mysql_query($query) or die(mysql_error());
						echo "<table class='table table-striped table-hover' style='width:100%'>";
						echo "	 <thead>";
						echo "	 <tr>";
						echo "	 	<th>";
						echo "	 		<strong>user id</strong>";
						echo "	 	</th>";
						echo "	 	<th>";
						echo "	 		<strong>user name</strong>";
						echo "	 	</th>";
						echo "	 	<th>";
						echo "	 		<strong>faculty id</strong>";
						echo "	 	</th>";
						echo "	 	<td>";
						echo "	 		<strong>first name</strong>";
						echo "	 	</th>";
						echo "	 	<th>";
						echo "	 		<strong>middle name</strong>";
						echo "	 	</th>";
						echo "	 	<th>";
						echo "	 		<strong>last name</strong>";
						echo "	 	</th>";
						echo "	 	<th>";
						echo "	 		<strong>email</strong>";
						echo "	 	</th>";
						echo "	 	<th>";
						echo "	 		<strong>contact</strong>";
						echo "	 	</th>";
						echo "	 	<th>";
						echo "	 		<strong>actions</strong>";
						echo "	 	</th>";
						echo "	 </tr>";
						echo "	 </thead>";
						echo "	 <tbody>";
						while ($row = mysql_fetch_array($result)) {
							echo "   <tr>";
							echo "      <td style='padding: 5px;'>";
							echo 			$row['user_id'];
							echo "      </td>";

							echo "      <td style='padding: 5px;'>";
							echo 			$row['username'];
							echo "      </td>";

							echo "      <td style='padding: 5px;'>";
							echo 			$row['faculty_id'];
							echo "      </td>";

							echo "      <td style='padding: 5px;'>";
							echo 			$row['fname'];
							echo "      </td>";

							echo "      <td style='padding: 5px;'>";
							echo 			$row['mname'];
							echo "      </td>";

							echo "      <td style='padding: 5px;'>";
							echo 			$row['lname'];
							echo "      </td>";

							echo "      <td style='padding: 5px;'>";
							echo 			$row['email'];
							echo "      </td>";

							echo "      <td style='padding: 5px;'>";
							echo 			$row['contact'];
							echo "      </td>";

							echo "      <td style='padding: 5px;'>";
							if(strcasecmp($row['user_type'],'FACULTY')==0){
								echo "<a href='http://" . $_SERVER['SERVER_NAME'] ."/dashboard_admin/faculty_schedule.php?faculty=". $row['faculty_id'] ."'>schedule</a>";
							}
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
