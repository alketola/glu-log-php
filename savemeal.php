<!DOCTYPE HTML>
<?php
/*
 * Displays recorded data as verification
 */
$recordtime = $_POST["recordtime"];
$glucose = $_POST["glucose"];
$carbs = $_POST["carbs"];
$insuline = $_POST["insulina"];

echo "Recordtime:" . $recordtime;
echo "Glucose:" . $glucose;
echo "Carbs:" . $carbs;
echo "Insuline" . $insuline;

?>
<br/>
<a href ="rec.php">Back</a>
<br/>