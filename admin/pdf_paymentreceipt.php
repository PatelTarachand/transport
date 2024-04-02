<?php  error_reporting(0);                                                                                           include("dbconnect.php");
include("../fpdf17/fpdf.php");
$tblname="m_payment";
$tblpkey = "payment_id";
$module = "Masters";
$keyvalue="";
 $bid_id = trim(addslashes($_GET['bid_id']));
	
//echo "select * from bidding_entry where bid_id='$bid_id'";
	$sql = mysqli_query($connection,"select * from bidding_entry where bid_id='$bid_id'");
	$row=mysqli_fetch_assoc($sql);	
	
	$adv_cash = $row['adv_cash'];
		$pay_no = $row['pay_no'];
	$adv_diesel = $row['adv_diesel'];
	$adv_date =  $cmn->dateformatindia($row['adv_date']);
	$adv_cheque = $row['adv_cheque'];
	 $cheque_no = $row['cheque_no'];
	$bankid = $row['bankid'];
    $paid_no = $row['paid_no'];
	$truckid = $row['truckid'];
	$destinationid = $row['destinationid'];
	$driver = $row['driver'];
	$drivermobile = $row['drivermobile'];
		$noofqty = $row['noofqty'];
			$deduct = $row['deduct'];

	$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
	$truckowner = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
		$truckownermobile = $cmn->getvalfield($connection,"m_truckowner","mobileno1","ownerid='$ownerid'");
	$payment_date = $cmn->dateformatindia($row['payment_date']);
	$adv_date = $cmn->dateformatindia($row['adv_date']);
	//$truckownermobile = $row['truckownermobile'];
	$advchequedate = $cmn->dateformatindia($row['advchequedate']);
	 $di_no = $cmn->getvalfield($connection,"bidding_entry","di_no","bid_id='$bid_id'");	
	$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");	
	$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");	
	$ac_number = $cmn->getvalfield($connection,"m_truckowner","ac_number","ownerid='$ownerid'");	
	$bankname = $cmn->getvalfield($connection,"m_bank","bankname","bankid='$bankid'");
	$destination = $cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'");
	$charrate = $rate_mt - $newrate;
	$advpaid = $adv_cash + $adv_diesel + $adv_cheque;
	
	$itemid = $row['itemid'];
		$itemname = $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");
	$qty = $row['qty'];
	$totalweight = $row['totalweight'];
	$rate_mt = $row['rate_mt'];
	$freight = $row['freight'];
	$newrate = $row['newrate'];
	
	$totalamt = $totalweight*$newrate;
	$commission = $row['commission'];
	$cashpayment = $row['cashpayment'];
		$cashpayment = $row['cashpayment'];
	$tds_per = $row['tds_amt'];
		$tds_amt = round($totalamt*$tds_per/100);
	$chequepaymentno = $row['chequepaymentno'];
	$paymentbankid = $row['paymentbankid']; 
	$chequepaydate = $cmn->dateformatindia($row['chequepaydate']); 
	$bankname = $cmn->getvalfield($connection,"m_bank","bankname","bankid='$paymentbankid'");
	$totalpayamt = $row['cashpayment']+$row['chequepayment']+$row['neftpayment'];
	
	$balamt=$totalamt-$advpaid;
	
