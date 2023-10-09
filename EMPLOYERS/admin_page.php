<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
define("IN_SCRIPT","1");
$is_mobile=false;
include("../config.php");
if(!$DEBUG_MODE) error_reporting(0);
include("../include/SiteManager.class.php");
include("../include/Database.class.php");
$website = new SiteManager();
$website->isAdminPanel = true;
$database = new Database();
$database->Connect($DBHost, $DBUser,$DBPass );
$database->SelectDB($DBName);
$website->SetDatabase($database);
include("security.php");
$website->LoadSettings();

include("include/AdminUser.class.php");
if(!isset($AuthUserName) || !isset($AuthGroup)) $website->ForceLogin();
$currentUser = new AdminUser($AuthUserName, $AuthGroup);
$currentUser->LoadPermissions();
$lang = $currentUser->GetLanguage();


if(file_exists("../ADMIN/texts_".$lang.".php"))
{
	include("../ADMIN/texts_".$lang.".php");
}
else
{
	include("../ADMIN/texts_en.php");
}
include("../include/texts_".$lang.".php");

		
include("include/page_functions.php");
include("include/AdminPage.class.php");
$currentPage = new AdminPage();
$output_html = $currentPage->GetHTML();

if(isset($_REQUEST["ajax_load"]))
{
	echo $output_html;
	echo "<script>parent.CallBack();</script>";
}
else
if(isset($_REQUEST["ajax_call"]))
{
	echo "<script>parent.CallBack();</script>";
}
else
{
	echo $output_html;
}

?>