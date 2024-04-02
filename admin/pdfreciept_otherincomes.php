<?php  error_reporting(0);                                                                                           include("dbconnect.php");
include("../fpdf17/fpdf.php");
$tblname="m_payment";
$tblpkey = "payment_id";
$module = "Masters";
$keyvalue="";
$otherincomeid = trim(addslashes($_GET['otherincomeid']));
	

	$sql = mysqli_query($connection,"select * from otherincome where otherincomeid='$otherincomeid'");
	$row=mysqli_fetch_assoc($sql);		
	
	$payeename = $row['payeename'];
	$stype = $row['stype'];
	$incomeamount = $row['incomeamount'];
	$head_id = $row['head_id'];
	$payment_type = $row['payment_type'];
	$chequeno = $row['chequeno'];
	$bankid = $row['bankid'];
	$paymentdate = $cmn->dateformatindia($row['paymentdate']);
	$narration = $row['narration'];
	$bankname = $cmn->getvalfield($connection,"m_bank","bankname","bankid='$bankid'");
		$headname = $cmn->getvalfield($connection,"other_income_expense","headname","head_id='$row[head_id]'");
	
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
	    $this->SetY(-15);
		$this->SetFont('Arial','I',9);
		//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		
		
		$this->SetY(-12);
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



 $pdf->SetFont('courier','b',9);
 $pdf->Rect(3,4, 204, 140, 'D'); //For A4
 
$pdf->SetFont('courier','b',9);
$pdf->Rect(3,4, 204, 16, 'D'); //For A4
 
 
$pdf->SetY(7);
//$pdf->SetX(13);
 $cname = $cmn->getvalfield($connection,"m_company","cname","compid='$compid'");
   $headaddress = $cmn->getvalfield($connection,"m_company","headaddress","compid='$compid'");
  $mobileno1  = $cmn->getvalfield($connection,"m_company","mobileno1","compid='$compid'");
   $mobileno2  = $cmn->getvalfield($connection,"m_company","mobileno2","compid='$compid'");
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

$pdf->SetFont('Arial','b',18);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(170,4,'Credit Voucher','0',1,'C',0);

$pdf->Ln(10);
$pdf->SetFont('Arial','b',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(25,4,'Income Type','0',0,'L',0);

$pdf->SetFont('Arial','b',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(35,4,': '.$stype,'0',0,'L',0);
//$pdf->Ln(2);
$pdf->SetFont('Arial','b',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(22,4,'Payee Name','0',0,'L',0);


$pdf->SetFont('Arial','b',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(60,4,': '.$payeename,'0',0,'L',0);


$pdf->SetFont('Arial','b',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(25,4,'Payment Date','0',0,'L',0);

$pdf->SetFont('Arial','b',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(35,4,': '.$paymentdate,'0',1,'L',0);



$pdf->Ln(2);
$pdf->SetX(9);

$pdf->SetFont('Arial','b',12);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(13,4,'Head ','0',0,'L',0);

$pdf->SetFont('Arial','b',12);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(35,4,': '.$headname,'0',1,'L',0);



//$pdf->Line(20,65,100,65);
//$pdf->Cell(18,5,"in words ".strtoupper($cmn->numtowords($receivedamt)),0,1,'C',0);


$pdf->Ln(1);
$pdf->SetX(10);

$pdf->Cell(190,6,'Payment Mode' ,1,1,'C',0);
//$pdf->Cell(30,5,$payment_type,0,1,'L',0);

$pdf->SetX(10);
$pdf->Cell(150,18,'Income Amount ',1,0,'L',0);
$pdf->Cell(40,18,number_format($incomeamount,2),1,1,'R',0);

$pdf->SetX(10);
$pdf->Cell(150,6,'Net Amount ',1,0,'R',0);
$pdf->Cell(40,6,number_format($incomeamount,2),1,1,'R',0);
$pdf->Ln(2);
$pdf->SetY(53);
$pdf->SetX(50);
$pdf->Cell(30,6,'Cheque No.' ,1,0,'L',0);
$pdf->Cell(30,6,$chequeno,1,0,'L',0);

$pdf->Cell(10,6,'' ,0,0,'L',0);
$pdf->Cell(50,6,'',0,0,'L',0);

$pdf->SetY(59);
$pdf->SetX(50);
$pdf->Cell(30,6,'Cheque Date.' ,1,0,'L',0);
$pdf->Cell(80,6,$chequedate,1,0,'L',0);

$pdf->SetY(65);
$pdf->SetX(50);
$pdf->Cell(30,6,'Bank Name.' ,1,0,'L',0);
$pdf->Cell(80,6,$bankname,1,0,'L',0);
$pdf->ln(10);




  $pdf->Output();	
?>
