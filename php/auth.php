<?php

include_once '../dbman/HealthRecord.php';
include_once '../dbman/DbMan.php';

$session_start = session_start();
/*
 * Copyright 2011 Antti Ketola. All rights reserved.
 * MIT LICENCE
 */
error_log("ak4");
$c = print_r($_COOKIE, true);
error_log("COOKIE=" . $c, 0);
$login = htmlspecialchars($_POST['username']);
$trypass = htmlspecialchars($_POST['password']);
$trychallenge = htmlspecialchars($_POST['challenge']);
$p = print_r($login, true);
error_log("Login=" . $p, 0);

try {
    $challenge = $_SESSION['challenge'];
    $salt = $_SESSION['serversalt'];
    $p = print_r("server salt   =" . $salt, true);
    error_log($p, 0);
    
    $p = print_r("challenge   =" . $challenge, true);
    error_log($p, 0);
    $p = print_r("trychallenge=" . $trychallenge, true);
    error_log($p, 0);

    if ($challenge != $trychallenge) {
        error_log("LOGIN: BADD CHALLENGE",0);
        throw new Exception("LOGIN: BAD CHALLENGE", 0, null);
    }

// get password from DB by username

    $username = $login;
    include_once '../dbman/useDbMan.php';
    $dbp->connect();
    $dbpass = $dbp->getPassword($login); // db contains md5 & salted passwords
    $dbp->disconnect();
    $dbHashPass = md5($dbpass . $challenge);

    $p = print_r("DBhPass=" . $dbHashPass, true);
    error_log($p, 0);
    $p = print_r("tryPass=" . $trypass, true);
    error_log($p, 0);

    if ($trypass === $dbHashPass) {
        //login succeeded
        $_SESSION['sesUserName'] = $username;
        unset($_SESSION['challenge']);
        //echo "LOGIN SUCCESS";
        //ob_start();
        header("Login-Success: yes");
        header("Location: ../welcome.php");

        //ob_flush();
    } else { // login failed }
        unset($_SESSION['sesUserName']);
        throw new Exception("LOGIN: PASSWORD MISMATCH", 0, null);
    }
} catch (Exception $e) {
    if (isset($_SESSION['sesUserName'])) {
        unset($_SESSION['sesUserName']);
    }
    header("Login-Success: no");
    header("Location: ../loginfail.php");
}
unset($_SESSION['challenge']);
?>
