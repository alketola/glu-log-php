<!--
For recording insuline.
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
        <script type="text/javascript">
            function timeModeSelect(tms) {                
                
                var tidiv = document.getElementById("timeInputDiv");
                if (tms == 'systemtime') {
                    tidiv.style.display = "none";
                } else {
                    tidiv.style.display = "block";                   
                }
            }
            
            function checkTimeInput() {
                var ti=document.getElementById("timeInputField");
                alert("checkTimeInput("+ti.value+")");
            }
        </script>

    </head>
    <body>
        <div id="mealform" class="form">
            <form name="datos" action="./php/save.php" method="POST">
                <?php
                echo "<H2>Please give long insuline shot data for " . $_SESSION['sesUserName'] . "</h2>";
                ?>
                <select id="timemodesel" >
                    <option onclick="timeModeSelect('systemtime');" selected>System time</option>
                    <option onclick="timeModeSelect('usertime');">Input time manually</option>
                </select>
                <br/>
                <?php
                $recordtime = date("d.m.Y H:i", time());
                echo "Current time: " . $recordtime;
                ?>                
                <input type="hidden" name="recordtime" value="<?php echo $recordtime ?>"></input>                
                <div id="timeInputDiv" style="display: none" >
                    Time for dose: <input onchange="checkTimeInput()" type="text" length="20" id="timeInputField"></input>
                </div>
                <p>
                    Long lasting insuline (units)<input type="text" name="insuline"></input><br/>
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
