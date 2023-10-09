<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
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
if(isset($_REQUEST["id"]))
{
	$id=$_REQUEST["id"];
	$website->ms_w($id);
}
else
{
	die("The ID is not set.");
}
	
if($database->SQLCount_Query("SELECT * FROM ".$DBprefix."rules WHERE code='$id'  ") == 1)
{

	if(isset($_REQUEST["cancel"]))
	{

		$database->Query
		(
			"DELETE FROM ".$DBprefix."rules
			WHERE code='".$id."'"
		);
					 
		 echo "
			<script>
				alert('Thank you! Your email alert has been deleted successfully!');
				document.location.href='index.php';
			</script>
		 ";
	
	}
	else
	{
		$database->SQLUpdate_SingleValue
		(
			"rules",
			"code",
			"'".$id."'",
			"active",
			"1"
		);
					 
		 echo "
			<script>
				alert('Thank you! Your email alert has been activated successfully!');
				document.location.href='index.php';
			</script>
		 ";
	 }

}
else
{
	echo "<i>WRONG CODE!</i>";
}
?>