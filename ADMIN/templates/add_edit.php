<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<br><br>
<?php
AddEditForm
	(
	array($ID_MESSAGE,$NOM,$DESCRIPTION,"HTML"),
	array("id","name","description","html"),
	array("id"),
	array("textbox_5","textbox_20","textbox_60","textarea_60_10"),
	"templates",
	"id",
	$id,
	$TEMPLATE_MODIFIE_SUCCES
	);
	
?>
<br>
<?php
generateBackLink("add");
?>