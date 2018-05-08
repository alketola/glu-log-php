<!--
Display records as HTML page
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
        <title>GLU - input meal data for <?php echo $_SESSION['sesUserName']; ?></title>
        <link rel="StyleSheet" href="./css/glycemic.css"/>
    </head>
    <body>
        <div id="mealform" class="form">
            <form name="datos" action="./php/save.php" method="POST">
                <?php
                echo "<H2>Input meal data for " . $_SESSION['sesUserName'] . "</h2>";
                $recordtime = date("d.m.Y H:i", time());
                echo "Current time: " . $recordtime;
                ?>
                <input type="hidden" name="recordtime" value="<?php echo $recordtime ?>"></input>
                <p>
                    Glucose (mg/dl)<input type="text"  name="glucose"></input><br/>
                </p>
                <p>
                    Carbohydrates (g)<input type="text" name="carbs"></input><br/>
                </p>
                <p>
                    Insuline (units)<input type="text" name="insuline"></input><br/>
                </p>
                <p>
                </p>
                <input type="submit"></input>
            </form>
        </div>
        <div class="footer">                  
            <a href="./index.php">Main Menu</a>
            <a href="./php/logout.php">Log out</a>
        </div>
        <div class="logo"><img src="./images/mobilitioXS.png"></img></div>        
    </body>
</html>
