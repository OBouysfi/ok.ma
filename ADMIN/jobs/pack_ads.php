<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<table summary="" border="0" width="100%">
	<tr>
		<td width="41">
		<img src="images/icons2/reports.gif" width="39" height="40" alt="" border="0">
		</td>
		<td>
		
		<b>
		<?php echo $M_ADD_NEW_PACKAGE;?>
		</b>
		
		</td>
	</tr>
</table>
<br>

<?php

AddNewForm(

		array("$M_ADS_NUM:","$M_VALID_DAYS:","$M_PRICE_CREDITS:","$ACTIVE:"),
		array("ads","valid","price","active"),
						
		array
		(
		"textbox_4",
		"textbox_4",
		"textbox_4",
		"combobox_YES_NO"
		),
		"$AJOUTER",
		"packages",
		$M_NEW_PACKAGE_ADDED_SUCC
	);
?>
<br><br>
<table summary="" border="0" width="100%">
	<tr>
		<td>
		<b>
		<?php echo $M_LIST_AV_PACKAGES;?>
		</b>
		</td>
	</tr>
</table>
<br>
<?php

if(isset($_REQUEST["Delete"]) && isset($_REQUEST["CheckList"]) &&sizeof($_REQUEST["CheckList"]) > 0)
{
		$website->ms_ia($_REQUEST["CheckList"]);
		$database->SQLDelete("packages","id",$_REQUEST["CheckList"]);
}
?>

<?php

	

 RenderTable(
						"packages",
						array("EditCar","ads","valid","price","active"),
						array($MODIFY,$M_ADS_NUM,$M_VALID_DAYS,$M_PRICE,$ACTIVE),
						
						700,
						"",
						$EFFACER,
						"id",
						"index.php?category=$category&action=$action"
						);
?>
