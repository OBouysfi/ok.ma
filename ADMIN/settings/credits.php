<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><div class="fright">
	<?php
	
	echo LinkTile
	 (
		"settings",
		"payments",
		$M_GO_BACK,
		"",
		
		"red"
	 );
	 
	/*
	echo LinkTile
	 (
		"settings",
		"credits_purchase_history",
		$M_CREDITS_PURCHASE_HISTORY,
		"",
		
		"lila"
	 );
	 */
	?>
</div>
<div class="clear"></div>
 
		 <?php
 if(isset($_REQUEST["ProceedDelete"]))
 {	
	$id=$_REQUEST["id"];
	$website->ms_i($id);
 	
  	$database->SQLQuery("DELETE FROM ".$DBprefix."credits WHERE id=".$id);
 }

?>

<span class="medium-font"><?php echo $M_CR_MANAGEMENT;?></span>
    
	<br><br><br>
	
	<i><?php echo $M_CREDITS_PURCHASE_SETTINGS;?> (<?php echo $M_THE_PRICE_IS;?> <?php echo $website->GetParam("WEBSITE_CURRENCY");?>)</i>
	<br><br><br>
	
	
	<?php
	
	$_REQUEST["message-column-width"]=470;
	EditParams
	(
		"700,701,702,703,704",
		array
		(
			"textbox_4","textbox_4","textbox_4","textbox_4","textbox_4"
		),
		$SAUVEGARDER,
		"<b>".$M_NEW_VALUES_SAVED."</b>"
	);
	
	?>	

<br><br>
		
		<i><?php echo $M_PURCHASED_WAITING;?></i>
	<center>	
	<br>
		<?php

if($database->SQLCount("credits"," WHERE status=0") == 0)
{
?>
		<i><?php echo $M_NO_CREDITS_WAITING;?></i>
		
		
<?php
}
else
{

if(isset($_REQUEST["Delete"]) && isset($_REQUEST["CheckList"]) && sizeof($_REQUEST["CheckList"]) > 0)
{
	
	foreach($_REQUEST["CheckList"] as $CheckId)
	{
		$website->ms_i($CheckId);
		$arrCdts = $database->DataArray("credits","id=".$CheckId);
		$arrAgent = $database->DataArray("employers","username='".$arrCdts["employer"]."'");
	
		$database->SQLUpdate_SingleValue
			(
				"employers",
				"username",
				"'".$arrCdts["employer"]."'",
				"credits",
				$arrCdts["credits"]+$arrAgent["credits"]
			);
			
		$database->SQLUpdate_SingleValue
			(
				"credits",
				"id",
				$CheckId,
				"status",
				"1"
			);
	}
	
}

		RenderTable
		(
			"credits",
			array("employer","credits","amount","payment","ShowFormDelete"),
			array($UTILISATEUR,$M_CREDITS,$M_AMOUNT,$M_PAYMENT,$EFFACER),
			"500",
			" WHERE status=0",
			$M_VALIDATE,
			"id",
			
			"index.php?category=".$category."&action=".$action
);
						
}
?>

</center>

