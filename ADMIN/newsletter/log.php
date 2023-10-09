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

if(isset($Delete))
{
	
		SQLDelete("newsletter_log","id",$CheckList);

}
?>

<?php
		$oCol=array("email","date","newsletter_id","status");
		$oNames=array($EMAIL,$DATE_MESSAGE,$NEWSLETTER_ID,$STATUS);

		RenderTable("newsletter_log",$oCol,$oNames,550,"ORDER BY id desc  ","$EFFACER","id","index.php?action=$action&category=".$category);
?>
