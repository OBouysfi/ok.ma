<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
if(isset($_REQUEST["Delete"]) && isset($_REQUEST["CheckList"]) && sizeof($_REQUEST["CheckList"])>0)
{
	foreach($_REQUEST["CheckList"] as $CheckId)
	{
		$arrPayment = $database->DataArray("jobseeker_payments","id=".$CheckId);
		
		if($arrPayment["user"]!="")
		{
		
				
				
				$arrUser = $database->DataArray("jobseekers","username='".$arrPayment["user"]."'");
							
				$arrPackage = $database->DataArray("jobseeker_packages","id=".$arrUser["package"]);
				
				
								$expires_date  = mktime(0, 0, 0, date("m")+$arrPackage["billed"]  , date("d"), date("Y"));
						
								
								SQLUpdate_SingleValue
								(
												"jobseeker_payments",
												"id",
												$CheckId,
												"validated",
												"1"
								);
								
								SQLUpdate_SingleValue
								(
												"jobseekers",
												"username",
												"'".$arrPayment["user"]."'",
												"active",
												"1"
								);
				
				
		}
	}
}
?>

<h3>Validate the bank transfer and cheque payments</h3>
<br/>
<a href="index.php?category=<?php echo $category;?>&folder=payments&page=ipn" style="font-size:11;font-weight:800">[Click here to see the PayPal IPN report]</a>
<br><br>
<a href="index.php?category=<?php echo $category;?>&folder=payments&page=validated" style="font-size:11;font-weight:800">[Click here to see the validated cheque/bank transfer payments]</a>

<br>
<?php

RenderTable
(
	"jobseeker_payments",
	array("date","user","method","amount"),
	array("Date","User","Method","Amount"),
	"100%",
	
	"WHERE user<>'' AND method<>'paypal'  AND validated=0 ORDER BY ID desc",
	"Validate",
	"id",
	"index.php?action=".$action."&category=".$category
);
?>
