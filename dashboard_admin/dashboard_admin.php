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
					user_type, 
					fname, 
					mname, 
					lname, 
					email, 
					contact
					) VALUES (
					'$username', 
					'".md5($password)."', 
					'$user_type', 
					'$fname', 
					'$mname', 
					'$lname', 
					'$email', 
					'$contact')";
			$result = mysql_query($query);
			$user_id = mysql_insert_id();
			if($result){
				$queryUpdate = "UPDATE `users` set `faculty_id`=$user_id where `user_id`=$user_id";
				mysql_query($queryUpdate);
				echo "add success!";
			}else{
				echo mysql_error();
			}
		}
    	}
		?>
			<p>
				<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/index.php';?>">Home</a> |	 
				<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/consultation_history.php';?>">Consultation History</a> |
				<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/dashboard_admin.php';?>">Manage Faculty</a> |	 
				<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/insert_research.php';?>">Add Research</a> |
				<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout</a>
			</p>
			<h4>Manage Faculty </h4>

			<div class="row">
				<div class="col-md-3">
					<div class="form container">
					<h5>add faculty</h5>
						<form name="registration" action="" method="post">
							<input type="text" name="username" placeholder="Username" required /><br/><br/>
							<input type="password" name="password" placeholder="Password" required /><br/><br/>

							<input type="text" name="fname" placeholder="First Name" required /><br/><br/>
							<input type="text" name="mname" placeholder="Middle Name" required /><br/><br/>
							<input type="text" name="lname" placeholder="Last Name" required /><br/><br/>
							<input type="email" name="email" placeholder="Email" required /><br/><br/>
							<input type="text" name="contact" placeholder="Contact Number" required /><br/><br/>
							<input type="submit" name="submit" value="Register" /><br/><br/>
						</form>
					</div>
					</div>
					<div class="col-md-9">
					<h5>faculty list</h5>
					<?php
						$query = "SELECT * FROM `users` WHERE `user_type`='FACULTY'";
						$result = mysql_query($query) or die(mysql_error());
						echo "<table class='table' border='1' style='width:100%'>";
						echo "	 <tr>";
						echo "	 	<td align='center'>";	
						echo "	 		<strong>user id</strong>";
						echo "	 	</td>";
						echo "	 	<td align='center'>";	
						echo "	 		<strong>user name</strong>";
						echo "	 	</td>";
						echo "	 	<td align='center'>";	
						echo "	 		<strong>first name</strong>";
						echo "	 	</td>";
						echo "	 	<td align='center'>";	
						echo "	 		<strong>middle name</strong>";
						echo "	 	</td>";
						echo "	 	<td align='center'>";	
						echo "	 		<strong>last name</strong>";
						echo "	 	</td>";
						echo "	 	<td align='center'>";	
						echo "	 		<strong>email</strong>";
						echo "	 	</td>";
						echo "	 	<td align='center'>";	
						echo "	 		<strong>contact</strong>";
						echo "	 	</td>";
						echo "	 	<td align='center'>";	
						echo "	 		<strong>actions</strong>";
						echo "	 	</td>";
						echo "	 </tr>";
						while ($row = mysql_fetch_array($result)) {
							echo "   <tr>";
							echo "      <td style='padding: 5px;'>";
							echo 			$row['user_id'];
							echo "      </td>";

							echo "      <td style='padding: 5px;'>";
							echo 			$row['username'];
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
								echo "<a href='http://" . $_SERVER['SERVER_NAME'] ."/dashboard_admin/faculty_schedule.php?faculty=". $row['user_id'] ."'>schedule</a>";
							}
							echo "      </td>";

							echo "   </tr>";
						}
						echo "<table>";
					?>		 	
				</div>
			</div>
			
		</div>
	</body>
</html>
