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
<title>Change Password</title>
<link rel="stylesheet" href="css/css_login.css" />
</head>
<body>
<div class="form">
<h1>Change Password</h1>
	<form action="change_password.php" method="post" name="ChangePass">
		<input type="password" name="oldpassword" placeholder="Old Password" required />
		<input type="password" name="newpassword" placeholder="New Password" required />
		<input type="password" name="confirmpassword" placeholder="New Password" required />
		<input name="submit" type="submit" value="Change Password" />
	</form>
</div>
</body>
</html>
