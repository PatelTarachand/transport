<?php  error_reporting(0);                                                                                           include("dbconnect.php");
require("../fpdf17/fpdf.php");
$logo = 'bps.png';

if(isset($_GET['bilty_id']))
{
	$bilty_id = trim(addslashes($_GET['bilty_id']));	
}

if($bilty_id !='')
{
	$sql_Q= mysqli_query($connection,"select * from bilty_entry where bilty_id='$bilty_id'");
	$row=mysqli_fetch_assoc($sql_Q);
	$billtyno = $row['billtyno'];
	$billtydate = $cmn->dateformatindia($row['billtydate']);
	$consignorid = $row['consignorid'];
	$consigneeid = $row['consigneeid'];
	$subconsigneeid = $row['subconsigneeid'];
	$driverlisenceno = $row['driverlisenceno'];

			$truckid = $row['truckid'];
	$subconsigneename = $cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$subconsigneeid'");
	$consigneename = $cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$consigneeid'");
		$consignorname = $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$consignorid'");
		$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
		$engineno = $cmn->getvalfield($connection,"m_truck","engineno","truckid='$truckid'");
			$chesisno = $cmn->getvalfield($connection,"m_truck","chesisno","truckid='$truckid'");
	$placeid = $row['placeid'];
	$destinationid = $row['destinationid'];
	$placename = $cmn->getvalfield($connection,"m_place","placename","placeid='$placeid'");
	$destination = $cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'");
	
	
	$shipmentno = $row['shipmentno'];
	$gpno = $row['gpno'];

	$drivername = $row['drivername'];
	$driverlisenceno = $row['driverlisenceno'];
	$truckowner = $row['truckowner'];
	$itemid = $row['itemid'];
	$qty = $row['qty'];
	$wt_mt = $row['wt_mt'];
	$rate_mt = $row['rate_mt'];
	$freight = $row['freight'];
	$newrate = $row['newrate'];
	$adv_cash = $row['adv_cash'];

}

function getinwordsbyindia($number)
{
   $no = round($number);
   $point = round($number - $no, 2) * 100;
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
        $plural = (($counter = count($str)) && $number > 9) ? '' : null;
        $hundred = ($counter == 1 && $str[0]) ? 'and ' : null;
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
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] :'';
		  
		
		  
if($points !='' && $points !='0')
{
 $words=  "$result Rupees $points  Paise";
}
else
{
	$words=  "$result Rupees  ";
}
   
   return $words;
}



