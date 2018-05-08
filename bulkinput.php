<!--
Copyright 2011. All rights reserved.

-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="StyleSheet" href="./css/glycemic.css"/>
        <script type="text/javascript">
            function createTbl() {
            
            }
            function postRecords() {
                var tbl = document.getElementById("recordtbl");                
                var rows = tbl.getElementsByTagName("tr");
                alert("tbl.inputs1="+tbl.getElementsByTagName("input")[1].value);
                alert("rows="+rows);
                var cels;
                for(var r in rows) {                    
                //NOT WORK    alert("r0="+rows.getElementsByTagName("input")[0]);
                }
                
            }
        </script>
    </head>
    <body>
        <table class="datain" id="recordtbl">
            <form id="bulkform">
                <tr><th>Time</th><th>Glucose</th><th>Carbs</th><th>Q-Insuline</th><th>L-Insuline</th></tr>
                <?php
                for ($i = 0; $i < 2; $i++) {
                    ?>
                    <tr><td>
                            <input class="datain" type="text"/>
                        </td>
                        <td>
                            <input class="datain" type="text"/>
                        </td>
                        <td><input class="datain" type="text"/>
                        </td>
                        <td>
                            <input class="datain" type="text"/>
                        </td>
                        <td><input class="datain" type="text"/>
                        </td>
                    </tr>
                    <?php
                }
                ?>

        </table>
        <input type="button" onclick="postRecords()" label="paina" value="PUSH"/>        
    </form>
</table>
</body>
</html>
