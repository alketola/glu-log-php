<?php

include_once '../dbman/HealthRecord.php';
include_once '../dbman/DbMan.php';

$session_start = session_start();

// Get/set session variables
if (!isset($_SESSION['sesUserName'])) {
    header("Location: ../login.php");
} else {
    include_once '../dbman/useDbMan.php';
}

function maxi_of(&$var, $par) {
    if ($par >= $var) {
        $var = $par;
    }
}

function mini_of(&$var, $par) {
    if ($par < $var) {
        $var = $par;
    }
}

/**
 * Snippet from http://roshanbh.com.np/2008/05/date-format-validation-php.html
 * Thanks.
 * @param type $date
 * @return type 
 */
function check_date_format($date)
{
  //match the format of the date
  if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts))
  {
    //check weather the date is valid of not
        if(checkdate($parts[2],$parts[3],$parts[1]))
          return true;
        else
         return false;
  }
  else
    return false;
}


    class Graph 
    {
    
        function __construct() {
            
        }
    
    function plot ($t,$tmin,$tmax,$pxleft,$pxright) {
        
    }

    }
/**
 * Fits argument with range from $minarg to $maxarg to a scale
 * of pixel positions between $origin and $end.
 * 
 * @param numeric $arg
 * @param numeric $minarg
 * @param numeric $maxarg
 * @param int $origin
 * @param int $end
 * @return int 
 */
function fit_to_scale($arg, $minarg, $maxarg, $origin, $end) {
    $rv = $origin;
    try {
        $rv = ceil(((($end - $origin) * ($arg - $minarg) / ($maxarg - $minarg))) + $origin);
    } catch (Exception $ex) {
        //echo 'Caught exception in fitToScale: ',  $e->getMessage(), "\n";
        $rv = $origin;
    }
    return $rv;
}

/**
 * Returns pixels per unit.
 * 
 * @param numeric $minunits   measurement units at origin
 * @param numeric $maxunits   measurement units at scale end
 * @param int $origin      origin position in pixels
 * @param int $end      scale end in pixels
 * @return real 
 */
function get_scale($minunits, $maxunits, $origin, $end) {
    return ($end - $origin) / ($maxunits - $minunits);
}

/**
 *
 * @param image $image      target image to draw on
 * @param int $startpx      starting pixel value
 * @param int $stoppx       ending pixel value
 * @param int $xpospx       x position pixel value
 * @param color $axiscolor  draw with color
 * @param int  $timemin    linear axis minimum value - use time()
 * @param int  $timemax    linear axis maximum value - use time()
 */
function draw_t_axis($image, $startpx, $stoppx, $ypospx, $axiscolor, $timemin, $timemax) {
//xaxis, time
    imagesetthickness($image, 1);
// draw horizontal axis
    imageline($image, $startpx, $ypospx, $stoppx, $ypospx, $axiscolor);

//config  variable settings. Should be constants?
    $textyoffset = 5;
    $labelwidth_year = 35;
    $labelwidth_monthyear = 45;
    $labelwidth_daymonthyear = 55;
    $labelwidth_dayhourmin = 65;
    $labelwidth_hourminsec = 65;
    $labelwidth = $labelwidth_hourminsec;
//draw vertical markers 'ticks'    
    $formatstring = "d-m-y h:m";
    $timestep = 60; /* sec */

    $timelength = ($timemax - $timemin);
    $width = $stoppx - $startpx;
//more than 2 years span
    if ($timelength > (2 * 365 /* days */ * 24 /* h */ * 60 /* min */ * 60/* sec */)) {
        $formatstring = 'y';
        $labelwidth = $labelwidth_year;
        $labelcount = $width / $labelwidth;
        $timestep = $timelength / $labelcount;
    } else { // more than 2 month span (shortest month for range def)
        if ($timelength > (2 * 28 /* days */ * 24 /* h */ * 60 /* min */ * 60/* sec */)) {
            $formatstring = 'm-y';
            $labelwidth = $labelwidth_monthyear;
            $labelcount = $width / $labelwidth;
            $timestep = $timelength / $labelcount;
        } else { // more than 14 day span
            if ($timelength > (14 /* days */ * 24 /* h */ * 60 /* min */ * 60/* sec */)) {
                $formatstring = 'd-m-y';
                $labelwidth = $labelwidth_daymonthyear;
                $labelcount = $width / $labelwidth;
                $timestep = $timelength / $labelcount;
            } else { // more than a day
                if ($timelength > ( 60 /* min */ * 60/* sec */)) {
                    $formatstring = 'd h:i';
                    $labelwidth = $labelwidth_dayhourmin;
                    $labelcount = $width / $labelwidth;
                    $timestep = $timelength / $labelcount;
                } else {
                    $formatstring = 'h:i:s';
                    $labelwidth = $labelwidth_hourminsec;
                    $labelcount = $width / $labelwidth;
                    $timestep = $timelength / $labelcount;
                }
            }
        }
    }

    $labelcount = 1 + $width / $labelwidth;

// dtaw the x-axis ticks and tick label texts
    $xticup = $ypospx - 4;
    $xticdown = $ypospx + 4;
    $tmo = new DateTime();
    $textypospx = $ypospx + $textyoffset;

    for ($timei = $timemin; $timei <= $timemax; $timei += $timestep) {
        $tmo->setTimestamp($timei);
        $ttext = $tmo->format($formatstring);
        $tx = fit_to_scale($timei, $timemin, $timemax, $startpx, $stoppx);

        imageline($image, $tx, $xticup, $tx, $xticdown, $axiscolor);
        imagestring($image, 3, $tx - 5, $textypospx, $ttext, $axiscolor);
        $lastx = $tx;
    }
}

