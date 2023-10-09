<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php 
if(!defined('IN_SCRIPT')) die("");
function current_url() 
{
	$pageURL = 'http://';
	
	$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	
	return $pageURL;
}

$str_current_url=current_url();?>
<a href="http://www.facebook.com/sharer.php?u=<?php echo $str_current_url;?>" target="_blank"><img alt="facebook icon" src="images/facebook_icon.png"/></a>
<a href="http://www.twitter.com/intent/tweet?url=<?php echo $str_current_url;?>" target="_blank"><img alt="twitter icon" src="images/twitter_icon.png" style="margin-left:7px"/></a>
<a href="http://plus.google.com/share?url=<?php echo $str_current_url;?>" target="_blank"><img alt="google plus icon" src="images/google_icon.png" style="margin-left:7px"/></a>
