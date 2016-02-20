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
	<link rel="stylesheet" href="../css/bootstrap/css/bootstrap.css" />
</head>
	<body>
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>">Logout </a></li>
		</ul>

		<div class="form">
		<h1>Change Password</h1>
			<form class="form-horizontal" action="change_password.php" method="post" name="ChangePass">
				<input class="form-control" type="password" name="oldpassword" placeholder="Old Password" required /><br/>
				<input class="form-control" type="password" name="newpassword" placeholder="New Password" required /><br/>
				<input class="form-control" type="password" name="confirmpassword" placeholder="New Password" required /><br/>
				<input class="btn btn-primary" name="submit" type="submit" value="Change Password" />
			</form>
		</div>
	</div>
</body>
</html>
