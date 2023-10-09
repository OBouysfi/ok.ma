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
					"languages",
					$M_GO_BACK,
					"",
					
					"red"
				 );
		?>
</div>
<div class="clear"></div>

<span id="page-header" class="medium-font">
<?php echo $AJOUTER_NOUVEAU_LANGUAGE;?>
</span>


<br/><br/><br/>
<?php
$arrExamples = array(" ex. \"Deutsch\""," ex. \"DE\"");


if(isset($_REQUEST["SpecialProcessAddForm"]))
{

	$code = substr(strtoupper($_REQUEST["code"]),0,2);
	
	$website->ms_w($code);
	
	$database->SQLQuery
	(
	"
		ALTER TABLE `".$DBprefix."pages` ADD `active_".strtolower($code)."` TINYINT NOT NULL ,
		ADD `name_".strtolower($code)."` VARCHAR( 255 ) NOT NULL ,
		ADD `link_".strtolower($code)."` VARCHAR( 255 ) NOT NULL ,
		ADD `description_".strtolower($code)."` TEXT NOT NULL ,
		ADD `keywords_".strtolower($code)."` TEXT NOT NULL ,
		ADD `html_".strtolower($code)."` TEXT NOT NULL ,
		ADD `custom_link_".strtolower($code)."` TEXT NOT NULL
	"
	);
	
	$database->SQLQuery("UPDATE
		".$DBprefix."pages 
 		SET active_".strtolower($code)."=active_en,
		name_".strtolower($code)."=name_en,
		link_".strtolower($code)."=link_en,
		description_".strtolower($code)."=description_en,
		keywords_".strtolower($code)."=keywords_en,
		html_".strtolower($code)."=html_en,
		custom_link_".strtolower($code)."=custom_link_en");
	
}



AddNewForm
(
	array($LANGUAGE.": ",$CODE.": ",$ACTIVE.": "),
	array("name","code","active"),
	array("textbox_30","textbox_6","combobox_$M_YES^1_$M_NO^0"),
	$AJOUTER,
	"languages",
	$AJOUTER_SUCCES,
	true,
	$arrExamples
);

?>

<br/>
<br/>