function convert_number_to_words($number)
 {
  
    $hyphen      = '-';
    $conjunction = ' and ';
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
		global $title1,$title2,$ownername,$cname,$mobile,$address,$headaddress,$logo;
		// Rect(float x, float y, float w, float h [, string style])
	
	     $this->Rect(5,25,200,120,'D');
		    $this->Rect(5,25,60,42,'D');//driver name
			 $this->Rect(65,25,80,42,'D');//consignee
			 $this->Rect(145,25,60,42,'D');//truck no
	
	
	
	
	    $this->SetY(5);
		 $this->SetX(5);
		$this->SetFont('arial','b',8);
		
	    $this->Cell(20,0,"AT OWNER RISK",0,1,'L');
		  $this->SetY(3);
		$this->SetFont('arial','b',10);
		$this->Cell(70);
	    $this->Cell(50,0,"CONSIGNMENT NOTE",0,1,'L');
		
		$this->Ln(7);
		$this->SetFont('arial','b',32);
		$this->Cell(70);
	    $this->Cell(50,0,"BPS",0,1,'L');
		$this->SetX(5);
		$this->SetY(20);
		
		 $this->SetY(8);
		  $this->SetX(40);
		$this->SetFont('arial','b',10);
		$this->Cell(70);
	    $this->Cell(50,0,"In Front of Nuvoco Barrier Gate, Raseda ",0,1,'L');
		$this->SetFont('arial','b',10);
		$this->Ln(4);
		 $this->SetX(40);
		$this->Cell(70);
	    $this->Cell(50,0,"Office No. 7225060501 7225060501",0,1,'L');
		
		$this->SetX(5);
		$this->SetY(20);
		
		$this->Line(75,15,190,15);
	    $this->Line(5,32,205,32);
		$this->Line(5,39,205,39);
		$this->Line(5,46,205,46);
	$this->Line(5,53,205,53);
		$this->Line(5,60,205,60);
		$this->Line(5,120,205,120);
		$this->Line(90, 16, 90, 24); //horizental
		$this->Line(160, 16,160, 24); //horizental
		
	
	
		 $this->SetX(7);
$this->SetFont('courier','b',8);
$y = $this->GetY();
$x = $this->GetX();
$width = 75;

$this->MultiCell($width,3,$consignoradd,0, 'L', FALSE);
$this->SetXY($x + $width, $y);
		
	
		//for Supplier Name
		
			$this->Ln(2);
		//$this->Cell(71,5,":".$challan_no,0,1,'L');
		$this->SetY(60);
	   $this->SetX(5);
	    
	
		$this->SetX(5);
		
		$this->SetWidths(array(7,16,42,18,18,22,22));
		//$this->SetAligns(array("L","L","L","L","R","R","R","R","R","R","R","R"));
		$this->SetAligns(array("C","L",'L',"L","L","L","R"));
		
	}
	  // Page footer
	function Footer()
	{
		global $ownername,$mobileno1,$mobileno2,$mobile;
	// Position at 1.5 cm from bottom
	
		//$this->MultiCell(200,5,'Subject To Raipur Jurisdiction',0,'C');
		$this->SetY(-8);
		$this->SetX(5);
	$this->SetFont('arial','b',8);
$this->SetTextColor(0,0,0);
$this->Cell(50,5,'Signature Of Truck Owner',0,0,'R',0);
$this->Cell(130,5,'For, BPS',0,0,'R',0);

		
	 
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
    $h=8*$nb;
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
        $this->MultiCell($w,8,$data[$i],0,$a);
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
$title1 = "Sale INVOICE";
$pdf->SetTitle($title1);

$title3 = $address;
$pdf->SetTitle($title2);
$pdf->AliasNbPages();
$pdf->AddPage('L','A5');



 $pdf->SetX(20);
   $pdf->SetFont('arial','b',9);
$pdf->Image('note.png',5,33,60,5);//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])


////$pdf->SetFont('arial','b',9);
//$pdf->Image('party.png',180,0,20,10);//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])

    
	$pdf->SetY(16);
	$pdf->SetX(5);
	     $pdf->SetFont('arial','b',9);
		 $pdf->Cell(38,4,"Nuvoco Sonadih Office ",0,0,'L');
		  $pdf->SetFont('arial','b',9);
		 $pdf->Cell(55,4,"- 7225060529,7225060520",0,0,'L');
	 
	 $pdf->SetFont('arial','b',9);
		 $pdf->Cell(28,4,"Ultratech Grasim -",0,0,'L');
		  $pdf->SetFont('arial','b',9);
		 $pdf->Cell(34,4,"7225060502",0,0,'L');
		 
		 $pdf->SetFont('arial','b',9);
		 $pdf->Cell(35,4,"Service Tax Code",0,1,'L');
		 
		 $pdf->SetX(5);
		  $pdf->SetFont('arial','b',9);
		 $pdf->Cell(40,4,"Nuvoco Arasmeta Office -",0,0,'L');
		  $pdf->SetFont('arial','b',9);
		 $pdf->Cell(55,4,"7225060530",0,0,'L');
	 
		 $pdf->SetFont('arial','b',9);
		 $pdf->Cell(28,4,"Ambuja Cement -",0,0,'L');
		  $pdf->SetFont('arial','b',9);
		 $pdf->Cell(33,4,"7225060502",0,0,'L');
		 
		 $pdf->SetFont('arial','b',9);
		 $pdf->Cell(30,4,"BATPS7721NST001",0,1,'L');
		 
		
    $pdf->SetY(27);
	$pdf->SetX(5);
	$pdf->SetFont('Arial','b',9);
    $pdf->Cell(13,4,"Ch. No.",0,0,'L');
	$pdf->Cell(48,4,": ".$billtyno,0,0,'L');
	
   
	$pdf->SetFont('Arial','b',9);
    $pdf->Cell(15,4,"Ship. No.",0,0,'L');
	$pdf->Cell(25,4,": ".$shipmentno,0,0,'L');
	
	$pdf->SetFont('Arial','b',9);
    $pdf->Cell(12,4,"G.P No.",0,0,'L');
	$pdf->Cell(38,4,": ".$gpno,0,0,'L');
	
	
	$pdf->SetFont('Arial','b',9);
    $pdf->Cell(10,4,"Date",0,0,'L');
	$pdf->Cell(15,4,": ".$billtydate,0,0,'L');
	
	
	
	  $pdf->SetY(33);
	 $pdf->SetX(5);	   
	$pdf->SetFont('Arial','b',9);
    $pdf->Cell(10,4,"",0,0,'L');
	$pdf->Cell(50,4," "."",0,0,'L');
	
	$pdf->SetFont('Arial','b',9);
    $pdf->Cell(22,4,"Consignor",0,0,'L');
	$pdf->Cell(58,4,": ".$consignorname,0,0,'L');
	
	
	$pdf->SetFont('Arial','b',9);
    $pdf->Cell(21,4,"Truck No.",0,0,'L');
	$pdf->Cell(40,4,": ".$truckno,0,1,'L');
	
	$pdf->Ln(3);
	
	$pdf->SetX(5);	   
	$pdf->SetFont('Arial','b',9);
    $pdf->Cell(10,4,"Driver",0,0,'L');
	$pdf->Cell(50,4," : ".$drivername,0,0,'L');
	
	$pdf->SetFont('Arial','b',9);
    $pdf->Cell(22,4,"",0,0,'L');
	$pdf->Cell(58,4,"",0,0,'L');
	
	
	$pdf->SetFont('Arial','b',9);
    $pdf->Cell(20,4,"Eng No.",0,0,'L');
	$pdf->Cell(40,4," : ".$engineno,0,1,'L');
	$pdf->Ln(4);
	
	$pdf->SetX(5);	   
	$pdf->SetFont('Arial','b',9);
    $pdf->Cell(10,4,"LIC No",0,0,'L');
	$pdf->Cell(50,4," : ".$driverlisenceno,0,0,'L');
	
	$pdf->SetFont('Arial','b',9);
    $pdf->Cell(22,4,"Consignee",0,0,'L');
	$pdf->Cell(58,4,": ".$consigneename,0,0,'L');
	
	
	$pdf->SetFont('Arial','b',9);
    $pdf->Cell(20,4,"Chassis No.",0,0,'L');
	$pdf->Cell(40,4," : ".$chesisno,0,1,'L');
	
		$pdf->Ln(3);
	
	$pdf->SetX(5);	   
	$pdf->SetFont('Arial','b',9);
    $pdf->Cell(10,4,"Owner",0,0,'L');
	$pdf->Cell(50,4," : ".$truckowner,0,0,'L');
	
	$pdf->SetFont('Arial','b',9);
    $pdf->Cell(24,4,"Sub Consignee",0,0,'L');
	$pdf->Cell(56,4,": ".$subconsigneename,0,0,'L');
	
	
	$pdf->SetFont('Arial','b',9);
    $pdf->Cell(20,4,"From",0,0,'L');
	$pdf->Cell(40,4," : ".$placename,0,1,'L');
	
		$pdf->Ln(2);
	
	$pdf->SetX(5);	   
	$pdf->SetFont('Arial','b',9);
    $pdf->Cell(10,4,"",0,0,'L');
	$pdf->Cell(50,4," ",0,0,'L');
	
	$pdf->SetFont('Arial','b',9);
    $pdf->Cell(22,4,"",0,0,'L');
	$pdf->Cell(58,4," "."",0,0,'L');
	
	
	$pdf->SetFont('Arial','b',9);
    $pdf->Cell(21,4,"To",0,0,'L');
	$pdf->Cell(40,4,": ".$destination,0,1,'L');
	
$pdf->Ln(2);
$pdf->SetX(5);
$pdf->SetFont('Arial','B',9);
$pdf->SetFillColor(0,0,0); //gray
$pdf->SetTextColor(255,255,255);
$pdf->Cell(30,6,'Quantity','1',0,'L',1);  
$pdf->Cell(47,6,'Description(Said to contain)',1,0,'L',1);
$pdf->Cell(39,6,'Seal & Sign',1,0,'L',1);
$pdf->Cell(22,6,'Weight(MT)',1,0,'L',1);
$pdf->Cell(22,6,'RATE(RS)/MT',1,0,'L',1);
$pdf->Cell(40,6,'Freight',1,1,'L',1);
$pdf->SetFont('Arial','',6);
	
$pdf->SetWidths(array(30,47,39,22,22,40));
$pdf->SetAligns(array("C","L","C","C","R","R"));

$pdf->SetX(5);	
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);
$pdf->Row(array($qty,"","",$wt_mt,'',$freight));
	
	$pdf->SetX(5);
