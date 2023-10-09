<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");


$id=$_REQUEST["id"];
$website->ms_i($id);
?>
<div class="fright">
<?php
echo LinkTile
	 (
		"site_management",
		"manage",
		$M_GO_BACK,
		"",
		"red"
	 );
?>
</div>

<div class="clear"></div>


<?php



AddEditForm
(
	array($NOM.":",$DESCRIPTION.":",$SUBMIT_BTN.":",$MSG_DISPLAYED.":",$EMAIL_RECEIVE.":"),
	array("name","description","submit","message","email"),
	array(),
	array("textbox_40","textarea_40_4","textbox_40","textarea_40_4","textbox_40"),
	"forms",
	"id",
	$id,
	$M_NEW_VALUES_SAVED,
	"",
	250
);

?>