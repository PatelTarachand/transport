<?php  include("dbconnect.php");
require("../fpdf17/fpdf.php");
$logo = 'bps.png';

if(isset($_GET['bid_id']))
{
	$bid_id = trim(addslashes($_GET['bid_id']));	
}


$companygst = $cmn->getvalfield($connection,"m_company","gst_no","compid='$_SESSION[compid]'");
$pan_card = $cmn->getvalfield($connection,"m_company","pan_card","compid='$_SESSION[compid]'");
$company_gst = $cmn->getvalfield($connection,"m_company","gst_no","compid='$_SESSION[compid]'");

$companyaddrs = $cmn->getvalfield($connection,"m_company","headaddress","compid='$_SESSION[compid]'");
$companymob1 = $cmn->getvalfield($connection,"m_company","mobileno1","compid='$_SESSION[compid]'");
$companymob2 = $cmn->getvalfield($connection,"m_company","mobileno2","compid='$_SESSION[compid]'");
$phoneno = $cmn->getvalfield($connection,"m_company","phoneno","compid='$_SESSION[compid]'");
$companyname = $cmn->getvalfield($connection,"m_company","cname","compid='$_SESSION[compid]'");

if($bid_id !='')
{
	$sql_Q= mysqli_query($connection,"select * from bidding_entry where bid_id='$bid_id'");
	$row=mysqli_fetch_assoc($sql_Q);
	$di_no = $row['di_no'];
    //$tokendate = $cmn->dateformatindia($row['tokendate']);
    $dt = new DateTime($row['tokendate']);	
    $tokendate = $dt->format('d-m-Y');
    $bilty_no = $row['bilty_no'];
	$gr_no = $row['gr_no'];
	$lr_no = $row['lr_no'];
	$bilty_date = $row['bilty_date'];
	$ewayno = $row['ewayno'];
	$dt = new DateTime($bilty_date);	
	$bilty_date = $dt->format('d-m-Y');
		
	//$bilty_date = $cmn->dateformatindia($row['bilty_date']);
	$invoiceno = $row['invoiceno'];
	
	$deliverat = $row['deliverat'];
	$consignorid = $row['consignorid'];
	$consigneeid = $row['consigneeid'];
	$truckid = $row['truckid'];
	$placeid = $row['placeid'];
	$destinationid = $row['destinationid'];	
	$brand_id = $row['brand_id'];
	$noofqty = $row['noofqty'];
	$driver = $row['driver'];
    $biltyremark =$row['biltyremark'];
	$adv_cash = $row['adv_cash'];
	$adv_diesel = $row['adv_diesel'];
	$adv_other = $row['adv_other'];
	$adv_consignor = $row['adv_consignor'];
	$adv_cheque = $row['adv_cheque'];
	$drivermobile = $row['drivermobile'];
	$consigneename = ucwords(strtolower($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$consigneeid'"))); 
	$consigneeaddress = $cmn->getvalfield($connection,"m_consignee","consigneeaddress","consigneeid='$consigneeid'");
	$consigneephoneno = $cmn->getvalfield($connection,"m_consignee","phoneno","consigneeid='$consigneeid'"); 
	 
	$consignorname = $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$consignorid'"); 
	$consignoraddress = $cmn->getvalfield($connection,"m_consignor","address","consignorid='$consignorid'"); 
	$consignorcontactno = $cmn->getvalfield($connection,"m_consignor","contactno","consignorid='$consignorid'"); 
	
	
	$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
	
	$engineno = $cmn->getvalfield($connection,"m_truck","engineno","truckid='$truckid'");	
	$chesisno = $cmn->getvalfield($connection,"m_truck","chesisno","truckid='$truckid'");	
	$typeid = $cmn->getvalfield($connection,"m_truck","typeid","truckid='$truckid'");
	$vehical_type = $cmn->getvalfield($connection,"m_trucktype","noofwheels","typeid='$typeid'");
	
	
	$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");	
	$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
	$owneraddress = $cmn->getvalfield($connection,"m_truckowner","owneraddress","ownerid='$ownerid'");	
	$ownermobileno = $cmn->getvalfield($connection,"m_truckowner","mobileno1","ownerid='$ownerid'");	
	
	$placename = $cmn->getvalfield($connection,"m_place","placename","placeid='$placeid'");
  //echo  $placename;die;
	$destination = ucwords(strtolower($cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'")));
	$brand_name = $cmn->getvalfield($connection,"brand_master","brand_name","brand_id='$brand_id'");
	$totalweight = $row['totalweight'];



    $comp_rate = $row['comp_rate'];
    	$own_rate = $row['own_rate'];
    
    $total_freight=$totalweight*$own_rate;
    $total_balance=$total_freight-$adv_cash - $adv_diesel;

	$itemid = $row['itemid'];
	$itemname = $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");
	
	
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
		global $title1,$di_no,$pan_card,$tokendate,$gr_no,$ewayno,$companyname,$companyaddrs,$companymob1,$companymob2,$company_gst,$lr_no,$phoneno;
		// Rect(float x, float y, float w, float h [, string style])
		$this->Rect(5,8,200,144,'D'); 
		$this->Rect(137,8,68,31,'D'); // sabse upper
		$this->Rect(97,8,40,10,'D'); // sabse upper
        $this->Rect(97,28,40,12,'D');
        $this->Rect(97,18,40,10,'D');
       // $this->Rect(97,28,40,11,'D');
        
        $this->Rect(137,26,68,13,'D');
		
		  //headofficeblock
		$this->Rect(5,40,66,30,'D');  //consignor
		$this->Rect(71,40,66,30,'D');  //consignee
		$this->Rect(137,39,68,40,'D'); //pan no
		
		  
		$this->Rect(137,99,68,22,'D');  //owner address
		
		$this->Rect(5,112,24,9,'D'); 
        $this->Rect(29,112,24,9,'D'); //undertaking
		$this->Rect(53,112,29,9,'D');
        $this->Rect(82,112,55,9,'D');  //own risk
		
		$this->Rect(5,121,132,19,'D');  //driver signature
		  //otwo point
		$this->Rect(137,121,68,19,'D');  //for mahakal
	 
   $this->SetFont('arial','b',16);
//$this->Image('bpslogo.png',80,3,35,16);//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
	
		$this->Ln(5);
		
        $this->setY(17);
		$this->SetX(8);
        $this->SetFont('arial','b',13);       
        $this->Cell(190,0,$companyname,0,1,'L');
        
        $this->setY(24);
        $this->SetX(8);
        $this->SetFont('arial','b',11);		
		$this->Cell(190,0,"Fleet Owner & Transport Contractor",0,1,'L');
	
        
        
           
    
    $this->SetY(28);
	$this->SetX(7);
    $this->SetFont('arial','b',8);
    //$this->Cell(136,0,"$companyaddrs   ",0,1,'L');
	$this->MultiCell(86,5,$companyaddrs,0,'C');
    //$pdf->Cell(190,0,"$companyaddrs Office No : $companymob1, $companymob1",0,1,'L');
    

	    $this->SetY(13);
		$this->SetX(138);
		$this->SetFont('arial','',11);		
		$this->Cell(68,0,"All Subject To Raipur Jurisdiction",0,1,'C');
		
		$this->Ln(5);
		$this->SetX(138);
		$this->SetFont('arial','b',11);
		$this->Cell(68,0,"CONSIGNMENT NOTE /",0,1,'C');
		
		$this->Ln(5);
		$this->SetX(138);
		$this->SetFont('arial','b',11);
		$this->Cell(68,0,"Freight Advice ",0,1,'C');
		
        $this->Ln(5);
        $this->SetY(33);
        $this->SetX(138);
        $this->SetFont('arial','b',11);
        $this->Cell(68,0,"LR No.: $lr_no",0,1,'C',0);
		
		 
        
       
		
		$this->SetY(12);
		$this->SetX(97);
		$this->SetFont('arial','',8);		
		$this->Cell(190,0,"GST No. $company_gst",0,1,'L');
		
		
			$this->SetY(16);
		$this->SetX(97);
		$this->SetFont('arial','',8);		
		$this->Cell(190,0,"PAN No.: $pan_card",0,1,'L');
		
	    $this->SetY(21);
		$this->SetX(97);
		$this->SetFont('arial','',9);		
		$this->Cell(10,0,"Contact No.:",0,1,'L');
		
		$this->SetY(25);
		$this->SetX(96.5);
		$this->SetFont('arial','',9);		
		$this->Cell(190,0,$phoneno.",".$companymob2,0,1,'L');
		
		$this->SetY(31);
		$this->SetX(97);
		$this->SetFont('arial','',9);		
		$this->Cell(10,0,"Mobile No.: ",0,1,'L');
		
		$this->SetY(35);
		$this->SetX(97);
		$this->SetFont('arial','',9);		
		$this->Cell(190,0,$companymob1,0,1,'L');
		
	
		
		$this->Ln(-2);
		
		
	}
	  // Page footer
	function Footer()
	{
	    global $title1,$di_no,$pan_card,$tokendate,$gr_no,$ewayno,$companyname;
		$this->SetY(-18);
	$this->SetX(7);
	$this->SetFont('arial','b',8);
	$this->SetTextColor(0,0,0);
	$this->Cell(130,5,"Receiver Signature",0,0,'C',0);
	$this->SetY(123);
    $this->SetX(139);
	$this->Cell(138,5,"FOR,".$companyname,0,0,'L',0);
	
	$this->SetY(-8);
	// Arial italic 8
	$this->SetFont('Arial','I',8); 
	$this->SetTextColor(0,0,0);	
	// Page number
	$this->SetX(25);
	$this->Cell(150,5,'|| Developed By Chaaruvi Infotech  Contact No :  +91-8871181890 ||',0,0,'C');
	 
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
$title1 = "Bilty INVOICE";
$pdf->SetTitle($title1);


//$pdf->SetTitle($title2);
$pdf->AliasNbPages();
$pdf->AddPage('L','A5');


	$pdf->Ln(10);
	
   
	
	$pdf->Ln(4);	
	$pdf->SetX(7);
	$pdf->SetFont('arial','',11);
	$pdf->Cell(190,0," ",0,1,'L');
	
	$pdf->Ln(11);	
	$pdf->SetY(43);
    $pdf->SetX(7);
	$pdf->SetFont('arial','b',11);
	$pdf->Cell(190,0,"Consignor :",0,1,'L');
	$pdf->Ln(2);	
	$pdf->SetFont('Arial','',9);
	$pdf->SetX(10);
	$pdf->MultiCell(65,4,"$consignorname \n$consignoraddress\nFrom Place :-$placename\n$consignorcontactno",0,'L');
	
  
	$pdf->SetY(43);
	$pdf->SetX(72);
	$pdf->SetFont('arial','b',11);
	$pdf->Cell(190,0,"Consignee :",0,1,'L');	
	$pdf->Ln(2);	
	$pdf->SetFont('Arial','',9);
	$pdf->SetX(75);
	$pdf->MultiCell(65,4,"$consigneename \n$consigneeaddress \nShip to city :- $destination\n$consigneephoneno ",0,'L');
	
	$pdf->SetY(39);
	$pdf->SetX(137);
	$pdf->SetFont('arial','',11);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(68,5,"Eway Bill No.: $ewayno",1,1,'L',0);
	
	//$pdf->SetX(137);
	//$pdf->SetFont('arial','',11);
	//$pdf->SetTextColor(0,0,0);
	//$pdf->Cell(68,5,"Eway Bill Date : $bilty_date",1,1,'L',0);
 //   $pdf->Cell(66,5,"Excise Invoice No : $invoiceno",1,1,'L',0);
	
    $pdf->SetY(44);
	$pdf->SetX(137);
	$pdf->SetFont('arial','',11);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(68,5,"Bilty No            : $bilty_no ",1,0,'L',0);
	
    $pdf->SetY(49);
    $pdf->SetX(137);
    $pdf->SetFont('arial','',11);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(68,5,"Bilty Date         : $bilty_date",1,0,'L',0);

    $pdf->SetY(54);
    $pdf->SetX(137);
    $pdf->SetFont('arial','',11);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(68,5,"Inv.No      : $invoiceno",1,0,'L',0);

    // $pdf->SetY(64);
    // $pdf->SetX(137);
    // $pdf->SetFont('arial','',11);
    // $pdf->SetTextColor(0,0,0);
    // $pdf->Cell(68,5,"Ex.Inv. Date      : $bilty_date",1,0,'L',0);

    $pdf->SetY(59);
    $pdf->SetX(137);
    $pdf->SetFont('arial','',11);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(68,5,"Vehicle No.   : $truckno",1,0,'L',0);

    $pdf->SetY(64);
    $pdf->SetX(137);
    $pdf->SetFont('arial','',11);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(68,5,"Vehicle Type : ".$vehical_type,1,0,'L',0);



    
    $pdf->SetY(69);
	$pdf->SetX(137);
	$pdf->SetFont('arial','',11);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(68,5,"Driver's Name : ".ucwords($driver),1,1,'L',0);
	
    $pdf->SetY(74);
	$pdf->SetX(137);
	$pdf->SetFont('arial','',11);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(68,5,"Driver Mobile No. : $drivermobile",1,1,'L',0);

    $pdf->SetY(79);
    $pdf->SetX(137);
    $pdf->SetFont('arial','',11);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(68,5,"Licence No.     : ",1,1,'L',0);
	
    $pdf->SetY(84);
	$pdf->SetX(137);
	$pdf->SetFont('arial','',11);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(68,5,"Engine No.      : $engineno",1,1,'L',0);
	
    $pdf->SetY(89);
	$pdf->SetX(137);
	$pdf->SetFont('arial','',11);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(68,5,"Chasis No.      : $chesisno",1,1,'L',0);

    $pdf->SetY(94);
    $pdf->SetX(137);
    $pdf->SetFont('arial','',11);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(68,5,"E-Way No.      : $ewayno",1,1,'L',0);
	
	
	
	$pdf->SetY(70);
	$pdf->SetX(5);
	$pdf->SetFont('Arial','B',9);
	//$pdf->SetFillColor(0,0,0); //gray
	//$pdf->SetTextColor(255,255,255);
	$pdf->Cell(30,4,'Item',1,0,'L',0);
	$pdf->Cell(24,4,'Weight(bags)','1',0,'C',0); 
	$pdf->Cell(20,4,'Weight(MT)',1,0,'L',0);
	$pdf->Cell(33,4,'OWN Rate',1,0,'C',0);
	$pdf->Cell(25,4,'Freight Amt',1,1,'C',0);
	$pdf->SetFont('Arial','',6);
	
	$pdf->SetX(5);
	$pdf->SetFont('arial','',11);	
	$pdf->Cell(30,5,$itemname,1,0,'L',0);
	$pdf->Cell(24,5,$noofqty,1,0,'C',0);
	$pdf->Cell(20,5,$totalweight.' MT',1,0,'C',0);
	$pdf->Cell(33,5,$own_rate." / MT",1,0,'R',0);
	$pdf->Cell(25,5,$total_freight,1,1,'R',0);
	
	
    $pdf->SetY(82);
	 $pdf->SetX(5);
	$pdf->SetFont('arial','',8);
	$pdf->Cell(12,4,"Remark :",0,0,'L');
    $pdf->MultiCell(30,4,$biltyremark,0,'L');	

	$pdf->SetY(99);
	$pdf->SetX(137);
	$pdf->SetFont('arial','',11);
	$pdf->Cell(68,6,"Truck Owner Details ",1,1,'L');	
	
    $pdf->SetY(105);
	$pdf->SetFont('Arial','',10);
	$pdf->SetX(136);
	$pdf->Cell(68,5," $ownername ",0,1,'L');
    $pdf->SetX(137);
    $pdf->Cell(68,5,"Mob.:  $ownermobileno ",0,1,'L');
    $pdf->SetX(137);
    $pdf->Cell(68,5,"Add.: $owneraddress",0,1,'L');

  
	
	$pdf->SetY(79);
	$pdf->SetX(59);
	$pdf->SetFont('arial','b',9);
	$pdf->SetTextColor(0,0,0);
	
	$pdf->Cell(38,5," Cash Advance ",1,0,'L',0);
	$pdf->Cell(15,5,'',1,1,'R',0);
	$pdf->SetY(79);
	$pdf->SetX(112);
	$pdf->Cell(25,5,number_format($adv_cash,2),1,1,'R',0);
	
	$pdf->SetX(59);
	$pdf->SetFont('arial','b',9);
	$pdf->SetTextColor(0,0,0);
	 
	$pdf->Cell(38,6,"Diesel Advance ",1,0,'L',0);
	$pdf->Cell(15,6,'',1,1,'R',0);
	$pdf->SetY(84);
	$pdf->SetX(112);
	$pdf->Cell(25,6,number_format($adv_diesel,2),1,1,'R',0);
	
	$pdf->SetX(59);
	$pdf->SetFont('arial','b',9);
	$pdf->SetTextColor(0,0,0);
	
	$pdf->Cell(38,6,"Total Advance ",1,0,'L',0);
	$pdf->Cell(15,6,'',1,1,'R',0);
	$pdf->SetY(90);
	$pdf->SetX(112);
	$pdf->Cell(25,6,number_format($adv_cash + $adv_diesel,2),1,1,'R',0);
	
	$pdf->SetY(96);
	$pdf->SetX(59);
	$pdf->Cell(38,8,"BALANCE TOTAL",1,0,'L',0);
	$pdf->Cell(15,8,'',1,1,'R',0);
	$pdf->SetY(96);
	$pdf->SetX(112);
	$pdf->Cell(25,8,number_format($total_balance,2),1,1,'R',0);
	
	if($itemname=='Rice'){
	$pdf->SetY(104);
	$pdf->SetX(5);
    $pdf->SetFont('arial','',8);   
 $pdf->MultiCell(132,4,'GST TAX WILL BE PAID BY 
				 CONSIGNOR [__] CONSIGNEE [__] ',1,'C'); 
	}
	else{
	
	$pdf->SetY(104);
	$pdf->SetX(5);
    $pdf->SetFont('arial','',7.5);   
  $pdf->MultiCell(132,4,'"UNDERTAKING : By virtue of section 9(3) of CGST Act 2017, The Goods Transport service provided by transporter falls under Reverse Charge Mechanism and 100% GST payable by recipient"',1,'L'); 
	}
	$pdf->Ln(4);
    $pdf->SetY(114);
    $pdf->SetX(5);
    $pdf->SetFont('arial','b',10);
    $pdf->SetTextColor(0,0,0);
    
	$pdf->Cell(36,6,"CONSIGNOR",0,0,'L',0);

    $pdf->SetY(114);
    $pdf->SetX(29);
    $pdf->SetFont('arial','b',10);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(36,6,"CONSIGNEE",0,0,'L',0);

    $pdf->SetY(114);
    $pdf->SetX(53);
    $pdf->SetFont('arial','b',10);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(36,6,"TRANSPORTER",0,0,'L',0);


	$pdf->SetY(114);
	$pdf->SetX(90);
	$pdf->SetFont('arial','b',10);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(38,6,"GOODS TRANSPORT AGENCY",0,0,'C',0);
	
	
	
 $pdf->SetFont('arial','b',9);
//$pdf->Image('termcondition.png',3,124,200,15);//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])


$pdf->Output();
?> 
                          	
<?php
mysqli_close($connection);



?>
