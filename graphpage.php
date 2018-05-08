<!--
Copyright 2011. All rights reserved.

-->
<?php
session_start();
if (!isset($_SESSION['sesUserName'])) {
    header('Location: ./login.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>GLU - Graphics</title>
        <script type="text/javascript">
            var daterangeinuse="no";
            winW = 630;
            winH = 460;
            function getWindowDim() {                
                if (document.body && document.body.offsetWidth) {
                    winW = document.body.offsetWidth;
                    winH = document.body.offsetHeight;
                }
                if (document.compatMode=='CSS1Compat' &&
                    document.documentElement &&
                    document.documentElement.offsetWidth ) {
                    winW = document.documentElement.offsetWidth;
                    winH = document.documentElement.offsetHeight;
                }
                if (window.innerWidth && window.innerHeight) {
                    winW = window.innerWidth;
                    winH = window.innerHeight;
                }                
            }
            function redrawTheGrafix() {
                getWindowDim();
                pic=document.getElementById("theGrafix");
                pic.innerHTML = "<img src='./php/graph.php?ScreenHeight="+winH+"&DateRangeInUse="+daterangeinuse+"&ScreenWidth="+winW+
                    "&StartDate="+document.getElementById("startdate").value+
                    "&EndDate="+document.getElementById("enddate").value+"'>";
                
            }            
            
            function checkDateUse() {
                $inuseval = document.getElementById("usedaterange").checked;
                if($inuseval) {
                    document.getElementById("dateinputs").style.display="block";
                    daterangeinuse="yes";
                } else {                    
                    document.getElementById("dateinputs").style.display="none";
                    daterangeinuse="no";
                }
                redrawTheGrafix();
            }
            
        </script>
        <link rel="StyleSheet" href="./css/glycemic.css"/>
    </head>
    <body onload="redrawTheGrafix()" onresize="redrawTheGrafix()">
        <div class="header">
            <input type="checkbox" id="usedaterange" onchange="checkDateUse()" >Use date range</input>
            <div id="dateinputs" style="display:none">
                Start date<input type="text" id="startdate" value="YYYY-MM-DD" onchange="redrawTheGrafix()"></input>
                <br>
                End date<input type ="text" id="enddate" value="YYYY-MM-DD" onchange="redrawTheGrafix()"></input>                
                <input type="button" value ="Refresh" style="background-color: lightgray, color: black" onclick="redrawTheGrafix()"></input>
            </div>
        </div>
        <div class="graphics" id="theGrafix"></div>
        <div class="footer">
            <a href="./index.php">Main Menu</a>
            <a href="./php/logout.php">Log out</a>
        </div>
    </body>
</html>
