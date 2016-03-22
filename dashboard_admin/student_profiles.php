<?php
/*
Author: Javed Ur Rehman
Website: https://htmlcssphptutorial.wordpress.com
*/
?>
<?php 
session_start();
include("auth.php"); //include auth.php file on all secure pages ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Manage Student</title>
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
	<div  class="container">

        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">ADMIN</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/dashboard_admin.php';?>"> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Manage Faculty</a></li>
						<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/consultation_history.php';?>"> <span class="glyphicon glyphicon-time" aria-hidden="true"></span> Consultation History</a></li>
						<li class="active"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/student_profiles.php';?>"> <span class="glyphicon glyphicon-education" aria-hidden="true"></span> Manage Student</a></li>
						<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/insert_research.php';?>"> <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> Add Research</a></li>
						<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/view_researches.php';?>"> <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> View Monitoring</a></li>
						<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/view_groups.php';?>"> <span class="glyphicon glyphicon-tower" aria-hidden="true"></span> View Groups</a></li>
						<li> <a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/logout.php';?>"> <span class="glyphicon glyphicon-off" aria-hidden="true"></span> Logout</a></li>
					</ul>
                </div>
            </div>
        </nav>

        <?php
			// require('db.php');
			//access from root folder
			$path = $_SERVER['DOCUMENT_ROOT'];
			$path .= "/db.php";
			require($path);
			$userid = $_SESSION['userid'];
		?>
        <?php
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
                    echo " <div class='alert alert-dismissible alert-info'>" . " Create Successful </div>";
                }
            }else{
                echo mysql_error();
            }
        }
        ?>

		<div class="row">

            <div class="col-md-3">
                <h5>Add Student</h5>
                <form name="registration" action="" method="post">
                    <input class="form-control" type="text" name="username" placeholder="Username/Research Code" required /><br/>
                    <input class="form-control" type="password" name="password" placeholder="Password" required /><br/>
                    <input class="form-control" type="text" name="fname" placeholder="First Name" required /><br/>
                    <input class="form-control" type="text" name="mname" placeholder="Middle Name" required /><br/>
                    <input class="form-control" type="text" name="lname" placeholder="Last Name" required /><br/>
                    <input class="form-control" type="number" name="studentnum" placeholder="Student Number" min="0" max="99999999999" required /><br/>
                    <input class="form-control" type="email" name="email" placeholder="Email" required /><br/>
                    <input class="form-control" type="text" name="contact" placeholder="Contact Number" required /><br/>
                    <input class="btn btn-default" type="submit" name="submit" value="Register" /><br/>
                </form>
            </div>

			<div class="col-md-9">
				<h5>Student Profiles</h5>
				<?php
					$query = "SELECT * FROM `users` WHERE LOWER(`user_type`) = LOWER('STUDENT')";
					$result = mysql_query($query) or die(mysql_error());
					echo "<table class='table table-striped table-hover' style='width:100%'>";
					echo "	 <thead>";
					echo "	 <tr>";
					echo "	 	<th align='center'>";
					echo "	 		<strong>Username/Research Code</strong>";
					echo "	 	</th>";
					echo "	 	<th align='center'>";
					echo "	 		<strong>First Name</strong>";
					echo "	 	</th>";
					echo "	 	<th align='center'>";
					echo "	 		<strong>Middle Name</strong>";
					echo "	 	</th>";
					echo "	 	<th align='center'>";
					echo "	 		<strong>Last Name</strong>";
					echo "	 	</th>";
                    echo "	 	<th align='center'>";
                    echo "	 		<strong>Email</strong>";
                    echo "	 	</th>";
                    echo "	 	<th align='center'>";
                    echo "	 		<strong>Contact No</strong>";
                    echo "	 	</th>";
                    echo "	 	<th align='center'>";
                    echo "	 		<strong>Action</strong>";
                    echo "	 	</th>";
					echo "	 </thead>";
					echo "	 <tbody>";
					while ($row = mysql_fetch_array($result)) {
						echo "   <tr>";

						echo "      <td style='padding: 5px;'>";
						echo 			$row['research_code'];
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

                        echo "      <td>";
                        echo 			'<form name="registration" action="update_student.php" method="post">
                                            <input type="hidden" value="'. $row['student_no'] . '" name="student_no_update"  required />
                                            <input class="btn btn-default" type="submit" name="submit" value="Edit" />
                                        </form>';
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