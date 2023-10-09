<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<?php
$id=$_REQUEST["id"];
$website->ms_i($id);

if(isset($_REQUEST["posting_id"]))
{
$posting_id=$_REQUEST["posting_id"];
$website->ms_i($posting_id);
?>
<div class="fright">
	<?php
	
	
	echo LinkTile
	 (
		"application_management",
		"list-id=".$posting_id."-Proceed=1",
		$M_GO_BACK,
		"",
		"red"
	 );
?>
</div>
<div class="clear"></div>
<?php
}
?>
<h3>
	<?php 
		echo $M_APPROVE_JOBSEEKER_APPLICATION;
	?>
</h3>

<?php



$SubmitButtonText = $SAUVEGARDER;

$_REQUEST["arrNames2"] = array("status");
$_REQUEST["arrValues2"] = array("1");


AddEditForm
	(
		array($M_REASON.":"),
		array("employer_reply"),
		array(),
		array("textarea_40_5"),
		"apply",
		"id",
		$id,
		"<script>document.location.href='index.php?category=application_management&action=approved'</script>"
	);
	



?>
<br><br>
