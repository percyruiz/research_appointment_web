<?php

    require('db.php');
    session_start();
    // If form submitted, insert values into the database.
    if (isset($_POST['username'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $username = stripslashes($username);
        $username = mysql_real_escape_string($username);
        $password = stripslashes($password);
        $password = mysql_real_escape_string($password);
    //Checking is user existing in the database or not
        $query = "SELECT * FROM 'users' WHERE username='$username' and password='".md5($password)."'";
        $result = mysql_query($query) or die(mysql_error());
        $rows = mysql_num_rows($result);
        
        /*$usertype = "";
        $usertype_result = mysql_query("SELECT usertype FROM users WHERE username='$username' and password='".md5($password)."'";
        */
        while ($row = mysql_fetch_array($result)) 
        {
            $usertype = $row['usertype'];  
        }

        if($rows==1){
            $_SESSION['username'] = $username;
            $_SESSION['usertype'] = $usertype;

         echo "<div class='form'><h3>Username/password ssis incorrect.</h3><br/>Click here to <a href='login.php'>Login</a></div>";
            }else{
                echo "<div class='form'><h3>Username/password is incorrect.</h3><br/>Click here to <a href='login.php'>Login</a></div>";
                }
    }


?>