function convert_number_to_words($number) {

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
	   global $adv_date,$payment_date;
	
		$this->SetFont('courier','b',15);
		$this->Cell(50);
		$this->Cell(110,0,$title1,0,1,'L');
		$this->Ln(6);
		$this->SetFont('courier','b',15);
		$this->Cell(80);
		$this->Cell(90,0,$title2,0,1,'C');
		$this->Ln(3);
		$this->Cell(-1);
		$this->SetFont('courier','b',11);
		//$this->Cell(95,5,"".$collect_from,0,0,'L');
		//$this->Cell(280,5,"Date : ".date('d-m-Y'),0,1,'R');
		$this->Ln(1);
		//$this->Ln(10);
		
		 $this->SetY(50);
			$this->SetX(130);
		    $this->SetFont('courier','b',9);
           $this->Cell(50,6,'Advance Date'." - ".$adv_date,0,1,'C',0);
		
		    $this->SetY(98);
			$this->SetX(130);
		    $this->SetFont('courier','b',9);
           $this->Cell(50,6,'Payment Date'." - ".$payment_date,0,1,'C',0);

		
	}
	function Footer()
	{ 
	 global $commission,$cashpayment,$tds_amt,$deduct,$noofqty,$chequepayment,$totalpayamt,$chequepaymentno,$chequepaydate,$bankname,$ac_number;
	 
	 
	  $this->SetY(-50);
$this->SetFont('Arial','B',12);
$this->Cell(190,6,'Final Payment',1,1,'C',0);


$this->SetFont('Arial','',8);
 $this->Cell(150,6,'Commission',1,0,'R',0);
$this->Cell(40,6,number_format($commission,2),1,1,'R',0);


$this->SetX(10);
$this->Cell(150,6,'TDS Amt.' ,1,0,'R',0);
$this->Cell(40,6,number_format($tds_amt,2),1,1,'R',0);

$this->SetX(10);
$this->Cell(150,6,'Shortage' ,1,0,'R',0);
$this->Cell(40,6,number_format($deduct,2),1,1,'R',0);



$this->SetX(10);
$this->Cell(150,6,'Total Paid Amount' ,1,0,'R',0);
$this->Cell(40,6,number_format($totalpayamt,2),1,1,'R',0);




		
		
		
		$this->SetY(-9);
$this->SetX(4);

$this->SetFont('Arial','b',8);
$this->SetTextColor(0,0,0);
$this->Cell(140,5,''.$billdate,0,0,'L',0);
$this->SetFont('Arial','b',8);
$this->SetTextColor(0,0,0);
$this->Cell(40,5,'Signature',0,0,'R',0);

		
		
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
$pdf->SetTitle("Payment Receipt");
$pdf->AliasNbPages();
$pdf->AddPage('L','A5');
//$pdf->MultiCell(80,5,"Customer Copy",0,'L');

$pdf->SetY(10);
 $pdf->SetX(20);
//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])

//Line(float x1, float y1, float x2, float y2)

// $pdf->SetFont('courier','b',9);
 //$pdf->Line(30,52, 130, 52 ); //For A4
 
 // $pdf->SetFont('courier','b',9);
  //$pdf->Line(20,61, 185, 61 ); //For A4
 


 $pdf->SetFont('courier','b',9);
 $pdf->Rect(3,4, 204, 140, 'D'); //For A4
 
$pdf->SetFont('courier','b',9);
$pdf->Rect(3,4, 204, 16, 'D'); //For A4
 
  //$pdf->SetFont('courier','b',9);
  //$pdf->Rect(10,71, 95, 25, 'D'); //For A4
 
 //$pdf->SetFont('courier','b',9);
 //$pdf->Rect(105,71, 95, 25, 'D'); //For A4
 
  //$pdf->SetY(25);
//$pdf->SetX(8);
//$pdf->Image('Chrysanthemum.jpg',10,10,20,15);//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
 //$pdf->SetFont('courier','b',9);
// $pdf->Rect(10,10, 20, 15, 'D'); //For A4
 
$pdf->SetY(7);
//$pdf->SetX(13);
 $cname = $cmn->getvalfield($connection,"m_company","cname","1 = 1");
   $headaddress = $cmn->getvalfield($connection,"m_company","headaddress","1 = 1");
  $mobileno1  = $cmn->getvalfield($connection,"m_company","mobileno1","1 = 1");
   $mobileno2  = $cmn->getvalfield($connection,"m_company","mobileno2","1 = 1");
$pdf->SetFont('Arial','b',16);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(170,4,$cname,'0',1,'C',0);
//$pdf->Ln(2);
$pdf->SetFont('Arial','b',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(170,4,ucwords($headaddress),'0',1,'C',0);
$pdf->SetFont('Arial','b',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(170,4,'Contact No -'.$mobileno1.",".$mobileno2,'0',1,'C',0);
$pdf->Ln(3);

$pdf->SetFont('Arial','b',16);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(170,4,'Payment Receipt','0',1,'C',0);
$pdf->Ln(3);
$pdf->SetFont('Arial','b',8);
$pdf->SetTextColor(0,0,0);
//$pdf->SetX(150);
$pdf->Cell(50,2,'Pay No : '.$pay_no,'0',0,'L',0);
//$pdf->Ln(2);
$pdf->SetFont('Arial','b',8);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(50,2,'Date : '.$adv_date,'0',0,'L',0);

$pdf->SetFont('Arial','b',9);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(58,2,'Bilty No : '.$di_no,'0',0,'L',0);

$pdf->SetFont('Arial','b',8);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(50,2,'Truck No : '.$truckno,'0',1,'L',0);

$pdf->Ln(2);
$pdf->SetFont('Arial','b',8);
$pdf->SetTextColor(0,0,0);
//$pdf->SetX(150);
$pdf->Cell(50,2,'Driver Name : '.$driver,'0',0,'L',0);
//$pdf->Ln(2);
$pdf->SetFont('Arial','b',8);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(38,2,'Driver No. : '.$drivermobile,'0',0,'L',0);

$pdf->SetFont('Arial','b',9);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(70,2,'Owner Name : '.$truckowner,'0',0,'L',0);

$pdf->SetFont('Arial','b',8);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(50,2,'Owner No. : '.$truckownermobile,'0',1,'L',0);
$pdf->Ln(2);



		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(30,5,'Description',1,0,'L',0);
		$pdf->Cell(50,5,'Destination',1,0,'L',0);
		$pdf->Cell(25,5,'Weight(MT)',1,0,'L',0);
			$pdf->Cell(25,5,'Rec. Qty(Bag)',1,0,'L',0);
				$pdf->Cell(25,5,'Rate',1,0,'L',0);
		$pdf->Cell(35,5,'Total',1,1,'L',0);  
		 
		
				
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(30,5,$itemname,1,0,'L',0);
		$pdf->Cell(50,5,$destination,1,0,'L',0);
		$pdf->Cell(25,5,$totalweight,1,0,'L',0);
			$pdf->Cell(25,5,$noofqty,1,0,'L',0);
		$pdf->Cell(25,5,$newrate,1,0,'L',0);
		
		$pdf->Cell(35,5,$totalamt,1,1,'L',0);

$pdf->Ln(3);



$pdf->SetX(10);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,6,'Advance Payment' ,1,1,'C',0);
//$pdf->Cell(30,5,$payment_type,0,1,'L',0);
$pdf->SetX(10);
$pdf->SetFont('Arial','',8);
$pdf->Cell(150,6,'Advance Cash',1,0,'R',0);
$pdf->Cell(40,6,number_format($adv_cash,2),1,1,'R',0);

$pdf->SetX(10);
$pdf->Cell(150,6,'Advance Diesel' ,1,0,'R',0);
$pdf->Cell(40,6,number_format($adv_diesel,2),1,1,'R',0);



$pdf->SetX(10);
$pdf->Cell(150,12,'Advance Cheque Amt',1,0,'L',0);
$pdf->Cell(40,12,number_format($adv_cheque,2),1,1,'R',0);

$pdf->SetX(10);
$pdf->Cell(150,6,'Total Advance Amount',1,0,'R',0);
$pdf->Cell(40,6,number_format($advpaid,2),1,1,'R',0);
$pdf->SetX(10);
$pdf->Cell(150,6,'Balance Amount',1,0,'R',0);
$pdf->Cell(40,6,number_format($balamt,2),1,1,'R',0);
$pdf->Ln(4);
$pdf->SetY(68);
$pdf->SetX(45);
$pdf->Cell(23,6,'Cheque No.' ,1,0,'L',0);
$pdf->Cell(30,6,$cheque_no,1,0,'L',0);
$pdf->Cell(24,6,'Cheque Date.' ,1,0,'L',0);
$pdf->Cell(38,6,$advchequedate,1,0,'L',0);

$pdf->SetY(74);
$pdf->SetX(45);
$pdf->Cell(23,6,'Bank Name' ,1,0,'L',0);
$pdf->Cell(30,6,$bankname,1,0,'L',0);
$pdf->Cell(24,6,'AC. No.' ,1,0,'L',0);
$pdf->Cell(38,6,$ac_number,1,0,'L',0);




  $pdf->Output();	
?>