$pdf->SetFont('arial','',8);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(25,5,'service Tax Liabll-',1,0,'R',0);
$pdf->Cell(25,5,'Consignor',1,0,'R',0);
$pdf->Cell(27,5,'Consignee',1,0,'R',0);
$pdf->Cell(39,5,'Goods Transport Agency',1,0,'R',0);
$pdf->Cell(44,5,'Add Service Tax Payable',1,0,'R',0);
$pdf->Cell(40,5,number_format($total,2),'1',1,'R',0);

$pdf->SetX(5);
$pdf->SetFont('arial','b',8);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(160,5,'Gross Amount',1,0,'R',0);
$pdf->Cell(40,5,number_format($total,2),'1',1,'R',0);

$pdf->SetX(5);
$pdf->SetFont('arial','b',8);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(160,5,'Advance Paid',1,0,'R',0);
$pdf->Cell(40,5,number_format($total,2),'1',1,'R',0);

$pdf->SetX(5);
$pdf->SetFont('arial','b',8);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(160,5,'Balance Payable At',1,0,'R',0);
$pdf->Cell(40,5,number_format($total,2),'1',1,'R',0);


$pdf->Ln(1);
$pdf->SetX(5);
$pdf->SetFont('Arial','b',8);
$pdf->Cell(100,5,'UNDERTAKING',0,0,'L',0);
$pdf->Ln();

$pdf->SetFont('Arial','',8);
//$pdf->Cell(100,5,$terms,0,0,'L',0);
$pdf->SetX(7);
$pdf->MultiCell(198,4,"In Terms of Service Tax Notification 32/2004-ST dated 03.12.2004, Service Tax is calculated on a value which is Equivalent to 25% of the Gross amount charged from the customer for providing the taxable service, and no credit of Duty paid on input or Capital Goods for providing such taxable service has been taken by us under the provisions of Cenvat Credit Rules,2004.",0,'L');
//$pdf->Ln(50);

$pdf->Ln(1);
 $pdf->SetFont('arial','b',9);
$pdf->Image('termcondition.png',4,120,155,20);//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])


$pdf->Output();
?> 
                          	
<?php
mysqli_close($connection);



?>
