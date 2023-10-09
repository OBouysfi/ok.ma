<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><div class="fright">
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


<script>

function ValidateForm(x)
{
	
	return true;
	
}
function CallBack()
{

	document.getElementById("page-header").innerHTML
	= "<?php echo $M_NEW_AREA_ADDED;?>";

	loadPage("#settings-banner_areas");
}
</script>
<span class="medium-font" id="page-header"><?php echo $M_ADD_NEW_AREA;?></span>
<br/>	<br/>	
<?php

$_REQUEST["message-column-width"] = 120;

AddNewForm
(
		array($NOM.":",$DESCRIPTION.":",$M_POSITION.":",$M_ROWS.":",$M_COLUMNS.":","$M_BANNER_WIDTH:","$M_BANNER_HEIGHT:","$M_BANNER_PRICE:","$M_BANNER_DAYS_VALID:"),
		array("name","description","position","rows","cols","width","height","price","days"),
		array("textbox_54","textarea_40_5","combobox_Side Column_Top_Bottom","textbox_5","textbox_5","textbox_5","textbox_5","textbox_5","textbox_5"),

		" $AJOUTER ",
		"banner_areas",
		$M_NEW_AREA_ADDED
		
);
?>


<br>
