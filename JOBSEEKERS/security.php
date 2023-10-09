<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
define("LOGIN_PAGE", "../index.php");
define("SUCCESS_PAGE", "index.php");
define("LOGIN_EXPIRE_AFTER", 20000);
 
if((!isset($_COOKIE["AuthJ"]))||$_COOKIE["AuthJ"]=="")
{
	die("<script>document.location.href=\"".LOGIN_PAGE."?error=expired\";</script>");
}
else
{

	list($cookieUser,$cookiePassword,$cookieExpire)=explode("~",$_COOKIE["AuthJ"]);
	
	$strSelect="SELECT * FROM ".$DBprefix."jobseekers WHERE username='".$database->escape_string($cookieUser)."'";

	$LoginResult=$database->Query($strSelect);
	$AdminUser = $arrUser = $LoginInfo = $database->fetch_array($LoginResult);
	
	if($database->num_rows($LoginResult)==1 && md5($LoginInfo["password"]) == $cookiePassword ) 
	{
		$AuthUserName=$LoginInfo["username"];
		$AuthGroup=$LoginInfo["type"];
	}
	else 
	{
		die("<script>document.location.href=\"".LOGIN_PAGE."?error=login\";</script>");
	}
	
}
?>