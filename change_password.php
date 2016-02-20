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
	<link rel="stylesheet" href="../css/bootstrap/css/bootstrap.css" />
</head>
<body>
<?php
	require('db.php');
	session_start();
	$username = $_SESSION['username'];
    $usertype = $_SESSION['usertype'];
	
    // If form submitted, insert values into the database.
    if (isset($_POST['newpassword'])){

        $oldpassword = $_POST['oldpassword'];
		$newpassword = $_POST['newpassword'];
		$confirmpassword = $_POST['confirmpassword'];
		
		$oldpassword = stripslashes($oldpassword);
		$oldpassword = mysql_real_escape_string($oldpassword);
		
		$newpassword = stripslashes($newpassword);
		$newpassword = mysql_real_escape_string($newpassword);
		
		$confirmpassword = stripslashes($confirmpassword);
		$confirmpassword = mysql_real_escape_string($confirmpassword);
		
	//Checking is user existing in the database or not
        $query = "SELECT * FROM `users` WHERE username='$username' and password='".md5($oldpassword)."'";
		$result = mysql_query($query) or die(mysql_error());
		$rows = mysql_num_rows($result);

		if($rows == 0){
			echo "<div class=\"alert alert-danger\">Old Password incorrect.</div>";
			include 'change_password_form.php';
		}
		else{
			if ($newpassword == $confirmpassword){
			$queryUpdate = "UPDATE users SET password='".md5($newpassword)."' WHERE username = '$username'";
			$resultUpdate = mysql_query($queryUpdate) or die(mysql_error());
			
				if($resultUpdate){
						echo "<div class=\"alert alert-dismissible alert-info\">Change Password Successful! ";
                        if (strcasecmp($_SESSION['usertype'],"FACULTY")==0){
                            echo "<strong><a href=http://". $_SERVER['SERVER_NAME'] ."/dashboard_faculty/dashboard_faculty.php>Go to Faculty Dashboard</a></strong></div>";
                        }else if(strcasecmp($_SESSION['usertype'],"STUDENT")==0){
                            echo "<strong><a href=http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/dashboard_student.php>Go to STUDENT dashboard</a></strong></div>";
                        }
				}
			}else{
				echo "<div class=\"alert alert-danger\">New Password and Confirm Password does not match.</div>";
				include 'change_password_form.php';
			}
		}
		/*
        if($rows==1){
        	$_SESSION['userid'] = $user_id;
			$_SESSION['username'] = $username;
			$_SESSION['usertype'] = $usertype;

			header("Location: index.php"); // Redirect user to index.php
         }else{
		 	echo "<div class='form'><h3>Username/password is incorrect.</h3><br/>Click here to <a href=http://". $_SERVER['SERVER_NAME'] ."/login.php>Login</a></div>";
		 }
		 */
    }else{
	include 'change_password_form.php';
	} ?>
</body>
</html>
