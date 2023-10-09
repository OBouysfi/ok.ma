<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
define("LOGIN_PAGE", "login.php");
define("SUCCESS_PAGE", "index.php");
define("LOGIN_EXPIRE_AFTER", 20000);
 

if((!isset($_COOKIE["Auth"]))||$_COOKIE["Auth"]=="")
{
	die("<script>document.location.href=\"".LOGIN_PAGE."?error=expired\";</script>");
}
else
{
	list($cookieUser,$cookiePassword,$cookieExpire)=explode("~",$_COOKIE["Auth"]);
	
	if($cookieExpire<time())
	{
		die("<script>document.location.href=\"".LOGIN_PAGE."?error=expired\";</script>");

	}
	else
	{
			$strSelect="SELECT * FROM ".$DBprefix."admin_users WHERE username='".$database->escape_string($cookieUser)."'";
				
			$LoginResult=$database->Query($strSelect);
			$AdminUser = $LoginInfo = $database->fetch_array($LoginResult);
				
			if($database->num_rows($LoginResult)==1 && $LoginInfo["password"] == $cookiePassword ) 
			{
				$AuthUserName=$LoginInfo["username"];
				$AuthGroup=$LoginInfo["type"];
			}
			else 
			{
				die("<script>document.location.href=\"".LOGIN_PAGE."?error=login\";</script>");
			}
		
	}
}

?>