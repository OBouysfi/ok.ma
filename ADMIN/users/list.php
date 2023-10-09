<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");

if(isset($_REQUEST["Delete"]))
{
	$database->SQLDelete("jobs","id",$_REQUEST["CheckList"]);
}

$strHighlightIdName = "id";
$arrHighlightIds = array();

$expiredTable = $database->DataTable("jobs", "WHERE expires<".time());

while($arrExpired = $database->fetch_array($expiredTable))
{
	array_push($arrHighlightIds, $arrExpired["id"]);
}


RenderTable
(
	"jobs",
	array("EditCar","date","title","active","notification","featured"),
	array("Modify","Date","Title","Active","Notification","Featured"),
	"100%",
	" ",
	"Delete",
	"id",
	
	"index.php?category=".$category."&action=".$action
);
?>


<i>Note: Expired ads are colored in blue</i>