/**
 *
 * @param type $image    target image to draw on
 * @param type $startpx  starting pixel value
 * @param type $stoppx   ending pixel value
 * @param type $xpospx   x position pixel value
 * @param type $axiscolor  draw with color
 * @param type $valuemin   linear axis minimum value
 * @param type $valuemax   linear axis maximum value
 * @param type $plotwidth - not used
 */
function draw_y_axis($image, $startpx, $stoppx, $xpospx, $axiscolor, $valuemin, $valuemax, $plotwidth) {
//xaxis, time
    $ylength = $stoppx - $startpx;
    imagesetthickness($image, 1);
    imageline($image, $xpospx, $startpx, $xpospx, $stoppx, $axiscolor);

    $scale = abs(get_scale($valuemin, $valuemax, $startpx, $stoppx));

    $tickunits = (($valuemax - $valuemin) > 12) ? 10 : 1;

    $nticks = ($valuemax - $valuemin) / $tickunits;
    $tickspace = abs($startpx - $stoppx) / $nticks;
    $textspacemin = 10;

    while ($tickspace < $textspacemin) {
        $tickunits +=10;
        $nticks = ($valuemax - $valuemin) / $tickunits;
        $tickspace = abs($startpx - $stoppx) / $nticks;
    }
    $fsz = 3;
    if ($fsz > 4) {
        $fsz = 4;
    }

    $yticleft = $xpospx - ceil($tickspace / 10);
    $yticright = $xpospx + ceil($tickspace / 10);
    $loff = 8;
    $voff = 12;
    for ($ix = 0; $ix < $nticks; $ix++) {
        $tic = $stoppx - ($ix * $tickspace);
        imageline($image, $yticleft, $tic, $yticright, $tic, $axiscolor);
        $stext = ceil($valuemin + ($ix * $tickunits));
        imagestring($image, $fsz, ($xpospx - $loff) < 0 ? 0 : ($xpospx - $loff), $tic - $voff, $stext, $axiscolor);
    }
}

// EXECUTION STARTS HERE
//echo "showrecords opening database";
define("MINDATE","1970-01-01");
define("MAXDATE","9999-12-01");

if (isset($_POST["DateRangeInUse"])) {
    $daterangeinuse_in = htmlspecialchars($_POST["DateRangeInUse"]);
} else {
    if (isset($_GET["DateRangeInUse"])) {
        $daterangeinuse_in = htmlspecialchars($_GET["DateRangeInUse"]);
    } else {
        $daterangeinuse_in = "no";        
    }
}

if ($daterangeinuse_in == "yes") {
    $daterangeinuse = true;

    if (isset($_POST["StartDate"])) {
        $startdate = htmlspecialchars($_POST["StartDate"]);
    } else {
        if (isset($_GET["StartDate"])) {
            $startdate = htmlspecialchars($_GET["StartDate"]);
        } else {
            $startdate = MINDATE;
        }
    }

    if (isset($_POST["EndDate"])) {
        $enddate = htmlspecialchars($_POST["EndDate"]);
    } else {
        if (isset($_GET["EndDate"])) {
            $enddate = htmlspecialchars($_GET["EndDate"]);
        } else {
            $enddate = MAXDATE;
        }
    }
} else {
    $daterangeinuse = false;
    $startdate = MINDATE;
    $enddate = MAXDATE;
}

