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
		"blue"
	 );
	 
	 echo LinkTile
	 (
		"home",
		"modules",
		$M_MODULES,
		$M_LINKS_NEWS_OTHERS,
		"red"
	 );
	 ?>
</div>

<?php
if(isset($_REQUEST["Delete"])&&isset($_REQUEST["CheckList"]))
{
	$database->SQLDelete("image","image_id",$_REQUEST["CheckList"]);
}
?>
<br/><br/>
<span class="medium-font">
<?php echo $ADD_NEW_IMAGE;?>
</span>

<br/><br/><br/><br/>

<?php

$DoNotInsert = true;

AddNewForm
(
	array($IMAGE.":"),
	array("image_id"),
	array("file"),

	" $AJOUTER ",
	"image",
	$IMAGE_ADDED_SUCCESSFULLY
);
?>

<br>

<?php


RenderTable
(
	"image",
	array("image_name","image_date","image_size","image_id"),
	array($NOM,$DATE_MESSAGE,$SIZE,$IMAGE),
	"100%",
	"ORDER BY image_id DESC",
	$EFFACER,
	"image_id",
	"index.php?action=".$action."&category=".$category
);
?>
