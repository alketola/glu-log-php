<?php

/*
 * Copyright 2011 Antti Ketola. All rights reserved.
 * MIT LICENCE
 */
include_once '../dbman/HealthRecord.php';
include_once '../dbman/DbMan.php';

session_start();
if (!isset($_SESSION['sesUserName'])) {
    header("Location: ./login.php");
}
// Get/set session variables
//if (!isset($_SESSION['sesUserName'])) {
//    echo "No username for session";
//    header("Location: login.php");
//} else {
//    $username = $_SESSION["sesUserName"];
////    if ($username != "administrator") {
////        echo "Insufficient privileges";
////        header("Location: login.php");
////    }
//}
include_once '../dbman/useDbMan.php';

$adminop = htmlspecialchars($_POST['adminop']);
$trychallenge = htmlspecialchars($_POST['challenge']);
$challenge = $_SESSION['challenge'];
$salt = $_SESSION['serversalt'];

//if ($challenge != $trychallenge) {
//    throw new Exception("LOGIN: BAD CHALLENGE", 0, null);    
//    $adminop="";
//}


if ($adminop == "add") {
    $nusername = htmlspecialchars($_POST['username']);
    $newpass = htmlspecialchars($_POST['password']);
    $dbp->connect();
    $dbp->addUser($nusername, $newpass);
    $dbp->disconnect();
    echo "<p>user " . $username . " added </p> <a href='../index.php'>Back to main menu</a>";
}
?>
