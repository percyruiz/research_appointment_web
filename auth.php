<?php
/*
Author: Javed Ur Rehman
Website: https://htmlcssphptutorial.wordpress.com
*/
?>

<?php
if(!isset($_SESSION["username"])){
	header("Location: login.php");
exit(); }
?>
