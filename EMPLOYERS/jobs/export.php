<?php
define("IN_SCRIPT","1");
ob_start();
$is_mobile=false;
include("../../config.php");
if(!$DEBUG_MODE) error_reporting(0);
include("../../include/SiteManager.class.php");
include("../../include/Database.class.php");
$website = new SiteManager();
$website->isAdminPanel = true;
$database = new Database();
$database->Connect($DBHost, $DBUser,$DBPass );
$database->SelectDB($DBName);
$website->SetDatabase($database);
include("../security.php");
$website->LoadSettings();


$resQuery = $database->Query("select * from $DBprefix"."jobs where employer='".$AuthUserName."' ");


header("Content-Type: application/csv-tab-delimited-table");
header("Content-disposition: filename=data.csv");

$exp_fields=explode("-",$_GET["fs"]);

if ($database->num_rows($resQuery) != 0) 
{

 	 	
		$fields=$exp_fields;
  		$i = 0;
  
  		foreach ($exp_fields as $field)
 		{
			if($i != 0)
			{
				echo ",";
			}
		
  			  echo "\"".$field."\"";
   			  $i++;
  		}
  		echo "\n";
 
 
 
 		while($arrSelect = $database->fetch_array($resQuery)) 
  		{
			
			$bFlag = true;
				
			foreach ($exp_fields as $field)
 			{
				if(!$bFlag)
				{
					echo ",";
				}
				
				echo "\"".$arrSelect[$field]."\"";
				
				$bFlag = false;
			}
							   
 			echo "\n";
  		}
  
  
}

ob_end_flush();
?>