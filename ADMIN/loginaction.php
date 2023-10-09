<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
ob_start();
include("../config.php");
if(!$DEBUG_MODE) error_reporting(0);
define("LOGIN_PAGE", "login.php");
define("SUCCESS_PAGE", "index.php");
define("LOGIN_EXPIRE_AFTER", 3600*24);
$Email = $_POST["Email"];
$Password = $_POST["Password"];
include("../include/Database.class.php");
$database = new Database();
$database->Connect($DBHost, $DBUser,$DBPass );
$database->SelectDB($DBName);

include("../config.php");

if($Email == "" || $Password == "") 
{
	die("<script>document.location.href='".LOGIN_PAGE."?error=no1';</script>");
}
else
{

	$strSelect="select * from ".$DBprefix."admin_users where username='".$database->escape_string($Email)."'";
	
	$LoginResult= $database->Query($strSelect);
	$LoginInfo = $database->fetch_array($LoginResult);

	if($database->num_rows($LoginResult)==1 && $LoginInfo["password"] == md5($Password)) 
	{

		$strCookie=$LoginInfo["username"]."~".$LoginInfo["password"]."~".(time()+LOGIN_EXPIRE_AFTER);

		setcookie("Auth",$strCookie);

		$database->Query
		("
			INSERT INTO ".$DBprefix."login_log(username,ip,date,action)
			VALUES('".$LoginInfo["username"]."','".$_SERVER["REMOTE_ADDR"]."','".time()."','login')
		");

		die("<script>document.location.href='".SUCCESS_PAGE."';</script>");
		
	}
	else 
	{

		$database->Query
		("
			INSERT INTO ".$DBprefix."login_log(username,ip,date,action,cookie)
			VALUES('".$Email."','".$_SERVER["REMOTE_ADDR"]."','".time()."','error','')
		");

		die("<script>document.location.href='".LOGIN_PAGE."?error=no2';</script>");
	}

}

ob_end_flush();
?>