// Check date range
if ($daterangeinuse == true) {
    if (false==check_date_format($startdate) ) {
        $startdate = MINDATE;
    }        
    if (false==check_date_format($enddate)) {
        $enddate = MAXDATE;
    }
} else {
    
}

$dbp->connect();

//$recarray = $dbp->getHealthRecordsAll($_SESSION["sesUserName"]);
$recarray = $dbp->getHealthRecordsBetweenDates($_SESSION["sesUserName"],$startdate,$enddate);
//HealthRecord::$recarray = $_POST("healthRecArray");
//these should be got from window size, AJAXing it from the browser
if (isset($_POST["ScreenWidth"])) {
    $screenwidth = htmlspecialchars($_POST["ScreenWidth"]);
} else if (isset($_GET["ScreenWidth"])) {
    $screenwidth = htmlspecialchars($_GET["ScreenWidth"]);
} else {
    $screenwidth = 800;
}

if (isset($_POST["ScreenHeight"])) {
    $screenheight = htmlspecialchars($_POST["ScreenHeight"]);
} else {
    if (isset($_GET["ScreenHeight"])) {
        $screenheight = htmlspecialchars($_GET["ScreenHeight"]);
    } else {
        $screenheight = 600;
    }
}

if (isset($_POST["ScreenHeight"])) {
    $screenheight = htmlspecialchars($_POST["ScreenHeight"]);
} else {
    if (isset($_GET["ScreenHeight"])) {
        $screenheight = htmlspecialchars($_GET["ScreenHeight"]);
    } else {
        $screenheight = 600;
    }
}

// analyze data
// get limits for scaling the chart
$reccount = count($recarray);
if ($reccount < 1) {
    $maxtime = time()+3600;
    $mintime = time();
    $maxgluc = 100;
    $mingluc = 0;
    $maxcarbs = 90;
    $mincarbs = 0;
    $maxins = 5;
    $minins = 0;
} else if ($reccount == 1) {
    $record = $recarray[0];
    $maxtime = $record->rectime +3600;
    $mintime = $record->rectime;
    $maxgluc = $record->glucose;
    $mingluc = 0;
    $maxcarbs = $record->carbs;
    $mincarbs = 0;
    $maxins = $record->insuline;
    $minins = 0;
} else {
    $record = $recarray[0];
    $maxtime = 1;
    $mintime = time();
    $maxgluc = 1;
    $mingluc = 0;
    $maxcarbs = 1;
    $mincarbs = 0;
    $maxins = 1;
    $minins = 0;
    $ix;

    for ($ix = 0; $ix < $reccount; $ix++) {
        $record = $recarray[$ix];

        maxi_of($maxtime, strtotime($record->rectime));
        mini_of($mintime, strtotime($record->rectime));

        maxi_of($maxgluc, $record->glucose);
//Mini($mingluc, $record->glucose);

        maxi_of($maxcarbs, $record->carbs);
//Mini($mincarbs, $record->carbs);

        maxi_of($maxins, $record->insuline);
//Mini($minins, $record->insuline);
//    public $weight; //Weight
//    public $diastolic; //Diastolic
//    public $systolic; //Systolic
//    public $pulse; //Pulse
    }
}

$imgwidth = $screenwidth - 10;
if ($daterangeinuse) 
    { $imgmargin = 88; } 
else 
    { $imgmargin = 44; }
$imgheight = (int) ($screenheight * 0.92) - $imgmargin;

$fsize = $imgwidth / 50;

$graph = imagecreate($imgwidth, $imgheight);
$bg = imagecolorallocate($graph, 250, 250, 250);
$Gcolor = imagecolorallocate($graph, 200, 0, 30); //red
$Ccolor = imagecolorallocate($graph, 10, 200, 100); //green
$Icolor = imagecolorallocate($graph, 10, 10, 200); //blue
$axiscolor = imagecolorallocate($graph, 10, 10, 10); //black

imagesetthickness($graph, 1);//ceil($imgheight / 200);

// pixel positions for axes off edges
$leftmargin = 0.2;
$rightmargin = 0.9;
$topmargin = 0.1;
$bottommargin = 0.9;


$xaxisy = ceil($imgheight * $bottommargin);
$xaxisleft = 50; //ceil($imgwidth * $leftmargin);
$xaxisright = ceil($imgwidth * $rightmargin);
$xlength = $xaxisright - $xaxisleft;

draw_t_axis($graph, $xaxisleft, $xaxisright, $xaxisy, $axiscolor, $mintime, $maxtime);
imagestring($graph, 4, $xaxisright + 5, $xaxisy - 5, "time", $axiscolor);
//yaxis

