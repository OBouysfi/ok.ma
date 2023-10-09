<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
$oLinkTexts=array($M_HOME,$M_PROFILE2,$M_MY_LISTINGS,$M_APPLICATIONS,$M_JOBSEEKERS);
$oLinkActions=array("home","profile","jobs","application_management","jobseekers");

$profile_oLinkTexts=array($M_VIEW,$M_EDIT,$M_LOGO,$M_VIDEO_PRESENTATION);
$profile_oLinkActions=array("current","edit","logo","video");

$application_management_oLinkTexts=array($JOBSEEKERS_APPLIED,$M_APPROVED_APPLICATIONS,$M_REJECTED_APPLICATIONS);
$application_management_oLinkActions=array("list","approved","rejected");

// $jobs_oLinkTexts=array($M_NEW_JOB,$MY_JOB_ADS,$M_COURSES,$M_BANNERS,$EXPIRED_ADS);
$jobs_oLinkTexts=array($M_NEW_JOB,$MY_JOB_ADS,$EXPIRED_ADS);
$jobs_oLinkActions=array("add","my","expired_ads");
// $jobs_oLinkActions=array("add","my","courses","banners","expired_ads");

$jobseekers_oLinkTexts=array($SEARCH,$M_BROWSE);
$jobseekers_oLinkActions=array("search","list");

if($website->GetParam("CHARGE_TYPE")==0||$website->GetParam("CHARGE_TYPE")==3)
{
	// $home_oLinkTexts=array($M_WELCOME,$M_SUB_ACCOUNTS,$M_CHANGE_PASSWORD,$M_MESSAGES2);
	$home_oLinkTexts=array($M_CHANGE_PASSWORD,$M_MESSAGES2);
	// $home_oLinkActions=array("welcome","sub_accounts","password","received");
	$home_oLinkActions=array("password","received");
}
else
{
	// $home_oLinkTexts=array($M_WELCOME,($website->GetParam("CHARGE_TYPE")==2?$M_CREDITS:$M_SUBSCRIPTIONS),$M_SUB_ACCOUNTS,$M_CHANGE_PASSWORD,$M_MESSAGES2);
	$home_oLinkTexts=array(($website->GetParam("CHARGE_TYPE")==2?$M_CREDITS:$M_SUBSCRIPTIONS),$M_CHANGE_PASSWORD,$M_MESSAGES2);
	$home_oLinkActions=array("credits","password","received");
}

$exit_oLinkTexts=array($M_THANK_YOU);
$exit_oLinkActions=array("exit");
?>