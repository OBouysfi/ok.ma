<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
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
		"links_directory",
		"reviews",
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
$_REQUEST["default_text"]=$M_ALL_CATEGORIES;
$_REQUEST["select-width"]="220";
$_REQUEST["message-column-width"]="190";
AddEditForm
(
	array
	(
		"Title:",
	
		$DESCRIPTION.":",
		"User:"
	),
	array
	(
		"title",
		"html",
		"author"
	),
	array(),
	array
	(
		"textbox_60",
		"textarea_80_6",
		"textbox_60"
		
	),
	"company_reviews",
	"id",
	$id,
	$M_NEW_VALUES_SAVED
);
	
?>
<br>

