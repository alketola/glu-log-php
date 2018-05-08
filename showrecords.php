<!-- Shows downloads and shows all records as a table -->
<?php
include_once './dbman/HealthRecord.php';
include_once './dbman/DbMan.php';
include_once './conf/DbConf.php';

$session_start = session_start();

// Get/set session variables
if (!isset($_SESSION['sesUserName'])) {
    header("Location: ./login.php");
} else {
    $username = $_SESSION["sesUserName"];
    include_once './dbman/useDbMan.php';

//echo "showrecords opening database";
    $dbp->connect();

    $recarray = $dbp->getHealthRecordsAll($username);
    ?>
    <html>
        <head>
            <link rel="StyleSheet" href="./css/glycemic.css"/>
        </head>
        <body>
            <div class="header">
                <H3>Recorded data for <?php echo $_SESSION["sesUserName"]; ?></H3>    
                <table border="1">
                    <thead><th>T</th><th>Gluc</th><th>Carbs</th><th>Insul</th></thead>
                    <?php
                    for ($index = 0; $index < count($recarray); $index++) {
                        $record = $recarray[$index];
                        /* @var $record $HealthRecord */
                        echo "<tr><td>" . $record->rectime . "</td><td>" .
                        $record->glucose . "</td><td>" .
                        $record->carbs . "</td><td>" .
                        $record->insuline . "</td></tr>";
                    }
                    ?>
                </table>
                <?php
                $dbp->disconnect();
            }
            ?>
            <hr/>
            <div class="footer">
                <a href="./index.php">Main Menu</a>
                <a href="./php/logout.php">Log out</a>
            </div>
            <div class="logo"><img src="./images/mobilitioXS.png"></img></div>
    </body>
</html>