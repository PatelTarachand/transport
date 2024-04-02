<?php  
error_reporting(0);
 include("dbconnect.php");
require("../fpdf17/fpdf.php");
$cname = $cmn->getvalfield($connection, "m_company", "cname", "compid='1'");

if(isset($_GET['purchaseid']))
{
	$purchaseid = $_GET['purchaseid'];	
	$sql = "select * from purchaseentry where purchaseid = '$purchaseid'";
	$res = mysqli_query($connection,$sql);
	$row = mysqli_fetch_array($res);
	$bill_type    =  $row['bill_type'];
    $billno    =  $row['billno'];
	$purchase_date   = $cmn->dateformatindia($row['purchase_date']);
	$purchase_type   = $row['purchase_type'];


	$sup_id = $row['sup_id'];
	
    $supplier_name = $cmn->getvalfield($connection, "suppliers", "sup_name", "sup_id='$row[sup_id]'");

     $mobile=$cmn->getvalfield($connection,"suppliers","contactno","sup_id='$row[sup_id]'");

   
	
	//   $cname     =  $cmn->getvalfield($connection,"m_company","cname","compid = '$compid'");     
	//  $caddress  = $cmn->getvalfield($connection,"m_company","address","compid='$compid'");	 
	//  $cphoneno = $cmn->getvalfield($connection,"m_company","phoneno","compid='$compid'"); 
	//   $mobile=$cmn->getvalfield($connection,"supplier_master","mobile_no","supplier_id='$supplier_id'");
	// $email_id     = $cmn->getvalfield($connection,"m_company","email_id","compid='$compid'");
	 
	// echo $imgname ;
/*  
	
	 $address=$cmn->getvalfield($connection,"m_supplier_party","address","suppartyid='$suppartyid'");
	 $tinno = $cmn->getvalfield($connection,"m_supplier_party","tinno","suppartyid='$suppartyid'");
	$stateid =$cmn->getvalfield($connection,"m_supplier_party","stateid","suppartyid='$suppartyid'");
	//echo $stateid ;
      $cus_state=$cmn->getvalfield($connection,"m_state","state_name","stateid='$stateid'");
     $cus_code=$cmn->getvalfield($connection,"m_state","state_code","stateid='$stateid'");
	 $tot_product_count = $cmn ->getvalfield($connection,"purchasentry_detail","count(*)","purchaseid='$purchaseid'");
    $last_page_number = ceil(($tot_product_count / 30)); */
}
else
$purchaseid = 0;
function convert_number($number) 
{ 
     $no = round($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'One', '2' => 'Two',
    '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
    '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
    '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
    '13' => 'Thirteen', '14' => 'Fourteen',
    '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
    '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
    '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
    '60' => 'Sixty', '70' => 'Seventy',
    '80' => 'Eighty', '90' => 'Ninety');
   $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' And ' : null;
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
          $words[$point = $point % 10] : '';
		  
  return $result; //. "and  " . $points . " Paise";
} 
class PDF_MC_Table extends FPDF
{
  var $widths;
  var $aligns;
	function Header()
	{
		global $title1,$title2,$supplier_name,$mobile,$billno,$purchase_date,$gsttinno,$bill_type,$cname,$caddress,$phoneno,$purchase_type,$billtype;
		 // courier 25
		 
		 $this->Rect(5, 5, 138, 200, 'D');
		$this->SetFont('times','b',15);
		// Move to the right
		 $this->SetY(9);
		 $this->Cell(55);
		// Title
		$this->Cell(10,0,'SHIVALI LOGISTICS',0,0,'C');
		// Line break
		$this->Ln(6);
		// Move to the right
		$this->Cell(50);
		 // courier bold 15
		$this->SetFont('courier','b',12);
		$this->Cell(20,0,$title2,0,0,'C');
		  // Move to the right
		$this->Ln(15);
		$this->SetY(20);
		$this->SetX(5);
		$this->SetFont('courier','b',9);
		$this->Cell(138,0,'',1,0,0,'C');
	    $this->Ln(2);	
      
		$this->SetX(6);
		$this->SetFont('arial','b',9);
	    $this->Cell(24,5,"Supplier name ",0,0,'L');
		$this->SetFont('arial','b',9);
	    $this->Cell(60,5,"  : ".strtoupper($supplier_name),0,0,'L');
		
		//echo $mobile;die;
        
		
		$this->SetFont('arial','b',9);
	    $this->Cell(28,5,"BILL NO. : ",0,0,'R');
		$this->SetFont('arial','b',9);
	    $this->Cell(5,5,$billno,0,1,'L');
		
		$this->SetX(6);
		$this->SetFont('arial','b',9);
	    $this->Cell(19,5,"Contact No",0,0,'L');
		$this->SetFont('arial','b',9);
	    $this->Cell(60,5,"     : ".$mobile,0,0,'L');
		
		$this->SetFont('arial','b',9);
	    $this->Cell(28,5,"DATE  ",0,0,'R');
		$this->SetFont('arial','b',9);
	   $this->Cell(20,5,": ".$purchase_date,0,1,'L');
	   
		$this->SetFont('arial','b',9);
	    $this->Cell(22,5,"Purchase Type  ",0,0,'R');
		$this->SetFont('arial','b',9);
	   $this->Cell(20,5,": ".$bill_type ,0,0,'L');
	    $this->Ln(10);	 
	}
	  // Page footer
	function Footer()
	{
		global $cname;
	// Position at 1.5 cm from bottom
		$this->SetY(-13);
		// Arial italic 8
		$this->SetFont('Arial','I',8); 
		// Page number
		$this->SetX(2);
		$this->MultiCell(140,5,'|| Developed By Chaaruvi Inotech, Contact us- +91-8871181890  ||',0,'C');
		
		  $this->SetY(-22);
		  $this->SetX(2);
          $this->SetFont('Arial','b',8);
          $this->SetTextColor(0,0,0);
        //   $this->Cell(138,5, "For "." ".$cname,0,'1','R',0);
		
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
$title1 =$cname;
$pdf->SetTitle($title1);
$title2 = "PURCHASE DETAILS";
$pdf->SetTitle($title2);

$pdf->AliasNbPages();
$pdf->AddPage('P','A5');
$pdf->SetX(5);
$pdf->SetFont('Arial','B',9);
$pdf->SetFillColor(170, 170, 170); //gray
$pdf->SetTextColor(0,0,0);
$pdf->Cell(8,6,'S.No.','1',0,'L',1);  
$pdf->Cell(50,6,'Item Name',1,0,'C',1);
$pdf->Cell(10,6,'Qty',1,0,'C',1);
$pdf->Cell(23,6,'Rate',1,0,'C',1);
$pdf->Cell(22,6,'Total Amt',1,0,'C',1);
if($bill_type=='challan'){
 
$pdf->Cell(25,6,'Net Amt.',1,1,'C',1);
}else{
   $pdf->Cell(10,6,'GST%',1,0,'C',1);
$pdf->Cell(15,6,'Net Amt.',1,1,'C',1);
}


$pdf->SetX(5);
if($bill_type=='challan'){
$pdf->SetWidths(array(8,50,10,23,22,25));
$pdf->SetAligns(array("L","L","R","R","R","R","R"));
}else{
    $pdf->SetWidths(array(8,50,10,23,22,10,15));
$pdf->SetAligns(array("L","L","R","R","R","R","R"));
}


$pdf->SetFont('Arial','',6);
$slno = 1;
// echo "Select * from purchasentry_detail where purchaseid='$purchaseid'";
$sql_get = mysqli_query($connection,"Select * from purchasentry_detail where purchaseid='$purchaseid'");
			while($row_get = mysqli_fetch_assoc($sql_get))
{
    
    $itemcategoryname = $cmn->getvalfield($connection, "items", "item_name", "itemid ='$row_get[itemid]'");
    // $item_category_name = $cmn->getvalfield($connection, "item_categories", "item_category_name", "itemcatid='$row_get[itemcatid]'");
	$serial_no = $cmn->getvalfield($connection, "purchasentry_detail", "serial_no", "purdetail_id='$row_get[purdetail_id]'");
	
		$itemid= $cmn->getvalfield($connection, "purchasentry_detail", "itemid", "purdetail_id ='$row_get[purdetail_id]'");
	$itemcatid = $cmn->getvalfield($connection, "items", "itemcatid", "itemid ='$itemid'");
				$item_category_name = $cmn->getvalfield($connection, "item_categories", "item_category_name", "itemcatid='$itemcatid'");

   
	 
    $qty =$row_get['qty'];
    $rate =$row_get['rate'];
    $total_amt =$row_get['total_amt'];
    $gst =$row_get['gst'];
    $total +=$row_get['total_amt'];
		
		
		 $gsttotal = $total_amt * $gst/100;
             $nettotal = $total_amt+$gsttotal;
           $subtotal +=$nettotal;
									  											
	$pdf->SetX(5);	
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(0,0,0);
	if($bill_type=='challan'){
	$pdf->Row(array($slno,strtoupper($itemcategoryname).'/'.$item_category_name, $row_get['qty'],$row_get['rate'],$row_get['total_amt'], $nettotal));
	}else{
	    $pdf->Row(array($slno,strtoupper($itemcategoryname).'/'.$item_category_name, $row_get['qty'],$row_get['rate'],$row_get['total_amt'],$row_get['gst'].'%', $nettotal));
	}
 if($slno % 14 == 0)
         {
              $pdf->AddPage('P','A5');
            // $curr_page = $pdf->PageNo('b');
            $pdf->SetY(50);
         }
         
	$slno++;
}


$pdf->SetX(5);
$pdf->SetFont('arial','b',8);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(91,5,'SUBTOTAL :',1,0,'R',0);
$pdf->Cell(22,5,number_format($total,2),'1',0,'R',0);
$pdf->Cell(25,5,number_format($subtotal,2),'1',0,'R',0);



$pdf->Output();
?> 
                          	
<?php
mysqli_close($db_link);

?>