$yaxisx = ceil($imgwidth * $leftmargin);
$yaxistop = ceil($imgheight * $topmargin);
$yaxisbottom = ceil($imgheight * $bottommargin);
$yscala = get_scale($mingluc, $maxgluc, $yaxisbottom, $yaxistop);
draw_y_axis($graph, $yaxistop, $yaxisbottom, 6, $Gcolor, $mingluc, $maxgluc, $xlength);
draw_y_axis($graph, $yaxistop, $yaxisbottom, 30, $Ccolor, $mincarbs, $maxcarbs, $xlength);
draw_y_axis($graph, $yaxistop, $yaxisbottom, 50, $Icolor, $minins, $maxins, $xlength);

imagesetthickness($graph, 1);//ceil($imgheight / 100));
$dotsize = 5; //abs($xlength * $yscala) / 200 + 5;

$index = 0;
$record = $recarray[$index];
//$x0 = fitToScale($index, 0, $reccount, $xaxisleft, $xaxisright);
$xg0 = fit_to_scale($index, 0, $reccount, $xaxisleft, $xaxisright);
$yg0 = fit_to_scale($record->glucose, $mingluc, $maxgluc, $yaxisbottom, $yaxistop);
imagefilledellipse($graph, $xg0, $yg0, $dotsize, $dotsize, $Gcolor);
$xc0 = fit_to_scale($index, 0, $reccount, $xaxisleft, $xaxisright);
$yc0 = fit_to_scale($record->carbs, $mincarbs, $maxcarbs, $yaxisbottom, $yaxistop);
imagefilledellipse($graph, $xc0, $yc0, $dotsize, $dotsize, $Ccolor);
$xi0 = fit_to_scale($index, 0, $reccount, $xaxisleft, $xaxisright);
$yi0 = fit_to_scale($record->insuline, $minins, $maxins, $yaxisbottom, $yaxistop);
imagefilledellipse($graph, $xi0, $yi0, $dotsize, $dotsize, $Icolor);
$index++;
while ($index < count($recarray)) {
    $record = $recarray[$index];
    /* @var $record $HealthRecord */

    $xg = fit_to_scale(strtotime($record->rectime), $mintime, $maxtime, $xaxisleft, $xaxisright);
    if ($record->glucose > 0) {
        $yg = fit_to_scale($record->glucose, $mingluc, $maxgluc, $yaxisbottom, $yaxistop);
        imageline($graph, $xg0, $yg0, $xg, $yg, $Gcolor);
        imagefilledellipse($graph, $xg, $yg, $dotsize, $dotsize, $Gcolor);
        $yg0 = $yg;        
        $xg0 = $xg;

    }

    $xc = fit_to_scale(strtotime($record->rectime), $mintime, $maxtime, $xaxisleft, $xaxisright);
    if ($record->carbs > 0) {
        
        $yc = fit_to_scale($record->carbs, $mincarbs, $maxcarbs, $yaxisbottom, $yaxistop);
        imageline($graph, $xc0, $yc0, $xc, $yc, $Ccolor);
        imagefilledellipse($graph, $xc, $yc, $dotsize, $dotsize, $Ccolor);
        $yc0 = $yc;
        $xc0 = $xc;
    }
    
    if ($record->insuline > 0) {
        $xi = fit_to_scale(strtotime($record->rectime), $mintime, $maxtime, $xaxisleft, $xaxisright);
        $yi = fit_to_scale($record->insuline, $minins, $maxins, $yaxisbottom, $yaxistop);
        imageline($graph, $xi0, $yi0, $xi, $yi, $Icolor);
        imagefilledellipse($graph, $xi, $yi, $dotsize, $dotsize, $Icolor);
        $yi0 = $yi;
        $xi0 = $xi;
    }
        
    $index++;
}

// write legend texts
$cx = fit_to_scale(80, 0, 100, $xaxisleft, $xaxisright);
$cyg = fit_to_scale(20, 0, 100, $yaxisbottom, $yaxistop);

$gtext = imagestring($graph, $fsize, $yaxisx, 0, "Gluc", $Gcolor);
$ctext = imagestring($graph, $fsize, $yaxisx + 6 * 2 * $fsize, 0, "Carbs", $Ccolor);
$itext = imagestring($graph, $fsize, $yaxisx + 12 * 2 * $fsize, 0, "Insulin", $Icolor);

imagestring($graph, $fize, 90, 40, $startdate, $Gcolor);
imagestring($graph, $fize, 90, 60, $enddate, $Gcolor);
// show the drawn image
header("Content-Type: image/jpeg");
$imagejpeg = imagejpeg($graph);
?>        


