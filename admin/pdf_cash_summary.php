<?php include("dbconnect.php");
include("../fpdf17/fpdf2.php");
$tblname="m_payment";
$tblpkey = "payment_id";
$module = "Masters";
$keyvalue="";
$title1='';
$title2='';
$uchantiadv =0;


if(isset($_GET['startdate']))
{
	$startdate = trim(addslashes($_GET['startdate']));
}
else
$startdate=date('d-m-Y');

$yesterday = $startdate;


$curdate = $cmn->dateformatusa($startdate);
$openingbal = $cmn->getcashopeningplant($connection,$yesterday);

$cementadv = $cmn->getvalfield($connection,"bidding_entry as A left join m_truck as B on A.truckid=B.truckid left join m_truckowner as C on B.ownerid=C.ownerid","sum(A.adv_cash)","A.itemid=2 && A.adv_date='$curdate'  and consignorid !=4");

$clinkeradv = $cmn->getvalfield($connection,"bidding_entry as A left join m_truck as B on A.truckid=B.truckid left join m_truckowner as C on B.ownerid=C.ownerid","sum(A.adv_cash)","A.itemid=1 && A.adv_date='$curdate'  and consignorid !=4");

//$uchantiadv = $cmn->getvalfield($connection,"bidding_entry as A left join m_truck as B on A.truckid=B.truckid left join m_truckowner as C on B.ownerid=C.ownerid","sum(A.adv_cash)","A.adv_date='$curdate' && C.owner_type='self'");

$otherincome = $cmn->getvalfield($connection,"otherincome as A left join m_userlogin as B on A.createdby = B.userid","sum(incomeamount)","payment_type='cash' && paymentdate='$curdate' && B.branchid=1  && A.createdby in (select userid from m_userlogin where consignorid !=4)");

//$otherexpense = $cmn->getvalfield($connection,"other_expense as A left join m_userlogin as B on A.createdby = B.userid","sum(expamount)","payment_type='cash' && paymentdate='$curdate' && branchid=1");  
	
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


