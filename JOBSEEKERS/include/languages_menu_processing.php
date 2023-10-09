<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php

if(isset($_REQUEST["ProceedChangeLanguage"]))
{
	$language_version=strtolower($_REQUEST["ProceedChangeLanguage"]);
	
	$database->SQLUpdate_SingleValue
	(
		"admin_users",
		"username",
		"'".$AuthUserName."'",
		"bo_lang",
		$language_version
	);
}
else
{

	if(trim($LoginInfo["bo_lang"])!="")
	{
		$language_version = $LoginInfo["bo_lang"];
	}
}


?>