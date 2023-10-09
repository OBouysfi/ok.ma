<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>


<div class="fright">

	<?php
		echo LinkTile
	 (
		"site_management",
		"pages_pro",
		$H_WEBSITE,
		$M_WEBSITE_MANAGEMENT,
		"lila"
	 );
		?>
		
	
</div>
<div class="clear"></div>

<?php
EditParams
(
	"333",
	array("textarea_60_6"),
	$M_SAVE,
	$M_NEW_VALUES_SAVED
);
	
?>
<br>
