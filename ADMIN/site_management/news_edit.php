<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
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
		"news",
		$M_GO_BACK,
		"",
		"red"
	 );
?>
</div>
<div class="clear"></div>
<script>

function SubmitNewsForm(x)
{
	var wEditor = new nicEditors.findEditor('html');
	
	
	wEditor.saveContent();
	
	return true;
}
</script>

<script src="js/nicEdit.js" type="text/javascript"></script>
<script type="text/javascript">
bkLib.onDomLoaded(function() {
	new nicEditor({buttonList : ['fontSize','bold','italic','forecolor','fontFamily','link','unlink','left','center','right','justify','ol','ul','removeformat','indent','outdent','hr','bgcolor','underline','html'],iconsPath : 'js/nicEditorIcons.gif'}).panelInstance('html');
});
</script>
<?php
$id=$_REQUEST["id"];
$website->ms_i($id);
$SubmitButtonText = $M_SAVE;

AddEditForm
(
	array($M_TITLE,$M_CONTENT,$ACTIVE),
	array("title","html","active"),
	array(),
	array("textbox_60","textarea_90_12","combobox_YES_NO"),
	"news",
	"id",
	$id,
	$M_NEW_VALUES_SAVED,
	"SubmitNewsForm"
);
?>



