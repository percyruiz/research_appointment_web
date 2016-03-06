<?php
/*
Author: Javed Ur Rehman
Website: https://htmlcssphptutorial.wordpress.com
*/
?>

<?php 
//access from root folder
	session_start();
	$path = $_SERVER['DOCUMENT_ROOT'];
	$path .= "/db.php";
	require($path);
	include("auth.php"); //include auth.php file on all secure pages 
?>

<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<title>Research Monitoring</title>
	<link rel="stylesheet" href="../css/bootstrap/css/bootstrap.css" />
	</head>

	<body>
		<div class="container">
			<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_faculty/handled_researches.php';?>">Back</a>
			<br/>
			<br/>

			<?php 
				if (isset($_GET['id'])){

                    $research_code = $_GET['id'];

                    $query = "SELECT * FROM `appointments` WHERE research_code='$research_code'";
                    $result = mysql_query($query) or die(mysql_error());


                    $resultResearch = mysql_query("SELECT * FROM `researches` WHERE research_code='$research_code' LIMIT 1");
                    $rowResearch = mysql_fetch_assoc($resultResearch);
                    $research_title = $rowResearch['research_title'];

                    $resultLeader = mysql_query("SELECT * FROM `users` WHERE research_code='$research_code' LIMIT 1");
                    $rowLeader = mysql_fetch_assoc($resultLeader);
                    $leader_fname = $rowLeader['fname'];
                    $leader_mname = $rowLeader['mname'];
                    $leader_lname = $rowLeader['lname'];
                    $leader_id = $rowLeader['user_id'];
                    $leader_name = $leader_lname . ", " . $leader_fname . " " . $leader_mname;
				}
		    ?>

            <?php
                echo "<h5> <strong>Title: </strong> $research_title </h5>";
                echo "<h5> <strong>Proponents: </strong></h5>";
                echo  "- $leader_name <br/>";

                $queryMembers = "SELECT * FROM `members` WHERE user_id='$leader_id'";
                $resultMembers = mysql_query($queryMembers) or die(mysql_error());
                while ($rowMember = mysql_fetch_array($resultMembers)) {
                    echo  "- ".$rowMember['name'] . "<br/>";
                }

                echo "<table class='table table-striped table-hover' style='width:100%'>";
                echo "	 <thead>";
                echo "	 <tr>";
                echo "	 	<th>";
                echo "	 		<strong>Date</strong>";
                echo "	 	</th>";
                echo "	 	<th>";
                echo "	 		<strong>Duration of Consultation</strong>";
                echo "	 	</th>";
                echo "	 	<th>";
                echo "	 		<strong>Comments</strong>";
                echo "	 	</th>";
                echo "	 	<th>";
                echo "	 		<strong>Signed by</strong>";
                echo "	 	</th>";
                echo "	 	<th>";
                echo "	 		<strong>Percentage</strong>";
                echo "	 	</th>";
                echo "	 </tr>";
                echo "	 </thead>";
                echo "	 <tbody>";

                while ($row = mysql_fetch_array($result)) {
                    $appointment_id = $row['appointment_id'];
                    $research_code = $row['research_code'];
                    $date = $row['appoint_date'];
                    $time_fr = $row['appoint_time_fr'];
                    $time_to = $row['appoint_time_to'];
                    $time_min = (strtotime($time_to) - strtotime($time_fr)) / 60;
                    $remarks = $row['remarks'];
                    $percentage = $row['percentage'];

                    $faculty_id = $row['faculty_id'];
                    $resultFaculty = mysql_query("SELECT * FROM `users` WHERE faculty_id='$faculty_id' LIMIT 1");
                    $rowFaculty = mysql_fetch_assoc($resultFaculty);
                    $faculty_fname = $rowFaculty['fname'];
                    $faculty_mname = $rowFaculty['mname'];
                    $faculty_lname = $rowFaculty['lname'];
                    $faculty_name = $faculty_lname . "," . $faculty_fname . " " . $faculty_mname;

                    echo "    <tr>";
                    echo "        <td width='10%'>";
                    echo "          $date";
                    echo "        </td>";

                    echo "        <td width='10%'>";
                    echo "          $time_min". " mins";
                    echo "        </td>";

                    echo "        <td width='50%'>";
                    echo "          $remarks";
                    echo "        </td>";

                    echo "        <td width='20%'>";
                    echo "          $faculty_name";
                    echo "        </td>";

                    echo "        <td width='10%'>";
                    echo "          $percentage"."%";
                    echo "        </td>";
                    echo "    </tr>";


                }

                echo "    </tbody>";
                echo "  </table>";
            ?>

		</div>
	<br/>
	</body>

</html>
