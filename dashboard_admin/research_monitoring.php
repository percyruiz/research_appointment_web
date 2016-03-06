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
			<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'].'/dashboard_admin/view_researches.php';?>">Back</a>
			<br/>
			<br/>

			<?php
                function getMonth($month){
                    switch($month){
                        case "Jan":{
                            return "January";
                        }
                        case "Feb":{
                            return "February";
                        }
                        case "Mar":{
                            return "March";
                        }
                        case "Apr":{
                            return "April";
                        }
                        case "May":{
                            return "May";
                        }
                        case "Jun":{
                            return "June";
                        }
                        case "Jul":{
                            return "July";
                        }
                        case "Aug":{
                            return "August";
                        }
                        case "Sep":{
                            return "September";
                        }
                        case "Oct":{
                            return "October";
                        }
                        case "Nov":{
                            return "November";
                        }
                        case "Dec":{
                            return "December";
                        }
                    }
                }

				if (isset($_GET['id'])){

                    $research_code = $_GET['id'];
                    $month = null;
                    if(isset($_POST['month']) && ($_POST['month'])!="All"){
                        $month = $_POST['month'];
                        $month_name = getMonth($month);
                        echo "<h5> <strong>Month: </strong> $month_name </h5>";
                        $query = "SELECT * FROM `appointments` WHERE research_code='$research_code' AND `appoint_date` LIKE '%$month%'";
                        $result = mysql_query($query) or die(mysql_error());
                    }else{
                        $query = "SELECT * FROM `appointments` WHERE research_code='$research_code'";
                        $result = mysql_query($query) or die(mysql_error());
                    }

                    $resultResearch = mysql_query("SELECT * FROM `researches` WHERE research_code='$research_code' LIMIT 1");
                    $rowResearch = mysql_fetch_assoc($resultResearch);
                    $research_title = $rowResearch['research_title'];
                    $research_type = $rowResearch['research_type'];
                    $faculty_id = $rowResearch['faculty_id'];

                    $resultLeader = mysql_query("SELECT * FROM `users` WHERE research_code='$research_code' LIMIT 1");
                    $rowLeader = mysql_fetch_assoc($resultLeader);
                    $leader_fname = $rowLeader['fname'];
                    $leader_mname = $rowLeader['mname'];
                    $leader_lname = $rowLeader['lname'];
                    $leader_id = $rowLeader['user_id'];
                    $leader_name = $leader_lname . ", " . $leader_fname . " " . $leader_mname;

                    $resultFaculty = mysql_query("SELECT * FROM `users` WHERE faculty_id='$faculty_id' LIMIT 1");
                    $rowFaculty = mysql_fetch_assoc($resultFaculty);
                    $faculty_fname = $rowFaculty['fname'];
                    $faculty_mname = $rowFaculty['mname'];
                    $faculty_lname = $rowFaculty['lname'];
                    $faculty_name = $faculty_lname . ", " . $faculty_fname . " " . $faculty_mname;

                    $to_pdf = "";

                    $to_pdf = $to_pdf . "<div width='100%' style='text-align:center'>";
                        $to_pdf = $to_pdf . "<strong>TECHNOLOGICAL INSTITUTE OF THE PHILIPPINES - QUEZON CITY</strong><br/>";
                        $to_pdf = $to_pdf . "<strong>College of Information Technology Education</strong><br/><br/>";
                        if($research_type == 'Thesis 1' || $research_type == 'Capstone 1'){
                            $to_pdf = $to_pdf . "<strong>CAPSTONE PROJECT 1/THESIS 1</strong><br/>";
                        }else{
                            $to_pdf = $to_pdf . "<strong>CAPSTONE PROJECT 2/THESIS 2</strong><br/>";
                        }
                        $to_pdf = $to_pdf . "<strong>Progress Monitoring Form</strong><br/>";
                        if($month!=null){
                            $month_name = getMonth($month);
                            $to_pdf = $to_pdf . "<strong>For the month of $month_name</strong><br/><br/>";
                        }
                    $to_pdf = $to_pdf . "</div>";

                    //echo

                    echo "<table width='100%'>";
                        echo "<tr>";
                        echo "    <td valign='top' width='80%'>";
                            echo "<strong>Title: </strong> $research_title ";
                        echo "    </td>";

                        echo "<td valign='top' width='20%'>";
                            echo "<strong> Proponents: </strong><br/>";
                            echo  "$leader_name <br/>";
                            $queryMembers = "SELECT * FROM `members` WHERE user_id='$leader_id'";
                            $resultMembers = mysql_query($queryMembers) or die(mysql_error());
                            while ($rowMember = mysql_fetch_array($resultMembers)) {
                                echo  $rowMember['name'] . "<br/>";
                            }
                        echo "</td>";
                        echo "</tr>";
                    echo "</table><br/>";

                    echo "<table width='100%'>";

                        echo "<tr>";
                        echo "    <td valign='top' width='80%'>";
                            echo "<strong>Adviser: </strong> $faculty_name ";
                        echo "    </td>";

                        echo "    <td valign='top' width='20%'>";
                        if($research_type == 'Thesis 1' || $research_type == 'Thesis 2'){
                            echo "<strong>Program: </strong> BS IT<br/>";
                        }else{
                            echo "<strong>Program: </strong> BS COMSCI<br/>";
                        }
                        echo "    </td>";
                        echo "</tr>";
                    echo "</table><br/>";

                    //echo

                    $to_pdf = $to_pdf . "<table width='100%'>";
                    $to_pdf = $to_pdf . "<tr>";
                    $to_pdf = $to_pdf . "    <td valign='top' width='80%'>";
                    $to_pdf = $to_pdf . "        <strong>Title: </strong> $research_title ";
                    $to_pdf = $to_pdf . "    </td>";

                    $to_pdf = $to_pdf . "<td valign='top' width='20%'>";
                    $to_pdf = $to_pdf . "    <strong> Proponents: </strong><br/>";
                    $to_pdf = $to_pdf .  "$leader_name <br/>";

                        $queryMembers = "SELECT * FROM `members` WHERE user_id='$leader_id'";
                        $resultMembers = mysql_query($queryMembers) or die(mysql_error());
                        while ($rowMember = mysql_fetch_array($resultMembers)) {
                            $to_pdf = $to_pdf .  $rowMember['name'] . "<br/>";
                        }
                    $to_pdf = $to_pdf . "    </td>";
                    $to_pdf = $to_pdf . "</tr>";
                    $to_pdf = $to_pdf . "</table><br/>";

                    $to_pdf = $to_pdf . "<table width='100%'>";
                    $to_pdf = $to_pdf . "    <tr>";
                    $to_pdf = $to_pdf . "        <td valign='top' width='80%'>";
                    $to_pdf = $to_pdf . "            <strong>Adviser: </strong> $faculty_name ";
                    $to_pdf = $to_pdf . "        </td>";

                    $to_pdf = $to_pdf . "        <td valign='top' width='20%'>";
                    if($research_type == 'Thesis 1' || $research_type == 'Thesis 2'){
                        $to_pdf = $to_pdf . "<strong>Program: </strong> BS IT<br/>";
                    }else{
                        $to_pdf = $to_pdf . "<strong>Program: </strong> BS COMSCI<br/>";
                    }
                    $to_pdf = $to_pdf . "        </td>";
                    $to_pdf = $to_pdf . "    </tr>";
                    $to_pdf = $to_pdf . "</table><br/>";
				}
		    ?>

            <form class="form-horizontal" action="" method="post">
                <select class="form-control-static" name="month">
                    <option value="All">All Months</option>
                    <option value="Jan">January</option>
                    <option value="Feb">February</option>
                    <option value="Mar">March</option>
                    <option value="Apr">April</option>
                    <option value="May">May</option>
                    <option value="Jun">June</option>
                    <option value="Jul">July</option>
                    <option value="Aug">August</option>
                    <option value="Sep">September</option>
                    <option value="Oct">October</option>
                    <option value="Nov">November</option>
                    <option value="Dec">December</option>
                </select>
                <input class="btn btn-primary" type="submit" name="submit" value="Filter" /><br/><br/>
            </form>

            <?php

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

                $to_pdf = $to_pdf . "<table class='table table-striped table-hover' style='width:100%'>";
                $to_pdf = $to_pdf . "	 <thead>";
                $to_pdf = $to_pdf . "	 <tr>";
                $to_pdf = $to_pdf . "	 	<th>";
                $to_pdf = $to_pdf . "	 		<strong>Date</strong>";
                $to_pdf = $to_pdf . "	 	</th>";
                $to_pdf = $to_pdf . "	 	<th>";
                $to_pdf = $to_pdf . "	 		<strong>Duration of Consultation</strong>";
                $to_pdf = $to_pdf . "	 	</th>";
                $to_pdf = $to_pdf . "	 	<th>";
                $to_pdf = $to_pdf . "	 		<strong>Comments</strong>";
                $to_pdf = $to_pdf . "	 	</th>";
                $to_pdf = $to_pdf . "	 	<th>";
                $to_pdf = $to_pdf . "	 		<strong>Signed by</strong>";
                $to_pdf = $to_pdf . "	 	</th>";
                $to_pdf = $to_pdf . "	 	<th>";
                $to_pdf = $to_pdf . "	 		<strong>Percentage</strong>";
                $to_pdf = $to_pdf . "	 	</th>";
                $to_pdf = $to_pdf . "	 </tr>";
                $to_pdf = $to_pdf . "	 </thead>";
                $to_pdf = $to_pdf . "	 <tbody>";

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

                    $to_pdf = $to_pdf . "    <tr>";
                    $to_pdf = $to_pdf . "        <td width='10%'>";
                    $to_pdf = $to_pdf . "          $date";
                    $to_pdf = $to_pdf . "        </td>";

                    $to_pdf = $to_pdf . "        <td width='10%'>";
                    $to_pdf = $to_pdf . "          $time_min". " mins";
                    $to_pdf = $to_pdf . "        </td>";

                    $to_pdf = $to_pdf . "        <td width='50%'>";
                    $to_pdf = $to_pdf . "          $remarks";
                    $to_pdf = $to_pdf . "        </td>";

                    $to_pdf = $to_pdf . "        <td width='20%'>";
                    $to_pdf = $to_pdf . "          $faculty_name";
                    $to_pdf = $to_pdf . "        </td>";

                    $to_pdf = $to_pdf . "        <td width='10%'>";
                    $to_pdf = $to_pdf . "          $percentage"."%";
                    $to_pdf = $to_pdf . "        </td>";
                    $to_pdf = $to_pdf . "    </tr>";

                }

                echo "    </tbody>";
                echo "  </table>";

                $to_pdf = $to_pdf . "    </tbody>";
                $to_pdf = $to_pdf . "  </table>";
            ?>

            <form class="form-horizontal" name="to_pdf" action="../to_pdf.php" method="post">
                <input type="hidden" name="to_pdf" value="<?php echo "<br/><br/>" . $to_pdf?>"/>
                <input class="btn btn-primary" type="submit" name="submit" value="Generate PDF" /><br/><br/>
            </form>
		</div>
	<br/>
	</body>

</html>
