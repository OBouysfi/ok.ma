<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
?><div class="fright">

<?php
	echo LinkTile
		 (
			"users",
			"new_jobseeker",
			$M_ADD_JOBSEEKER,
			"",
			
			"green"
		 );
?>
</div>
<div class="clear"></div>


<h3><?php echo $M_JOBSEEKERS_LIST;?></h3>


<?php
if(isset($_REQUEST["act"]))
{
	$website->ms_i($_REQUEST["ur"]);
	$website->ms_i($_REQUEST["act"]);
	
	$database->Query("UPDATE ".$DBprefix."jobseekers SET active=".$_REQUEST["act"]." WHERE id=".$_REQUEST["ur"]);
}

if(isset($_REQUEST["Delete"]) && isset($_REQUEST["CheckList"]) && sizeof($_REQUEST["CheckList"]) > 0)
{
	$website->ms_ia($_REQUEST["CheckList"]);
	
	foreach($_REQUEST["CheckList"] as $CheckID)
	{
		$jobseeker = $database->DataArray("jobseekers","id=".$CheckID);
		
		$database->Query("DELETE FROM ".$DBprefix."jobseekers_stat WHERE jobseeker='".$jobseeker["username"]."'");
		$database->Query("DELETE FROM ".$DBprefix."jobseeker_resumes WHERE username='".$jobseeker["username"]."'");
		
	}
	
	$database->SQLDelete("jobseekers","id",$_REQUEST["CheckList"]);
}

$ORDER_QUERY="ORDER BY id DESC";

$_REQUEST["arrTDSizes"]=array("40","100","100","100","100","100","100","35","20");

RenderTable
(
	"jobseekers",
	array("EditNote","username","first_name","last_name","phone","ShowPicture","date","ShowCV","ShowActive"),
	array($MODIFY,$NOM_DUTILISATEUR,$FIRST_NAME,$LAST_NAME,$M_PHONE,$M_PICTURE,$M_DATE,$M_CV,$ACTIVE),
	"100%",
	" ",
	$EFFACER,
	"id",
	
	"index.php?category=".$category."&action=".$action,
	false,
	20,
	false,
	-1,
	$ORDER_QUERY
);
?>
