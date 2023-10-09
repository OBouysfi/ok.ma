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
		 
	echo LinkTile
	 (
		"jobmail",
		"add",
		$ADD_A_NEW_RULE,
		"",
		"green"
	 );
	
	
	?>

</div>
<div class="clear"></div>
<h3>
	<?php echo $MANAGE_EMAIL_NOTIFICATIONS;?>
</h3>
<br/>
<i>
	<?php echo $LIST_RULES;?>
</i>	
<div class="clearfix"></div>
<br/><br/>
<?php

if(isset($_POST["Delete"])&&isset($_POST["CheckList"])&&sizeof($_POST["CheckList"])>0)
{
	$website->ms_ia($_POST["CheckList"]);
	$database->SQLDelete("rules","id",$_POST["CheckList"]);
}
?>

<?php


if($database->SQLCount("rules","WHERE user='$AuthUserName'") == 0)
{
	echo "<br/>
	
	<i>".$ANY_RULES."</i>
	<br/>
	";
}
else
{
	
	RenderTable
	(
		"rules",
		array("rule","show_category_name","show_location"),
		array($CONTAINING_WORD,$M_CATEGORY,$M_REGION),
		500,
		"WHERE user='".$AuthUserName."'",
		$EFFACER,
		"id",
		"index.php"
	);
}
?>
