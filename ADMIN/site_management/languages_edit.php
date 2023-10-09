<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
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
					"languages",
					$M_LANGUAGE_VERSIONS,
					$AJOUTER_NOUVEAU_LANGUAGE,
					"yellow"
				 );
		?>
</div>
<div class="clear"></div>
<?php
AddEditForm
(
		array("$LANGUAGE: ","$CODE: ","$ACTIVE: "),
		
	array("name","code","active"),
	array("code"),
	array("textbox_20","textbox_3","combobox_".$M_YES."^1_".$M_NO."^0"),
	"languages",
	"id",
	$id,
	$M_NEW_VALUES_SAVED
);

?>
