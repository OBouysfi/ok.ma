<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php

ob_start();
include("../config.php");
if(!$DEBUG_MODE) error_reporting(0);
define("LOGIN_PAGE", "../index.php");
define("SUCCESS_PAGE", "index.php");
define("LOGIN_EXPIRE_AFTER", 3600*24);
$Email = $_POST["Email"];
$Password = $_POST["Password"];
include("../include/Database.class.php");
$database = new Database();
$database->Connect($DBHost, $DBUser,$DBPass );
$database->SelectDB($DBName);

if($Email == "" || $Password == "") 
{
	die("<script>document.location.href='".LOGIN_PAGE."?error=no".(isset($_REQUEST["lng"])?"&lng=".$_REQUEST["lng"]:"")."';</script>");
}
else
{

	$strSelect="select * from ".$DBprefix."vendors where username='".$database->escape_string($Email)."'";

	$LoginResult= $database->Query($strSelect);
	$LoginInfo = $database->fetch_array($LoginResult);
	
	
	if($database->num_rows($LoginResult)==1 && $LoginInfo["password"] == md5($Password)) 
	{

		$strCookie=$LoginInfo["username"]."~".md5($LoginInfo["password"])."~".(time()+LOGIN_EXPIRE_AFTER);

		setcookie("AuthVendor",$strCookie, time() + 24*3600, "/");

		$database->Query
		("
			INSERT INTO ".$DBprefix."login_log(username,ip,date,action)
			VALUES('".$LoginInfo["username"]."','".$_SERVER["REMOTE_ADDR"]."','".time()."','login')
		");

		die("<script>document.location.href='".SUCCESS_PAGE."".(isset($_REQUEST["lng"])?"?lng=".$_REQUEST["lng"]:"")."';</script>");
		
	}
	else 
	{

		$database->Query
		("
			INSERT INTO ".$DBprefix."login_log(username,ip,date,action,cookie)
			VALUES('".$Email."','".$_SERVER["REMOTE_ADDR"]."','".time()."','error','')
		");

		die("<script>document.location.href='".LOGIN_PAGE."?error=login".(isset($_REQUEST["lng"])?"&lng=".$_REQUEST["lng"]:"")."';</script>");
	}

}

ob_end_flush();
?>