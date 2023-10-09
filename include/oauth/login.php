<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
session_start();
error_reporting(0);
include("../../jobs_config.php");
function LoadParams(){ global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix; $arrResult=array(); mysql_connect($DBHost,$DBUser,$DBPass); mysql_select_db($DBName); $strQuery="select id,value from ".$DBprefix."settings"; $oDataTable=mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error()); while($oRow=mysql_fetch_array($oDataTable)){ $arrResult[$oRow["id"]]=$oRow["value"]; } mysql_close(); return $arrResult;}
$admin_params = LoadParams();
$LINKEDIN_API_KEY=$admin_params[450];
$LINKEDIN_SECRET=$admin_params[451];
if($admin_params[421]=="YES") 
	$USE_MOD_REWRITE = true;
else
	$USE_MOD_REWRITE = false;
	

$config['base_url']             =   "http://www.".$DOMAIN_NAME.'/include/oauth/login.php';
$config['callback_url']         =   "http://www.".$DOMAIN_NAME.'/index.php?mod=linkedin_signup';
$config['linkedin_access']      =   $LINKEDIN_API_KEY;
$config['linkedin_secret']      =   $LINKEDIN_SECRET;
include_once "linkedin.php";
$linkedin = new LinkedIn($config['linkedin_access'], $config['linkedin_secret'], $config['callback_url'] );
$linkedin->debug = false;
$linkedin->getRequestToken();
$_SESSION['requestToken'] = serialize($linkedin->request_token);

header("Location: " . $linkedin->generateAuthorizeUrl());
?>