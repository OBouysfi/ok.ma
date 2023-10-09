<?php
ob_start();
require("config.php");
if(!$DEBUG_MODE) error_reporting(0);
require("include/SiteManager.class.php");
include("include/Database.class.php");

/// Initialization of the site manager and database objects
$database = new Database();

/// Connect to the website database
$database->Connect($DBHost, $DBUser,$DBPass );
$database->SelectDB($DBName);
$website = new SiteManager();
$website->SetDatabase($database);


/// Loading the website default settings
$website->LoadSettings();

define("LOGIN_EXPIRE_AFTER", 86400);

$id=$_GET["id"];
$website->ms_w($id);

if($database->SQLCount_Query("SELECT * FROM ".$DBprefix."jobseekers WHERE code='$id'  ") == 1)
{
	$arrUser = $database->DataArray("jobseekers","code='$id' ");
	
	$database->SQLUpdate_SingleValue
		(
			"jobseekers",
			"id",
			$arrUser["id"],
			"active",
			"1"
		);
		
	$database->SQLUpdate_SingleValue
		(
			"jobseekers",
			"id",
			$arrUser["id"],
			"code",
			$arrUser["code"]."_VALIDATED"
		);
		
	$strCookie = $arrUser["username"]."~".md5($arrUser["password"])."~".(time()+14400);
		
	setcookie("AuthJ",$strCookie);	
		
	$database->SQLInsert(
						"login_log",
						array("username","ip","date","action","cookie"),
						array($arrUser["username"],$_SERVER["REMOTE_ADDR"],time(),'login',$strCookie)
					);
								
	 
	 echo "
	 	<script>
			alert('Thank you! Your account has been activated successfully!');
			document.location.href='JOBSEEKERS/index.php';
		</script>
	 ";

}
else
if($database->SQLCount_Query("SELECT * FROM ".$DBprefix."jobseekers WHERE code='".$id."_VALIDATED'  ") == 1)
{
	$arrUser = $database->DataArray("jobseekers","code='".$id."_VALIDATED' ");
		
	$strCookie = $arrUser["username"]."~".md5($arrUser["password"])."~".(time()+14400);
		
	setcookie("AuthJ",$strCookie);	
		
	$database->SQLInsert(
						"login_log",
						array("username","ip","date","action","cookie"),
						array($arrUser["username"],$_SERVER["REMOTE_ADDR"],time(),'login',$strCookie)
					);
								
	 
	 echo "
	 	<script>
			alert('Your account has been already activated!');
			document.location.href='JOBSEEKERS/index.php';
		</script>
	 ";
		
}
else
{
		echo "<h3>WRONG ACTIVATION CODE!</h3>";
}
ob_end_flush();
?>