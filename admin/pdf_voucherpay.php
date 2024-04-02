<?php  
include("dbconnect.php");

require("../fpdf17/fpdf.php");
$tblname="voucher_pay";
$tblpkey = "pay_id";
$module = "Masters";
$keyvalue="";
     $pay_id = trim(addslashes($_GET['pay_id']));
	$voucher_no = trim(addslashes($_GET['voucher_no']));
	$sql = mysqli_query($connection,"select * from $tblname where pay_id='$pay_id' ");
	$row=mysqli_fetch_assoc($sql);	
	
 $voucher=$cmn->getvalfield($connection,"voucher_entry","voucher_no","bulk_vid='$row[bulk_vid]'"); 
$partyid=$cmn->getvalfield($connection,"voucher_entry","partyid","bulk_vid='$row[bulk_vid]'"); 
$party_name=$cmn->getvalfield($connection,"supplier_master","party_name","supplier_id='$partyid'"); 
 $vamt=$cmn->getvalfield($connection,"payment_recive","sum(final_total)","bulk_vid='$row[bulk_vid]'"); 
 $receive_amt=$row['amt'];
$user_name=$cmn->getvalfield($connection,"user_master","uname","user_id='$row[user_id]'"); 
$balamt= $vamt - $receive_amt;
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
	   //global $title1,$title2;
	
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
		
		    $this->SetFont('courier','b',9);
	       // $this->Rect(5, 5, 200, 80, 'D'); //For A4
		
		
	}
	function Footer()
	{ 
	    global $user_name;
	    $this->SetY(-15);
		$this->SetFont('Arial','I',9);
		//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		
		
		$this->SetY(135);
$this->SetX(12);

$this->SetFont('Arial','b',9);
$this->SetTextColor(0,0,0);
$this->Cell(70,5,'Cashier',0,0,'L',0);
$this->Cell(10,5,'Created by- '.$user_name,0,0,'L',0);

$this->SetFont('Arial','b',9);
$this->SetTextColor(0,0,0);
$this->Cell(50,5,' ',0,0,'L',0);

$this->SetFont('Arial','b',9);
$this->SetTextColor(0,0,0);
$this->Cell(45,5,'',0,0,'L',0);


$this->SetFont('Arial','b',9);
$this->SetTextColor(0,0,0);

$this->Cell(10,5,'Receiver',0,0,'R',0);




		
		
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
$pdf->SetTitle("Payment Voucher");
$pdf->AliasNbPages();
$pdf->AddPage('L','A5');
//$pdf->MultiCell(80,5,"Customer Copy",0,'L');

$pdf->SetY(10);
 $pdf->SetX(20);
//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])



 $pdf->SetFont('courier','b',9);
 $pdf->Rect(3,4, 204, 140, 'D'); //For A4
 
$pdf->SetFont('courier','b',9);
$pdf->Rect(3,4, 204, 16, 'D'); //For A4
$pdf->Rect(3,120, 204, 10, 'D'); //For A4  
$pdf->Rect(3,130, 204, 14, 'D'); //For A4 




 
 
 
 
$pdf->SetY(7);
//$pdf->SetX(13);
$cname = $cmn->getvalfield($connection, "company_master", "com_name", "company_id =$_SESSION[company_id]");
$mobileno1 = $cmn->getvalfield($connection, "company_master", "mobile1", "company_id=$_SESSION[company_id]");
// $mobileno2 = $cmn->getvalfield($connection, "m_company", "mobileno2", "comp_id=$_SESSION[comp_id]");
$caddress = $cmn->getvalfield($connection, "company_master", "add1", "company_id=$_SESSION[company_id]");
$emailid = $cmn->getvalfield($connection, "company_master", "emailid", "company_id=$_SESSION[company_id]");
// $clogo = $cmn->getvalfield($connection, "m_company", "clogo", "comp_id=$_SESSION[comp_id]");
//   $pdf->Image('../upload/logo/'.$clogo,15,5,14,14);
$pdf->SetFont('Arial','b',16);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(180,4,$cname,'0',1,'C',0);
//$pdf->Ln(2);
$pdf->SetFont('Arial','b',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(180,4,ucwords($caddress),'0',1,'C',0);
$pdf->SetFont('Arial','b',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(180,4,'Contact No -'.$mobileno1,'0',1,'C',0);
$pdf->Ln(2);
$pdf->setX(180);



$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->setX(145);
// $pdf->setY(-10);
$pdf->Ln(2);
// $pdf->Cell(51,4,': ','0',0,'R',0);

$pdf->SetFont('Arial','b',16);
$pdf->SetTextColor(0,0,0);
$pdf->setX(10);
$pdf->Cell(180,4,'Payment Voucher','0',1,'C',0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(12,4,'Rec No :','0',0,'R',0);
$pdf->Cell(40,4,'0000'.$row['rec_no'],'0',1,'L',0);
$pdf->setX(170);
$pdf->SetFont('Arial','b',10);
$pdf->SetTextColor(0,0,0);
//  $pdf->setY(-10);


$pdf->Ln(4);
$pdf->SetFont('Arial','b',10);
$pdf->SetTextColor(0,0,0);
$pdf->setX(3);
$pdf->Cell(51,8,'Voucher No','1',0,'C',0);

$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(45,8,' '.$voucher,'1',0,'C',0);
//$pdf->Ln(2);
$pdf->SetFont('Arial','b',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(45,8,'Payment Date','1',0,'C',0);


$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(63,8,' '.dateformatindia($row['rec_date']),'1',0,'C',0);



$pdf->Ln(8);
$pdf->SetFont('Arial','b',10);
$pdf->SetTextColor(0,0,0);
$pdf->setX(3);
$pdf->Cell(51,8,'Party Name','1',0,'C',0);

$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(45,8,' '.strtoupper($party_name),'1',0,'C',0);
//$pdf->Ln(2);
$pdf->SetFont('Arial','b',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(45,8,'Received From','1',0,'C',0);


$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(63,8,''.strtoupper($row['rec_from']),'1',0,'C',0);





$pdf->Ln(3);
$pdf->SetX(9);

$pdf->SetFont('Arial','b',10);
$pdf->SetTextColor(0,0,0);

$pdf->SetFont('Arial','b',10);
$pdf->SetTextColor(0,0,0);


$pdf->SetFont('Arial','b',10);
$pdf->SetTextColor(0,0,0);



//$pdf->Line(20,65,100,65);
//$pdf->Cell(18,5,"in words ".strtoupper($cmn->numtowords($receivedamt)),0,1,'C',0);

$pdf->Ln(10);

//$totalamt = $wt_mt*$newrate;
		

$pdf->Ln(3);
$pdf->SetX(10);
$pdf->Cell(187,6,'Payment Details' ,1,1,'C',0);

$pdf->SetX(10);

$pdf->Cell(120,6,'Voucher Amount',1,0,'C',0);
$pdf->Cell(67,6,number_format($vamt,2),1,1,'R',0);

$pdf->SetX(10);
$pdf->Cell(120,6,'Paid Amount',1,0,'C',0);
$pdf->Cell(67,6,number_format($receive_amt,2),1,1,'R',0);



$pdf->SetX(10);
$pdf->Cell(120,6,'Balance Amount' ,1,0,'C',0);
$pdf->Cell(67,6,number_format($balamt,2),1,1,'R',0);


/*
$pdf->Ln(2);
$pdf->SetY(92);
$pdf->SetX(50);
$pdf->Cell(26,6,'A/c Holder Name' ,1,0,'L',0);
$pdf->Cell(84,6,$advchequedate,1,0,'L',0);



$pdf->SetY(98);
$pdf->SetX(50);
$pdf->Cell(26,6,'A/c No.' ,1,0,'L',0);
$pdf->Cell(38,6,$cheque_no,1,0,'L',0);

$pdf->Cell(16,6,'IFSC Code' ,1,0,'L',0);
$pdf->Cell(30,6,$ac_number,1,0,'L',0);

$pdf->SetY(104);
$pdf->SetX(50);
$pdf->Cell(26,6,'Bank Name' ,1,0,'L',0);
$pdf->Cell(84,6,$bankname,1,0,'L',0);


$pdf->SetY(110);
$pdf->SetX(50);
$pdf->Cell(26,6,'Branch Name' ,1,0,'L',0);
$pdf->Cell(84,6,$bankname,1,0,'L',0);
*/


$pdf->SetX(10);
// $pdf->Cell(150,6,'Net Amount ',1,0,'R',0);
// $pdf->Cell(37,6,number_format($totalamt,2),1,1,'R',0);

// $pdf->SetX(10);
$pdf->Cell(24,10,'In Words :',0,0,'R',0);
$pdf->Cell(40,10,ucwords(convert_number_to_words($receive_amt))." Rupees Only",0,1,'L',0);
// $pdf->ln(10);






  $pdf->Output();
  
  
  
?>
