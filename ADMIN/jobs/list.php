<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="fright">

	<?php
			echo LinkTile
				 (
					"jobs",
					"add",
					$M_NEW_JOB_AD,
					"",
					
					"green"
				 );
		?>
</div>
<div class="clear"></div>


<h3><?php echo $M_MANAGE_JOB_ADS;?></h3>


<?php
if(isset($_REQUEST["act"]))
{
	$website->ms_i($_REQUEST["ur"]);
	$website->ms_i($_REQUEST["act"]);
	
	$database->Query("UPDATE ".$DBprefix."jobs SET status=".$_REQUEST["act"]." WHERE id=".$_REQUEST["ur"]);
}

if(isset($_REQUEST["renew"])&&isset($_REQUEST["id"]))
{
	$website->ms_i($_REQUEST["id"]);
	$database->SQLUpdate("jobs",array("expires"),array((time()+$website->GetParam("ADS_EXPIRE")*86400)),"id=".$_REQUEST["id"]);
	?>
	<span class="medium-font">
	The job with id #<?php echo $_REQUEST["id"];?> was renewed successfully!
	</span>
	<br/>
	<?php
}


if(isset($_REQUEST["Delete"]) && isset($_REQUEST["CheckList"]) && sizeof($_REQUEST["CheckList"]) > 0)
{
	$website->ms_ia($_REQUEST["CheckList"]);
	$database->SQLDelete("jobs","id",$_REQUEST["CheckList"]);
}

$strHighlightIdName = "id";
$arrHighlightIds = array();

$expiredTable = $database->DataTable("jobs", "WHERE expires<".time());

while($arrExpired = $database->fetch_array($expiredTable))
{
	array_push($arrHighlightIds, $arrExpired["id"]);
}

$_REQUEST["arrTDSizes"]=array("70","40","100","100","*","120","200","40");

RenderTable
(
	"jobs",
	array("EditNote","ShowRenew","date","expires","title","show_category_name","employer","_status"),
	array($MODIFY,$M_RENEW,$DATE_MESSAGE,"Expires",$M_TITLE,$M_CATEGORY,$M_EMPLOYER,$ACTIVE),
	"100%",
	" ORDER BY id DESC ",
	$EFFACER,
	"id",
	
	"index.php?category=".$category."&action=".$action
);
?>

<div class="clearfix"></div>
<br/><br/>
<!--
<i><?php echo $M_NOTE_EXPIRED;?></i>
	-->
