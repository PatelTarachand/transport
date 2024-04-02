<?php  error_reporting(0);include("dbconnect.php");
include("../fpdf17/fpdf.php");
$tblname="m_payment";
$tblpkey = "payment_id";
$module = "Masters";
$keyvalue="";

$caddress= $cmn->getvalfield($connection,"m_company","caddress","1='1'"); 
$cname= $cmn->getvalfield($connection,"m_company","cname","1='1'");

if(isset($_GET['invoiceid'])) {
	$invoiceid = trim(addslashes($_GET['invoiceid']));
}
else
$invoiceid='';


$sql = mysqli_query($connection,"select * from invoicebilty where invoiceid='$invoiceid'");
$row= mysqli_fetch_assoc($sql);
$invdate = $cmn->dateformatindia($row['invdate']);
$invno = $row['invno'];
$itemtype = $row['itemtype'];
$consigneeid = $cmn->getvalfield($connection,"bidding_entry","consigneeid","invoiceid='$invoiceid'");
$consigneename = "M/s SHREE RAIPUR CEMENT PLANT, KHAPRADIG";
$consigneeaddress = "Vill- Khapradig, Teh-Simga Distt- Baloda Bazar-Bhatapara City: Baloda Bazar Chhattisgarh";
$consignneepan = "AACCS8796G";
$consignneegst = "22AACCS8796G1Z1";


$cname = $cmn->getvalfield($connection,"m_company","cname","1 = 1");
$headaddress = $cmn->getvalfield($connection,"m_company","headaddress","1 = 1");
$mobileno1  = $cmn->getvalfield($connection,"m_company","mobileno1","1 = 1");
$mobileno2  = $cmn->getvalfield($connection,"m_company","mobileno2","1 = 1");
$companygst  = $cmn->getvalfield($connection,"m_company","gst_no","1 = 1");
$companysaac  = $cmn->getvalfield($connection,"m_company","saaccode","1 = 1");
$companypan  = $cmn->getvalfield($connection,"m_company","pan_card","1 = 1");


function convert_number($number) 
{ 
  $no = (int)floor($number);
   $point = (int)round(($number - $no) * 100);
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'one', '2' => 'two',
    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
    '7' => 'seven', '8' => 'eight', '9' => 'nine',
    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
    '13' => 'thirteen', '14' => 'fourteen',
    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
    '60' => 'sixty', '70' => 'seventy',
    '80' => 'eighty', '90' => 'ninety');
   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;


     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);


  if ($point > 20) {
    $points = ($point) ?
      "" . $words[floor($point / 10) * 10] . " " . 
          $words[$point = $point % 10] : ''; 
  } else {
      $points = $words[$point];
  }
  if($points != ''){        
      return $result . "Rupees  " . $points . " Paise ";
  } else {

      return $result . "Rupees ";
  }
}

	
function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' & ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}


class PDF_MC_Table extends FPDF
{
  var $widths;
  var $aligns;
	function Header()
	{ 
	   global $companygst,$companysaac,$consigneeaddress,$companypan,$invdate,$invno,$consigneename,$consignneepan,$consignneegst;
	
	$this->setX(5);
	//$this->SetFillColor(0,0,0); //gray
	//$this->SetTextColor(255,255,255);
	//$this->Row(array('Sno','TAX INV NO','GR DATE','GR/TR NO','DI NO ','TRUCK NO ','CONSIGNEE','DESTINATION','WEIGHT (MT)','RATE/MT','FREIGHT','LABOUR','TOTAL AMOUNT','CGST','SGST','SHT-BG','SHT-MT'));
		
	}
	function Footer()
	{ 
	
						
     }
function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function Row($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function Row2($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}


function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
}
?>
<?php


function GenerateWord()
{
    //Get a random word
    $nb=rand(3,10);
    $w='';
    for($i=1;$i<=$nb;$i++)
        $w.=chr(rand(ord('a'),ord('z')));
    return $w;
}

function GenerateSentence()
{
    //Get a random sentence
    $nb=rand(1,10);
    $s='';
    for($i=1;$i<=$nb;$i++)
        $s.=GenerateWord().' ';
    return substr($s,0,-1);
}



$pdf=new PDF_MC_Table();
$pdf->SetTitle("Advance Voucher");
$pdf->AliasNbPages();
$pdf->AddPage('L','A4');
$pdf->SetX(5);
//$pdf->MultiCell(80,5,"Customer Copy",0,'L');


//$pdf->SetX(13);


	
$pdf->SetFont('courier','b',9);
	$pdf->Rect(5,5, 287, 200, 'D'); //For A4	
	$pdf->SetFont('courier','b',9);
	$pdf->Rect(205,25,80, 20, 'D'); //For A4
	$pdf->Rect(7,54,165,41,'D'); //For A4
	//$this->Rect(3,116, 204, 14, 'D'); //For A4  
	//$this->Rect(3,130, 204, 14, 'D'); //For A4 
	
