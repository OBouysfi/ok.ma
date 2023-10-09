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
			"documents",
			"list",
			$M_GO_BACK,
			"",
			"red"
		 );
	
	?>

</div>
<div class="clear"></div>	

<?php
$id=$_REQUEST["id"];
$website->ms_i($id);
$arrFile=$database->DataArray("files","file_id=".$id);

if($arrFile["user"]!=$AuthUserName)
{
	die("");
}
?>
<h3><?php echo $FILE.": <strong>".stripslashes($arrFile["file_name"]);?></strong></h3>
<br/>
<?php

$_REQUEST["strSpecialHiddenFieldsToAdd"]="<input type=\"hidden\" name=\"id\" value=\"".$id."\">";
AddEditForm
(
	array($DESCRIPTION.":",$M_CV.":"),
	array("description","is_resume"),
	array(),
	array("textarea_50_6","combobox_special"),
	"files",
	"file_id",
	$id,
	$VALEURS_MODFIEES_SUCCESS
);
	
?>
