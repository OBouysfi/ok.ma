<?php
error_reporting(0);
ob_start();
define('FPDF_FONTPATH','font/');
require('fpdf.php');
include("../../config.php");

class PDF extends FPDF
{

function LoadData($file)
{

    $lines=file($file);
    $data=array();
    foreach($lines as $line)
        $data[]=explode(';',chop($line));
    return $data;
}


function BasicTable($header,$data)
{

    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();

    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(40,6,$col,1);
        $this->Ln();
    }
}




function Footer()
{
    $this->SetFont('Arial','B',15);
}


function PDF($orientation='P',$unit='mm',$format='A4')
{

    $this->FPDF($orientation,$unit,$format);
   
    $this->B=0;
    $this->I=0;
    $this->U=0;
    $this->HREF='';
}

function WriteHTML($html)
{
    
    $html=str_replace("\n",' ',$html);
    $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
           
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,$e);
        }
        else
        {
           
            if($e{0}=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
               
                $a2=explode(' ',$e);
                $tag=strtoupper(array_shift($a2));
                $attr=array();
                foreach($a2 as $v)
                    if(ereg('^([^=]*)=["\']?([^"\']*)["\']?$',$v,$a3))
                        $attr[strtoupper($a3[1])]=$a3[2];
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function OpenTag($tag,$attr)
{

    if($tag=='B' or $tag=='I' or $tag=='U')
        $this->SetStyle($tag,true);
    if($tag=='A')
        $this->HREF=$attr['HREF'];
    if($tag=='BR')
        $this->Ln(5);
}

function CloseTag($tag)
{
  
    if($tag=='B' or $tag=='I' or $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF='';
}

function SetStyle($tag,$enable)
{
    
    $this->$tag+=($enable ? 1 : -1);
    $style='';
    foreach(array('B','I','U') as $s)
        if($this->$s>0)
            $style.=$s;
    $this->SetFont('',$style);
}

function PutLink($URL,$txt)
{
  
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}

}
	
$pdf=new PDF();
$pdf->AddPage(); 
 
if(isset($_POST['jobseeker_image']))
{
 if(file_exists('../../user_images/'.$_POST['jobseeker_image'].'.jpg'))
 {
 	 $pdf->Image('../../user_images/'.$_POST['jobseeker_image'].'.jpg',140,30);	
 }
 else
 if(file_exists('../../user_images/'.$_POST['jobseeker_image'].'.png'))
 {
 	 $pdf->Image('../../user_images/'.$_POST['jobseeker_image'].'.png',140,30);	
 }
}  
 
$pdf->SetTextColor(57,93,115);
 
$html_code = trim(stripslashes($_POST["html"]));
$html_code = strip_tags($html_code,"<i><b>");
$html_code =str_replace("\n","<br>",$html_code);
$html_code =str_replace("&nbsp;"," ",$html_code);
$html_code = preg_replace('~\s+~', ' ', $html_code);
$html_code =str_replace("<br> ","<br>",$html_code);
$html_code =str_replace("</i></i>","</i>",$html_code);
$html_code =str_replace("<i> <i>","<i>",$html_code);
$html_code = preg_replace('~(<br>)+~', '<br>', $html_code);
$html_code =str_replace("<i><b>","<br><i><b>",$html_code);
$html_code =str_replace("<b> <br>","<b>",$html_code);
$html_code =str_replace("<br><br>","<br>",$html_code);
$html_code =str_replace("  "," ",$html_code);
$html_code =str_replace("</b>","</b><br>",$html_code);
$html_code =str_replace("Â"," ",$html_code);
$html_code =str_replace("·"," ",$html_code);
$html_code =str_replace("â","-",$html_code);

$pdf->SetFont('Arial','',8);
$pdf->WriteHTML("Saved from ".strtoupper($DOMAIN_NAME)."<br>");
$pdf->SetFont('Arial','',10);

$pdf->WriteHTML(stripslashes($html_code));
 
$pdf->Output("resume.pdf","D");
ob_end_flush();
?>
