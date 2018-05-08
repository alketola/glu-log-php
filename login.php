<!--
Copyright 2011. All rights reserved.

-->
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
                challenge = res.challenge;
                salt = res.salt;
                document.getElementById("challenge").setValue(challenge);
                document.getElementById("salt").setValue(salt);
                //alert("js:Stored auth res: " challenge:"+ challenge);
            }

            function sendBack() {
                var plp = document.getElementById("plainpass");
                var unm = document.getElementById("username").value;
                //var salt = document.getElementById("salt").value;
                //alert("Send back parms: plain password="+plp.value+" salt="+salt+" username="+ unm +" challenge="+challenge);
                
                var hashpass = hex_md5(hex_md5(plp.value+salt) + challenge);//password
                //alert("hex_md5(unm.value=" +unm+") = "+hex_md5(unm));
                plp.value="";
                
                document.forms.loginform.password.setValue(hashpass);
                document.forms.loginform.submit();
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
            <h3>Sign in, please</h3>
        </div>
        <div class="form">
            <form id="loginform" action="./php/auth.php" method="POST">
                User<input id="username" name="username"/><br>
                Pass<input type="password" id="plainpass"/><br/>
                <button type="button" id="entradasubmit" onclick="sendBack()">Login</button>
                <input type="hidden" name="password" id="password" value="" >
                <input type="hidden" name="challenge" id="challenge" value="" >
            </form>
            <p>
                <a href="./index.php">Main Menu</a>
                <a href="./php/logout.php">Log out</a>
            </p>
            <input type="hidden" name="salt" id="salt" value="" />
        </div>
        <div class="footer">            
        </div>
        <div class="logo"><img src="./images/mobilitioXS.png"></img></div>
    </body>
</html>
