<?php
include("dbconnect.php");
// require("../fpdf17/fpdf.php");
include("../fpdf17/rotation.php");
 
  $cond=' ';
  
  
  
  if(isset($_GET['bulk_vid']))
  {
    $bulk_vid = trim(addslashes($_GET['bulk_vid']));  
  }
  else
  $bulk_vid = '';
  


  
  $cond= " where 1=1";
  // if($from !='1970-01-01' && $todate !='1970-01-01') {
    
  //   $cond .=" and  B.tokendate BETWEEN '$from' and '$todate'";
    
  //   }
    if($bulk_vid !='') {
    
    $cond .=" and bulk_vid='$bulk_vid'";
    }
     
  
// $c_logo = $cmn->getvalfield($connection,"m_company","clogo","comp_id='$_SESSION[comp_id]'");
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

 $this->Rect(10,5,280,200,'D'); // sabse upper
//  $this->Rect(10,20,280,30,'D'); 
    }
    
    function Footer()

    { 

     global $deduct,$ac_number,$ifsc_code,$branch_name,$bank_name ;

     $this->SetY(-30);

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
$pdf->SetY(5);

 $pdf->SetX(20);
 
                                       
                                          
                                            $company_owner = "SELECT * FROM `m_company` where compid='$compid' ";

                                    $cmp_owm = mysqli_query($connection,$company_owner);
                               while($onwer = mysqli_fetch_assoc($cmp_owm)){
    
                                    //   $pdf->Image('../upload/logo/'.$c_logo,10,2,13);
                                                    
                                        $pdf->SetX(120);
                                         $pdf->SetFont('Arial','',24);
                                        $pdf->Cell(150,18,$onwer['cname'],2,0,'L');
                                        
                                        //  $pdf->SetX(130);
                                        //  $pdf->SetFont('Arial','',24);
                                        // $pdf->Cell(150,8,'',2,0,'L');
                                        
                                        // $pdf->Ln();

                                        $pdf->SetX(40);
                                        //  $pdf->SetFont('Arial','',10);
                                        // $pdf->Cell(270,6,$onwer['add1'],2,0,'L');
                                        $pdf->Ln();

                                            
                                    //      $pdf->SetFont('Arial','',10);
                                    //   $pdf->Cell(150,5,'',2,0,'L');
                                    //     $pdf->SetFont('Arial','',10);
                                    //   $pdf->Cell(125,-20,'Contact : '.$onwer['mobile1'],2,0,'R');
                                         
                                               

                                        $pdf->SetFont('Arial','',10);
                                       $pdf->Cell(150,5,'',2,0,'L');
                                        $pdf->SetFont('Arial','',10);
                                        // $pdf->Cell(120,-10,'GST No. : '.$onwer['gst_no'],2,0,'R');
                                        $pdf->Ln();

                                         
                                                                               

                                        $pdf->SetFont('Arial','',10);

                                       $pdf->Cell(150,10,'',2,0,'R');

                                        $pdf->SetFont('Arial','',10);
                                        // $pdf->Cell(125,8,'PAN No. : '.$onwer['pan_no'],2,0,'R');
                                        $pdf->Ln();


                                         $pdf->SetFont('Arial','',10);

                                       $pdf->Cell(150,10,'',2,0,'R');

                                        $pdf->SetFont('Arial','',10);
                                        // $pdf->Cell(125,2,'GST No. : '.$onwer['gst_no'],2,0,'R');
                                        $pdf->Ln();

                                           

                                           $lh = 100;
                                            $lw= $lh+8;

                                            $pdf->Line(10,20, 290,20);
                                             $pdf->Ln(0);

                                              $pdf->SetFont('Arial','',10);

                                       $pdf->Cell(5,10,'',2,0,'L');
                                         $pdf->SetFont('Arial','B',12);

}
               
                            
                   $invoicquery = "SELECT * from voucher_entry  $cond  ";

                                            $invres = mysqli_query($connection,$invoicquery);
                                    $incrow = mysqli_fetch_array($invres);
 
                                    $voucher_no=$incrow['voucher_no']; 
                                    $paid_to=$incrow['paid_to']; 
                                    $pay_date=$incrow['pay_date']; 
                                    $remark=$incrow['remark']; 
                                 $partyid=$incrow['partyid'];
      $party_name=$cmn->getvalfield($connection,"supplier_master","party_name","supplier_id='$partyid'");   
      
      
       
         
                        // $pdf->Cell(125,10,'Category: '.$cname ,2,0,'L');
                                         
                                               

                                    //     $pdf->SetFont('Arial','',10);

                                    //   $pdf->Cell(45,10,'',2,0,'L');
                                     $pdf->SetX(10);
                                      $pdf->SetY(20);

                                        $pdf->SetFont('Arial','',10);
                                        $pdf->Cell(70,8,'Voucher No.',1,0,'R');
                                        // $pdf->Ln(5);
//  $pdf->SetFont('Arial','B',7);
                                                    //  $pdf->Cell(20,8,"Gross Amount",1,0,'R');
                                          
                                      $pdf->Cell(70,8,$voucher_no ,1,0,'L');
                                        $pdf->Cell(70,8,' Date : ' ,1,0,'R');
                                         $pdf->Cell(70,8,dateformatindia($pay_date) ,1,1,'L');

                                 $pdf->Cell(70,8,'Paid To ',1,0,'R');
                                        // $pdf->Ln(5);
//  $pdf->SetFont('Arial','B',7);
                                                    //  $pdf->Cell(20,8,"Gross Amount",1,0,'R');
                                          
                                      $pdf->Cell(70,8,$paid_to ,1,0,'L');
                                        $pdf->Cell(70,8,'Remark  ' ,1,0,'R');
                                         $pdf->Cell(70,8,$remark ,1,1,'L');
                                        $pdf->Cell(155,10,'Payment Details  '.' ( '. $party_name.' )' ,2,0,'R');
                                     $pdf->Line(10,45, 290,45);     
                                        
                                        
                                    
                                      
                      
                                        
                                        
                                    //       $pdf->SetFont('Arial','',10);

                                    //   $pdf->Cell(5,10,'',2,0,'L');

                                      
                                        
                                        $pdf->Ln(9);
                                        $pdf->SetX(10);

                                            $pdf->SetFont('Arial','B',8);
                                                    $pdf->Cell(10,8,'S.N',1,0,'C');

                                                     

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(25,8,'Trip No./LR No.',1,0,'L');
                                                     
                                                      
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(18,8,'Loding Date',1,0,'R');
                                                     


                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(21,8,'Truck No',1,0,'R');

                                                     $pdf->SetFont('Arial','B',8);
                                                  //  $pdf->Cell(30,8,'Destination',1,0,'L');
                                                      $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(15,8,'Qty',1,0,'L');
                                                     
                                                    //  $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(12,8,'Wt.(MT)',1,0,'R');
                                                     $pdf->SetFont('Arial','B',7);
                                                     $pdf->Cell(20,8,'Rate',1,0,'R');
                                                    //  $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(13,8,'Com. Rate',1,0,'R');

                                                    //  $pdf->SetFont('Arial','B',7);
                                                    //  $pdf->Cell(13,8,'Commi.',1,0,'R');

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(20,8,'Frieght Amt',1,0,'L');
                                                     
                                                    //  $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(20,8,'Tds %',1,0,'L');
                                                     
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(20,8,'Tds Amt',1,0,'L');
                                                     
                                                      $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(25,8,'Trip Expenses',1,0,'R');

                                                    $pdf->SetFont('Arial','B',7);
                                                     $pdf->Cell(20,8,"Gross Amount",1,0,'R');

                                                    //  $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(14,8,'Shortage',1,0,'R');

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(20,8,'Shortamt',1,0,'R');


                                                    // $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(8,8,'TDS',1,0,'R');

                                                    $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(25,8,'Other Deduction',1,0,'R');

                                                    //  $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(22,8,'Tp Name',1,0,'C');
                                                     
                                                    //   $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(20,8,'Tp Amount',1,0,'C');
                                                     
                                                      $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(41,8,'Net Amount',1,1,'C');
                                                    //       $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(18,8,'Consignor',1,0,'C');
                                                    //      $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(18,8,'Consignee',1,0,'C');
                                                    
                                                    //  $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(15,8,' Net Amt',1,1,'R');
                                                    


     
                    // echo  "SELECT * from payment_recive  $cond ";    
                      $sn=1;  
                  $sel = "SELECT * from payment_recive  $cond";
        $res = mysqli_query($connection,$sel);
                                    while($row = mysqli_fetch_array($res))
                                    {
           
 $trip_no=$cmn->getvalfield($connection,"trip_entry","trip_no","trip_id='$row[trip_id]'");   
 $loding_date=$cmn->getvalfield($connection,"trip_entry","loding_date","trip_id='$row[trip_id]'");   
  $vehicle_id=$cmn->getvalfield($connection,"trip_entry","vehicle_id","trip_id='$row[trip_id]'");   
 $qty_mt_day_trip=$cmn->getvalfield($connection,"trip_entry","qty_mt_day_trip","trip_id='$row[trip_id]'");   
	$vehicle_no = $cmn->getvalfield($connection, "vehicle_master", "vehicle_no", "vehicle_id='$vehicle_id'");
$rate=$cmn->getvalfield($connection,"trip_entry","rate","trip_id='$row[trip_id]'");   
$frieght_amt=$cmn->getvalfield($connection,"trip_entry","frieght_amt","trip_id='$row[trip_id]'");   
$trip_expenses=$cmn->getvalfield($connection,"trip_entry","trip_expenses","trip_id='$row[trip_id]'");   
$tp_name=$cmn->getvalfield($connection,"tp_master","tp_name","tp_id='$row[tp_id]'");   
$gross_amt=$frieght_amt-$trip_expenses;
 $short_deduct=$row['short_deduct'];
 $other_deduct=$row['other_deduct'];
  $tp_amount=$row['tp_amount'];
 $final_total=$row['final_total']; 
     $tds=$row['tds'];   
   $tds_amt=$row['tds_amt'];  
      $pdf->SetFont('Arial','',8);
      $pdf->SetX(10);
                                                    $pdf->Cell(10,8, $sn++,1,0,'L');

                                                     

                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(25,8,$trip_no,1,0,'L');
                                                     
                                                    
                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(18,8,date('d-m-Y',strtotime($loding_date)),1,0,'R');
                                                     


                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(21,8,$vehicle_no,1,0,'R');

                                                     $pdf->SetFont('Arial','',8);
                                                  //  $pdf->Cell(30,8,$toplace,1,0,'L');
                                                     
                                                      $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(15,8,$qty_mt_day_trip,1,0,'C');
                                                     
                                                    //  $pdf->SetFont('Arial','',8);
                                                    //  $pdf->Cell(12,8, $wt_mt,1,0,'R');

                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(20,8,$rate,1,0,'R');

                                                    //  $pdf->SetFont('Arial','',8);
                                                    //  $pdf->Cell(13,8,$rate_mt,1,0,'R');


                                                    // $pdf->SetFont('Arial','',8);
                                                    //  $pdf->Cell(13,8,$trip_commission,1,0,'R');

                                                     $pdf->SetFont('Arial','',8);
                                                    $pdf->Cell(20,8,round($frieght_amt),1,0,'R');
                                                    //  $pdf->SetFont('Arial','',8);
                                                    // $pdf->Cell(20,8,round($tds),1,0,'R');
                                                     $pdf->SetFont('Arial','',8);
                                                    $pdf->Cell(20,8,round($tds_amt),1,0,'R');
                                                     $pdf->Cell(25,8,round($trip_expenses),1,0,'R');
                                                     $pdf->SetFont('Arial','',8);

                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(20,8,round($gross_amt),1,0,'R');
                                                    //  $pdf->SetFont('Arial','',8);
                                                    //  $pdf->Cell(14,8,$sort_wt,1,0,'R');

                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(20,8,$short_deduct,1,0,'R');



                                                    // $pdf->SetFont('Arial','',8);
                                                    //  $pdf->Cell(8,8,$tds.'%',1,0,'R');

                                                    $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(25,8,round($other_deduct),1,0,'R');

                                                    //  $pdf->SetFont('Arial','',8);
                                                    //  $pdf->Cell(22,8,$tp_name,1,0,'R');
                                                    //   $pdf->SetFont('Arial','',8);
                                                    //  $pdf->Cell(20,8,round($tp_amount),1,0,'R');
                                                      $pdf->SetFont('Arial','',8);
                                                $pdf->Cell(41,8,round($final_total),1,0,'R');
                                                    //   $pdf->SetFont('Arial','',8);
                                                    //  $pdf->Cell(18,8,round($consignor_cash_adv),1,0,'R');
                                                    //   $pdf->SetFont('Arial','',8);
                                                    //  $pdf->Cell(18,8,round($consignee_cash_adv),1,0,'R');
                                                     $pdf->SetFont('Arial','',8);
                                                    
                                                    // $pdf->Cell(15,8,number_format(round($amt_paid_to),2),1,0,'R');

      
                                                   
                                                 

                                                      $pdf->Ln();
                                                //     $total_wt_mt+=$wt_mt;
                                                // $total_recweight+=$rec_wt;
                                                // $total_final_rate+=$freight_rate;
                                                //     $total_rate_mt+=$rate_mt;
                                                $total_trip_expenses+=$trip_expenses;
                                                $total_short_deduct+=$short_deduct;
                                                $total_freight+=$frieght_amt;
                                                $total_tp_amount+=$tds_amt;    
                                                $total_other_deduct+=$other_deduct;
                                                $total_gross_amt +=$gross_amt;
                                                $total_desial_adv += $diesel_adv_amt;
                                                $total_final_total +=$final_total;
                                                // $toal_advconsi +=$consignor_cash_adv;
                                                // $great_total +=$amt_paid_to;
                                                // $total_tds+=$tds_amt;
                                          

                                          }  
                                                     
                                        $pdf->SetX(10);
                                                     $pdf->SetFont('Arial','B',9);
                                                     $pdf->Cell(109,12,'Total',1,0,'C');

                                                     
                                                     
                                                    //  $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(12,12, $total_wt_mt,1,0,'R');
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(20,12,$total_freight,1,0,'R');
                                                    //  $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(13,12,$total_rate_mt,1,0,'R');

                                                    //  $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(13,12,$total_trip_commission,1,0,'R');
    //  $pdf->SetFont('Arial','',8);
                                                    // $pdf->Cell(20,12,'',1,0,'R');
                                                     $pdf->SetFont('Arial','',8);
                                                    $pdf->Cell(20,12,round($total_tp_amount),1,0,'R');
                                                    $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(25,12,$total_trip_expenses,1,0,'R');
                                                     
                                                      $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(20,12,round($total_gross_amt),1,0,'R');
                                                     

                                                  $pdf->SetFont('Arial','B',8);
                                             $pdf->Cell(20,12,round($total_short_deduct),1,0,'R');

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(25,12,$total_other_deduct,1,0,'R');


                                                    // $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(22,12,'',1,0,'R');

                                                    // $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(8,12,'',1,0,'R');
                                                     

                                                    //  $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(20,12,round($total_tp_amount),1,0,'R');
                                                        $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(41,12,round($total_final_total),1,0,'R');
                                                   
                                                    //   $pdf->SetFont('Arial','B',8);
                                                    //   $pdf->Cell(13,12,'',1,0,'R');
                                                    //     $pdf->SetFont('Arial','B',8);
                                                        
                                                  //  $pdf->Cell(24,12,'',1,0,'R');
                                                    
                                                    //  $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(15,12,number_format(round($great_total),2),1,0,'R');



                                                      $pdf->Ln();
                                                     $pdf->SetX(10);
                                                      $pdf->SetFont('Arial','B',10);
                                                     $pdf->Cell(194,12,' Total Amount',1,0,'C');

                                                     
                                                     $pdf->Cell(86,12,number_format(round($total_final_total),2),1,0,'R');



                                                  
                                                     
                                                      

                                               


                                                  
                                                     
                                                      

                                               

 $pdf->Output();
?>
