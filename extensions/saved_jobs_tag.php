<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
$link_suffix="";

if($MULTI_LANGUAGE_SITE)
{
	$link_suffix="lang=".$this->lang;
}

if(isset($_COOKIE["saved_listings"])&&trim($_COOKIE["saved_listings"])!="")
{

	$items=explode(",",$_COOKIE["saved_listings"]);
?>
	<a href="<?php echo $this->mod_link("saved");?>" class="sub-text underline-link r-margin-15"><?php echo (sizeof($items)-1)." ".$M_SAVED_JOBS;?></a>
<?php
}
?>
