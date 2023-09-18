# PrintablePDFYearCalendar

This project provides a script that renders a year calendar on a single page PDF file. This is perfect for workshift scedules, club meetings, school holidays and much more.
The option to color highlight days makes it clearer to read and gives an easy overview.

This projekt was made to print a 24-hour shift scedule for a career fire department and is used in that project [link to fireshift git].

It was a well considered desicion to use 2-dimensional arrays as input cause they are easy to fill with data from different sources and dont blow the code that much.

# Features

* highly customizeable
* text and color for each day seperatly
* multi language suport
* suports holidays (color highlightning)
* color highlighting for Saturday and Sunday (AFAIK that fits western and hebrew demands, if your culture needs other highlighting, let me know and i will add suport for this)

# Usage

1. include mkCal.php in your project
2. create new pdf
3. call mkCal function
 
require('mkCal.php');

$pdf = new PDF('L','mm','A4');

$pdf->mkCal("Example Calendar", 2024 ,"en_US", $DaysTextArray, $DaysColorArray, $DaysHolidaysArray, "#AAAA00" ,"#FF0000", "#990000", "some customizeable footer text", "A4Landscape", "#0000FF");



## style

$locale [string] e.g. "en_US" or "de_DE" for correct display of month and days in your lanaguage

$highlightHolidays [string] contains the Hex color key for holiday highlighting

$highlightSunday [string] contains the Hex color key for sunday highlighting

$ighlightSaturday [string] contains the Hex color key for saturday highlighting

*$format* [string] "A4Landscape" NOT IMPLEMENTED YET

*$colorSceme* [string] "red/blue/green/yellow"



## Calendar content

$title [string] contains the printed title of the calendar.

$Year [int] contains the Year of the Calendar (used to calculate weekdays...)

$footer [string] contains the footer text you want to be displayed.

Function expects three 2-dimensional Arrays. Where the first index is the month and the second is the day.

$DaysTextArray [string] contains the text to display in each given Day

$DaysColorArray [string] contains the Hex color key for backgroud color of each given Day

$DaysHolidaysArray [boolean] specifies if the given day is an holiday


example: 

$DaysTextArray[2][18]="goerdy";

//February the 18th displays "goerdy".


$DaysColorArray[2][18]="#FF0000";

//February the 18th has a red background.


$DaysHolidaysArray[3][17]="true";

//March the 17th is highlighted as holiday.


See well documented example.php for further information.

# Licence

*GNU GPL v3*

# Credits

Uses FPDF in version 1.86 http://www.fpdf.org/

unchanged used FPDF Files:

fpdf.php

/fonts/...
