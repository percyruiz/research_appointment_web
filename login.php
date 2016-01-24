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
<title>Login</title>
<link rel="stylesheet" href="css/css_login.css" />
</head>
<body>
<?php
	require('db.php');
	session_start();
    // If form submitted, insert values into the database.
    if (isset($_POST['username'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
		$username = stripslashes($username);
		$username = mysql_real_escape_string($username);
		$password = stripslashes($password);
		$password = mysql_real_escape_string($password);
	//Checking is user existing in the database or not
        $query = "SELECT * FROM `users` WHERE username='$username' and password='".md5($password)."'";
		$result = mysql_query($query) or die(mysql_error());
		$rows = mysql_num_rows($result);
		
		while ($row = mysql_fetch_array($result)) 
		{
			$usertype = $row['user_type']; 
			$user_id = $row['user_id']; 
		}

        if($rows==1){
        	$_SESSION['userid'] = $user_id;
			$_SESSION['username'] = $username;
			$_SESSION['usertype'] = $usertype;

			header("Location: index.php"); // Redirect user to index.php
         }else{
		 	echo "<div class='form'><h3>Username/password is incorrect.</h3><br/>Click here to <a href=http://". $_SERVER['SERVER_NAME'] ."/login.php>Login</a></div>";
		 }
    }else{
?>
<div class="form">
<h1>Log In</h1>
	<form action="" method="post" name="login">
		<input type="text" name="username" placeholder="Username" required />
		<input type="password" name="password" placeholder="Password" required />
		<input name="submit" type="submit" value="Login" />
	</form>
<p>Not registered yet? <a href='/dir_users/add_user.php'>Register Here</a></p>
</div>
<?php } ?>
</body>
</html>
