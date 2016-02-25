<?php
/*
Author: Javed Ur Rehman
Website: https://htmlcssphptutorial.wordpress.com
*/
?>

<?php
$connection = mysql_connect('sql100.byethost7.com', 'b7_16992137', 'capstone123');
if (!$connection){
    die("Database Connection Failed" . mysql_error());
}
$select_db = mysql_select_db('b7_16992137_citeappointments');
if (!$select_db){
    die("Database Selection Failed" . mysql_error());
}
?>