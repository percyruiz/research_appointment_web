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
	<link rel="stylesheet" href="../css/bootstrap/css/login.css" />
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

            if (strcasecmp($_SESSION['usertype'],"ADMIN")==0) {
                header("Location: dashboard_admin/dashboard_admin.php"); // Redirect user to index.php
            } else if (strcasecmp($_SESSION['usertype'],"FACULTY")==0) {
                header("Location: dashboard_faculty/dashboard_faculty.php"); // Redirect user to index.php
            }else if (strcasecmp($_SESSION['usertype'],"STUDENT")==0) {
                header("Location: dashboard_student/view_research.php"); // Redirect user to index.php
            }
         }else{
		 	echo "<div class=\"alert alert-danger\"> Username/password is incorrect. Click here to <strong><a href=http://". $_SERVER['SERVER_NAME'] ."/login.php>Login</a></strong></div>";
		 }
    }else{
?>

<div class="container">

    <div id="logbox">
        <center>
            <img src="image/tip_logo.png" alt="Logo" style="width:100px;height:100px;">
        </center>
        <form id="signup" action="" method="post" name="login">
            <h1>Research Appointment</h1>
            <input type="text" class="input pass" name="username" placeholder="Username" required autofocus>
            <input type="password" class="input pass" placeholder="Password"  name="password" required>
            <input type="submit" value="Sign me in!" class="inputButton"/>
            <div class="text-center"">
                <a href="/dir_users/add_user.php" >Create an account </a>
            </div>
        </form>
    </div>

</div>

<?php } ?>
</body>
</html>
