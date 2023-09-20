<?php
/*
-= PrintablePDFYearCalendar =-

https://github.com/goerdy/PrintablePDFYearCalendar

by Philipp "goerdy" Gürth
github@philipp-guerth.de

Version: 0.1
*/
//TODO: Improve code comments

//This is a simple example file to show the usage of PrintablePDFYearCalendar

//Include mkCal.php to your project
require('mkCal.php');

//Get your Data together
//you can use three 2-dimensional Arrays to deliver your data

//$DaysTextArray[MONTH][DAY] = string
$DaysTextArray[2][18]="goerdy"; //prints "goerdy" on february 18th

//$DaysColorArray[MONTH][DAY] = sting
$DaysColorArray[2][18]="#FF0000"; //red background for February 18th
$DaysColorArray[4][22]="#00FF00"; //green background for April 22nd
$DaysColorArray[12][3]="#0000FF"; //blue background for December 12

//DaysHolidaysArray[MONTH][DAY]= boolean
$DaysHolidaysArray[3][17]="true"; //March 17th is highlighted as holiday

//function PrintablePDFYearCalendar($title, $Year, $locale, $daysText, $daysColor, $daysHolidays, $highlightHolidays, $highlightSunday, $highlightSaturday, $footer, $format, $colorScheme)

PrintablePDFYearCalendar("Example Calendar", 2024 ,"en_US", $DaysTextArray, $DaysColorArray, $DaysHolidaysArray, "#0F0F0F" ,"#FF0000", "#990000", "some customizable footer text", "A4Landscape", "blue");
?>
