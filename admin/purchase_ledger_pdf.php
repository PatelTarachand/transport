<?php error_reporting(0);
ini_set("memory_limit","500M");
include("mpdf/mpdf.php");
include("dbconnect.php");


$pagename = "purtrasaction_report.php";
$module = "Purchase Transaction Report";
$submodule = "Purchase Transaction Report List";
$btn_name = "Search";
$keyvalue = 0;
$tblname = "transaction_details";
$tblpkey = "ptrans_id";

if (isset($_GET['ptrans_id']))
    $keyvalue = $_GET['ptrans_id'];
else
    $keyvalue = 0;
if (isset($_GET['action']))
    $action = $_GET['action'];

$search_sql = "";


if (isset($_GET['fromdate']) != "" && isset($_GET['todate']) != "") {
    $fromdate = addslashes(trim($_GET['fromdate']));
    $todate = addslashes(trim($_GET['todate']));
} else {
    $fromdate =date("d-m-Y", strtotime("-1 months"));
    $todate = date('d-m-Y');
}

$crit = '';
if ($fromdate != "" && $todate != "") {
    $fromdate = $cmn->dateformatusa($fromdate);
    $todate = $cmn->dateformatusa($todate);
    $crit .= " and transdate between '$fromdate' and '$todate'";
}

if (isset($_GET['sup_id'])) {
    $sup_id = trim(addslashes($_GET['sup_id']));
} else
    $sup_id = '';



if ($sup_id != '') {
    $crit .= " and sup_id='$sup_id' ";
}
$yesterday = date('Y-m-d', strtotime('-1 day', strtotime($fromdate)));




$comp_name =  $cmn->getvalfield($connection,"company_setting","comp_name","1 = 1");
$comp_mobile =  $cmn->getvalfield($connection,"company_setting","mobile","1 = 1");
$company_address=$cmn->getvalfield($connection,"company_setting","address","1 = 1");
$phone_pay=$cmn->getvalfield($connection,"company_setting","phone_pay","1 = 1");
$w_no=$cmn->getvalfield($connection,"company_setting","w_no","1 = 1");
$imgname=$cmn->getvalfield($connection,'company_setting','imgname','1=1');

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

$mpdf=new mPDF('utf-8','A5');
$mpdf->AddPage('P','','','','','4','4','4','4');
$bills_arr = explode (",", $bills);  

$opnbalamt = 0;
$total_blcamt = 0;
$sel = "select * from purchase_trans where 1=1 and transdate > '$fromdate' ";
$res = mysqli_query($connection, $sel);
while ($row = mysqli_fetch_assoc($res)) {


    if ($row['transtype'] == 'debit') {

        $opnbalamt += $row['pamount'];
    }
    if ($row['transtype'] == 'credit') {
        $opnbalamt -= $row['pamount'];

        // $opnbalamt +=$balamt;


    }
}

            
	

$html ='
<html>
<head>
<meta charset="utf-8">
</head>';

$html.="
  <div style='width:100%;height:30%;background-color:white;border:
#000000 1px solid;' >
<div style='width:15%;float:left' >
	
		
		
</div>
 <div style='width:84%;float:right' >
		<table width='90%'>
		
				<tr>
<td style='text-align:center;font-family:ind_hi_1_001;'><h4>Purchase Ledger 	
</h4></td>
						
				</tr>
				<tr>
					<td style='text-align:center;font-family:ind_hi_1_001;'>
					<h3>".constant("COMPANY")."</h3></td>
						
				</tr>
				<tr>
					<td style='text-align:center;font-family:ind_hi_1_001;'>
					<h6>".constant("COMPANYMOBILE")."</h6></td>
						
				</tr>
				
				<tr>
						<td style='text-align:center;font-family:ind_hi_1_001;'><h5>".constant("COMPANYADDRESS")."</h5></td>
						
				</tr>
			
				
		</table>
</div>

<div style='width:100%;height:82%;background-color:white;border:
#000000 1px solid' >
	
	<br/><tr>

	</tr>
	<table width='100%' cellpadding='1' cellspacing='-2' border='1'>
	<tr style='border-bottom:
#000000 1px solid; background:#333333;'>
			<td width='10%' style='border-bottom:
#000000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h5> SN </h5> </td>
			<td width='30%' style='border-bottom:
#000000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF;text-align:center;'> <h5>Date </h5></td>
			<td width='20%' style='border-bottom:
#000000 1px solid;font-family:ind_hi_1_001;text-align:center;color:#FFFFFF'> <h5>Purticular </h5></td>
			<td width='20%' style='border-bottom:
#000000 1px solid;font-family:ind_hi_1_001;text-align:center;color:#FFFFFF'> <h5>Debit   </h5></td>
			<td width='20%' style='border-bottom:
#000000 1px solid;font-family:ind_hi_1_001;text-align:right;color:#FFFFFF'> <h5>Credit  </h5></td>
			<td width='20%' style='border-bottom:
#000000 1px solid;font-family:ind_hi_1_001;text-align:right;color:#FFFFFF'> <h5>Balance   </h5></td>

	</tr>
		<tr style='border-bottom:
#000000 1px solid; background:#333333;'>
			<td width='10%' style='border-bottom:
#000000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h5> </h5> </td>
			<td width='30%' style='border-bottom:
#000000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF;text-align:center;'> <h5> </h5></td>
			<td width='20%' style='border-bottom:
