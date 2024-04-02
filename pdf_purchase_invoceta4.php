<?php  
error_reporting(0);
include("../adminsession.php");
require("../fpdf17/fpdf.php");

if(isset($_GET['saleid']))
{
	$saleid = $_GET['saleid'];
	$sql = "select * from saleentry where saleid = '$saleid'";
	$res = mysqli_query($connection,$sql);
	$row = mysqli_fetch_array($res);
	
	$billno=$row['billno'];
$suppartyid=$row['suppartyid'];
$saledate= date('d-m-Y',strtotime($row['saledate']));
$billtype=$row['billtype'];
	 $from_place=$row['from_place'];
$ewayno=$row['ewayno'];
$shipto=$row['shipto'];
$brandid=$row['brandid'];
$fortype=$row['fortype'];
$exfactory_freight_rate=$row['exfactory_freight_rate'];
$freight_amt=$row['freight_amt'];
$qty=$row['qty'];
$bag=$row['bag'];
$rate=$row['rate'];
$amount=$row['amount'];
$taxablevalue=$row['taxablevalue'];
$productid=$row['productid'];
$gst=$row['gst'];
$gsttype=$row['gsttype'];
$igst=$row['igst'];
$cgst=$row['cgst'];
$sgst=$row['sgst'];
$taxamt=$row['taxamt'];
$invoice_amt=$row['invoice_amt'];
$drive_name=$row['drive_name'];
$own_name=$row['own_name'];
$truck_no=$row['truck_no'];
$remark=$row['remark'];
$dl_no=$row['dl_no'];
$ship_state=$row['ship_state'];
$ship_gst=$row['ship_gst'];
 $ship_mobile=$row['ship_mobile'];
$ship_pan=$row['ship_pan'];
$ship_address=$row['ship_address'];
$ship_address2=$row['ship_address2'];
$ship_name=$row['ship_name'];

	 $compname = $row['comp_name'];

	 $supparty_name=$cmn->getvalfield($connection,"m_supplier_party","supparty_name","suppartyid='$suppartyid'");
	 $sup_mobile=$cmn->getvalfield($connection,"m_supplier_party","mobile","suppartyid='$suppartyid'");
	$sup_address=$cmn->getvalfield($connection,"m_supplier_party","address","suppartyid='$suppartyid'");
	$sup_address2=$cmn->getvalfield($connection,"m_supplier_party","address2","suppartyid='$suppartyid'");
	$panno=$cmn->getvalfield($connection,"m_supplier_party","panno","suppartyid='$suppartyid'");
	$gstType=$cmn->getvalfield($connection,"m_supplier_party","gstType","suppartyid='$suppartyid'");
	$tinno = $cmn->getvalfield($connection,"m_supplier_party","tinno","suppartyid='$suppartyid'");
	$stateid=$cmn->getvalfield($connection,"m_supplier_party","stateid","suppartyid='$suppartyid'");
	$cus_code=$cmn->getvalfield($connection,"m_state","state_code","stateid = '$stateid'");
	$cus_state=$cmn->getvalfield($connection,"m_state","state_name","stateid = '$stateid'");
	$state_code=$cmn->getvalfield($connection,"m_state","state_code","stateid = '$stateid'");


	$comp_name =  $cmn->getvalfield($connection,"company_setting","comp_name","compid ='$compname'");
	$stateidd =  $cmn->getvalfield($connection,"company_setting","stateid","compid = '$compname'");
	$company_code=$cmn->getvalfield($connection,"m_state","state_code","stateid = '$stateidd'");
	$company_state=$cmn->getvalfield($connection,"m_state","state_name","stateid = '$stateidd'");
	$gsttinno =  $cmn->getvalfield($connection,"company_setting","gsttinno","compid='$compname'");


}
else
$saleid = 0;

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
		global $title1,$title2,$comp_tinno,$com_pan,$com_stateid,$com_code,$com_address,$invoice,$diNo,$supparty_name,$mobile,$billno,$saledate,$from_place,$gsttinno,$transport_name,$transport_date,$sup_address2,$sup_address,$ewayno,$freight_amt,$company_state,$cus_code,$cus_state,$state_code,$challan_no,$Address,$gsttype,$title4,$tinno,$address2,$comp_name,$sup_mobile,$tinno,$ship_state,$ship_gst,$ship_mobile,$ship_pan,$ship_name,$ship_address2,$ship_address,$panno,$cus_state,$truck_no,$remark,$dl_no,$own_name,$drive_name;
		 //courier 25
		$this->Rect(5, 5,200,22,'D');
		$this->Rect(5, 5,200,287,'D');
		//for first Rect
		$this->Rect(5,35,100,38,'D');
		//for second Rect
		$this->Rect(105,35,100,38,'D');
		
		$this->Rect(5,60,100,60,'D');
		$this->Rect(105,60,100,60,'D');
		
		$this->Rect(5,130,100,130,'D');
		$this->Rect(105,130,100,130,'D');
		
	     //$this->SetFont('courier','b',20);
		///for Second part
		//$this->Rect(5,40,100,20,'D');
		//for second Rect
		//$this->Rect(5,70,200,14,'D');
		$this->SetFont('courier','b',18);
		$this->SetY(8);
		$this->Cell(90);
		$this->Cell(10,0,$title2,0,1,'C');
		$this->Ln(5);
		$this->SetFont('courier','b',11);
		$this->Cell(90);
		$this->Cell(10,0,$com_address.",".$address2.",".$com_stateid."(".$com_code.")",0,1,'C');
		$this->Ln(5);
		$this->SetFont('courier','b',11);
		$this->Cell(90);
		$this->Cell(11,0,"9755758693 - 8959529000",0,1,'C');
		$this->Ln(5);
		$this->SetFont('courier','b',11);
		$this->Cell(90);
		$this->Cell(12,0," GSTIN : ".$comp_tinno,0,1,'C');
		$this->Ln(5);
	   $this->SetFont('courier','b',15);
	   
		// Move to the right
		$this->Cell(90);
		// Title
		//$this->Cell(10,0,strtoupper($supparty_name),0,1,'C');
		// Line break
		//$this->Ln(5);
		//$this->SetFont('courier','b',11);
		//$this->Cell(90);
		//$this->Cell(10,0,$sup_address." "."Mobile No :".$sup_mobile,0,1,'C');
	    //$this->Ln(4);
		// $this->SetFont('courier','b',11);
		// $this->Cell(90);
	    // $this->Cell(10,0,$title4,0,1,'C');
		$this->Ln(5);
		// $this->SetFont('courier','b',11);
		//$this->Cell(90);
	   // $this->Cell(10,0,"Subject to Raipur Jurisdiction",0,1,'C');
		//$this->Ln(5);
		
		
		$this->Line(5,66,205,66);
		$this->Line(5,60,205,60);
		
		$this->SetX(5);
		$this->SetFont('courier','b',11);
		$this->Cell(40,61,"Dispatch From :-",0,0,'L');
		$this->Cell(63,61,$from_place,0,'L');
		//Dispatch  From
		$this->SetX(5);
		$this->SetFont('courier','b',10);
		$this->Cell(60,73,"Bill to party ",0,0,'C');
		
		//Bill to party
		$this->SetX(5);
		$this->SetFont('courier','b',10);
		$this->Cell(300,73,"Ship to Party  ",0,0,'C');
		
		
		
		
		// for Company GST
		$this->SetX(5);
		$this->SetFont('courier','b',14);
		$this->Cell(205,-4,"TAX INVOICE",0,0,'C');
		$this->Cell(71,5," ",0,0,'L');
		 $this->Ln(5);
	
	    //for Company Invoice
		$this->SetX(5);
		$this->SetFont('courier','b',11);
		$this->Cell(29,5,"Bill No",0,0,'L');
		$this->Cell(71,5,": ".$billno,0,0,'L');
		//for date
		//$this->SetFont('courier','b',11);
		//$this->Cell(25,5,"From",0,0,'L');
		//$this->Cell(75,5,":".$Address,0,1,'L');
		
		$this->SetFont('courier','b',11);
		$this->Cell(25,5,"PAN",0,0,'L');
		$this->Cell(75,5,"   : ".$com_pan,0,1,'L');
		
		//for Company Invoice
		
		$this->SetX(5);
		$this->SetFont('courier','b',11);
		$this->Cell(29,5,"Date",0,0,'L');
		$this->Cell(71,5,": ".$saledate,0,0,'L');
		//for Supplier GST
		$this->SetFont('courier','b',11);
		$this->Cell(25,5,"Date Supply",0,0,'L');
		$this->Cell(75,5,"   : ".$saledate,0,1,'L');
		//for Company Invoice
		
		$this->SetX(5);
		$this->SetFont('courier','b',11);
		$this->Cell(29,5,"State",0,0,'L');
		$this->Cell(71,5,": ".$com_stateid."(".$com_code.")",0,0,'L');
		//for Supplier GST
		$this->SetFont('courier','b',11);
		$this->Cell(30,5,"Place Supply",0,0,'L');
		$this->Cell(75,5," : ".$com_stateid."(".$com_code.")",0,1,'L');
		
			$this->SetX(5);
		$this->SetFont('courier','b',9);
		$this->Cell(18,45,"NAME ",0,0,'L');
		$this->Cell(84,45,$supparty_name,0,0,'L');
		//for BillNo Name
		$this->SetFont('courier','b',9);
		$this->Cell(18,45,"NAME",0,0,'L');
		$this->Cell(75,45,$ship_name,0,1,'L');
		
		$this->SetY(90);
		$this->SetX(5);
		$this->SetFont('courier','b',9);
		$this->Cell(22,10,"MOBILE NO  ",0,0,'L');
		$this->Cell(80,10,$sup_mobile,0,0,'L');
		//for BillNo Name
		$this->SetFont('courier','b',9);
		$this->Cell(22,10,"MOBILE NO  ",0,0,'L');
		$this->Cell(75,10,$ship_mobile,0,1,'L');
		
		$this->SetY(97);
		$this->SetX(5);
		$this->SetFont('courier','b',9);
		$this->Cell(22,10,"PAN     ",0,0,'L');
		$this->Cell(80,10,$panno,0,0,'L');
		//for BillNo Name
		$this->SetFont('courier','b',9);
		$this->Cell(22,10,"PAN    ",0,0,'L');
		$this->Cell(75,10,$ship_pan,0,1,'L');
		
		$this->SetY(103);
		$this->SetX(5);
		$this->SetFont('courier','b',9);
		$this->Cell(22,10,"GSTIN  ",0,0,'L');
		$this->Cell(80,10,$tinno,0,0,'L');
		//for BillNo Name
		$this->SetFont('courier','b',9);
		$this->Cell(22,10,"GSTIN  ",0,0,'L');
		$this->Cell(75,10,$ship_gst,0,1,'L');
		
		$this->SetY(78);
		$this->SetX(5);
		$this->SetFont('courier','b',9);
		$this->Cell(25,5,"Address",0,0,'L');
		
		$this->SetX(23);
		$this->MultiCell(85,5,$sup_address." ".$sup_address2,0,'L');
		
		//for BillNo Name
		$this->SetY(78);
		$this->SetX(107);
		$this->SetFont('courier','b',9);
		$this->Cell(30,5,"Address ",0,0,'L');
		$this->SetX(126);
		$this->MultiCell(85,5,$ship_address." ".$ship_address2,0,'L');
		
	$this->SetY(110);
		$this->SetX(5);
		$this->SetFont('courier','b',9);
		$this->Cell(22,10,"State/Code",0,0,'L');
		$this->Cell(80,10,$cus_state."(".$state_code.")",0,0,'L');
		//for BillNo Name
		$this->SetFont('courier','b',9);
		$this->Cell(22,10,"State/Code ",0,0,'L');
		$this->Cell(75,10,$ship_state,0,1,'L');
		
		//$this->Line(5,153,105,153);
		//$this->Line(5,158,105,158);
		//$this->Line(5,170,105,170);
		//$this->Line(5,176,105,176);
		//$this->Line(5,182,105,182);
		//$this->Line(5,188,105,188);
		//$this->Line(5,194,105,194);
	//	$this->Line(105,153,205,153);
	//$this->Line(105,185,205,185);
	//$this->Line(5,195,105,195);
		//$this->Line(105,164,205,164);
		//$this->Line(105,195,205,195);
		//$this->Line(105,176,205,176);
		//$this->Line(105,182,205,182);
		
		if($gsttype=='CSGST'){
	    
	  
	   $this->SetY(125);
	    $this->SetX(5);
		$this->SetFont('Arial','B',6);
		$this->SetFillColor(170, 170, 170); //gray
		$this->SetTextColor(0,0,0);
		$this->Cell(5,7,'Sno','1',0,'L',1);  
		$this->Cell(22,7,'Product Name',1,0,'L',1);
		$this->Cell(14,7,'HSNO',1,0,'C',1);
		$this->Cell(14,7,'QTY(M/T)',1,0,'C',1);
		$this->Cell(15,7,'QTY Bags',1,0,'C',1);
		
		$this->Cell(12,7,'RATE',1,0,'C',1);
		
		//$this->Cell(15,7,'Disc (Rs)',1,0,'C',1);
		$this->Cell(18,7,'TAXABLE AMT7',1,0,'C',1);
		$this->Cell(32,7,'CGST',1,0,'C',1);
		$this->Cell(32,7,'SGST',1,0,'C',1);
		$this->Cell(12,7,'Tax Amt',1,0,'C',1);
		$this->Cell(24,7,'Total',1,1,'C',1);
		$this->SetX(5);
		
		$this->SetFont('Arial','B',8);
		$this->SetFillColor(170, 170, 170); //gray
		$this->SetTextColor(0,0,0);
		$this->Cell(100,7,'',1,0,'L',1);
	
	
	    $this->Cell(12,7,'CGST %',1,0,'C',1);
		$this->Cell(20,7,'Amt.',1,0,'L',1);
		
		$this->Cell(12,7,'SGST %',1,0,'C',1);
		$this->Cell(20,7,'Amt.',1,0,'L',1);
	    $this->Cell(12,7,'',1,0,'L',1);
		$this->Cell(24,7,'',1,1,'L',1);
		
		$this->SetWidths(array(5,22,14,14,15,12,18,12,20,12,20,12,24));
		$this->SetAligns(array("C","L","R","R","R","R","R","R","R","R","R","R","R","R"));
		}

