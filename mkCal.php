<?php
require('fpdf.php');

class PDF extends FPDF
{
// Load data
function LoadData($file)
{
    // Read file lines
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}

// Colored table
function FancyTable($header, $data, $footer)
{
    //title
    $this->Cell(200,10,'Dienstplan',0);
     $this->Ln();
    
    // Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Header
    $w = 22; //Cell Width
    $this->Cell(8,7,$header[$i],1,0,'C',true);
    for($i=1;$i<count($header);$i++)
        $this->Cell($w,7,iconv('UTF-8', 'windows-1252', $header[$i]),1,0,'C',true);
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
        $this->Cell(8,5.2,$data[$j][$i],'LRB',0,'L',$fill);
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
        
        $this->Cell($w,5.2,$data[$j][$i],'LRB',0,'L',$fill);
        $fill=false;
        $this->SetDrawColor(0,0,0);
      }
      }
      
      
      $this->Ln();
    }    
        $this->Cell(400,10,$footer,0);
  
        $fill = !$fill;
    }
    // Closing line
    //$this->Cell(520,0,'','T');
     //$this->Ln();
   // $this->Cell(400,10,$footer,1);
    // $this->Ln();
}
