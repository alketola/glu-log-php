<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
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


const NA = -1;
function copyPost($fieldname) {
    if(isset($_POST[$fieldname])) {
        $variable = htmlspecialchars($_POST[$fieldname]);
    } else {
        $variable = NA;
    }
    return $variable;
}

$recordtime = copyPost("recordtime");

//$recordtime = htmlspecialchars($_POST["recordtime"]);
$glucose = copyPost("glucose");
//$glucose = htmlspecialchars($_POST["glucose"]);
$carbs = copyPost("carbs");
//$carbs = htmlspecialchars($_POST["carbs"]);
$insuline = copyPost("insuline");
//$insuline = htmlspecialchars($_POST["insuline"]);
$insulinetyoe = copyPost("insulinetype");
//$insulineType=htmlspecialchars($_POST["insulinetype"]);
$weight = copyPost("weight");
//$weight = htmlspecialchars($_POST["weight"]);
$diastolic = copyPost("diastolic");
//$diastolic = htmlspecialchars($_POST["diastolic"]); 
$systolic = copyPost("systolic");
//$systolic = htmlspecialchars($_POST["systolic"]);
$pulse = copyPost("pulse");
//$pulse = htmlspecialchars($_POST["pulse"]);

$dbp->connect();
$rv = $dbp->insertHealthRecord($recordtime, $username, $glucose, $carbs,
        $insuline, $insulineType, $weight, $diastolic, $systolic, $pulse);

$dbp->disconnect();
$header = header("Location: ../index.php");

?>