if($gsttype=='IGST'){
	  $this->SetY(125);
	   $this->SetX(5);
		$this->SetFont('Arial','B',8);
		$this->SetFillColor(170, 170, 170); //gray
		$this->SetTextColor(0,0,0);
		$this->Cell(9,7,'Sno','1',0,'L',1);  
		$this->Cell(31,7,'Product Name',1,0,'L',1);
		$this->Cell(15,7,'HSNO',1,0,'C',1);
		$this->Cell(14,7,'QTY(M/T)',1,0,'C',1);
		$this->Cell(16,7,' BAGs',1,0,'C',1);
		
		$this->Cell(15,7,'RATE',1,0,'C',1);
		
		
		$this->Cell(22,7,'AMOUNT',1,0,'C',1);
		$this->Cell(42,7,'IGST',1,0,'C',1);
		
		$this->Cell(36,7,'Total',1,1,'C',1);
		$this->SetX(5);
		
		$this->SetFont('Arial','B',8);
		$this->SetFillColor(170, 170, 170); //gray
		$this->SetTextColor(0,0,0);
		$this->Cell(122,7,'',1,0,'L',1);

	
	    $this->Cell(21,7,'IGST %',1,0,'L',1);
		$this->Cell(21,7,'Amt.',1,0,'L',1);
		
		$this->Cell(36,7,'',1,1,'L',1);
		
		$this->SetWidths(array(9,31,15,14,16,15,22,21,21,36));
		$this->SetAligns(array("C","L","R","R","R","R","R","R","R","R","R","R"));
		}

		
	}
	  // Page footer
	function Footer()
	{
		global $comp_name;
	// Position at 1.5 cm from bottom
		$this->SetY(-11);
		// Arial italic 8
		$this->SetFont('Arial','I',8); 
		// Page number
		$this->SetX(5);
		$this->MultiCell(200,3,'|| SUBJECT TO DURG JURISDICTION ||
This is a Computer Generated Invoice',0,'C');
	   $this->SetY(-22);
	   $this->SetX(5);
	   $this->SetFont('Arial','b',8);
	   $this->SetTextColor(0,0,0);
	  // $this->Cell(172,5, "For ".$title2,0,'1','R',0);
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
$title1 = "MAA SHARDA ENTERPRISES";
$pdf->SetTitle($title1);
$title2 = $cmn->getvalfield($connection,"company_setting","comp_name","1 = 1");
$com_address = $cmn->getvalfield($connection,"company_setting","address","1 = 1");
$address2 = $cmn->getvalfield($connection,"company_setting","address2","1 = 1");
$email_id  = $cmn->getvalfield($connection,"company_setting","email_id ","1 = 1");
$mobile  = $cmn->getvalfield($connection,"company_setting","mobile ","1 = 1");
$com_pan  = $cmn->getvalfield($connection,"company_setting","com_pan","1 = 1");
$comp_tinno  = $cmn->getvalfield($connection,"company_setting","gsttinno ","1 = 1");
 $cstateid  = $cmn->getvalfield($connection,"company_setting","stateid","1 = 1");
 $com_stateid  = $cmn->getvalfield($connection,"m_state","state_name","stateid =$cstateid");
  $com_code  = $cmn->getvalfield($connection,"m_state","state_code","stateid =$cstateid");

$title3 = $address;
$title4 = "Mobile No : ".$mobile." "."Email ID : ".$email_id;
$pdf->AliasNbPages();
$pdf->AddPage('P','A4');
$slno = 1;

$tot_qty =0;
$tot_amt =0;
$total =0;

$totcgst =0;
$totsgcst =0;
$totigst =0;
$toalgst=0;$totalroundoff=0;

$sql_get = mysqli_query($connection,"Select * from saleentry where saleid='$saleid'");
			while($row_get = mysqli_fetch_assoc($sql_get))
{
		$amount=0;
		$gsttax=0;
		$gstamt=0;
		
		$cgstamt=0;
		$sgstamt=0;
		$igstamt=0;
		
		$productid=$row_get['productid'];
		$unitid=$row_get['unitid'];
		$prodname=$cmn->getvalfield($connection,"m_product","prodname","productid='$productid'");
		$hsn_no=$cmn->getvalfield($connection,"m_product","hsn_no","productid='$productid'");
		$unit_name = $cmn->getvalfield($connection,"m_unit","unit_name","unitid ='$unitid'");
		$rate =$row_get['rate'];
		$qtymt =$row_get['qtymt'];	
		$bag =$row_get['bag'];	
			$qty =$row_get['qty'];
		$netAmount =$row_get['netAmount'];
		 $igst =$row_get['igst'];
		$sgst =$row_get['sgst'];
		$cgst =$row_get['cgst'];
		$roundoff =$row_get['roundoff'];
		
		$gst =$row_get['gst'];
		$gstAmount =$row_get['taxamt'];
		$gstAmounthalf=$gstAmount/2;
		$CGSTper=$gst/2;
		$invoice_amt =$row_get['invoice_amt'];
		
		$TOTAL = $taxamt+$invoice_amt;
		
		$rate_include=$row_get['rate_include'];
$frieght_paidby=$row_get['frieght_paidby'];
		
	   $amount= $rate * $bag;
	   
	   if($disc_rs !='0')
	   {
		   $discamt=$disc_rs;	     	
	   }
	   else
	   {
			$discamt=0;   
	   }
	   
	   $amount= $amount - $discamt;
	

	   $totaltax = ($cgstamt+$sgstamt+$igstamt);
	   
	   $rate = ($invoice_amt-$gstAmount)/$bag;
	   $taxableamt = ($invoice_amt-$gstAmount);
	   
		
	$pdf->SetX(5);	
	$pdf->SetFont('Arial','',7);
	$pdf->SetTextColor(0,0,0);
	if($gsttype=='CSGST'){
	$pdf->Row(array($slno,$prodname,$hsn_no,$qty,$bag,number_format($rate,2),number_format($taxableamt,2),$CGSTper.' %',number_format($gstAmounthalf,2),$CGSTper.' %',number_format($gstAmounthalf,2),$gstAmount,number_format($invoice_amt,2)));
	$pdf->SetX(5);
$pdf->SetFont('Arial','B',8);
$pdf->SetFillColor(170, 170, 170); //gray
$pdf->SetTextColor(0,0,0);
$pdf->Cell(82,8,'Total','1',0,'R',1);
$pdf->Cell(18,8,number_format($taxableamt,2),1,0,'R',1);
$pdf->Cell(76,8,'',1,0,'L',1);
$pdf->Cell(24,8,number_format($invoice_amt,2),1,1,'R',1);  
$tot_qty +=$qtymt;
	$tot_amt +=$amount;
	$total +=$invoice_amt;
	$toalgst += $gstAmount;
	$totalroundoff += $roundoff;
	$totcgst += $cgst;
	$totsgcst += $sgst;
	$totigst += $igst;
	}
	if($gsttype=='IGST'){
        $pdf->Row(array($slno,$prodname,$hsn_no,$qty,$bag,number_format($rate,2),number_format($taxableamt,2),$gst.' %',number_format($gstAmount,2),number_format($invoice_amt,2)));
			$pdf->SetX(5);
$pdf->SetFont('Arial','B',7);
$pdf->SetFillColor(170, 170, 170); //gray
$pdf->SetTextColor(0,0,0);
$pdf->Cell(100,8,'Total','1',0,'R',1);
$pdf->Cell(22,8,number_format($taxableamt,2),1,0,'R',1);
$pdf->Cell(42,8,'',1,0,'L',1);
$pdf->Cell(36,8,number_format($invoice_amt,2),1,1,'R',1); 
$tot_qty +=$qtymt;
	$tot_amt +=$amount;
	$total +=$invoice_amt;
	$toalgst += $gstAmount;
	$totalroundoff += $roundoff;
	$totcgst += $cgst;
	$totsgcst += $sgst;
	$totigst += $igst;
	}
	
	$slno++;
	}	
	
	

	
$pdf->SetY(155);
$pdf->SetX(5);
$pdf->SetFont('arial','b',11);
		$pdf->Cell(100,5,"Total Amount in Words",0,0,'L');
		
		//for BillNo Name
		$pdf->SetFont('arial','b',11);
		$pdf->Cell(75,5,"      Total Amount Before Tax",1,0,'C');
		$pdf->Cell(25,5,number_format($tot_amt-$gstAmount,2),1,1,'R');




$taxamt=$cmn->getTotalcgst_pur($connection,$saleid);
$igstamt=$cmn->getTotalIgst_pur($connection,$saleid); 

$tot_amt=$total+$toalgst;
$tax=$tot_amt*0.001;
$grand_total=$tot_amt+$tax;
if($gsttype=='CSGST')
{
$pdf->SetX(7);

$pdf->SetFont('arial','',10);
$pdf->MultiCell(100,5,ucfirst(getinwordsbyindia($total)),0,'L');
		//$pdf->Cell(100,7,"Rupees-".ucfirst(convert_number_to_words($total))." ONLY",0,0,'C');
		$pdf->SetY(143);	
$pdf->SetX(105);
		//for BillNo Name
		//$pdf->SetFont('arial','b',11);
		//$pdf->Cell(122,7, 'CGST'.$CGSTper."%:",0,0,'C');
		//$pdf->Cell(-22,7,number_format($toalgst/2,2),0,1,'R');

$pdf->SetY(160);

$pdf->SetX(5);
$pdf->SetFont('arial','b',11);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(175,7,'CGST  @'.$CGSTper."%",1,0,'R',0);
$pdf->Cell(25,7,number_format($toalgst/2,2),'1',1,'R',0);

$pdf->SetX(5);
$pdf->SetFont('arial','b',11);

$pdf->Cell(175,5,'SGST  @'.$CGSTper."%",0,0,'R',0);
$pdf->Cell(25,5,number_format($toalgst/2,2),'1',1,'R',0);

$pdf->SetX(5);
		$pdf->SetFont('arial','b',11);
		$pdf->Cell(29,5," ",0,0,'L');
		$pdf->Cell(71,5,"",0,0,'L');
		//for BillNo Name
		$pdf->SetFont('arial','b',11);
		$pdf->Cell(75,5,"                             Total Tax Amount ",1,0,'C');
		$pdf->Cell(25,5,number_format($gstAmount,2),1,1,'R');

$pdf->SetX(5);
		$pdf->SetFont('arial','b',11);
		$pdf->Cell(100,5,"E- Way Bill No :   ".$ewayno,1,0,'L');
		
		//for BillNo Name
		$pdf->SetFont('arial','b',11);
		$pdf->Cell(75,5,"                      Total Amount after Tax ",1,0,'C');
		$pdf->Cell(25,5,number_format($total,2),1,1,'R');




        $pdf->SetX(5);
		$pdf->SetFont('arial','b',10);
		$pdf->Cell(100,5,"Freight :          ".$frieght_paidby,1,0,'L');
		
		//for BillNo Name
		
		$pdf->SetFont('arial','b',11);
		$pdf->Cell(75,5,"             Total Invoice Amount ",1,0,'C');
		$pdf->Cell(25,5,number_format($total,2),1,1,'R');
		 $pdf->SetX(106);
		$pdf->SetFont('arial','',9);
		$pdf->MultiCell(100,8,'Certified that the particulars given above are true and correct',0,'L');
				
$pdf->SetX(5);
$pdf->SetY(200);
$pdf->SetFont('arial','b',11);
		$pdf->Cell(45,5,"Term for Delivery   ",0,0,'L');
		$pdf->Cell(55,5," Next Day RTGS ",0,0,'L');
	//	for BillNo Name
		$pdf->SetFont('arial','B',12);
		$pdf->Cell(100,7,"for Maa Sharda Enterprises",0,0,'C');
		

$pdf->SetX(5);

		$pdf->SetFont('arial','b',10);
		$pdf->Cell(29,33,"Truck NO  ",0,0,'L');
		$pdf->Cell(71,33,$truck_no,0,0,'L');
		
	//	$pdf->SetFont('arial','b',12);
		//$pdf->Cell(100,24,"for Maa Sharda Enterprises",0,0,'C');
		
		//for BillNo Name
		$pdf->SetX(5);
		$pdf->SetFont('arial','b',10);
		$pdf->Cell(29,43,"Owner Name ",0,0,'L');
		$pdf->Cell(71,43,$own_name,0,0,'L');
		//for BillNo Name
		$pdf->SetX(5);
		$pdf->SetFont('arial','b',10);
		$pdf->Cell(29,53,"Driver Name ",0,0,'L');
		$pdf->Cell(71,53,$drive_name,0,0,'L');
		//for BillNo Name
		$pdf->SetX(5);
		$pdf->SetFont('arial','b',10);
		$pdf->Cell(29,63,"D/L No   ",0,0,'L');
		$pdf->Cell(71,63,$dl_no,0,0,'L');
		//for BillNo Name
		$pdf->SetX(5);
		$pdf->SetFont('arial','b',10);
		$pdf->Cell(29,73,"REMARKS  ",0,0,'L');
		$pdf->Cell(71,73,$frieght_paidby,0,0,'L');
		//for BillNo Name
		


$pdf->SetX(7);
$pdf->SetY(250);
$pdf->SetFont('arial','b',12);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(190,10,'Authorised Signatory',0,0,'R',0);

}
if($gsttype=='IGST')
{
$pdf->SetX(5);
$pdf->SetFont('arial','',11);
$pdf->MultiCell(100,5,ucfirst(getinwordsbyindia($total)),0,'L');

$pdf->SetY(160);	
$pdf->SetX(105);
		//for BillNo Name
		$pdf->SetFont('arial','b',11);
		$pdf->Cell(75,14, '   IGST  @'.$gst."%",1,0,'C');
		$pdf->Cell(25,14,number_format($toalgst,2),1,1,'R');
$pdf->Ln(0);
$pdf->SetY(170);	

$pdf->SetX(5);
$pdf->SetFont('arial','b',11);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(172,4,'',0,0,'R',0);
$pdf->Cell(28,4,'','0',1,'R',0);

$pdf->SetX(5);
		$pdf->SetFont('arial','b',11);
		$pdf->Cell(29,5," ",0,0,'L');
		$pdf->Cell(71,5,"",0,0,'L');
		//for BillNo Name
		$pdf->SetFont('arial','b',11);
		$pdf->Cell(75,5,"                           Total Tax Amount",1,0,'C');
		$pdf->Cell(25,5,number_format($gstAmount,2),1,1,'R');

$pdf->SetX(5);
		$pdf->SetFont('arial','b',11);
		$pdf->Cell(100,7,"E- Way Bill No :".$ewayno,1,0,'L');
		
		//for BillNo Name
		$pdf->SetFont('arial','b',11);
		$pdf->Cell(75,7,"                  Total Amount after Tax  ",1,0,'C');
		$pdf->Cell(25,7,number_format($total,2),1,1,'R');




        $pdf->SetX(5);
		$pdf->SetFont('arial','b',11);
		$pdf->Cell(100,7,"Freight :           ".$frieght_paidby,1,0,'L');
		//$pdf->Cell(60,7,":".$frieght_paidby,0,0,'L');
		//for BillNo Name
		$pdf->SetFont('arial','b',11);
		$pdf->Cell(75,7,"                        Total Invoice Amount Tax",1,0,'C');
		$pdf->Cell(25,7,number_format($total,2),1,1,'R');

	$pdf->SetY(200);
	$pdf->SetX(107);
		$pdf->SetFont('arial','',10);
		$pdf->MultiCell(100,5,"Certified that the particulars given above are true and correct.",0,'L');

		






$pdf->SetX(7);
$pdf->SetY(200);
$pdf->SetFont('arial','b',11);
	$pdf->SetFont('arial','b',11);
		$pdf->Cell(45,5,"Term for Delivery   ",0,0,'L');
		$pdf->Cell(55,5," Next Day RTGS ",0,0,'L');
		//for BillNo Name
		$pdf->SetFont('arial','',8);
		$pdf->Cell(100,5,"",0,0,'C');
		

$pdf->SetX(5);
		$pdf->SetFont('arial','b',10);
		$pdf->Cell(29,33,"Truck NO  ",0,0,'L');
		$pdf->Cell(71,33,"".$truck_no,0,0,'L');
		$pdf->SetFont('arial','b',12);
		$pdf->Cell(100,20,"for Maa Sharda Enterprises",0,0,'C');
		//for BillNo Name
		$pdf->SetX(5);
		$pdf->SetFont('arial','b',10);
		$pdf->Cell(29,43,"Owner Name ",0,0,'L');
		$pdf->Cell(71,43,"".$own_name,0,0,'L');
		//for BillNo Name
		$pdf->SetX(5);
		$pdf->SetFont('arial','b',10);
		$pdf->Cell(29,53,"Driver Name ",0,0,'L');
		$pdf->Cell(71,53,"".$drive_name,0,0,'L');
		//for BillNo Name
		$pdf->SetX(5);
		$pdf->SetFont('arial','b',10);
		$pdf->Cell(29,63,"D/L No   ",0,0,'L');
		$pdf->Cell(71,63,"".$dl_no,0,0,'L');
		//for BillNo Name
		$pdf->SetX(5);
		$pdf->SetFont('arial','b',10);
		$pdf->Cell(29,73,"REMARKS  ",0,0,'L');
		$pdf->Cell(71,73,"".$frieght_paidby,0,0,'L');
		//for BillNo Name
		


$pdf->SetX(7);
$pdf->SetY(250);
$pdf->SetFont('arial','b',12);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(190,10,'Authorised Signatory',0,0,'R',0);


}


$pdf->SetX(5);
$pdf->SetFont('arial','b',11);
$pdf->SetTextColor(0,0,0);

$pdf->Ln(0);	
//$pdf->SetX(5);
//$pdf->SetFont('Arial','',8);
//$pdf->Cell(100,-55,'',0,1,'C',0);
//$pdf->Cell(100,67,"Rupees-".ucfirst(convert_number_to_words($total))." ONLY",0,1,'C',0);
//$pdf->Ln(5);

$pdf->Output();
?> 
                          	
<?php
mysql_close($db_link);

?>