	 $pdf->setY(10);
	 
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(280,4,"Original for Recipient",'0',1,'R',0);
	$pdf->Ln(1);
		$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(280,4,"Duplicate for Supplier",'0',1,'R',0);
	$pdf->Ln(10);
		$pdf->SetFont('Arial','UB',22);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(280,4,$cname,'0',1,'L',0);
	$pdf->Ln(2);
		
		$pdf->SetFont('Arial','UB',10);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(280,4,$caddress,'0',1,'L',0);
	$pdf->Ln(4);
	
	$pdf->setY(28);
	$pdf->setX(200);
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(90,4,"Quantity & Freight Rate",'0',1,'C',0);
	$pdf->Ln(1);
	
	$pdf->setX(200);
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(90,4,"Verified Bill Passed For Rs :",'0',1,'C',0);
	$pdf->Ln(1);
	
	$pdf->setX(200);
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(90,4,"Authorised Signatory",'0',1,'C',0);
	$pdf->Ln(4);
		
	$pdf->SetFont('Arial','ub',16);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(280,4,"TAX INVOICE",'0',1,'C',0);


	
	 $pdf->setY(55);
	 $pdf->SetFont('Arial','b',12);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(280,4,"Code No : 33090",'0',1,'L',0);
	
	$pdf->SetFont('Arial','b',12);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(280,4,"To,",'0',1,'L',0);
	$pdf->Ln(2);
	
