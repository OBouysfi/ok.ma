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
			"jobs",
			"questionnaire&id=".$_REQUEST["job_id"],
			$M_GO_BACK,
			"",
			"red"
		 );
	?>
</div>
<div class="clear"></div>
<?php
$id=$_REQUEST["id"];
$website->ms_i($id);
if($database->SQLCount("questionnaire","WHERE employer='".$AuthUserName."' AND id=".$id." ") == 0)
{
	die("");
}
?>


<h3>
	<?php echo $M_MODIFY_QUESTION;?>
</h3>
<br/>



<?php

$_REQUEST["strSpecialHiddenFieldsToAdd"]=
'
	<input type="hidden" name="job_id" value="'.$_REQUEST["job_id"].'"/>
';
	AddEditForm
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
		array(),
		array
		(
			"textbox_67",
			"textarea_70_4"
		),
		"questionnaire",
		"id",
		$id,
		$VALEURS_MODFIEES_SUCCESS
	);

?>
<br/>