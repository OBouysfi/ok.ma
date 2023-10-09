<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?>
<div class="fright">

	<?php
echo LinkTile
	 (
		"settings",
		"subscriptions",
		$M_GO_BACK,
		$M_GO_BACK_PACKS,
		
		"red"
	 );
	 
	 
$id=$_REQUEST["id"];
$website->ms_i($id);

?>
</div>
<div class="clear"></div>
<br/>
<span class="medium-font">
	<?php echo $M_MODIFY_PACKAGE_ID;?> 
	#<?php echo $id;?>
</span>
<br/>
<br/>
<?php

AddEditForm
(
		array
		(
			$NOM.":",
			$M_DESCRIPTION.":",
			$M_MAX_LISTINGS.":",
			$M_MAX_FEATURED_LISTINGS.":",
			$M_MAX_BANNERS.":",
			
			$M_PRICE.":",
			$M_BILLED_MONTHS.":",
		
		
			$M_PAYMENT_CODE
),
array
(
			"name",
			"description",
			"listings",
			"featured_listings",
			"banners",
			"price",
			"billed",
			
		
			"html"
		),
		array()
		,
		array
		(
			"textbox_50",
			"textarea_50_3",
			"textbox_5",
			"textbox_5",
			"textbox_5",
			
			"textbox_5",
			"combobox_1_3_6_12_24",
		
			"textarea_50_3"
		),
	"subscriptions",
	"id",
	$id,
	$M_NEW_VALUES_SAVED,
	"",
	"210"
);
	
?>
<br>

