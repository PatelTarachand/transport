<?php
error_reporting(0);
include("dbconnect.php");
include("../fpdf17/fpdf.php");
$tblname="m_payment";
$tblpkey = "payment_id";
$module = "Masters";
$keyvalue="";

$caddress= $cmn->getvalfield($connection,"m_company","caddress","compid='$compid'"); 
$cname= $cmn->getvalfield($connection,"m_company","cname","compid='$compid'");
$account_no= $cmn->getvalfield($connection,"m_company","account_no","compid='$compid'");
$account_holder= $cmn->getvalfield($connection,"m_company","account_holder","compid='$compid'");

$bank_name= $cmn->getvalfield($connection,"m_company","bank_name","compid='$compid'");
$branch= $cmn->getvalfield($connection,"m_company","branch","compid='$compid'");
$ifsc_code= $cmn->getvalfield($connection,"m_company","ifsc_code","compid='$compid'");

$billid = addslashes(trim($_GET['p']));
$fromdate = $cmn->dateformatindia($cmn->getvalfield($connection,"bidding_entry as A left join bill_details as B on A.bid_id=B.bid_id","min(inv_date)","A.invoiceid='$billid'"));
$todate = $cmn->dateformatindia($cmn->getvalfield($connection,"bidding_entry as A left join bill_details as B on A.bid_id=B.bid_id","max(inv_date)","A.invoiceid='$billid'")); 


$sql = mysqli_query($connection,"select * from bill where billid = '$billid'");
if($sql)
{
    while($row = mysqli_fetch_assoc($sql))
    {
        $consignorid = $row['consignorid'];
        $billno= $row['billno'];
        $billdate= $cmn->dateformatdb($row['billdate']);
        $taxable_percent= $row['taxable_percent']; 
        $serv_tax_percent = $row['serv_tax_percent'];
        $ecess_percent= $row['ecess_percent'];
        $hcess_percent= $row['hcess_percent'];
        $safai_percent= $row['safai_percent'];
        $krishi_cess = $row['krishi_cess'];
        //$addlist = $row['addlist'];
        $cgst_percent = $row['cgst_percent']; 
        $sgst_percent = $row['sgst_percent'];
        $consigneeid = $row['consigneeid'];
        
         $consi_type = $row['consi_type'];
           $receive_date = $cmn->getvalfield($connection,"consignee_payment","receive_date","billid='$billid'");
    
        //find sortagr
        $sortagr = 0;
        $sql_bill = mysqli_query($connection,"select bid_id from bill_details where billid = '$billid' ");
        if($sql_bill)
        {
            while($row_bill = mysqli_fetch_assoc($sql_bill))
            {
                $sortagr += $cmn->getvalfield($connection,"bidding_entry","sum(sortagr)","bid_id = '$row_bill[bid_id]' ");
            }
        }
        //echo $sortagr;die;
        if($sortagr != '0')
        $sortagr_text = " ";
        else 
        $sortagr_text = " ";
    }
    // $compid  = $cmn->getvalfield($connection,"m_company","compid","1=1");
      $cname = $cmn->getvalfield($connection,"m_company","cname","compid = '$compid'");
     $caddress = $cmn->getvalfield($connection,"m_company","headaddress","compid = '$compid'");
     $phoneno = $cmn->getvalfield($connection,"m_company","phoneno","compid = '$compid'");
     $mobileno1 = $cmn->getvalfield($connection,"m_company","mobileno1","compid = '$compid'");
     $comp_pan_card = $cmn->getvalfield($connection,"m_company","pan_card","compid = '$compid'");
     $comp_gst_no   = $cmn->getvalfield($connection,"m_company","gst_no","compid = '$compid'");
      $comp_sac_code   = $cmn->getvalfield($connection,"m_company","saaccode","compid = '$compid'");
    
        if($consi_type=='Consignor'){ 
     $consignorname = $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid = '$consignorid'");
    $consignoraddress = $cmn->getvalfield($connection,"m_consignor","address","consignorid = '$consignorid'");
	   $consignormobile = $cmn->getvalfield($connection,"m_consignor","contactno","consignorid = '$consignorid'");
        }else{
          $consignorname = $cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$consigneeid'"); 
	$consignoraddress = $cmn->getvalfield($connection,"m_consignee","consigneeaddress","consigneeid='$consigneeid'");
	$consignormobile = $cmn->getvalfield($connection,"m_consignee","phoneno","consigneeid='$consigneeid'");  
        }
     
     $placeid = $cmn->getvalfield($connection,"m_consignor","placeid","consignorid = '$consignorid'"); 
     $placename = $cmn->getvalfield($connection,"m_place","placename","placeid = '$placeid'");
    $stateid = $cmn->getvalfield($connection,"m_consignor","stateid","consignorid = '$consignorid'"); 
    $state_code = $cmn->getvalfield($connection,"m_state","statecode","stateid = '$stateid'");
    
     
    
    
    $cong_gstin = $cmn->getvalfield($connection,"m_consignor","cong_gstin","consignorid = '$consignorid'");
    $districtid = '';
    $distname =''; 
    $hsn_no  = '';

}
$c_logo = $cmn->getvalfield($connection,"m_company","c_logo","compid='$_SESSION[compid]'");
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
	   
	   	if($receive_date!=''){
		$this->SetFont('Arial','B',80);
		$this->SetTextColor(255,192,203);
		$this->RotatedText(100,150,'PAID',45);
		$this->SetFont('Arial','B',18);
		$this->RotatedText(110,150,$receive_date,45);
		}
	
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
$pdf->SetTitle("Bill Voucher");
$pdf->AliasNbPages();
$pdf->AddPage('L','A4');
$pdf->SetX(5);
//$pdf->MultiCell(80,5,"Customer Copy",0,'L');


