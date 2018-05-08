<?php

/*
 * Copyright 2011 Antti Ketola. All rights reserved.
 * 
 */
/**
 * This script sends to browser javascript client parameter for 
 * obfuscating login in JSON echo.
 * 
 * challenge: current time (about random)
 * serversalt: additional teaser string
 */
$session_start = session_start();
header('Content-type: application/json'); // Nota bien
$salt = $_SERVER['SERVER_NAME']; //mobilitio needs this way='127.0.0.1';"<here was a 17 byte hash of something>";
$jason = array();
if (isset($_GET["rtype"])) {
    $rtype = htmlspecialchars($_GET["rtype"]);
    if($rtype=="authpar") {
        $challenge = time(); //maybe md5 it?
        
        $_SESSION['challenge'] = $challenge;
        $jason['challenge'] = $challenge;
        $jason['salt'] = $salt;
    } else {
        $jason['response'] = 'INCORRECT REQUEST';
    }
} else {
    $jason['response'] = 'NOTHING TO GET';
}
$_SESSION['serversalt'] = $salt;
echo json_encode($jason);
?>