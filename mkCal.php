<?php
/*
-= PrintablePDFYearCalendar =-

https://github.com/goerdy/PrintablePDFYearCalendar

by Philipp "goerdy" Gürth
github@philipp-guerth.de

Version: 0.1
*/
require('fpdf.php');

function PrintablePDFYearCalendar($title, $Year, $locale, $daysText, $daysColor, $daysHolidays, $highlightHolidays, $highlightSunday, $highlightSaturday, $footer, $format, $colorScheme)
{
    //fpdf constructor
    if($format=="A4Landscape")
    {
        $pdf = new PDF('L','mm','A4');
    }
    elseif ($format=="LetterLandscape")
    {
        $pdf = new PDF('L','mm','Letter');
    }
    else
    {
        //ToDo: Error Handling for not supported page format
        //Falling back to A4
        $pdf = new PDF('L','mm','A4');
    }
    

    //function call mkCal
    $pdf->mkCal($title, $Year, $locale, $daysText, $daysColor, $daysHolidays, $highlightHolidays, $highlightSunday, $highlightSaturday, $footer, $format, $colorScheme);

    //build a filename from $title and $Year
    //TODO: use improved regex to make it working for non latin title text.
    $filename = preg_replace ( '/[^a-z0-9]/i', '', $title.$Year);
    $filename = $filename.'.pdf';

    //instruct browser to download the file Change "dest" parameter from 'D' to 'I' to open in browser / pdf-reader
    $pdf->Output('D', $filename);
}

