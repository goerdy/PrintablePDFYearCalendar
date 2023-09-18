# PrintablePDFYearCalendar

This project provides a script that renders a year calendar on a single page PDF file. This is perfect for workshift schedules, club meetings, school holidays and much more.
The option to color highlight days makes it clearer to read and gives an easy overview.

This project was made to print a 24-hour shift schedule for a career fire department and is used in that project [link to fireshift git].

It was a well considered decision to use 2-dimensional arrays as input because they are easy to fill with data from different sources and don't blow the code that much.

# Features

* highly customizable
* text and color for each day separately
* multi-language support
* supports holidays (color highlighting)
* color highlighting for Saturday and Sunday (AFAIK that fits western and hebrew demands, if your culture needs other highlighting, let me know and I will add support for this)

# Usage

1. include mkCal.php in your project
2. call PrintablePDFYearCalendar function
 
require('mkCal.php');

$pdf->mkCal("Example Calendar", 2024 ,"en_US", $DaysTextArray, $DaysColorArray, $DaysHolidaysArray, "#AAAA00" ,"#FF0000", "#990000", "some customizable footer text", "A4Landscape", "#0000FF");



## style

$locale [string] e.g. "en_US" or "de_DE" for correct display of month and days in your language

$highlightHolidays [string] contains the Hex color key for holiday highlighting

$highlightSunday [string] contains the Hex color key for sunday highlighting

$highlightSaturday [string] contains the Hex color key for saturday highlighting

*$format* [string] "A4Landscape" NOT IMPLEMENTED YET

*$colorScheme* [string] "red/blue/green/yellow" NOT IMPLEMENTED YET



## Calendar content

$title [string] contains the printed title of the calendar.

$Year [int] contains the Year of the Calendar (used to calculate weekdays...)

$footer [string] contains the footer text you want to be displayed.

Function expects three 2-dimensional Arrays. Where the first index is the month and the second is the day.

$DaysTextArray [string] contains the text to display in each given Day

$DaysColorArray [string] contains the Hex color key for background color of each given Day

$DaysHolidaysArray [boolean] specifies if the given day is a holiday


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
