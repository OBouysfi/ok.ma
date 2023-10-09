<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="fright">

	<?php
		echo LinkTile
		 (
			"jobs",
			"my",
			$M_GO_BACK,
			"",
			"red"
		 );
	?>
</div>
<div class="clear"></div>

<h3 class="no-top-margin"><?php echo $M_ADD_NEW_QUESTION;?></h3>
<br/>
<?php
$job_id=$_REQUEST["id"];


if(isset($_POST["Delete"])&&isset($_POST["CheckList"]))
{
	if(sizeof($_POST["CheckList"])>0)
	{
		$website->ms_ia($_POST["CheckList"]);
		$database->SQLDeletePlus("employer",$AuthUserName,"questionnaire","id",$_POST["CheckList"]);
	}
}

$website->ms_i($job_id);
$arrJob=$database->DataArray("jobs","id=".$job_id);

if($arrJob["employer"]!=$AuthUserName)
{
	die("");
}
$_REQUEST["message-column-width"]=150;


$_REQUEST["arrNames2"]=array("employer","job_id");
$_REQUEST["arrValues2"]=array($AuthUserName,$job_id);

$_REQUEST["strSpecialHiddenFieldsToAdd"]=
'
	<input type="hidden" name="id" value="'.$job_id.'"/>
';
$insertID = AddNewForm
(
	array
	(
		$M_QUESTION.":",
		$M_POSSIBLE_ANSWERS.":"
	),
	array
	(
		"question",
		"answers"
	),
	array
	(
		"textbox_67",
		"textarea_70_4"
	),
	$M_ADD,
	"questionnaire",
	$M_NEW_QUESTION_ADDED,
	false,
	array("","test")
);
?>

<div class="clear"></div>
<br/><br/>
<?php

if($database->SQLCount("questionnaire","WHERE job_id=".$job_id)==0)
{
?>
	<br/>
	<i><?php echo $M_STILL_NO_QUESTIONS;?></i>
	<br/><br/><br/>
<?php
}
else
{
	$_REQUEST["arrTDSizes"] = array("60","*","250");

	RenderTable
	(
		"questionnaire",
		array("EditPosting","question","show_answers"),
		array($MODIFY,$M_QUESTION,$M_POSSIBLE_ANSWERS),
		"100%",
		"WHERE job_id=".$job_id,
		$M_DELETE,
		"id",
		
		"index.php?job_id=5"
	);
}
?>