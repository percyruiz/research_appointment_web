<?php
/*
Author: Javed Ur Rehman
Website: https://htmlcssphptutorial.wordpress.com
*/
?>

<?php
$connection = mysql_connect('localhost', 'root', '');
if (!$connection){
    die("Database Connection Failed" . mysql_error());
}
$select_db = mysql_select_db('citeappo_db01152016');
if (!$select_db){
    die("Database Selection Failed" . mysql_error());
}
?>