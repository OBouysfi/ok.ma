<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
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
	 
	?>
</div>
<div class="clear"></div>
 
<span class="medium-font"><?php echo $M_SERVICE_PRICE_MANAGEMENT;?></span>
    
	<br><br><br>
	
	<?php
	
	$_REQUEST["message-column-width"]=200;
	EditParams
	(
		"710,711,712",
		array
		(
			"textbox_4","textbox_4","textbox_4"
		),
		$SAUVEGARDER,
		"<b>".$M_NEW_VALUES_SAVED."</b>"
	);
	
	?>	

<br><br>
		
	
