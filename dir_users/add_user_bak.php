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
<base href="http://citeappointments.byethost7.com/" />
<link rel="stylesheet" href="css/css_login.css" />
</head>
<body>
<?php
	//require('db.php');
	//access from root folder
	$path = $_SERVER['DOCUMENT_ROOT'];
	$path .= "/db.php";
	require($path);
   
    // If form submitted, insert values into the database.
    if (isset($_POST['username'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $usertype = $_POST['usertype'];
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
		$email = $_POST['email'];
		$contact = $_POST['contact'];
		
		$username = stripslashes($username);
		$username = mysql_real_escape_string($username);

		$password = stripslashes($password);
		$password = mysql_real_escape_string($password);
		
		$usertype = stripslashes($usertype);
		$usertype = mysql_real_escape_string($usertype);
		
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
				'$usertype', 
				'$fname', 
				'$mname', 
				'$lname', 
				'$email', 
				'$contact')";
        $result = mysql_query($query);
        if($result){
            echo "<div class='form'><h3>You are registered successfully.</h3><br/>Click here to <a href='login.php'>Login</a></div>";
        }else{
        	echo mysql_error();
        }
    }else{
?>
<div class="form">
<h1>Registration</h1>
<form name="registration" action="" method="post">
<input type="text" name="username" placeholder="Username" required />
<input type="password" name="password" placeholder="Password" required />

<select name="usertype">
  <option value="STUDENT">STUDENT</option>
  <option value="FACULTY">FACULTY</option>
</select>

<input type="text" name="fname" placeholder="First Name" required />
<input type="text" name="mname" placeholder="Middle Name" required />
<input type="text" name="lname" placeholder="Last Name" required />
<input type="email" name="email" placeholder="Email" required />
<input type="text" name="contact" placeholder="Contact Number" required />
<input type="submit" name="submit" value="Register" />
</form>
</div>
<?php } ?>
</body>
</html>
