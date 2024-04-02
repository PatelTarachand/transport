<?php
/*call the FPDF library*/
error_reporting(0);
include("../dbinfo.php");

include("../lib/getval.php");
include("../lib/dboperation.php");
$cmn = new Comman();

include("../fpdf17/rotation.php");
if(isset($_REQUEST['action']))
  $action = $_REQUEST['action'];
  else
  $action = 0;  
  
  $cond=' ';
  
  
  
  if(isset($_GET['di_no']))
  {
    $di_no = trim(addslashes($_GET['di_no']));  
  }
  else
  $di_no = '';
  
  if(isset($_GET['ownerid']))
  {
    $ownerid = trim(addslashes($_GET['ownerid']));  
  }
  else
   $ownerid = '';
  


  
  $cond= " where 1=1";
  // if($from !='1970-01-01' && $todate !='1970-01-01') {
    
  //   $cond .=" and  B.tokendate BETWEEN '$from' and '$todate'";
    
  //   }
    if($ownerid !='') {
    
    $cond .=" and A.ownerid='$ownerid'";
    }
     $bulk_voucher_id=$_GET['bulk_voucher_id'];

    if($bulk_voucher_id !='') {
    
    $cond .=" and B.voucher_id='$bulk_voucher_id'";
    }
    
    $vocharid=$_GET['voucharno'];
    $compid=$_GET['compid'];
    $sessionid=$_GET['sessionid'];



$c_logo = $cmn->getvalfield($connection,"m_company","c_logo","compid='$compid'");


  $receive_date = dateformatindia($cmn->getvalfield($connection,"bilty_payment_voucher","receive_date","voucher_id='$bulk_voucher_id' && sessionid='$sessionid' && ownerid='$ownerid'"));

  $sql = mysqli_query($connection,"select * from m_truckowner where ownerid='$ownerid'");
	$row=mysqli_fetch_assoc($sql);		
	
	$ownername = $row['ownername'];
	$ac_number = $row['ac_number'];
	$ifsc_code = $row['ifsc_code'];
	$bank_name = $row['bank_name'];
	$branch_name = $row['branch_name'];
	// $chequeno = $row['chequeno'];
	// $bankid = $row['bankid'];
	// $paymentdate = $cmn->dateformatindia($row['paymentdate']);
	// $narration = $row['narration'];
	// $bankname = $cmn->getvalfield($connection,"m_bank","bankname","bankid='$bankid'");
	// $headname = $cmn->getvalfield($connection,"other_income_expense","headname","head_id='$row[head_id]'");

    
    $voucher_amount= showBiltyVoucher($connection,$compid,$bulk_voucher_id,$sessionid);	
    $payamount = $cmn->getvalfield($connection,"bilty_payment_voucher","sum(payamount)","ownerid='$ownerid' && voucher_id='$bulk_voucher_id' && sessionid='$sessionid'");

   // $bal_amt=floatval($voucher_amount)-floatval($payamount);
      $bal_amt = bcsub($voucher_amount, $payamount);
	

                                    //   if($bal_amt < 0){
                                       //  $bal_amt=0;  
                                      // }
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


class PDF extends PDF_Rotate
{
	var $widths;

  var $aligns;
	function Header()
	{
		 global $adv_date,$bal_amt,$receive_date;
		/* Put the watermark */
		
		if($bal_amt=='0'){
		$this->SetFont('Arial','B',80);
		$this->SetTextColor(255,192,203);
		$this->RotatedText(100,150,'PAID',45);
		$this->SetFont('Arial','B',18);
		$this->RotatedText(110,150,$receive_date,45);
		}
       if($receive_date!='' && $bal_amt > 0){
            $this->SetFont('Arial','B',80);
            $this->SetTextColor(255,192,203);
            $this->RotatedText(100,150,'Pending',45);
            $this->SetFont('Arial','B',18);
            //$this->RotatedText(110,150,$receive_date,45); 
        }

	}
	