	$pdf->SetFont('Arial','B',14);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(90,4,"$consigneename",'0',1,'L',0);
	$pdf->Ln(2);
	//$this->setY(40);
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);
	$pdf->MultiCell(160,5,"( A unit of Shree Cement  Ltd. ) $consigneeaddress",0,'L');
	//$this->Cell(90,4,"",'0',1,'L',0);
	
	
	$pdf->Ln(2);
	  
	//$this->setY(40);
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(90,4,"PAN No- $consignneepan",'0',1,'L',0);
	$pdf->Ln(2);
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(150,4,"GST NO- $consignneegst",'0',1,'L',0);
	
	
	 $pdf->setY(58);
	$pdf->setX(200);
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(40,4,"FREIGHT BILL NO :",'0',0,'R',0);
	$pdf->Cell(80,4,"$invno",'0',1,'L',0);
	$pdf->Ln(2);
		$pdf->setX(200);
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(40,4,"DATE :",'0',0,'R',0);
	$pdf->Cell(80,4,"$invdate",'0',1,'L',0);
	$pdf->Ln(2);
		$pdf->setX(200);
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(40,4,"PAN NO :",'0',0,'R',0);
	$pdf->Cell(80,4,"$companypan",'0',1,'L',0);
	$pdf->Ln(2);
		$pdf->setX(200);
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(40,4,"GST NO:",'0',0,'R',0);
	$pdf->Cell(80,4,"$companygst",'0',1,'L',0);
	$pdf->Ln(2);
		$pdf->setX(200);
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(40,4,"SAC CODE:",'0',0,'R',0);
	$pdf->Cell(80,4,"$companysaac",'0',1,'L',0);
	$pdf->Ln(2);
		$pdf->setX(200);
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(40,4,"PLACE OF SUPPLY :",'0',0,'R',0);
	$pdf->Cell(80,4,"CHATTISHGARH-22",'0',1,'L',0);
	$pdf->Ln(6);
	
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(43,4,'Service Description :','0',0,'L',0);
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(170,4,' FREIGHT AMOUNT CHARGED FOR TRANSPORTATION OF '.$itemtype.'(GTA)','0',1,'L',0);
	$pdf->Ln(5);
	 
	$pdf->SetX(5);
	$pdf->SetFont('Arial','B',9);
	$pdf->SetFillColor(255,255,255); //gray
	//$this->SetTextColor(255,255,255);
	$pdf->Cell(8,6,'Sno','1',0,'L',1); 
	$pdf->Cell(24,6,'TAX INV NO','1',0,'L',1);  
	$pdf->Cell(17,6,'GR DATE',1,0,'L',1);
	$pdf->Cell(24,6,'GR/TR NO',1,0,'L',1);
	$pdf->Cell(17,6,'DI NO ',1,0,'L',1);
	$pdf->Cell(22,6,'TRUCK NO ',1,0,'L',1);	
	$pdf->Cell(32,6,'CONSIGNEE',1,0,'L',1);
	$pdf->Cell(28,6,'DESTINATION',1,0,'L',1);
	$pdf->Cell(14,6,'WT',1,0,'L',1);
	$pdf->Cell(15,6,'RATE',1,0,'L',1);
	$pdf->Cell(18,6,'FREIGHT',1,0,'L',1);
	//$this->Cell(16,6,'LABOUR',1,0,'L',1);	
	$pdf->Cell(20,6,'TOTAL',1,0,'C',1);
	$pdf->Cell(14,6,'CGST',1,0,'L',1);
	$pdf->Cell(14,6,'SGST',1,0,'L',1);
	$pdf->Cell(10,6,'SHT',1,0,'L',1);
	$pdf->Cell(10,6,'SHT',1,1,'L',1);
	
	//$this->Cell(10,6,'SHT-BG',1,0,'L',1);
	//$this->Cell(10,6,'SHT-MT',1,1,'L',1);
	$pdf->SetX(5);
	$pdf->SetFont('Arial','B',9);
	//$this->SetFillColor(0,0,0); //gray
	//$this->SetTextColor(255,255,255);
	$pdf->Cell(8,6,' ','1',0,'L',1); 
	$pdf->Cell(24,6,' ','1',0,'L',1);  
	$pdf->Cell(17,6,' ',1,0,'L',1);
	$pdf->Cell(24,6,' ',1,0,'L',1);
	$pdf->Cell(17,6,' ',1,0,'L',1);
	$pdf->Cell(22,6,' ',1,0,'L',1);	
	$pdf->Cell(32,6,' ',1,0,'L',1);
	$pdf->Cell(28,6,' ',1,0,'L',1);
	$pdf->Cell(14,6,' (MT)',1,0,'L',1);
	$pdf->Cell(15,6,' MT',1,0,'L',1);
	$pdf->Cell(18,6,' ',1,0,'L',1);
	//$this->Cell(16,6,' ',1,0,'L',1);	
	$pdf->Cell(20,6,' AMOUNT',1,0,'L',1);
	$pdf->Cell(14,6,' ',1,0,'L',1);
	$pdf->Cell(14,6,' ',1,0,'L',1);
	$pdf->Cell(10,6,'BG',1,0,'L',1);
	$pdf->Cell(10,6,'MT',1,1,'L',1);
	//$this->Cell(10,6,' ',1,0,'L',1);
	//$this->Cell(10,6,' ',1,1,'L',1);
	
	$pdf->SetWidths(array(8,24,17,24,17,22,32,28,14,15,18,20,14,14,10,10));
	$pdf->SetAligns(array("C","L","L","L","L","L","L","L","L","L","L","L","L","L","L","L"));
	$pdf->SetX(5);	
	$pdf->SetFont('Arial','B',9);