//$pdf->SetX(13);


	
    $pdf->SetFont('courier','b',9);
	$pdf->Rect(5,5, 287, 200, 'D'); //For A4	
	$pdf->SetFont('courier','b',9);

	//$this->Rect(3,116, 204, 14, 'D'); //For A4  
	//$this->Rect(3,130, 204, 14, 'D'); //For A4 
	
	
	  
	  
	$pdf->Ln(3);
	$pdf->setY(14);
		$pdf->SetX(8);
		$pdf->SetFont('arial','b',16);		
	  $pdf->Image('logo/'.$c_logo,10,5,20);
	
	 $pdf->setY(12);
	 $pdf->SetX(35);
		$pdf->SetFont('Arial','UB',18);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(280,4,$cname,'0',1,'L',0);
	$pdf->Ln(6);
	$pdf->SetFont('Arial','B',6);
		$pdf->Cell(880,4,"_______________________________________________________________________________________________________________________________________________________________________________________________________________________________________",'0',1,'L',0);
	$pdf->setY(18);
	 $pdf->SetX(35);
		$pdf->SetFont('Arial','UB',9);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(280,4,$caddress,'0',1,'L',0);
	$pdf->Ln(6);
	
  
		
	$pdf->SetFont('Arial','ub',12);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(280,4,"BILL ",'0',1,'C',0);


	
	 $pdf->setY(32);
 
	
	$pdf->SetFont('Arial','b',10);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(280,4,"TO,",'0',1,'L',0);
	$pdf->Ln(1);
	
	
	
	$pdf->SetFont('Arial','b',11);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(90,4,$consignorname,'0',1,'L',0);

	
	$pdf->SetFont('Arial','B',11);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(90,4,'Mobile No.'.$consignormobile,'0',1,'L',0);

	
	//$this->setY(40);
	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(0,0,0);
	$pdf->MultiCell(160,5,$consignoraddress,0,'L');
	//$this->Cell(90,4,"",'0',1,'L',0);
	
	
	
		$pdf->Ln(1);
	  
	/*//$this->setY(40);
	$pdf->SetFont('Arial','b',10);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(90,4," PAN No- ".$comp_pan_card,'0',1,'L',0);
	$pdf->Ln(1);
	$pdf->SetFont('Arial','b',10);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(150,4,"",'0',1,'L',0);*/
	
	
	 $pdf->setY(34);
	 
	/*$pdf->setX(200);
	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(40,4,"BILL TYPE          :",'0',0,'L',0);
	$pdf->Cell(80,4,"SALE/SDF",'0',1,'L',0);*/
	
	
	 $pdf->Ln(1);
	$pdf->setX(200);
	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(40,4,"Bill NO                 :",'0',0,'L',0);
	$pdf->Cell(80,4,"$billno",'0',1,'L',0);
	$pdf->Ln(1);
		$pdf->setX(200);
	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(40,4,"BILL DATE          :",'0',0,'L',0);
	$pdf->Cell(80,4,"$billdate",'0',1,'L',0);
	$pdf->Ln(1);
		$pdf->setX(200);
	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(40,4,"PAN NO              :",'0',0,'L',0);
	$pdf->Cell(80,4,"$comp_pan_card",'0',1,'L',0);
	$pdf->Ln(1);
		$pdf->setX(200);
	/*$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(40,4,"GST NO              :",'0',0,'L',0);
	$pdf->Cell(80,4,"$comp_gst_no",'0',1,'L',0);
	$pdf->Ln(1);
		$pdf->setX(200);
	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(40,4,"SAC CODE         :",'0',0,'L',0);
	$pdf->Cell(80,4,"$comp_sac_code",'0',1,'L',0);*/
	
	$pdf->Ln(10);
	
	
	$pdf->SetFont('Arial','',9);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(170,4,"",'0',1,'L',0);
	$pdf->Ln(1);
	 
	$pdf->SetX(5);
	$pdf->SetFont('Arial','B',9);
	$pdf->SetFillColor(255,255,255); //gray
	//$this->SetTextColor(255,255,255);
	$pdf->Cell(8,6,'Sn','1',0,'L',1); 
	 $pdf->Cell(20,6,'LR NO',1,0,'L',1);
	  $pdf->Cell(20,6,'DATE',1,0,'L',1);
	  $pdf->Cell(25,6,'BILTY NO','1',0,'L',1);
	  $pdf->Cell(25,6,'TRUCK NO',1,0,'L',1);	
	  $pdf->Cell(28,6,'FROM PLACE',1,0,'L',1);
	  $pdf->Cell(27,6,'TO PLACE',1,0,'L',1);
	  $pdf->Cell(25,6,'WEIGHT',1,0,'L',1);
	  $pdf->Cell(25,6,'RATE',1,0,'L',1);
    $pdf->Cell(25,6,'FREIGHT AMT',1,0,'L',1);
	 $pdf->Cell(18,6,'ADVANCE',1,0,'L',1);
   $pdf->Cell(16,6,'U/L',1,0,'C',1);
	$pdf->Cell(25,6,'NET AMOUNT',1,0,'C',1);
   
	
	
 	$pdf->Ln(1);
	$pdf->SetX(5);
	$pdf->SetY(71);
	$pdf->SetFont('Arial','B',9);
 
	
	$pdf->SetWidths(array(8,20,20,25,25,28,27,25,25,25,18,16,25));
	$pdf->SetAligns(array("C","L","L","L","L","L","L","R","R","R","R","R","R","R","R","R"));
	$pdf->SetX(5);	
	$pdf->SetFont('Arial','B',9);

