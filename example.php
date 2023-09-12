<?php
require('mkCal.php');

$DaysTextArray;
$DaysColorArray;
$DaysHollidaysArray;

$DaysTextArray[2][18]="Philipps Birthday";
$DaysColorArray[2][18]="green";
$DaysHollydaysArray[3][17]="true";

//function mkCal($title, $Year, $locale, $daysText, $daysColor, $daysHollidays, $highlightHollidays, $highlightSunday, $ighlightSaturday, $footer, $format)
$pdf = new PDF('L','mm','A4');
$pdf->mkCal("Test Calendar", 2023 ,"de_DE", $DaysTextArray, $DaysColorArray, $DaysHollydaysArray, "magenta" ,"red", "firebrick1", "some idiotic footer text", "A4Landscape");

?>
