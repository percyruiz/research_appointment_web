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
    if (isset($_POST['to_pdf'])){
		$to_pdf = $_POST['to_pdf'];
		include("mpdf/mpdf.php");
		$mpdf = new mPDF('win-1252', 'A4-L', '', '', 10, '', '', '', '', '');
		$mpdf -> useOnlyCoreFonts = true;
		$mpdf -> SetDisplayMode('fullpage');
		$mpdf -> WriteHTML($to_pdf);
		$mpdf -> Output();// this generates the pdf
		exit;
	}
?>
</body>
</html>
