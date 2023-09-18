<?php
require('mkCal.php');

//TODO: Improve code comments

$DaysTextArray[2][18]="goerdy";
$DaysColorArray[2][18]="#FF0000";
$DaysColorArray[4][22]="#00FF00";
$DaysColorArray[12][3]="#0000FF";
$DaysHolidaysArray[3][17]="true";

//function mkCal($title, $Year, $locale, $daysText, $daysColor, $daysHolidays, $highlightHolidays, $highlightSunday, $ighlightSaturday, $footer, $format, $colorSceme)

//TODO: Check if possible to move constructor to mkCal function or build a wrapper
$pdf = new PDF('L','mm','A4');
$pdf->mkCal("Example Calendar", 2024 ,"en_US", $DaysTextArray, $DaysColorArray, $DaysHolidaysArray, "#AAAA00" ,"#FF0000", "#990000", "some customizeable footer text", "A4Landscape", "blue");

?>
