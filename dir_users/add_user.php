<?php
/*
Author: Javed Ur Rehman
Website: https://htmlcssphptutorial.wordpress.com
*/
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Registration</title>
<link rel="stylesheet" href="../css/bootstrap/css/login.css" />
</head>
<body>
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
		$studentnum = $_POST['studentnum'];
		
		$username = stripslashes($username);
		$username = mysql_real_escape_string($username);

		$password = stripslashes($password);
		$password = mysql_real_escape_string($password);
		
		$usertype = "STUDENT";
		
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

		$studentnum = stripslashes($studentnum);
		$studentnum = mysql_real_escape_string($studentnum);
		
		$queryUsername = "SELECT * FROM `users` WHERE username='$username'";
		$resultUsername = mysql_query($queryUsername);
		
		$rows = mysql_num_rows($resultUsername);
		
		$query = "UPDATE `users` SET
				username='$username', 
				password='".md5($password)."', 
				user_type='$usertype', 
				fname='$fname', 
				mname='$mname', 
				lname='$lname', 
				email='$email', 
				contact='$contact',
				student_no='$studentnum'
				WHERE research_code='$username'";
		$result = mysql_query($query);
		if($result){
			$queryResearches = "UPDATE `researches` SET
					student_no='$studentnum'
					WHERE research_code='$username'";
			$resultResearches = mysql_query($queryResearches);
			if($resultResearches){
				echo " <div class='alert alert-dismissible alert-info'>" .
					"You are registered successfully. Click here to <a href=http://".
					$_SERVER['SERVER_NAME'] ."/login.php>Login</a></div>";

			}
		}else{
			echo mysql_error();
		}
	}
	?>
	<div class="form container">
		<div id="logbox">
			<form name="registration" action="" method="post" id="signup">
				<h1>create an account</h1>
				<input class="input pass" type="text" name="username" placeholder="Username/Research Code" required />
				<input class="input pass" type="password" name="password" placeholder="Password" required />
				<input class="input pass" type="text" name="fname" placeholder="First Name" required />
				<input class="input pass" type="text" name="mname" placeholder="Middle Name" required />
				<input class="input pass" type="text" name="lname" placeholder="Last Name" required />
				<input class="input pass" type="number" name="studentnum" placeholder="Student Number" min="0" max="99999999999" required />
				<input class="input pass" type="email" name="email" placeholder="Email" required />
				<input class="input pass" type="text" name="contact" placeholder="Contact Number" required />
				<input class="inputButton" type="submit" name="submit" value="Register" />
			</form>
		</div>
	</div>
</body>
</html>
