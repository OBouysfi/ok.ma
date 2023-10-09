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
			"home",
			"welcome",
			$M_DASHBOARD,
			"",
			"blue"
		 );
	
	?>

</div>
<div class="clear"></div>
<h3>
	<?php echo $M_YOUR_JOB_APPLICATIONS_HISTORY;?>
</h3>
<br/>
<?php

	
if($database->SQLCount("apply","WHERE jobseeker='".$AuthUserName."' ")==0)	
{
	?>
	<br>
			
			<i>
			<?php echo $M_STILL_DIDNT_APPLY;?>
			</i>
			
	<?php
}
else
{

	$QUERY_TO_EXECUTE=
		"
			SELECT 
				a.id as app_id,
				a.date,
				a.jobseeker,
				a.message,
				a.status,
				a.notification,
				a.employer_reply,
				a.guest,
				a.guest_id,
				a.posting_id
			FROM
				".$DBprefix."apply a
			RIGHT JOIN ".$DBprefix."jobs b ON
			(a.posting_id = b.id)
			WHERE a.jobseeker='".$AuthUserName."' 
			ORDER BY app_id DESC
		";
	
	$_REQUEST["arrTDSizes"]=array("70","140","*","80");
	
	RenderTable
	(
		"apply",
		array("date","show_status","employer_reply","AdInfo"),
		array($DATE_MESSAGE,$STATUS,$M_EMPLOYER_REPLY,$M_DETAILS),
		"650",
		"WHERE jobseeker='".$AuthUserName."' ",
		"",
		"id",
		"index.php?category=".$category."&action=".$action,
		false,
		20,
		false,
		-1,
		"",
		$QUERY_TO_EXECUTE
		
	);
}
?>
