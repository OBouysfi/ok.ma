<?php
define("LOGIN_PAGE", "../index.php");
define("SUCCESS_PAGE", "index.php");
define("LOGIN_EXPIRE_AFTER", 20000);
 
if((!isset($_COOKIE["AuthE"]))||$_COOKIE["AuthE"]=="")
{
	die("<script>document.location.href=\"".LOGIN_PAGE."?error=expired\";</script>");
}
else
{

	list($cookieUser,$cookiePassword,$cookieExpire,$subAccount)=explode("~",$_COOKIE["AuthE"]);
	
	$strSelect="SELECT * FROM ".$DBprefix."employers WHERE username='".$database->escape_string($cookieUser)."'";
		
	$LoginResult=$database->Query($strSelect);
	$AdminUser = $arrUser = $LoginInfo = $database->fetch_array($LoginResult);
	
	if($database->num_rows($LoginResult)==1 && md5($LoginInfo["password"]) == $cookiePassword ) 
	{
		$AuthUserName=$LoginInfo["username"];
		$AuthGroup=$LoginInfo["type"];
		
		if(isset($subAccount))
		{
			$LoginInfo["subAccount"]=$subAccount;
		}
	}
	else 
	{
		die("<script>document.location.href=\"".LOGIN_PAGE."?error=login\";</script>");
	}
	
}
?>