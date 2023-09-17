<?php
require('fpdf.php');

class PDF extends FPDF
{

// makeCalendar
    function mkCal($title, $Year, $locale, $daysText, $daysColor, $daysHolidays, $highlightHolidays, $highlightSunday, $highlightSaturday, $footer, $format, $colorSceme)
    {
        /*
            $title = String that contains the Header-text of the Calendar
            $locale = locale setting for Month and Day names (e.g. de_DE)
            $daysText = 2-dimensional string array [month][day] for text in cell
            $daysColor = 2-dimensional string array [month][day] for bgcolor of cell (HEX)
            $daysHolidays = 2-dimensional bool array [month][day] true=day is holiday
            $highlightHolidays = Hex key of highlightcolor of Holidays
            $highlightSunday = Hex key of highlightcolor of Sundays
            $highlightSaturday = Hex key of highlightcolor of Saturdays
            $footer = String with footer text
            $format = currently only "A4Landscape"
            $ColorSceme = Color for Title and Month Background
        */

        //setlocale for correct display of month and days
        setlocale(LC_TIME, $locale);

        //initialize PDF
        // $this = new PDF('L','mm','A4');
        $this->SetMargins(12,5,5);
        $this->SetAutoPageBreak(true,5);
        $this->SetFont('Arial','',10);
        $this->AddPage();



        //title
        $this->SetFont('','B');
        $this->SetFont('Arial','',22);
        list($r, $g, $b) = sscanf($colorSceme, "#%02x%02x%02x");
        $this->SetTextColor($r,$g,$b);
        $this->Cell(250,10,iconv('UTF-8', 'windows-1252', $title),0);
        $this->Cell(30,10,$Year,0);
        $this->Ln();

        // Colors, line width and bold font
        list($r, $g, $b) = sscanf($colorSceme, "#%02x%02x%02x");
        $this->SetFillColor($r,$g,$b);
        $this->SetTextColor(255);
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(.3);
        $this->SetFont('','B');
        $this->SetFont('Arial','',12);
        // Header
        $w = 16; //Cell Width
        $wWeekDay = 6; //Cell Width
        $this->Cell(8,7,' ',1,0,'C',true);
        for($i=1;$i<=12;$i++)
            $this->Cell($w+$wWeekDay,7,$date = strftime('%B',strtotime($i."/01/1970")) ,1,0,'C',true);
        $this->Ln();
        // Color and font restoration
        //$this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('Arial','',14);
        // Data
        $fill = false;

        for($i=1;$i<=31;$i++)
        {
            for($j=0;$j<13;$j++)
            {
                if($j==0)
                {
                    $this->SetFont('Arial','',14);
                    $this->SetDrawColor(0,0,0);
                    $this->Cell(8,5.2,$i,'LRB',0,'L',false);
                }
                else
                {
                    // Weekday
                    $this->SetFont('Arial','',6);
                    //check if sunday/saturday/ and set fill color
                    $wday= date('w', strtotime($i.'-'.$j.'-'.$Year));
                    if($wday==0)
                    {
                        list($r, $g, $b) = sscanf($highlightSunday, "#%02x%02x%02x");
                        $this->SetFillColor($r,$g,$b);
                        $fill = true;
                    }
                    else if($wday==6)
                    {
                        list($r, $g, $b) = sscanf($highlightSaturday, "#%02x%02x%02x");
                        $this->SetFillColor($r,$g,$b);
                        $fill = true;
                    }
                    else
                    {
                        $this->SetFillColor(0,0,0);
                        $fill = false;
                    }
                    if(checkdate($j,$i,$Year))
                    {
                        $this->Cell($wWeekDay,5.2,strftime('%a', strtotime($i.'-'.$j.'-'.$Year)),1,0,'L',$fill);
                    }
                    else
                    {
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
                        $fill=false;
                    }
                    // End of Background Color

                    $this->Cell($w,5.2,$daysText[$j][$i],1,0,'L',$fill);
                    //$this->SetFillColor(0,0,0);
                    //$this->SetDrawColor(0,0,0);
                }
            }


            $this->Ln();
        }
        $this->SetFont('Arial','',14);
        $this->Cell(400,10,$footer,0);
        $this->Ln();
        $this->SetFont('Arial','',10);
        $this->Cell(400,10,iconv('UTF-8', 'windows-1252',"This Calendar was made using PrintablePDFYearCalendar by Philipp Gürth - github.com/goerdy/PrintablePDFYearCalendar"),0);
        $fill = !$fill;



        //finalize pdf and output
        $this->Output();
    }
}

?>
