<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<?php
$id=$_REQUEST["id"];
$website->ms_i($id);
if($database->SQLCount("jobs","WHERE employer='".$AuthUserName."' AND id=".$id." ") == 0)
{
	die("");
}
?>

<div class="row">

<div class="col-md-9">

<h3>
	<?php echo $M_JOB_DETAILS;?>
</h3>
<br/>

<?php
$_REQUEST["message-column-width"]=120;
$_REQUEST["select-width"]=400;
$_REQUEST["HideSubmit"]=true;

  $strJobType="";

foreach($website->GetParam("arrJobTypes") as $arrJobType)
{
	if($arrJobType[0]==0) continue;
	$strJobType.="_".$arrJobType[1]."^".$arrJobType[0];

}

AddEditForm
(
	array
	(
		$M_TITLE.":",
		$M_DESCRIPTION.":",
		$M_CATEGORY.":",
		$M_JOB_TYPE.":",
		
		$M_REGION.":",
		$M_ZIP.":",
	
		$M_SALARY.":",
		$M_DATE_AVAILABLE.":",
		$ACTIVE.":"
	),
	array
	(
		"title",
		"message",
		"job_category",
		
		"job_type",
		
		"region",
		"zip",
		"salary",
		"date_available",
		"active"
	),
	array
	(
		"job_category",
		
		"job_type",
		"title",
		"message",
		"region",
		"zip",
		"salary",
		"date_available",
		"active"
	),
	array
	(
		"combobox_special",
		
		"combobox".$strJobType,
		"textbox_67",
		"textarea_70_10",
		"combobox_region",
		"textbox_5",
		
		"textbox_8",
		"textbox_8",
		"combobox_".$M_YES."^YES_".$M_NO."^NO"
	),
	"jobs",
	"id",
	$id,
	$VALEURS_MODFIEES_SUCCESS
);



?>
<br/>
<a href="index.php?category=jobs&action=my"><?php echo $GO_BACK_TO." <strong>\"".$MY_JOB_ADS."\"</strong>";?></a>

</div>


<div class="col-md-3">

	<?php
		echo LinkTile
		 (
			"jobs",
			"my_edit&id=".$id,
			$MODIFY,
			"",
			"lila"
		 );
		 
		 echo LinkTile
		 (
			"jobs",
			"questionnaire&id=".$id,
			$M_QUESTIONNAIRE." (".$database->SQLCount("questionnaire","WHERE job_id=".$id).")",
			"",
			"blue"
		 );
		 
		 echo LinkTile
		 (
			"jobs",
			"my_stat&id=".$id,
			$M_VISITS." (".$database->SQLCount("jobs_stat","WHERE posting_id=".$id).")",
			"",
			"gray"
		 );
		 
		 echo LinkTile
		 (
			"application_management",
			"list&Proceed=1&id=".$id,
			$M_APPLICATIONS." (".$database->SQLCount("apply","WHERE posting_id=".$id).")",
			"",
			"yellow"
		 );
	?>
</div>
</div>