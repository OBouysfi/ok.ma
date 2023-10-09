<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?>

<h3><?php echo $M_PAYMENTS;?> - <?php echo $M_SETTINGS;?></h3>

<hr/>

<div class="fright">
	<?php
			 
	echo LinkTile
	 (
		"settings",
		"subscriptions",
		$M_SUBSCRIPTIONS,
		"",
		"blue"
	 );
	?>
<div class="clearfix"></div>
<?php	
	 echo LinkTile
	 (
		"settings",
		"credits",
		$M_CREDITS,
		"",
		"lila"
	 );
?>
<div class="clearfix"></div>
<?php	
	 echo LinkTile
	 (
		"settings",
		"direct_payments",
		$M_DIRECT_PAYMENTS,
		"",
		"yellow"
	 );
?>
</div>


<form action="index.php" method="post">
<input type="hidden" name="ProceedSave" value="1"/>
<input type="hidden" name="category" value="settings"/>
<input type="hidden" name="action" value="payments"/>
<?php

if(isset($_REQUEST["ProceedSave"]))
{
	$charge_type=$_REQUEST["charge_type"];
	$website->ms_i($charge_type);
	$database->SetParameter(899, $charge_type);
}
else
{
	$charge_type=$website->GetParam("CHARGE_TYPE");
}
?>
<br/>
<h4><?php echo $M_HOW_TO_CHARGE_EMPLOYERS;?></h4>

<input class="margin-top-8" type="radio" <?php if($charge_type==0) echo "checked";?> name="charge_type" value="0"/>
<?php echo $M_SITE_FREE;?>
<br/>
<input class="margin-top-8" type="radio" <?php if($charge_type==1) echo "checked";?> name="charge_type" value="1"/>
<a class="underline-link" href="index.php?category=settings&action=subscriptions"><?php echo $M_USING_SUBSCRIPTIONS;?></a>
<br/>
<input class="margin-top-8" type="radio" <?php if($charge_type==2) echo "checked";?> name="charge_type" value="2"/>
<a class="underline-link" href="index.php?category=settings&action=credits"><?php echo $M_USING_CREDITS;?></a>
<br/>
<input class="margin-top-8" type="radio" <?php if($charge_type==3) echo "checked";?> name="charge_type" value="3"/>
<a class="underline-link" href="index.php?category=settings&action=direct_payments"><?php echo $M_DIRECT_PAYMENTS;?></a>

<br/><br/>
<input type="submit" class="btn btn-primary" value="<?php echo $M_SAVE;?>"/>

</form>
<br/><br/><br/>
<h4><?php echo $M_PAYMENT_GATEWAY;?></h4>
<br/>
<?php




$values_list="112,113";

for($k=116;$k<=128;$k++)
{
	if($values_list!="") $values_list.=",";
	$values_list .= $k;
}

$values_list.=",437,438";

EditParams
	(
		$values_list,
		array
		(
			"textbox_10",
			"textbox_10",
			"textbox_40",
			"textbox_40",
			"textarea_53_4",
			
			"textarea_53_4",
			"textbox_40",
			"textbox_40",
			"textbox_40",
			"textbox_40",
			"textbox_40",
			"textbox_40",
			"textbox_40",			
			"textbox_40",
			"textbox_40",
			"textbox_40",
			"textbox_40"
		),
			$M_SAVE,
			$M_NEW_VALUES_SAVED
	);

?>
