<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
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
			"users",
			"employers",
			$M_EMPLOYERS,
			"",
			
			"lila"
		 );
		 
		 
		echo LinkTile
		 (
			"users",
			"jobseekers",
			$M_JOBSEEKERS,
			"",
			
			"yellow"
		 );
?>
</div>
<div class="clear"></div>

<h3><?php echo $M_LIST_EXCHANGED_MESSAGES;?></h3>

<?php

if(isset($_REQUEST["Delete"]) && isset($_REQUEST["CheckList"]) && sizeof($_REQUEST["CheckList"]) > 0)
{
	$website->ms_ia($_REQUEST["CheckList"]);
	$database->SQLDelete("user_messages","id",$_REQUEST["CheckList"]);
}

RenderTable
(
	"user_messages",
	array("date","user_from","user_to","subject","message"),
	array($DATE_MESSAGE,$M_FROM,$M_TO,$SUBJECT,$M_MESSAGE),
	"100%",
	"ORDER BY date DESC",
	$EFFACER,
	"id",
	
	"index.php?category=".$category."&action=".$action
);

?>