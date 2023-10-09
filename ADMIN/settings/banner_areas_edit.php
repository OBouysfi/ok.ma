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
		"banner_areas",
		$M_GO_BACK,
		"",
		
		"red"
	 );

		?>
</div>
<div class="clear"></div>
<?php

$id = $_REQUEST["id"];
$website->ms_i($id);
?>

<span class="medium-font"><?php echo $M_MODIFY_BANNER_AREA;?> #<?php echo $id;?></span>
	
<br/><br/><br/>

<?php

$_REQUEST["message-column-width"] = 130;

AddEditForm
(
		array("$NOM:","$M_DESCRIPTION:",$M_POSITION.":","$M_ROWS:","$M_COLUMNS:","$M_BANNER_WIDTH:","$M_BANNER_HEIGHT:","$M_BANNER_PRICE:","$M_BANNER_DAYS_VALID:"),
		array("name","description","position","rows","cols","width","height","price","days"),
		array(),
		array("textbox_50","textarea_40_5","combobox_Side Column_Top_Bottom","textbox_5","textbox_5","textbox_5","textbox_5","textbox_5","textbox_5"),

		"banner_areas",
		"id",
		$id,
		$M_BANNER_AREA_MODIFIED
);
?>

