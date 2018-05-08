<?php

/*
 * Copyright Antti Ketola 2012. All rights reserved.
 * 
 */
include '../dbman/HealthRecord.php';
include '../dbman/DbMan.php';

$session_start = session_start();

// Get/set session variables
if (!isset($_SESSION['sesUserName'])) {
    echo "No username for session";
    header("Location: ../login.php");
} else {
    $username = $_SESSION['sesUserName'];
    include_once '../dbman/useDbMan.php';
}

function copyField($fieldname, $a) {
    $variable = "";
    if (array_key_exists($fieldname, $a)) {
        $variable = htmlspecialchars($a[$fieldname]);
    } else {
        $variable = "-1";
    }
    // safeguard for empty valued keys
    if ($variable == "") {
        $variable = "-1";
    }
    return $variable;
}

//error_log("Posted to receiveData:");
//$p = print_r($_POST['json], true);
//error_log($p, 0);

$jsonstring = $_POST['json'];

$receiveChecksum = md5(stripslashes($jsonstring));
//DEBUGPRINT will mess output to unqualified
//print_r("receive checksum:" . $receiveChecksum, false);
//error_log($p, 0);
$json_a = json_decode(stripslashes($jsonstring), true);
//echo $jsonstring;
//$records = json_decode($j,true);
//$p = print_r($json_a);//, true);
//error_log($p, 0);
if ($json_a != null) {
    //   var_dump($json_a);
    foreach ($json_a['records'] as $r) {
        $recordtime = copyField('Time', $r);
        $glucose = copyField('glucose', $r);
        $carbs = copyField('carbs', $r);
        $insuline = copyField('insuline', $r);
        $insulineType = copyField('insulinetype', $r);
        $weight = copyField('weight', $r);
        $diastolic = copyField('diastolic', $r);
        $systolic = copyField('systolic', $r);
        $pulse = copyField('pulse', $r);

//    $recordtime = copyField('Time', $json_a);
//    $glucose = copyField('glucose', $json_a);
//    $carbs = copyField('carbs', $json_a);
//    $insuline = copyField('insuline', $json_a);
//    $insulineType = copyField('insulinetype', $json_a);
//    $weight = copyField('weight', $json_a);
//    $diastolic = copyField('diastolic', $json_a);
//    $systolic = copyField('systolic', $json_a);
//    $pulse = copyField('pulse', $json_a);

        $dbp->connect();
        $rv = $dbp->insertTimedHealthRecord($recordtime, $username, $glucose, $carbs, $insuline, $insulineType, $weight, $diastolic, $systolic, $pulse);
        $dbp->disconnect();

//    $header = header("Location: ../index.php");
//    echo $r, ":", $username, "/", $recordtime, "/", $glucose, "/", $carbs, "/",
//    $insuline, "/", $insulineType, "/", $weight, "/", $diastolic, "/", $systolic, "/", $pulse;
//        $p = "Final:" . $r . ":" . $username . "/" . $recordtime . "/" . $glucose . "/" . $carbs . "/" .
//                $insuline . "/" . $insulineType . "/" . $weight . "/" . $diastolic . "/" . $systolic . "/" . $pulse;
//        error_log($p, 0);
    }
    echo ($receiveChecksum); // the only permitted print
} else {
    //error_log("Garbage received.");
    echo ("###RECEIVE ERROR");
}
?>
