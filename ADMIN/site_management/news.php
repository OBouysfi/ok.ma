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
<span class="medium-font"><?php echo $M_ADD_NEWS;?></span>

<br/><br/>
<script>

function SubmitNewsForm()
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

$_REQUEST["arrNames2"]=array("date");
$_REQUEST["arrValues2"]=array(time());

AddNewForm
(
		array($M_TITLE.":",$M_CONTENT.":","Active"),
		
		array("title","html","active"),

		array("textbox_60","textarea_90_12","combobox_YES_NO"),

		$AJOUTER,
		"news",
		"The news has been added successfully!",
		false,
		array(),
		"SubmitNewsForm"
	);
?>









<?php

if(isset($_REQUEST["Delete"])&&isset($_REQUEST["CheckList"]))
{
	
	$database->SQLDelete("news","id",$_REQUEST["CheckList"]);
	
}

?>

<br/>
<br/>
<br/>
<span class="medium-font">
<?php echo $M_LIST_CURRENT_NEWS;?>
</span>

<br/>	

<?php

$arrTDSizes=array("50","50","*");

$tableNotes = $database->DataTable("news","WHERE active='NO'");
$strHighlightIdName="id";
$arrHighlightIds=array();

while($arrNote = $database->fetch_array($tableNotes))
{
	array_push($arrHighlightIds,$arrNote["id"]);
}


RenderTable
(
	"news",
	array("EditNote","date","title"),
	array($MODIFY,$DATE_MESSAGE,$M_TITLE),
	700,
	
	(isset($order_type)?"":"ORDER BY id DESC"),
	$EFFACER,
	"id",
	"index.php"
);
?>
