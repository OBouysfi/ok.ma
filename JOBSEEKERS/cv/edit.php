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
			"",
			"",
			$M_SAVE,
			"",
			
			"blue",
			"small",
			"true",
			"SavePage"
		 );
		 
		 
		echo LinkTile
		 (
			"cv",
			"description",
			$M_GO_BACK,
			"",
			"red"
		 );
	
	?>

</div>
<div class="clear"></div>


<h3>
	<?php echo $MANAGE_CV;?>
</h3>

<br>
<script>
function SavePage()
{
	var wEditor = new nicEditors.findEditor('cv');
	
	
	wEditor.saveContent();
	
	document.getElementById("EditForm").submit();
	
	return true;
}
</script>
<script src="js/nicEdit.js" type="text/javascript"></script>
<script type="text/javascript">
bkLib.onDomLoaded(function() {
	new nicEditor({buttonList : ['fontSize','bold','italic','forecolor','fontFamily','link','unlink','left','center','right','justify','ol','ul','removeformat','indent','outdent','hr','bgcolor','underline','fontFormat','strikeThrough','subscript','superscript','html'],iconsPath : 'js/nicEditorIcons.gif'}).panelInstance('cv');
});
</script>
<?php

$textAreaWidth = "900px";
$textAreaHeight = "600px";
$MessageTDLength = 0;
$SubmitButtonText=$SAUVEGARDER;
AddEditForm
(
	array(""),
	array("cv"),
	array(),
	array("textarea_100%_30"),
	"jobseekers",
	"id",
	$LoginInfo["id"],
	$LES_VALEURS_MODIFIEES_SUCCES,
	"SavePage",
	120,
	true
);
?>