$sn=1;
$tot_wt=0;
$tot_own_rate=0;
$nettotal_amt=0;
$tot_gst=0;
$sql2 = mysqli_query($connection,"select * from bidding_entry where invoiceid='$invoiceid' order by gr_date");
while($row2=mysqli_fetch_assoc($sql2)) {

	$invoiceno = $row2['invoiceno'];
	$gr_date = $row2['gr_date'];
	$gr_no = $row2['gr_no'];
	$di_no = $row2['di_no'];
	$truckid = $row2['truckid'];
	$consigneeid = $row2['consigneeid'];
	$deliverat = $row2['deliverat'];
	$totalweight = $row2['totalweight'];
	$own_rate = $row2['own_rate'];
	
	$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
	$consigneename = $cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$consigneeid'");
	$total_amt = $totalweight * $own_rate;
	$gst =  ($total_amt * 12)/100;
	
	$pdf->SetX(5);	
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(0,0,0);
	$pdf->Row(array($sn++,$invoiceno,$cmn->dateformatindia($gr_date),$gr_no,$di_no,$truckno,$consigneename,$deliverat,$totalweight,$own_rate,number_format($total_amt,2),number_format($total_amt,2),number_format($gst/2,2),number_format($gst/2,2),"0","0"));

	$tot_wt += $totalweight;
	$tot_own_rate += $own_rate;
	$nettotal_amt += $total_amt;
	$tot_gst += $gst;
	//$tot_wt += $totalweight;
	//$tot_wt += $totalweight;

}

	$pdf->setX(5);
	$pdf->SetFont('Arial','b',8);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(172,4,"",'1',0,'R',0);
	$pdf->Cell(14,4,number_format($tot_wt,2),'1',0,'L',0);
	$pdf->Cell(15,4,number_format(tot_own_rate,2),'1',0,'L',0);
	$pdf->Cell(18,4,number_format($nettotal_amt,2),'1',0,'L',0);
	
	$pdf->Cell(20,4,number_format($nettotal_amt,2),'1',0,'L',0);
	$pdf->Cell(14,4,number_format($tot_gst/2,2),'1',0,'L',0);
	$pdf->Cell(14,4,number_format($tot_gst/2,2),'1',0,'L',0);
	$pdf->Cell(10,4,"",'1',0,'L',0);
	$pdf->Cell(10,4,"",'1',1,'L',0);
	
	$pdf->setX(5);
	$pdf->SetFont('Arial','b',8);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(8,4,' ','1',0,'L',0); 
	$pdf->Cell(24,4,' ','1',0,'L',0);  
	$pdf->Cell(17,4,' ',1,0,'L',0);
	$pdf->Cell(24,4,' ',1,0,'L',0);
	$pdf->Cell(17,4,' ',1,0,'L',0);
	$pdf->Cell(22,4,' ',1,0,'L',0);	
	$pdf->Cell(32,4,' ',1,0,'L',0);
	$pdf->Cell(28,4,' ',1,0,'L',0);
	
	$pdf->Cell(47,4,"TOTAL AMOUNT",'1',0,'L',0);
	$pdf->Cell(34,4,number_format($nettotal_amt +$tot_gst,2),'1',0,'L',0);
	$pdf->Cell(14,4,'','1',0,'L',0);
	$pdf->Cell(20,4,'','1',1,'L',0);
	
	$pdf->setX(5);
	$pdf->SetFont('Arial','b',8);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(287,4,'In Words : '.ucwords(convert_number($nettotal_amt +$tot_gst))." only",'1',1,'L',0); 
	
 // $height = $pdf->getX();
$pdf->Ln(5);  
$pdf->setX(5);
$pdf->SetFont('Arial','',12);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(200);
$pdf->Cell(87,4," For:".$cname,'0',0,'C',0); 

$pdf->Ln(8);  
$pdf->setX(5);
$pdf->SetFont('Arial','',12);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(200);
$pdf->Cell(87,4," Authorised Signatory",'0',0,'C',0); 
	
  $pdf->Output();	
?>
