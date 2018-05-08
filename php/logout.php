<?php
/*
 * Copyright 2011. All rights reserved.
 * 
 */
$ses=session_start();
unset($_SESSION['DBMAN']);
unset($_SESSION['sesUserName']);
$_SESSION = array();
session_unset();
session_destroy();
setcookie("PHPSESSID","",time()-3600,"/"); // delete session cookie 
header("Location: ../login.php");
?>