	function Footer()

	{ 

	 global $deduct,$ac_number,$ifsc_code,$branch_name,$bank_name ;

	 $this->SetY(-30);
if($ac_number!=''){

                                                      $this->SetFont('Arial','b',10);
                                                      $this->SetTextColor(0,0,0);
                                                      $this->Cell(24,10,'A/C Number :' ,0,0,'L',0);
                                                      $this->SetFont('Arial','',10);
                                                      $this->Cell(10,10,$ac_number,0,0,'L',0);

                                                      $this->Ln(5);

                                                      $this->SetFont('Arial','b',10);
                                                      $this->SetTextColor(0,0,0);
                                                      $this->Cell(22,10,'IFSC Code :' ,0,0,'L',0);
                                                      $this->SetFont('Arial','',10);
                                                      $this->Cell(10,10,$ifsc_code,0,0,'L',0);

                                                      $this->Ln(5);

                                                      $this->SetFont('Arial','b',10);
                                                      $this->SetTextColor(0,0,0);
                                                      $this->Cell(23,10,'Bank Name :' ,0,0,'L',0);
                                                      $this->SetFont('Arial','',10);
                                                      $this->Cell(10,10,$bank_name,0,0,'L',0);

                                                      $this->Ln(5);

                                                      $this->SetFont('Arial','b',10);
                                                      $this->SetTextColor(0,0,0);
                                                      $this->Cell(26,10,'Branch Name :' ,0,0,'L',0);
                                                      $this->SetFont('Arial','',10);
                                                      $this->Cell(10,10,$branch_name,0,0,'L',0);
}

     }
	

