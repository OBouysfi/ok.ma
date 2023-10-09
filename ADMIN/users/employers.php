<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?><div class="fright">

<?php
	echo LinkTile
		 (
			"users",
			"new_employer",
			$M_ADD_NEW_EMPLOYER,
			"",
			
			"green"
		 );
?>
</div>
<div class="clear"></div>


<h3><?php echo $M_MANAGE_REGISTERED_EMPLOYERS;?></h3>

<br>

<?php

if(isset($_REQUEST["appr_sub"]))
{
	$website->ms_i($_REQUEST["appr_sub"]);
	$database->Query("UPDATE ".$DBprefix."employers SET subscription=new_subscription WHERE id=".$_REQUEST["appr_sub"]);
}


if(isset($_REQUEST["act"]))
{
	$website->ms_i($_REQUEST["ur"]);
	$website->ms_i($_REQUEST["act"]);
	
	$database->Query("UPDATE ".$DBprefix."employers SET active=".$_REQUEST["act"]." WHERE id=".$_REQUEST["ur"]);
}



if(isset($_REQUEST["Delete"]) && isset($_REQUEST["CheckList"]) && sizeof($_REQUEST["CheckList"]) > 0)
{
	$website->ms_ia($_REQUEST["CheckList"]);
	
	foreach($_REQUEST["CheckList"] as $CheckID)
	{
		$empl = $database->DataArray("employers","id=".$CheckID);
		
		$database->Query("DELETE FROM ".$DBprefix."banners WHERE employer='".$empl["username"]."'");
		$database->Query("DELETE FROM ".$DBprefix."credits WHERE employer='".$empl["username"]."'");
		$database->Query("DELETE FROM ".$DBprefix."courses WHERE employer='".$empl["username"]."'");
		$database->Query("DELETE FROM ".$DBprefix."jobs WHERE employer='".$empl["username"]."'");
		$database->Query("DELETE FROM ".$DBprefix."imported_ads WHERE employer='".$empl["username"]."'");
		
	}
	
	$database->SQLDelete("employers","id",$_REQUEST["CheckList"]);
}

$ORDER_QUERY="ORDER BY id DESC";

$arr_subscriptions = array();
$subscriptions=$database->DataTable("subscriptions","");

while($arr_subscription=$database->fetch_array($subscriptions))
{
	$arr_subscriptions[$arr_subscription["id"]]=stripslashes($arr_subscription["name"]);
}

$_REQUEST["subscriptions"]=$arr_subscriptions;


if($website->GetParam("CHARGE_TYPE")==3)
{
	RenderTable
	(
		"employers",
		array("EditNote","username","company","phone","ShowPictureEmployer","date","ShowActive"),
		array($MODIFY,$M_EMAIL,$M_COMPANY,$M_PHONE,$M_LOGO,$M_DATE,$ACTIVE),
		"100%",
		"",
		$EFFACER,
		"id",
		
		"index.php",
		false,
		20,
		false,
		-1,
		$ORDER_QUERY
	);

}
else
if($website->GetParam("CHARGE_TYPE")==1)
{
	RenderTable
	(
		"employers",
		array("EditNote","username","company","phone","show_subscription","ShowPictureEmployer","date","ShowActive"),
		array($MODIFY,$M_EMAIL,$M_COMPANY,$M_PHONE,$M_SUBSCRIPTION,$M_LOGO,$M_DATE,$ACTIVE),
		"100%",
		"",
		$EFFACER,
		"id",
		
		"index.php",
		false,
		20,
		false,
		-1,
		$ORDER_QUERY
	);

}
else
{
	RenderTable
	(
		"employers",
		array("EditNote","username","company","phone","credits","ShowPictureEmployer","date","ShowActive"),
		array($MODIFY,$M_EMAIL,$M_COMPANY,$M_PHONE,$M_CREDITS,$M_LOGO,$M_DATE,$ACTIVE),
		"100%",
		"",
		$EFFACER,
		"id",
		
		"index.php",
		false,
		20,
		false,
		-1,
		$ORDER_QUERY
	);
}
?>
