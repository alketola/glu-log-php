<!--
Copyright 2011, Antti Ketola. All rights reserved.
MIT licence

This is the welcome page
-->
<?php
session_start();
if (!isset($_SESSION['sesUserName'])) {
    header("Location: ./login.php");
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>GLU - welcome</title>
        <link rel="StyleSheet" href="./css/glycemic.css"/>
    </head>
    <body>
        <div class="header">
            Welcome,
            <?php
            echo " " . $_SESSION['sesUserName'];
            ?>            
        </div>
        <div class="footer">
            <a href="index.php">Main Menu</a>
        </div>
        <div class="logo"><img src="./images/mobilitioXS.png"></img></div>        
    </body>
</html>