	function RotatedText($x, $y, $txt, $angle)
	{
		/* Text rotated around its origin */
		$this->Rotate($angle,$x,$y);
		$this->Text($x,$y,$txt);
		$this->Rotate(0);
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

	
$pdf=new PDF('L','mm','A4');
$pdf->AddPage();
/*output the result*/
$pdf->SetY(10);

 $pdf->SetX(20);
 
                                       
                                          
                                            $company_owner = "SELECT * FROM `m_company` where compid='$compid' ";

                                    $cmp_owm = mysqli_query($connection,$company_owner);
                               while($onwer = mysqli_fetch_assoc($cmp_owm)){
    
                                       $pdf->Image('logo/'.$c_logo,10,5,20);
                                                    
                                        $pdf->SetX(30);
                                         $pdf->SetFont('Arial','',24);
                                        $pdf->Cell(150,8,$onwer['cname'],2,0,'L');
                                        
                                         $pdf->SetX(130);
                                         $pdf->SetFont('Arial','',24);
                                        $pdf->Cell(150,8,'',2,0,'L');
                                        
                                        $pdf->Ln();

                                        $pdf->SetX(28);
                                         $pdf->SetFont('Arial','',10);
                                        $pdf->Cell(270,6,$onwer['headaddress'],2,0,'L');
                                        $pdf->Ln();

                                            
                                         $pdf->SetFont('Arial','',10);
                                       $pdf->Cell(150,5,'',2,0,'L');
                                        $pdf->SetFont('Arial','',10);
                                       $pdf->Cell(125,-20,'Contact : '.$onwer['mobileno1'].",".$onwer['mobileno2'],2,0,'R');
                                         
                                               

                                        $pdf->SetFont('Arial','',10);
                                       $pdf->Cell(150,5,'',2,0,'L');
                                        $pdf->SetFont('Arial','',10);
                                        $pdf->Cell(125,-10,'GST No. : '.$onwer['gst_no'],2,0,'R');
                                        $pdf->Ln();

                                         
                                                                               

                                        $pdf->SetFont('Arial','',10);

                                       $pdf->Cell(150,10,'',2,0,'R');

                                        $pdf->SetFont('Arial','',10);
                                        $pdf->Cell(125,8,'PAN No. : '.$onwer['pan_card'],2,0,'R');
                                        $pdf->Ln();


                                         $pdf->SetFont('Arial','',10);

                                       $pdf->Cell(150,10,'',2,0,'R');

                                        $pdf->SetFont('Arial','',10);
                                        $pdf->Cell(125,2,'GST No. : '.$onwer['gst_no'],2,0,'R');
                                        $pdf->Ln();

                                           }

                                           $lh = 100;
                                            $lw= $lh+8;

                                            $pdf->Line(5, 30, 290,30);
                                             $pdf->Ln(8);

                                              $pdf->SetFont('Arial','',10);

                                       $pdf->Cell(5,10,'',2,0,'L');
                                         $pdf->SetFont('Arial','B',12);


                                         $OWNIID= $_GET['ownerid'];
                  $OWN="SELECT * FROM `m_truckowner` WHERE `ownerid`=$OWNIID";
                  $OWNres = mysqli_query($connection,$OWN);
                                  $OWNrow = mysqli_fetch_array($OWNres);
                               $invoicquery = "SELECT * from  bidding_entry Where  voucher_id='$bulk_voucher_id' && compid='$compid' && sessionid='$sessionid' ";      
                                        
                  //  $invoicquery = "SELECT * from m_truck as A left join bidding_entry as B on (A.truckid = B.truckid)   $cond and B.is_complete=1 && B.recweight !='0' ";

                                            $invres = mysqli_query($connection,$invoicquery);
                                    $incrow = mysqli_fetch_array($invres);
 //$truckid = $row['truckid']; 
                                        $truckid = $incrow['truckid']; 
                                        $ownerid = $OWNrow['ownerid'];
                                          $destinationid = $incrow['destinationid'];
                                         
                      //  $ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
                        $ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
                        
                                    $inc_payment_dat=$incrow['payment_date']; 
                                    $voucher_id=$incrow['voucher_id']; 
                                     $di_no=$incrow['di_no']; 
  $adv_other=$incrow['adv_other'];
 $paidto=$incrow['paidto']; 
      $remark=$incrow['remark']; 
                        $pdf->Cell(125,10,'Truck Owner: '.$ownername ,2,0,'L');
                                         
                                               

                                        $pdf->SetFont('Arial','',10);

                                       $pdf->Cell(45,10,'',2,0,'L');

                                        $pdf->SetFont('Arial','',10);
                                        $pdf->Cell(95,8,'Voucher No.: '.$vocharid,2,0,'L');
                                        $pdf->Ln();

                                           $pdf->SetFont('Arial','',10);
											  
											   $pdf->Cell(5,10,'',2,0,'L');
                                         $pdf->SetFont('Arial','B',10);
                                       $pdf->Cell(95,10,'Paid To : '.$paidto ,2,0,'L');
									   

                                       $pdf->Cell(5,10,'',2,0,'L');
                                         $pdf->SetFont('Arial','',10);
                                       $pdf->Cell(80,10,'Payment Date : '.date('d-m-Y',strtotime($inc_payment_dat)) ,2,0,'L');
                                       
                                             

                                        $pdf->SetFont('Arial','',10);

                                       $pdf->Cell(45,10,'',2,0,'L');

                                        $pdf->SetFont('Arial','',10);
                                        $pdf->Cell(95,8,'Location: Raipur',2,1,'L');
                                        
                                         $pdf->SetFont('Arial','B',10);
                                          $pdf->Cell(5,10,'',2,0,'L');
                                        $pdf->Cell(85,8,'Remark: '.$remark ,2,1,'L');
                                           $toplace = $cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'"); 
                                         $pdf->SetFont('Arial','B',10);
                                          $pdf->Cell(5,8,'',2,0,'L');
                                        $pdf->Cell(85,5,'Destination : '.$toplace ,2,0,'L');
                                        $pdf->Ln(3);
                                        
                                        
                                        
                                        
                                    
                                      
                      
                                        
                                        
                                          $pdf->SetFont('Arial','',10);

                                       $pdf->Cell(5,10,'',2,0,'L');

                                      
                                        
                                        $pdf->Ln(10);

                                            $pdf->SetFont('Arial','B',8);
                                                    $pdf->Cell(6,8,'S.N',1,0,'C');

                                                     

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(10,8,'LR No',1,0,'L');
                                                     
                                                      
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(16,8,'Bilty Date',1,0,'R');
                                                     


                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(19,8,'Truck No',1,0,'R');

                                                     $pdf->SetFont('Arial','B',8);
                                                   //  $pdf->Cell(30,8,'Destination',1,0,'L');
                                                      $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(20,8,'Item',1,0,'L');
                                                     
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(12,8,'Wt.(MT)',1,0,'R');
                                                     $pdf->SetFont('Arial','B',7);
                                                     $pdf->Cell(15,8,'Rec.wt(MT)',1,0,'R');
                                                    //  $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(13,8,'Com. Rate',1,0,'R');

                                                    //  $pdf->SetFont('Arial','B',7);
                                                    //  $pdf->Cell(13,8,'Commi.',1,0,'R');

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(15,8,'Final Rate',1,0,'L');
                                                     
                                                      $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(19,8,'Freight Amt',1,0,'R');

                                                    $pdf->SetFont('Arial','B',7);
                                                     $pdf->Cell(16,8,"Paymt Comi",1,0,'R');

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(14,8,'Shortage',1,0,'R');

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(14,8,'Shortamt',1,0,'R');


                                                    $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(8,8,'TDS',1,0,'R');

                                                    $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(14,8,'TDS Amt',1,0,'R');

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(27,8,'Cash+Di Adv(Self)',1,0,'C');
                                                     
                                                      $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(23,8,'Cash Adv(Consi)',1,0,'C');
                                                     
                                                      $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(15,8,'Other Adv',1,0,'C');

                                                    
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(20,8,'Total Net Amt',1,0,'R');
                                                    



                                                      $pdf->Ln();
													  
													  
													  $total_wt_mt=0;
                                                $total_recweight=0;
                                                $total_final_rate=0;
                                                    $total_rate_mt=0;
                                                $total_trip_commission=0;
                                                $total_commision=0;
                                                    $total_freight=0;
                                                $total_deduct=0;   
                                                $total_tds_amount=0;
                                                $total_adv =0;
                                                $total_desial_adv =0;
                                                $total_netamout =0;
                                                $toal_advconsi =0;
                                                $great_total=0;
                                                $total_tds=0;
                                                         $sn=1;
                                                           $sel = "SELECT * from  bidding_entry Where  voucher_id='$bulk_voucher_id' && compid='$compid' && sessionid='$sessionid' "; 
                                  //$sel = "SELECT * from m_truck as A left join bidding_entry as B on (A.truckid = B.truckid)   $cond and B.is_complete=1  && B.recweight !='0' ";

                                            $res = mysqli_query($connection,$sel);
                                    while($row = mysqli_fetch_array($res))
                                    {
                                        $truckid = $row['truckid']; 
                                        $truckno = $row['truckno']; 
                                        $ownerid = $row['ownerid']; 
                                        $bid_id = $row['bid_id'];   
                        $ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
                        $ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
                        
                        $consignorid = $row['consignorid'];
                        $consigneeid = $row['consigneeid'];
                        $consignorname = $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$consignorid'");
                        $consigneename = $cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$consigneeid'");
                        $placeid = $row['placeid'];
                        $destinationid = $row['destinationid'];
                        $itemid = $row['itemid'];
                        $truckid = $row['truckid'];
                        $wt_mt = $row['totalweight'];
                        $recweight = $row['recweight'];
                        $pay_no = $row['pay_no'];
                        $di_no=$row['di_no'];
                        if($pay_no!=''){
                        $pay_no = $cmn->getcode($connection,"bidding_entry","pay_no","1=1 and sessionid = $_SESSION[sessionid]  && consignorid=4");
                        
                        }
                        else {
                        $pay_no = $row['pay_no'];
                        }
                        
                        $ac_holder = $row['ac_holder'];
                        $rate_mt = $row['freightamt'];
                        $newrate = $row['newrate']; 
                        $deduct_r = $row['deduct_r'];
                        if($deduct_r=='') { $deduct_r= 0; }
                        
                        $deduct = $row['deduct'];   
                        
                        $fromplace = $cmn->getvalfield($connection,"m_place","placename","placeid='$placeid'");
                        $toplace = $cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'");
                        $itemname = $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");
                        $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
                        $ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
                        $truckowner = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
                        $adv_cash = $row['adv_cash'];
                        $adv_other =  $row['adv_other'];
						 $adv_consignor =  $row['adv_consignor'];
                        $adv_diesel = $row['adv_diesel'];
                        $adv_cheque = $row['adv_cheque'];
                        $cheque_no = $row['cheque_no']; 
                        
                        
                        $payment_date = $row['payment_date'];
                        $chequepaydate = $row['chequepaydate']; ;
                        
                        //$venderid = $row['venderid'];
                        $commission = $row['commission'];
                        
                        
                        $cashpayment = $row['cashpayment'];
                        $chequepayment = $row['chequepayment'];
                        $chequepaymentno = $row['chequepaymentno'];
                        $paymentbankid = $row['paymentbankid']; 
                       $shortagewt =  $row['shortagewt']; 
                       // $compcommission =  $row['compcommission']; 
                       // $cashbook_date = $row['cashbook_date'];
                        $payeename = $row['payeename']; 
                        $tds_amt = $row['tds_amt']; 
                        $neftpayment =$row['neftpayment'];  
                        $sortagr =$row['sortagr'];
                        $sortamount =$row['sortamount'];  
                        


                        if($payment_date=='0000-00-00')
                        {
                        $payment_date = date('Y-m-d');
                        $compcommission = $cmn->getvalfield($connection,"m_consignor","commission","consignorid='$consignorid'");
                        }
                        
                        $friendt_amount=$newrate * $recweight;
                        $netamount = $newrate * $recweight;
                        $charrate = $rate_mt - $newrate;    
                        $tot_adv = $adv_cash  + $adv_cheque +$adv_other+$adv_consignor;
                        
                        $balamt = $netamount - $adv_cash - $adv_diesel - $adv_cheque -$adv_other -$adv_consignor - $commission;
                        
                        $tot_profit = $recweight * $charrate;
                        $comp_commision = ($tot_profit * $compcommission)/100;
                        $net_profit = round($tot_profit - $comp_commision);
                        
                        $othrcharrate = $rate_mt - $newrate;
                        
                        $trip_commission=$row['trip_commission'];
                        $netamount=$netamount-$deduct;    
                        $tds_amount= $netamount*$row['tds_amt']/100;

                        if($newrate==0){ $newrate=''; }
                        if($adv_cash==0){ $adv_cash='0'; }
                        if($adv_diesel==0){ $adv_diesel='0'; }
                        if($adv_cheque==0){ $adv_cheque=''; }
                        if($adv_other==0){ $adv_other='0'; }
                        if($adv_consignor==0){ $adv_consignor='0'; }
                      $total_paid= $netamount-$commission-$adv_diesel-$tot_adv-$tds_amount-$sortamount;
                      $final_rate=$rate_mt-$trip_commission;
                      
                                            $pdf->SetFont('Arial','',8);
                                                    $pdf->Cell(6,8, $sn++,1,0,'L');

                                                     

                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(10,8,$row['lr_no'],1,0,'L');
                                                     
                                                    
                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(16,8,date('d-m-Y',strtotime($row['tokendate'])),1,0,'R');
                                                     


                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(19,8,$truckno,1,0,'R');

                                                     $pdf->SetFont('Arial','',8);
                                                   //  $pdf->Cell(30,8,$toplace,1,0,'L');
                                                     
                                                      $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(20,8,$itemname,1,0,'C');
                                                     
                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(12,8, $wt_mt,1,0,'R');

                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(15,8,$row['recweight'],1,0,'R');

                                                    //  $pdf->SetFont('Arial','',8);
                                                    //  $pdf->Cell(13,8,$rate_mt,1,0,'R');


                                                    // $pdf->SetFont('Arial','',8);
                                                    //  $pdf->Cell(13,8,$trip_commission,1,0,'R');

                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(15,8,round($final_rate),1,0,'R');
                                                    
                                                     $pdf->Cell(19,8,round($friendt_amount),1,0,'R');
                                                     $pdf->SetFont('Arial','',8);

                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(16,8,round($commission),1,0,'R');
                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(14,8,$sortagr,1,0,'R');

                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(14,8,$sortamount,1,0,'R');



                                                    $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(8,8,$tds_amt.'%',1,0,'R');

                                                    $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(14,8,round($tds_amount),1,0,'R');

                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(27,8,round($adv_cash),1,0,'R');
                                                      $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(23,8,round($adv_consignor),1,0,'R');
                                                      $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(15,8,round($adv_other),1,0,'R');
                                                    
                                                    
                                                     $pdf->SetFont('Arial','',8);
                                                    
                                                     $pdf->Cell(20,8,number_format(round($total_paid),2),1,0,'R');



                                                      $pdf->Ln();
                                                    $total_wt_mt+=$wt_mt;
                                                $total_recweight+=$row['recweight'];
                                                $total_final_rate+=$final_rate;
                                                    $total_rate_mt+=$rate_mt;
                                                $total_trip_commission+=$trip_commission;
                                                $total_commision+=$commission;
                                                $total_freight+=$friendt_amount;
                                                $total_deduct+=$sortagr;    
                                                $total_tds_amount+=$tds_amount;
                                                $total_adv +=$adv_cash;
                                                $total_desial_adv += $adv_diesel;
                                                $total_netamout +=$netamount;
                                                $toal_advconsi +=$adv_consignor;
                                                $great_total +=$total_paid;
                                                $total_tds+=$tds_amt;
                                                
                                                   
                                                  }  

                                          
                                                     

                                                     $pdf->SetFont('Arial','B',9);
                                                     $pdf->Cell(71,12,'Total',1,0,'C');

                                                     
                                                     
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(12,12, $total_wt_mt,1,0,'R');
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(15,12,$total_recweight,1,0,'R');
                                                    //  $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(13,12,$total_rate_mt,1,0,'R');

                                                    //  $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(13,12,$total_trip_commission,1,0,'R');

                                                    $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(15,12,'',1,0,'R');
                                                     
                                                      $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(19,12,round($total_freight),1,0,'R');
                                                     

                                                      $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(16,12,round($total_commision),1,0,'R');

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(14,12,$total_deduct,1,0,'R');


                                                    $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(14,12,'',1,0,'R');

                                                    $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(8,12,'',1,0,'R');
                                                    

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(14,12,'',1,0,'R');
                                                        $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(27,12,round($total_adv),1,0,'R');
                                                   
                                                       $pdf->SetFont('Arial','B',8);
                                                      $pdf->Cell(23,12,'',1,0,'R');
                                                        $pdf->SetFont('Arial','B',8);
                                                        
                                                   //  $pdf->Cell(24,12,'',1,0,'R');
                                                    
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(35,12,number_format(round($great_total),2),1,0,'R');



                                                      $pdf->Ln();

                                                      $pdf->SetFont('Arial','B',10);
                                                     $pdf->Cell(225,12,'Grant Total Amount',1,0,'C');

                                                     
                                                     $pdf->Cell(58,12,number_format(round($great_total),2),1,0,'R');



                                                  
                                                     
                                                      

                                               

 $pdf->Output();
?>
