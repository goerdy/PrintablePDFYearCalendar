<?php
require('fpdf.php');

class PDF extends FPDF
{

// makeCalendar
function mkCal($title, $Year, $locale, $daysText, $daysColor, $daysHollidays, $highlightHollidays, $highlightSunday, $ighlightSaturday, $footer, $format)
{
    /*
        $title = String that contains the Header-text of the Calendar
        $locale = locale setting for Month and Day names (e.g. de_DE)
        $daysText = 2-dimensional string array [month][day] for text in cell
        $daysColor = 2-dimensional string array [month][day] for bgcolor of cell (HEX)
        $daysHollidays = 2-dimensional bool array [month][day] true=day is holliday
        $highlightHollidays = Hex key of highlightcolor of Hollidays
        $highlightSunday = Hex key of highlightcolor of Sundays
        $highlightSaturday = Hex key of highlightcolor of Saturdays
        $footer = String with footer text
        $format = currently only "A4Landscape"
    */

    //setlocale for correct display of month and days
    setlocale(LC_TIME, $locale);
    
    //initialize PDF
    $this->SetMargins(12,5,5);
    $this->SetAutoPageBreak(true,5);
    $this->SetFont('Arial','',12);
    $this->AddPage();



    //title
    $this->Cell(200,10,iconv('UTF-8', 'windows-1252', $title),0);
    $this->Ln();
    
    // Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Header
    $w = 22; //Cell Width
    $this->Cell(8,7,' ',1,0,'C',true);
    for($i=1;$i<=12;$i++)
        $this->Cell($w,7,$date = strftime('%B',strtotime($i."/01/1970")) ,1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;

    for($i=1;$i<=31;$i++)
    {
      for($j=0;$j<13;$j++)
      {
      if($j==0)
      {
        $this->Cell(8,5.2,$i,'LRB',0,'L',$fill);
      }
      else
      {
        if($data[$j][$i]==3)
        {
          $fill=true;
        }
        
        //check if sunday and draw border
        $wday= date('w', strtotime('2024'.$j.$l));
        if($wday==0)
        {
        $this->SetDrawColor(138,0,138);
        $fill = true;
        }
        
        $this->Cell($w,5.2,$daysText[$j][$i],'LRB',0,'L',$fill);
        $fill=false;
        $this->SetDrawColor(0,0,0);
      }
      }
      
      
      $this->Ln();
    }    
        $this->Cell(400,10,$footer,0);
        $this->Ln();
        $this->Cell(400,10,"This Calendar was made using PrintablePDFYearCalendar by @goerdy - github.com/goerdy/PrintablePDFYearCalendar",0);
  
  
        $fill = !$fill;

    //finalize pdf and output
    $this->Output();
    }
    

    
}

?>
