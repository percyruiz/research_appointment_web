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
        <ul class="breadcrumb">
            <li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/student_profiles.php';?>">Back</a></li>
        </ul>

        <?php
			// require('db.php');
			//access from root folder
			$path = $_SERVER['DOCUMENT_ROOT'];
			$path .= "/db.php";
			require($path);
			$userid = $_SESSION['userid'];
		?>

        <?php
            if(isset($_POST['student_no_update'])) {
                $student_no = $_POST['student_no_update'];
                $result_r = mysql_query("SELECT * FROM `users` WHERE student_no='$student_no' LIMIT 1");
                $student = mysql_fetch_assoc($result_r);
            }

        ?>

        <?php
            if (isset($_POST['username'])){
            $username = $_POST['username'];
            $fname = $_POST['fname'];
            $mname = $_POST['mname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $contact = $_POST['contact'];
            $studentnum = $_POST['studentnum'];

            $studentnum = stripslashes($studentnum);
            $studentnum = mysql_real_escape_string($studentnum);

            $username = stripslashes($username);
            $username = mysql_real_escape_string($username);

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


            $queryUsername = "SELECT * FROM `users` WHERE username='$username'";
            $resultUsername = mysql_query($queryUsername);

            $rows = mysql_num_rows($resultUsername);

            $query = "UPDATE `users` SET
            user_type='$usertype',
            fname='$fname',
            mname='$mname',
            lname='$lname',
            email='$email',
            contact='$contact'
            WHERE research_code='$username'";
            $result = mysql_query($query);
            if($result){
                $queryResearches = "UPDATE `researches` SET
            student_no='$studentnum'
            WHERE research_code='$username'";
                $resultResearches = mysql_query($queryResearches);
                if($resultResearches){
                    echo " <div class='alert alert-dismissible alert-info'>" . " Update Successful </div>";
                    $result_r = mysql_query("SELECT * FROM `users` WHERE student_no='$studentnum' LIMIT 1");
                    $student = mysql_fetch_assoc($result_r);
                }
            }else{
                echo mysql_error();
            }
        }
        ?>

                <h5>Update Student</h5>
                <form name="" action="" method="post">
                    <table width="30%">
                        <tr>
                            <td style="vertical-align: middle">
                                <label> username/research code: </label>
                            </td>
                            <td style="vertical-align: middle">
                                <input readonly value="<?php echo $student['research_code']?>" class="form-control" type="text" name="username" placeholder="Username/Research Code" required /><br/>
                            </td>
                        </tr>

                        <tr>
                            <td style="vertical-align: middle">
                                <label> student no: </label>
                            </td>
                            <td style="vertical-align: middle">
                                <input readonly value="<?php echo $student['student_no']?>" class="form-control" type="number" name="studentnum" placeholder="Student Number" min="0" max="99999999999" required /><br/>
                            </td>
                        </tr>

                        <tr>
                            <td style="vertical-align: middle">
                                <label> first name: </label>
                            </td>
                            <td style="vertical-align: middle">
                                <input value="<?php echo $student['fname']?>" class="form-control" type="text" name="fname" placeholder="First Name" required /><br/>
                            </td>
                        </tr>

                        <tr>
                            <td style="vertical-align: middle">
                                <label> middle name: </label>
                            </td>
                            <td style="vertical-align: middle">
                                <input value="<?php echo $student['mname']?>" class="form-control" type="text" name="mname" placeholder="Middle Name" required /><br/>
                            </td>
                        </tr>

                        <tr>
                            <td style="vertical-align: middle">
                                <label> last name: </label>
                            </td>
                            <td style="vertical-align: middle">
                                <input value="<?php echo $student['lname']?>" class="form-control" type="text" name="lname" placeholder="Last Name" required /><br/>
                            </td>
                        </tr>

                        <tr>
                            <td style="vertical-align: middle">
                                <label> email: </label>
                            </td>
                            <td style="vertical-align: middle">
                                <input value="<?php echo $student['email']?>" class="form-control" type="email" name="email" placeholder="Email" required /><br/>
                            </td>
                        </tr>

                        <tr>
                            <td style="vertical-align: middle">
                                <label> contact no: </label>
                            </td>
                            <td style="vertical-align: middle">
                                <input value="<?php echo $student['contact']?>" class="form-control" type="text" name="contact" placeholder="Contact Number" required /><br/>
                            </td>
                        </tr>

                        <tr>
                            <td>
                            </td>
                            <td>
                                <input class="btn btn-primary" type="submit" name="submit" value="Update" /><br/>
                            </td>
                        </tr>
                    </table>
                </form>
	</div>
</body>
</html>