class PDF_MC_Table extends FPDF2
{
  var $widths;
  var $aligns;
	function Header()
	{ 
	   global $adv_date,$payment_date,$title1,$title2;
	
		$this->SetFont('courier','b',15);
		$this->Cell(60);
		$this->Cell(195,0,$title1,0,1,'L');
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
$pdf->SetTitle("Cash Summery");
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




$pdf->SetFont('Arial','b',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(175,4,'Shree Ganeshay Namah','0',0,'C',0);

$pdf->setX(175);
$pdf->SetFont('Arial','b',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(100,4,'Date : '.$startdate,'0',0,'L',0);

$pdf->Ln(10);

$pdf->setX(20);
$pdf->SetFont('Arial','b',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(100,4,'Shree Cement Side :','0',1,'L',0);
$pdf->Ln(2);
$pdf->setX(25);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(20,4,number_format($openingbal,2),'0',0,'R',0);
$pdf->Cell(80,4,'Opening Balance','0',1,'L',0);
$pdf->Ln(2);
$pdf->setX(25);
$pdf->Cell(20,4,number_format($otherincome,2),'0',0,'R',0);
$pdf->Cell(80,4,'Cash Received','0',1,'L',0);

$total_income = $openingbal + $otherincome;

$pdf->Ln(8);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(80);
$pdf->Cell(20,4,number_format($cementadv,2),'0',0,'R',0);
$pdf->Cell(100,4,'Cement Advance','0',1,'L',0);
$pdf->Ln(2);
$pdf->Cell(80);
$pdf->Cell(20,4,number_format($clinkeradv,2),'0',0,'R',0);
$pdf->Cell(100,4,'Clinker Advance','0',1,'L',0);

/*
$pdf->Ln(2);
$pdf->Cell(80);
$pdf->Cell(20,4,number_format($uchantiadv,2),'0',0,'R',0);
$pdf->Cell(100,4,'Uchanti','0',1,'L',0); */

//uchantiadv
//$otherexpense = $cmn->getvalfield($connection,"other_expense as A left join m_userlogin as B on A.createdby = B.userid","sum(expamount)","payment_type='cash' && paymentdate='$curdate' && branchid=1");  
$otherexpense =0;
$sql = mysqli_query($connection,"select A.* from other_expense as A left join m_userlogin as B on A.createdby = B.userid where payment_type='cash' && paymentdate='$curdate' && branchid=1  && A.createdby in (select userid from m_userlogin where consignorid !=4) group by head_id"); 
while($row=mysqli_fetch_assoc($sql))
{
$head_id = $row['head_id'];
$headname = $cmn->getvalfield($connection,"other_income_expense","headname","head_id='$head_id'");

$expamount = $cmn->getvalfield($connection,"other_expense as A left join m_userlogin as B on A.createdby = B.userid","sum(expamount)","payment_type='cash' && paymentdate='$curdate' && branchid=1 && head_id='$head_id'  && A.createdby in (select userid from m_userlogin where consignorid !=4)");

$pdf->Ln(2);
$pdf->Cell(80);
$pdf->Cell(20,4,number_format($expamount,2),'0',0,'R',0);
$pdf->Cell(100,4,$headname,'0',1,'L',0);

$otherexpense += $expamount;
}


//echo "select A.* from truck_expense as A left join m_userlogin as B on A.createdby = B.userid where payment_type='cash' && paymentdate='$curdate' && branchid=1"; die;
$sql = mysqli_query($connection,"select A.* from truck_expense as A left join m_userlogin as B on A.createdby = B.userid where payment_type='cash' && paymentdate='$curdate' && branchid=1  && A.createdby in (select userid from m_userlogin where consignorid !=4) group by head_id"); 
while($row=mysqli_fetch_assoc($sql))
{
$head_id = $row['head_id'];
$headname = $cmn->getvalfield($connection,"other_income_expense","headname","head_id='$head_id'");
$expamount = $cmn->getvalfield($connection,"truck_expense as A left join m_userlogin as B on A.createdby = B.userid","sum(uchantiamount)","payment_type='cash' && paymentdate='$curdate' && branchid=1 && head_id='$head_id'  && A.createdby in (select userid from m_userlogin where consignorid !=4)");

$pdf->Ln(2);
$pdf->Cell(80);
$pdf->Cell(20,4,number_format($expamount,2),'0',0,'R',0);
$pdf->Cell(100,4,$headname,'0',1,'L',0);

$otherexpense += $expamount;
}


$total_expense = $cementadv + $clinkeradv + $otherexpense + $uchantiadv;


$pdf->Ln(22);
$lh = 100;
$lw= $lh+8;
$pdf->Line(20, $lh, 190,$lh);
$pdf->Line(20, $lw, 190,$lw);
$pdf->Ln(2);
$pdf->setY(102);
$pdf->SetFont('Arial','b',10);
$pdf->SetTextColor(0,0,0);
$pdf->setX(25);

$pdf->SetFont('Arial','b',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(20,4,number_format($total_income,2),'0',0,'R',0);
$pdf->Cell(45,4,' ','0',0,'L',0);
$pdf->Cell(20,4,number_format($total_expense,2),'0',0,'R',0);
$pdf->Cell(100,4,' ','0',1,'L',0);

$pdf->Ln(5);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(80);
$pdf->Cell(20,4,number_format($total_income,2),'0',0,'R',0);
$pdf->Cell(100,4,' ','0',1,'L',0);

$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(80);
$pdf->Cell(20,4,number_format($total_expense,2),'0',0,'R',0);
$pdf->Cell(100,4,' ','0',1,'L',0);


$pdf->Ln(3);
$pdf->SetFont('Arial','b',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(80);
$pdf->Cell(20,4,number_format($total_income - $total_expense,2),'0',0,'R',0);
$pdf->Cell(100,4,'Closing Balance','0',1,'L',0);



$pdf->Line(20, 120, 190,120);
$pdf->Line(20, 128, 190,128);

$pdf->Output();	
?>
