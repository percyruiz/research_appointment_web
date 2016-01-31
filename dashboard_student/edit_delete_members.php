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
<title>Registration</title>
<link rel="stylesheet" href="../css/bootstrap/css/bootstrap.css" />
</head>
<body>

<div class="container">
<?php
	// require('db.php');
	//access from root folder
	$path = $_SERVER['DOCUMENT_ROOT'];
	$path .= "/db.php";
	require($path);
   
    // If form submitted, insert values into the database.
     // if (isset($_POST['research'])){

        $userid = $_SESSION['userid'];

        $queryMembers = "SELECT * FROM `members` WHERE user_id='$userid'";
       	$resultMembers = mysql_query($queryMembers) or die(mysql_error());
    	$rows = mysql_num_rows($resultMembers);
    	
		if($rows == 0){
			echo "No Members yet.<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/insert_members.php'>Add Members</a></div>";
			echo "<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/dashboard_student.php'>Back</a></div>";
		}else{
			
			if($resultMembers){
				if (isset($_POST['name'])){
								$membername = $_POST['name'];								
				$member_id = $_POST['memberid'];
				
				$membername = stripslashes($membername);
				$membername = mysql_real_escape_string($membername);

				echo "THis is it";
				echo $membername;
		
				$queryUpdate = "UPDATE members SET name='$membername' WHERE member_id = '$member_id'";
				$resultUpdate = mysql_query($queryUpdate) or die(mysql_error());
				
				if($resultUpdate){
					header("Location: http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/edit_delete_members.php");
				}else{
					echo mysql_error();
				}
				}
				else{
				echo "<div class='form'><h4>HERE ARE THE MEMBERS.</h4><br/>";
				echo "<table class='table' border='1' style='width:70%'>";
				echo "   <tr>";
				echo "      <td align='center'>";   
				echo "          <strong>Name</strong>";
				echo "      </td>";
				echo "      <td align='center'>";
				echo "          <strong>Action to do</strong>";
				echo "      </td>";
				echo "   </tr>";
				while ($row = mysql_fetch_array($resultMembers)) 
				{
					echo "   <tr>";
					echo "      <td align='center'>";
					echo "		<div class='row'>";
					echo "		<div class='col-md-6'>";
					echo "		<form method='post' name='saveForm'>";					
					echo "		<input type='text' name='name' value='". $row['name'] ."'>";
					//$_SESSION['membername'] = $row['name'];
					//$_SESSION['member_id'] = $row['member_id'];
					echo "      </td>";
					echo "      <td align='center'>";


					//echo '			<input type="hidden" name="membername" value='.$row['name'].'/>';
					echo '			<input type="hidden" name="memberid" value='.$row['member_id'].'/>';
					echo "			<input style='color:#0000FF' type='submit' name='savebutton' value='SAVE'/>";
					echo "		</form>";
					echo "		</div>";
					echo "		<div class='col-md-6'>";
					echo "		<form action='delete_member.php'  method='post' name='deleteForm'>";
					echo '			<input type="hidden" name="memberid" value='.$row['member_id'].'/>';
					echo "			<input style='color:#0000FF' type='submit' name='delete' value='DELETE'/>";
					echo "		</form>";
					echo "		</div>";
					echo "		</div>";
					//echo '		<input type="button" name="edit" value="SAVE" onclick="alert(".this is message.")";>';
					//echo "		<input type='button' name='edit' value='DELETE' onclick='location.href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/delete_member.php';'>";
					echo "      </td>";
					echo "   </tr>";
				}
				
				echo "<table>";
				echo "<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/dashboard_student.php'>Back</a></div>";
				echo "<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/insert_members.php'>Add another member</a></div>";
				echo "<br/><a href='http://". $_SERVER['SERVER_NAME'] ."/dashboard_student/dashboard_student.php'>Edit or Delete Member</a></div>";
			}
			}else{
				echo mysql_error();
			}

        }
    // }else{
?>
</div>
</body>
</html>