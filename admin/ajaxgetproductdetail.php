<?php
include("dbconnect.php");

$item_id=trim(addslashes($_REQUEST['item_id']));

$process=trim(addslashes($_REQUEST['process']));





	if($item_id !='')

	{
		$itemrate=$cmn->getvalfield($connection,"item_master","itemrate","item_id='$item_id'");

		$unit_id =$cmn->getvalfield($connection,"item_master","unit_id","item_id='$item_id'");		

		echo $unitname=$cmn->getvalfield($connection,"m_unit","unitname","unit_id='$unit_id'");

	//	$tax_id=$cmn->getvalfield($connection,"item_master","tax_id","item_id='$item_id'");

	//	$tax=$cmn->getvalfield($connection,"m_tax","tax","tax_id='$tax_id'");
		$stock = $cmn->getstock($connection,$item_id);
		
		$lastissueno = $cmn->getvalfield($connection,"issueentrydetail as A left join issueentry as B on A.issueid = B.issueid","B.issuno","A.item_id='$item_id' order by issuedetailid desc");
		$lastissuedate= $cmn->dateformatindia($cmn->getvalfield($connection,"issueentrydetail as A left join issueentry as B on A.issueid = B.issueid","B.issudate","A.item_id='$item_id' order by issuedetailid desc"));

		echo $unitname."|".$itemrate."|".$stock."|".$lastissueno."|".$lastissuedate;

			

	}

	?>

