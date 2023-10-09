<?php
if(!defined('IN_SCRIPT')) die("");
?>
<?php
if(isset($_REQUEST["Delete"])&&isset($_REQUEST["CheckList"]))
{
		SQLDelete("newsletter_categories","id",$_REQUEST["CheckList"]);
}

?>
<br>
<span class="medium-font"><?php echo str_replace("DM","Newsletter",$ADD_DM_CATEGORY);?></span>
		
<br>
<br>
<?php
AddNewForm
(
		array($NOM.":",$DESCRIPTION.":"),
		array("name_en","description_en"),
		array("textbox_50","textarea_37_5"),

		" $AJOUTER ",
		"newsletter_categories",
		$NEW_CATEGORY_ADDED_SUCCESSFULLY
);
?>
<br>
<br><br><br>
<span class="medium-font"><?php echo str_replace("DM","Newsletter",$LIST_AVAILABLE_DM_CAT);?></span>
	<br>	

<br>
<?php

$arrTDSizes = array("50","200","*");

RenderTable
(
	"newsletter_categories",
	array("EditCar","name_en","description_en"),
	array($MODIFY,$NOM,$DESCRIPTION),
	700,
	" ",
	$EFFACER,
	"id",
	"index.php"
);
?>




