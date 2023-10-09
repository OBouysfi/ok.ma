<?php
ob_start();
include("config.php");
if(!$DEBUG_MODE) error_reporting(0);
define("LOGIN_PAGE", "index.php");
define("LOGIN_EXPIRE_AFTER", 3600*24);
$Email = $_POST["Email"];
$Password = $_POST["Password"];
include("include/Database.class.php");
$database = new Database();
$database->Connect($DBHost, $DBUser,$DBPass );
$database->SelectDB($DBName);


if($Email == "" || $Password == "") 
{
	die("<script>document.location.href='".LOGIN_PAGE."?error=no".(isset($_POST["lang"])?"&lang=".$_POST["lang"]:"").(isset($_POST["p"])?"&p=".$_POST["p"]:"")."';</script>");
}
else
{
	
	$subAccount="";

	$strSelectSA="select username,password,employer from ".$DBprefix."sub_accounts where username='".$database->escape_string($Email)."' ";

	$LoginResultSA=$database->Query($strSelectSA);
	$LoginInfoSA = $database->fetch_array($LoginResultSA);
	
	if($database->num_rows($LoginResultSA)>0&&$LoginInfoSA["password"]==$Password) 
	{
		$subAccount=$Email;
		$Email = $LoginInfoSA["employer"];
	}
		
	$strSelect="select username,password from ".$DBprefix."employers where username='".$database->escape_string($Email)."'  AND active=1";
	$LoginResult=$database->Query($strSelect);
	$LoginInfo = $database->fetch_array($LoginResult);
	
	
	if($database->num_rows($LoginResult)>0&&($subAccount!=""||$LoginInfo["password"]==$Password)) 
	{
		$strCookie=$LoginInfo["username"]."~".md5($LoginInfo["password"])."~".(time()+LOGIN_EXPIRE_AFTER."~".($subAccount!=""?$subAccount:""));
		
		setcookie("AuthE",$strCookie);	
			
		$database->Query
		("
			INSERT INTO ".$DBprefix."login_log(username,ip,date,action) 
			VALUES('".($subAccount!=""?($LoginInfo["username"]."/".$subAccount):$subAccount)."','".$_SERVER["REMOTE_ADDR"]."','".time()."','login')
		");
									
		echo "<script>document.location.href='EMPLOYERS/index.php".(isset($_POST["lang"])?"?lng=".$_POST["lang"]:"")."';</script>";		
	}
	else 
	{
	
		$strSelect="select username,password from ".$DBprefix."jobseekers where username='".$database->escape_string($Email)."' AND active=1";
	
		$LoginResult=$database->Query($strSelect);
		$LoginInfo = $database->fetch_array($LoginResult);

		if($database->num_rows($LoginResult)>0&&$LoginInfo["password"]==$Password) 
		{
			$strCookie=$LoginInfo["username"]."~".md5($LoginInfo["password"])."~".(time()+LOGIN_EXPIRE_AFTER);

			setcookie("AuthJ",$strCookie);	
			
			$database->Query
			("
				INSERT INTO ".$DBprefix."login_log(username,ip,date,action) 
				VALUES('".$LoginInfo["username"]."','".$_SERVER["REMOTE_ADDR"]."','".time()."','login')
			");
			

			if(isset($_POST["returnURL"]) && $_POST["returnURL"]!= "")				
			{
				
				echo "<script>document.location.href='".$_POST["returnURL"]."';</script>";					
			}
			else
			{
				echo "<script>document.location.href='JOBSEEKERS/index.php".(isset($_POST["lang"])?"?lng=".$_POST["lang"]:"")."';</script>";					
			}			
			echo "<script>document.location.href='JOBSEEKERS/index.php".(isset($_POST["lang"])?"?lng=".$_POST["lang"]:"")."';</script>";					
			
		}
		else
		{			
			
			$database->Query
			("
				INSERT INTO ".$DBprefix."login_log(username,ip,date,action,cookie) 
				VALUES('".$Email."','".$_SERVER["REMOTE_ADDR"]."','".time()."','error','')
			");

			if(isset($_POST["returnURL"]) && $_POST["returnURL"]!= "")				
			{
				
				echo "<script>document.location.href='".$_POST["returnURL"]."&error=login';</script>";					
			}
			else
			{
				echo "<script>document.location.href='index.php?error=login';</script>";					
			}
		}
		
	}

}
	
	
ob_end_flush();
?>