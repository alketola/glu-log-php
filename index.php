<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>GLU - by mobilitio.com</title>
        <link rel="StyleSheet" href="./css/glycemic.css"/>
    </head>
    <body>
        <div class="header">
            <img src="./images/glu.png"/>
            <h2>Great Logging Utility</h2>
            <h3>on <?php echo $_SERVER['SERVER_NAME']; ?></h3>
        </div>
        <?php
        session_start();
        ?>
        <div class ="form"
             <p>
                <a class="menuitem" href="./login.php">Login</a><br/>
                <a class="menuitem" href="./php/logout.php">Logout</a><br/>
                <a class="menuitem" href="./rec.php">Diabetic: meal</a><br/>
                <a class="menuitem" href="./rlongi.php">Diabetic: Long Insuline</a><br/>
                <a class="menuitem" href="./showrecords.php">Diabetic: Show records</a><br/>
                <a class="menuitem" href="./graphpage.php">Diabetic: Graphics</a><br/>
                <a class="menuitem" href="./adduser.php">Admin: Add user</a><br/>
            </p>
        </div>
        <div class="footer">            
        </div>
        <div class="logo"><img src="./images/mobilitioXS.png"></img></div>
    </body>
</html>
