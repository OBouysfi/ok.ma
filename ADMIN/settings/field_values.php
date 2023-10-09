<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!isset($iKEY)||$iKEY!="AZ8007") die("ACCESS DENIED");
?>
<div class="fright">
	<?php
		

		
	echo LinkTile
	(
		"settings",
		"options",
		$M_CONFIGURATION_OPTIONS,
		"",
		"blue"
	);
?>
</div>
<div class="clear"></div>
<span class="medium-font">
<?php echo $M_FIELD_VALUES;?>
</span>
<br/>
<br/>
<br/>
		
<?php

$_REQUEST["message-column-width"]="240";
$_REQUEST["select-width"]="200";

$values_list="900,901,902,903,904,905,906";


	EditParams
	(
		$values_list,
		array
		(
			
			"textbox_80",
			"textbox_80",
			"textbox_80",			
			"textbox_80",
			"textbox_80",
			"textbox_80",
			"textbox_80"
		),
			$M_SAVE,
			$M_NEW_VALUES_SAVED
	);

?>
		
		
	<br>

