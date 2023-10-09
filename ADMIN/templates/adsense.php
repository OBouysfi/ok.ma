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
	
	
</div>

<span class="medium-font">
<?php echo $M_CONFIGURATION_OPTIONS;?>
</span>
<br/>
<br/>
<br/>
		
<?php

$_REQUEST["message-column-width"]="240";
$_REQUEST["select-width"]="200";

$values_list="190,191,192,193";

	EditParams
	(
		$values_list,
		array
		(
			"textarea_53_5",
			"textarea_53_5",
			"textarea_53_5",
			"textarea_53_5"
			
		),
			$M_SAVE,
			$M_NEW_VALUES_SAVED
	);

?>
		
		
	<br>

