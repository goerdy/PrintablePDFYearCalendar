<?php
require('mkCal.php');

function mkCal($title, $Year, $locale, $daysText, $daysColor, $daysHollidays, $highlightHollidays, $highlightSunday, $ighlightSaturday, $footer, $format)
mkCal("Test Calendar", 2023 ,"de_DE", daystext, dayscolor, dayshollidays, "magenta" ,"red", "firebrick1", "some idiotic footer text", "A4Landscape");

?>