class PDF extends FPDF
{

// makeCalendar
    function mkCal($title, $Year, $locale, $daysText, $daysColor, $daysHolidays, $highlightHolidays, $highlightSunday, $highlightSaturday, $footer, $format, $colorScheme)
    {
        /*
            $title = String that contains the Header-text of the Calendar
            $Year = The Year for which the calendar should be rendered
            $locale = locale setting for Month and Day names (e.g. de_DE)
            $daysText = 2-dimensional string array [month][day] for text in cell
            $daysColor = 2-dimensional string array [month][day] for bgcolor of cell (HEX)
            $daysHolidays = 2-dimensional bool array [month][day] true=day is holiday
            $highlightHolidays = Hex key of highlightcolor of Holidays
            $highlightSunday = Hex key of highlightcolor of Sundays
            $highlightSaturday = Hex key of highlightcolor of Saturdays
            $footer = String with footer text
            $format = "A4Landscape / LetterLandscape"
            $ColorScheme = Color for Title and Month Background
        */
        
        //TODO: clean up code, some executions are obsolete
        //TODO: improve code comments

        //set PDF Metadata
        $this->SetCreator("PrintablePDFYearCalendar"); //Creator
        $this->SetAuthor($_SERVER['HTTP_HOST']); //Set Domain as Author
        $this->SetTitle($title." ".$Year); //Title
        $this->SetSubject("PDF single page year calendar of ".$Year." generated on ".$_SERVER['HTTP_HOST']); //Subject
        $this->SetKeywords("Year-Calendar Calendar ".$Year." ".$_SERVER['HTTP_HOST']." PrintablePDFYearCalendar ".$title); // Keywords


        //setlocale for correct display of month and days
        setlocale(LC_TIME, $locale);

        //set Colors depending on ColorScheme
        //ToDo: Improve color schemes - better matching eye and print friendly colors
        switch($colorScheme)
        {
            case "red":
                $headerColor = "#FF0000";
                $titleColor = "#FF1010";
             break;
            case "green":
                 $headerColor = "#00FF00";
                 $titleColor = "#10FF10";
             break;
            case "blue":
                 $headerColor = "#0000FF";
                 $titleColor = "#1010FF";
             break;
            case "yellow":
                 $headerColor = "#FFFF00";
                 $titleColor = "#FFFF10";
             break;
        }


        //initialize PDF
        //Page format A4/Letter changes at the moment only the left page margin. works for the moment but may be improved later on
        if($format=="A4Landscape")
        {
            $this->SetMargins(12,5,5);
        }
        elseif($format=="LetterLandscape")
        {
            $this->SetMargins(4,5,5);
        }
        else
        {
            //ToDo: Add error handling
            $this->SetMargins(12,5,5);
        }

        $this->SetAutoPageBreak(true,5);
        $this->SetFont('Arial','',10);
        $this->AddPage();

        //title
        $this->SetFont('','B');
        $this->SetFont('Arial','',22);
        list($r, $g, $b) = sscanf($titleColor, "#%02x%02x%02x");
        $this->SetTextColor($r,$g,$b);
        $this->Cell(250,10,iconv('UTF-8', 'windows-1252', $title),0);
        $this->Cell(30,10,$Year,0);
        $this->Ln();

        // Colors, line width and bold font
        list($r, $g, $b) = sscanf($headerColor, "#%02x%02x%02x");
        $this->SetFillColor($r,$g,$b);
        $this->SetTextColor(255);
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(.3);
        $this->SetFont('','B');
        $this->SetFont('Arial','',12);

        // Header (Month)
        $w = 16; //Cell Width
        $wWeekDay = 6; //Cell Width
        $this->Cell(8,7,' ',1,0,'C',true);
        for($i=1;$i<=12;$i++)
            $this->Cell($w+$wWeekDay,7,$date = strftime('%B',strtotime($i."/01/1970")) ,1,0,'C',true);
        $this->Ln();

        // Calendar data
        $this->SetTextColor(0);
        $this->SetFont('Arial','',14);
        $fill = false;

        for($i=1;$i<=31;$i++)
        {
            for($j=0;$j<13;$j++)
            {
                if($j==0)
                {
                    //first column - print number of the day
                    $this->SetFont('Arial','',14);
                    $this->SetDrawColor(0,0,0);
                    $this->Cell(8,5.2,$i,'LRB',0,'L',false);
                }
                else
                {
                    //Day Cell, devided in short of weekday and data cell
                    
                    // Weekday
                    $this->SetFont('Arial','',6);
                    //check if sunday/saturday/ and set fill color
                    $wday= date('w', strtotime($i.'-'.$j.'-'.$Year));
                    if($wday==0) //Sunday
                    {
                        list($r, $g, $b) = sscanf($highlightSunday, "#%02x%02x%02x");
                        $this->SetFillColor($r,$g,$b);
                        $fill = true;
                    }
                    else if($wday==6) //Saturday
                    {
                        list($r, $g, $b) = sscanf($highlightSaturday, "#%02x%02x%02x");
                        $this->SetFillColor($r,$g,$b);
                        $fill = true;
                    }
                    else //Monday - Friday
                    {
                        $this->SetFillColor(0,0,0);
                        $fill = false;
                    }

                    //set background color for holiday
                    if($daysHolidays[$j][$i])
                    {
                        list($r, $g, $b) = sscanf($highlightHolidays, "#%02x%02x%02x");
                        $this->SetFillColor($r,$g,$b);
                        $fill = true;
                    }

                    
                    if(checkdate($j,$i,$Year)) //Check if particular date exists ( e.g. 29. of february...)
                    {
                        //print short version of day name
                        $this->Cell($wWeekDay,5.2,strftime('%a', strtotime($i.'-'.$j.'-'.$Year)),1,0,'L',$fill);
                    }
                    else
                    {
                        //leave cell empty because day doesn't exist
                        $this->Cell($wWeekDay,5.2,' ',1,0,'L',false);
                    }
                    $this->SetFont('Arial','',12);

                    // Cell Background depending on DayColorArray
                    list($r, $g, $b) = sscanf($daysColor[$j][$i], "#%02x%02x%02x");
                    $this->SetFillColor($r,$g,$b);
                    if($r!=0||$g!=0||$b!=0)
                    {
                        $fill=true;
                    }
                    else
                    {
                        //no fill color given
                        $fill=false;
                    }

                    //Write DayText to Cell
                    $this->Cell($w,5.2,$daysText[$j][$i],1,0,'L',$fill);
                }
            }


            $this->Ln();
        }
        $this->SetFont('Arial','',14);
        $this->Cell(400,10,$footer,0);
        $this->Ln();
        $this->SetFont('Arial','',10);
        $this->Cell($this->GetPageWidth()-17,10,iconv('UTF-8', 'windows-1252',"powered by PrintablePDFYearCalendar by Philipp Gürth - github.com/goerdy/PrintablePDFYearCalendar"),0, 1, "R");
        $fill = !$fill;
    }
}

?>
