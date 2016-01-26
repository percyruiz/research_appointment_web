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
<link rel="stylesheet" href="../css/bootstrap/css/bootstrap.css" />
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
		
        $query = "INSERT into `users` (
				username, 
				password, 
				user_type, 
				fname, 
				mname, 
				lname, 
				email, 
				contact,
				student_no
				) VALUES (
				'$username', 
				'".md5($password)."', 
				'$usertype', 
				'$fname', 
				'$mname', 
				'$lname', 
				'$email', 
				'$contact',
				'$studentnum')";
        $result = mysql_query($query);
        if($result){
            echo "<div class='form'><h3>You are registered successfully.</h3><br/>Click here to <a href=http://". $_SERVER['SERVER_NAME'] ."/login.php>Login</a></div>";
        }else{
        	echo mysql_error();
        }
    }else{
?>
<div class="form container">
<h3>Registration</h3>
<form name="registration" action="" method="post">
<input type="text" name="username" placeholder="Username" required /><br/><br/>
<input type="password" name="password" placeholder="Password" required /><br/><br/>

<input type="text" name="fname" placeholder="First Name" required /><br/><br/>
<input type="text" name="mname" placeholder="Middle Name" required /><br/><br/>
<input type="text" name="lname" placeholder="Last Name" required /><br/><br/>
<input type="number" name="studentnum" placeholder="Student Number" min="0" max="99999999999" required /><br/><br/>
<input type="email" name="email" placeholder="Email" required /><br/><br/>
<input type="text" name="contact" placeholder="Contact Number" required /><br/><br/>
<input type="submit" name="submit" value="Register" /><br/><br/>
</form>
</div>
<?php } ?>
</body>
</html>