<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><div class="fright">
	<?php
	echo LinkTile
	 (
		"users",
		"credits",
		$M_GO_BACK,
		"",
		
		"red"
	 );
	?>
</div>
<div class="clear"></div>

<span class="medium-font">
<?php echo $M_CREDITS_PURCHASE_HISTORY;?>
</span>
	
<br/><br/>
<?php
RenderTable
(
	"ext_credits",
	array("date_start","agent","credits","amount","payment","show_invoice","payment_status"),
	array($DATE_MESSAGE,$M_AGENT,$M_CREDITS,$M_AMOUNT,$M_PAYMENT,$M_INVOICE,$STATUS),
	750,
	"WHERE status=1   ",
	"",
	"id",
	"index.php?category=users&action=credits_purchase_history"
);
?>