if($billid != 0)
{
$sn=1;

 $sel = "select *,DATE_FORMAT(tokendate,'%Y-%m-%d') as tokendate from  bill_details left join bidding_entry on bidding_entry.bid_id = bill_details.bid_id  where bidding_entry.invoiceid = '$billid' order by bidding_entry.di_no";
$res = mysqli_query($connection,$sel);
$billtylist = "";

$tot_wt = 0;
$tot_fr_amt=0;
$tot_cgstamt=0;
$tot_sgstamt =0;
$tot_netamt=0;
$tot_ulamt =0; 
$tot_adv_consignor =0;
$tot_total=0;
$tot_rate =0;

    while($row = mysqli_fetch_array($res))
    {
        $ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid = '$row[truckid]'");
        $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid = '$row[truckid]'");
        $ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid = '$ownerid'");
        $billtydate = $row['tokendate'];
        $rate = $row['comp_rate'];
        $ulamt = $row['ulamt'];
        $pur_no = '';
        $hsn_no =  $cmn->getvalfield($connection,"inv_m_item","hsncode","itemid = '$row[itemid]'");
        $destination = $cmn->getvalfield($connection,"m_place","placename","placeid = '$row[destinationid]'");
		$fromplace = $cmn->getvalfield($connection,"m_place","placename","placeid = '$row[placeid]'");
        
        
        $recweight = $row['recweight'];
        $totalweight   = $row['totalweight'];
        $di_no = $row['di_no'];
        $gr_no = $row['gr_no'];
         $lr_no = $row['lr_no'];
        $bilty_no   = $row['bilty_no'];
		$inv_date = $cmn->dateformatindia($row['inv_date']);
        $ewayno = $row['ewayno'];
        $shortagetype = $row['shortagetype'];
		
		$paytype = $row['paytype'];
		//if($paytype=='Consignor'){
			$adv_consignor = $row['adv_consignor'];
		//}else{
		//	$adv_consignor = 0;
		//}
        
         if($totalweight <= $recweight) 
         $total = ($rate * $recweight);
         else
         $total =  ($rate * $recweight);
		
		if($totalweight <= $recweight) { 
		$qty = $totalweight; 
		$shortagetype = '';
		}
		else
		{
		$qty = $totalweight;
		$shortagetype = $row['shortagetype'];
		}
          
         $cgstamt = $cgst_percent *  $total /100;
         $sgstamt = $sgst_percent *  $total /100;
            
         $net =     $total + $cgstamt + $sgstamt + $ulamt-$adv_consignor;
      
      

	$pdf->SetX(5);	
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(0,0,0);

	
	$pdf->Row(array($sn++,$lr_no,$cmn->dateformatindia($billtydate),$bilty_no,$truckno,$fromplace,$destination,$recweight,$rate,$total,$adv_consignor,number_format($ulamt,2),$net));
	
	
	if($pdf->getY()>=160) {
	    $pdf->AddPage('L','A4');
        $pdf->SetX(5);
	    
	}
	

	
$tot_wt += $totalweight;   
$tot_fr_amt += $net;  
$tot_cgstamt += $cgstamt;   
$tot_sgstamt += $sgstamt;   
     
$tot_netamt += $net;   

$tot_ulamt += $ulamt; 
$tot_adv_consignor += $adv_consignor;
$tot_total += $total;
$tot_rate += $rate;
}
}

	$pdf->setX(5);
	$pdf->SetFont('Arial','b',8);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(153,4,"",'1',0,'R',0);
	$pdf->Cell(25,4,number_format($tot_wt,2),'1',0,'R',0);
	$pdf->Cell(25,4,"",'1',0,'R',0);
	$pdf->Cell(25,4,number_format(round($tot_total),2),'1',0,'R',0);
	$pdf->Cell(18,4,number_format(round($tot_adv_consignor),2),'1',0,'R',0);
	$pdf->Cell(16,4,number_format(round($tot_ulamt),2),'1',0,'R',0);
	$pdf->Cell(25,4,number_format(round($tot_fr_amt),2),'1',0,'R',0);
	
	
	
	$pdf->Ln(4);
	$pdf->setX(5);
	$pdf->SetFont('Arial','b',8);
	$pdf->SetTextColor(0,0,0);
	 
	$pdf->Cell(153,4,' ',1,0,'L',0);
	

	
	$pdf->setX(5);
	$pdf->SetFont('Arial','b',8);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(287,4,'In Words : '.ucwords(convert_number(round($tot_fr_amt)))." only",'1',1,'L',0); 
	
 // $height = $pdf->getX();
	$pdf->setY(-35);
	
	
	
	
	
	$pdf->setY(-41);
	
	// //$pdf->Rect(10,174,135, 16, 'D'); //For A4
	// $pdf->setX(5);
	// $pdf->SetFont('Arial','',10);
	// $pdf->SetTextColor(0,0,0);
	// $pdf->Cell(200);
	// $pdf->Cell(87,4," For:".$cname,'0',0,'C',0); 
	
	// $pdf->Ln(6);  
	// $pdf->setX(5);
	// $pdf->SetFont('Arial','',10);
	// $pdf->SetTextColor(0,0,0);
	// $pdf->Cell(200);
	// $pdf->Cell(87,4," Authorised Signatory",'0',0,'C',0); 
	
    $pdf->Cell(140,2,' ',0,0,'L',0);
	

	
	$pdf->setX(10);
	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(287,4,'Account No : '.$account_no,'0',1,'L',0); 
	$pdf->Cell(287,4,'Account Holder : '.$account_holder,'0',1,'L',0); 

	$pdf->Cell(287,4,'Bank Name  : '.$bank_name,'0',1,'L',0); 
    $pdf->Cell(287,4,'Branch : '.$branch,'0',1,'L',0); 
    $pdf->Cell(287,4,'IFSC Code : '.$ifsc_code,'0',1,'L',0); 
    
 // $height = $pdf->getX();
	$pdf->setY(-35);
	
	
	
	
	
	$pdf->setY(-35);
	
	//$pdf->Rect(10,174,135, 16, 'D'); //For A4
	$pdf->setX(5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(200);
	$pdf->Cell(87,4," For:".$cname,'0',0,'C',0); 
	
	$pdf->Ln(6);  
	$pdf->setX(5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(200);
	$pdf->Cell(87,4," Authorised Signatory",'0',0,'C',0); 
	
  $pdf->Output();	
?>
