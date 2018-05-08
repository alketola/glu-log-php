<!--
Copyright 2011 Antti Ketola. All rights reserved.
MIT LICENCE 2018
-->
<?php
session_start();
//if (!isset($_SESSION['sesUserName'])) {
//    header("Location: ../login.php");
//}
?>
<!DOCTYPE html>
<html>
    <head>
        <script type="text/javascript" src="javascript/prototype.js"></script>
        <script type="text/javascript" src="javascript/md5.js"></script>
        <script type="text/javascript">            
            form=null;
            function getAuthPar() {                
                url = "./php/getchallenge.php?rtype=authpar";
                var par = {
                    onSuccess: function(obj) {
                        storeAuthPar(obj);
                    }, method : "get"
                };

                var r = new Ajax.Request(url,par);
            }

            function storeAuthPar(obj) {                                     
                var res = obj.responseJSON;                
                salt = res.salt;
                challenge = res.challenge;
                //alert("js:Stored auth res: salt:"+salt+" challenge:"+ challenge);                
                document.getElementById("challenge").setValue(challenge);
                document.getElementById("salt").setValue(salt);
            }
    
            function testPasswords() {
                var indicator_p = document.getElementById("passwordindicator");
                var p1 = document.getElementById("plainpass").value;
                var p2 = document.getElementById("repassword").value;
                if (p1 == p2) {                    
                    if(p1.length < 8) {
                        indicator_p.innerHTML="<i>password min length is 8 characters</i>";
                        return false;
                    } else {
                        indicator_p.innerHTML="<b>matching passwords</b>";
                        return true;
                    }
                    
                } else {
                    indicator_p.innerHTML="<i>mismatch</i>";
                    return false;
                }
        
            }

            function sendBack() {
                var plp = document.getElementById("plainpass").value;
                var unm = document.getElementById("usuario").value;
                if (testPasswords()) {
                    //alert("Send back parms: plain password="+plp+" salt="+salt+"usuario="+ unm +" challenge="+challenge);
                
                    var myhash = hex_md5(plp+salt);
                    //alert("Send back: 3x hashed password:"+myhash);
                
                    document.getElementById("password").setValue(myhash);
                    document.forms.addform.submit();
                }
            }

        </script>
        <link rel="StyleSheet" href="./css/glycemic.css"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Login</title>

    </head>
    <body onload="getAuthPar()">
        <div class="header">
            <img src="./images/glu.png"></img>
            <H2>Great Logging Utility</h2>
        </div>
        <div class="form">
            <h3>Add user</h3>
            <form id="addform" action="./php/admin.php" method="POST">
                New username<input id="usuario" name="username"/><br>
                New password<input oninput="testPasswords()" type="password" id="plainpass"/><br/>
                Re-enter password<input oninput="testPasswords()" type="password" id="repassword"/><br/>
                Status: <a id="passwordindicator"></a><br/>
                <button type="button" id="entradasubmit" onclick="sendBack()">Add</button>
                <input type="hidden" name="password" id="password" value="" >
                <input type="hidden" name="adminop" id="adminop" value="add" >
                <input type="hidden" name="challenge" id="challenge" value="" >
            </form>
        </div>
        <div class="footer">                  
            <a href="./index.php">Main Menu</a>
            <a href="./php/logout.php">Log out</a>
        </div>
        <div class="logo"><img src="./images/mobilitioXS.png"></img></div>
    </body>
</html>
