<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<script>
function CallBack()
{
	lock_check = false;
	loadPage("#site_management-languages");
	
}

function DeleteLanguage(x,y)
{
	if(confirm("Are you sure that you want to delete this language version of the website?\n\nBe aware that once deleted the language version and all the information associated with it can not be restored!"))
	{
		document.location.href="index.php?category=<?php echo $category;?>&action=languages&Delete="+x+"&ProceedDelete="+y;
	}
}


function ValidateForm(x)
{
 
	if(x.name.value=="")
	{
		x.name.style.background="#edeff3";
		
		document.getElementById("page-header").innerHTML=
		"The language name can't be empty!";
		return false;
	}
	
	if(document.getElementById("code").value=="")
	{
		document.getElementById("code").style.background="#edeff3";
		document.getElementById("page-header").innerHTML=
		"The language code can't be empty!";
		return false;
	}
	
	return true;
}

</script>



<div class="fright">

		
	<?php
	
	echo LinkTile
		 (
			"site_management",
			"languages_add",
			$AJOUTER_NOUVEAU_LANGUAGE,
			"",
			
			"green"
		 );
		 
		?>
		
	
</div>
<div class="clear"></div>

<?php

if(isset($_REQUEST["Delete"])&&isset($_REQUEST["ProceedDelete"]))
{
	$ProceedDelete = $_REQUEST["ProceedDelete"];
	
	$website->ms_w($ProceedDelete);
	
	$Delete = $_REQUEST["Delete"];
	
	$website->ms_i($Delete);
		
	$database->SQLQuery
	(
	"
		ALTER TABLE `".$DBprefix."pages` DROP `active_".strtolower($ProceedDelete)."`,
		DROP `name_".strtolower($ProceedDelete)."` ,
		DROP `link_".strtolower($ProceedDelete)."` ,
		DROP `description_".strtolower($ProceedDelete)."` ,
		DROP `keywords_".strtolower($ProceedDelete)."` ,
		DROP `html_".strtolower($ProceedDelete)."` ,
		DROP `custom_link_".strtolower($ProceedDelete)."` 
	"
	);
	
	$database->SQLDelete("languages","id",array($Delete));
}
else
if(isset($_REQUEST["ProceedChangeDefault"]))
{
	$ID = $_REQUEST["ID"];
	
	$website->ms_i($ID);
	
	$database->SQLQuery("UPDATE ".$DBprefix."languages SET default_language=0");
	$database->SQLQuery("UPDATE ".$DBprefix."languages SET default_language=1 WHERE id=".$ID);
	
}

if(isset($_REQUEST["code"]))
{
	$_REQUEST["code"] = substr(strtoupper($_REQUEST["code"]),0,2);
}
	
	
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



?>

<script>

function RadioClick(languageID)
{
	document.location.href="index.php?action=<?php echo $action;?>&category=<?php echo $category;?>&ProceedChangeDefault=&ID="+languageID;
}

</script>


<div class="fright">

	<?php
			
		
		?>
		
	
</div>


<br/>

<br/>
<br/>

<div id="header-message" class="medium-font">		
	<?php echo $LISTE_LANGUAGES;?>
</div>


<?php
RenderTable
(
	"languages",
	array("ShowSpecialLanguage","DeleteLanguage","ChangeLanguage","name","code","active"),
	array($PRINCIPAL,$EFFACER,$MODIFIER,$LANGUAGE,$CODE,$ACTIVE),
	550,
	"",
	"",
	"id",
	"index.php"
);
?>