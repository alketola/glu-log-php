<?php
include_once '../dbman/DbMan.php';
include_once '../conf/DbConf.php';
global $dbp;
if (!isset($_SESSION["DBMAN"])) {
    $dbp = new DbMan();

    $_SESSION["DBMAN"] = serialize($dbp);
} else {

    $dbp = unserialize($_SESSION["DBMAN"]);
}

?>