#000000 1px solid;font-family:ind_hi_1_001;text-align:center;color:#FFFFFF'> <h5> </h5></td>
			<td width='20%' style='border-bottom:
#000000 1px solid;font-family:ind_hi_1_001;text-align:center;color:#FFFFFF'> <h5>   </h5></td>
			<td width='20%' style='border-bottom:
#000000 1px solid;font-family:ind_hi_1_001;text-align:right;color:#FFFFFF'> <h5>Opening Balance </h5></td>
			<td width='20%' style='border-bottom:
#000000 1px solid;font-family:ind_hi_1_001;text-align:right;color:#FFFFFF'> <h5>$opnbalamt Dr.    </h5></td>

	</tr>";


    $slno = 1;
    $balamt = 0;
    // echo "select * from billing_entry where 1=1 $crit order by billing_id desc";
    $sel = "select * from purchase_trans where 1=1 $crit ";
    $res = mysqli_query($connection, $sel);
    while ($row = mysqli_fetch_assoc($res)) {


        if ($row['transtype'] == 'debit') {

            $balamt += $row['pamount'];
        }
        if ($row['transtype'] == 'credit') {
            $balamt -= $row['pamount'];
        }
        $transdate= dateformatusa($row['transdate']);
        $purticular=$row['purticular'];
	
		
	$html .="
	<tr>
			<td>$slno</td>
			<td style='font-family:ind_hi_1_001;text-align:center;'><h5>$transdate </h5></td>			
			<td style='text-align:center;'>$purticular</td>
			<td style='text-align:center;'>$er_amt</td>
			<td style='text-align:right;'>$pr_amt</td>
			<td style='text-align:right;'>$balamt</td>

	</tr>";
	
	$totaldebit +=$er_amt;

$totalcredit +=$pr_amt;
	//$tot_oth_charge += $qty * $row2['unitrate'];
	$slno++;
	}
	
	
	
	$total += $tot_oth_charge;
	if($tot_oth_charge !=0) {
	$html .="
	<tr>
			
			<td colspan='5'  style='font-family:ind_hi_1_001;text-align:right;border-top:
#000000 1px solid;'><h5> अतिरिक्त रकम :-</h5></td>
			<td style='text-align:right;border-top:
#000000 1px solid;font-weight:bold'>".number_format($tot_oth_charge,2)."</td>
	</tr>";
	}
	
	$total = round($total);
	$prevbalance = $cmn->getvalfield($connection,"m_supplier_party","prevbalance","sup_id='$sup_id'");
	$tot_sale = $cmn->getvalfield($connection,"saleenetry","sum((rate * qty * weight)+(qty * unitrate))","sup_id='$sup_id' && billdate ='$billdate'");	
	$tot_paid = $cmn->getvalfield($connection,"payment","sum(paid_amt + discamt)","sup_id='$sup_id' && paymentdate ='$billdate'");
	


	
	$html .="	
	


	
	<tr>
			
			<td colspan='3' style='font-family:ind_hi_1_001;text-align:right;border-bottom:
#000000 1px solid;background:#CCCCCC; color:#000000;'><h5>योग :-</h5></td>
			<td colspan='1' style='text-align:right;border-bottom:
#000000 1px solid;background:#CCCCCC; color:#000000;font-weight:bold'>$totaldebit</td>
<td colspan='1' style='text-align:right;border-bottom:
#000000 1px solid;background:#CCCCCC; color:#000000;font-weight:bold'>$totalcredit</td>
	</tr>";
	
	$balmsg='';
	
	$sqlu = mysqli_query($connection,"select unitid,unit_name,unit_name_hindi from m_unit where isstockable=1");	
	while($rowu=mysqli_fetch_assoc($sqlu)) {
	$totqty=0;
	$retqty=0;
	$unit_name = $rowu['unit_name_hindi'];
		
	// $balqty = $cmn->getcarretopenbydate($connection,$sup_id,$rowu['unitid'],$billdate);
	
	$balmsg .= "$unit_name : $balqty , ";
	
	
	}
	
	
$html .="
	

	
	</table>
	
	 			

</div>
</div>
	
	
";	
$mpdf->WriteHTML($html);
// $mpdf->Image('barcode/logo/'.$imgname,85,40,15);
// $mpdf->Image('img/news_logo.png', 5, 5, 35, 10, 'png', '', true, false);

$mpdf->SetTitle('SLM Certificate');

// $mpdf->WriteHTML('<div style="width:100%;text-align:center;position:fixed;bottom:65px "><span style="font-family:ind_hi_1_001;  font-size: 12px; font-weight: bold; ">भुगतान करते समय रसीद अवश्य प्राप्त करे | एजेंट- डिकेश्वर वर्मा</span></div>');
// $mpdf->WriteHTML('<div style="width:100%;text-align:center;position:fixed;bottom:52px "><span style="font-family:ind_hi_1_001;  font-size: 10px; font-weight: bold ; ">(फोन पे करने के बाद स्क्रीनशॉट उपर दिए व्हाट्स नंबर पर भेजे| ) </span></div>');	






//==============================================================









$mpdf->Output();

if ($_REQUEST['html']) //{ //echo $html; exit; }
if ($_REQUEST['source']) { 
	$file = __FILE__;
	header("Content-Type: text/plain");
	header("Content-Length: ".filesize($file));
	header("Content-Disposition: attachment; filename='".$file."'");
	readfile($file);
    exit; 
}



//exit;
//==============================================================
?>

<!--<img  src="../uploaded/registration/".$imge width="172px" height="136px"/> -->