<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
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

$log_file = "include/IPN_REPORT.php";   
$strReport="";
$writeToLog = true;

if (!$file_handle = fopen($log_file,"a")) 
{
	$writeToLog = false;
}
else
{
	fclose($file_handle); 
}


function WriteToIPNLog($strText)
{
	global $writeToLog,$log_file,$SYSTEM_EMAIL_ADDRESS;
	if($writeToLog)
	{
		
		if (!$file_handle = fopen($log_file,"a")) 
		{
			 return;
		}  
		
		if (!fwrite($file_handle, $strText)) 
		{ 
			return;
		}  
		fclose($file_handle); 
	}
}



$req = 'cmd=_notify-validate';

$logVars ="";

foreach ($_POST as $key => $value) 
{
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
	$logVars .= $key.">>".$value." ";
}


date_default_timezone_set("Europe/London");
WriteToIPNLog
	(
		"NEW IPN REPORT ".date("F j, Y, g:i a")."\n".
		"********************\n".
		$logVars."\n"
	);
	
	
	$header = "POST /cgi-bin/webscr HTTP/1.1\r\n"; 
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen ($req) . "\r\n\r\n";


$header = "POST /cgi-bin/webscr HTTP/1.1\r\n"; // HTTP POST request
$header.= "Content-Type: application/x-www-form-urlencoded\r\n";
$header.= "Host: www.paypal.com\r\n";
$header.= "Content-Length: " . strlen($req) . "\r\n";
$header.= "Connection: Close\r\n\r\n";


	$fp = fsockopen ("ssl://www.paypal.com", 443, $errno, $errstr, 30);


	if (!$fp) 
	{
		WriteToIPNLog
		(
			"System failed to connect to paypal!\n"
		);
		
	} 
	else 
	{

		fputs ($fp, $header . $req);
		  
		$strReport = "";
			
 		while (!feof($fp)) 
 		{

			$res = fgets ($fp, 1024);
				
			$strReport .= $res;
		
    		if (strcmp (trim($res), "VERIFIED") == 0) 
			{
				if (strcmp ($_POST['payment_status'], "Completed") == 0) 
				{
					$listing_id = $_POST["custom"];
										
					$database->SQLUpdate_SingleValue
					(
						"jobs",
						"id",
						$listing_id,
						"status",
						"1"
					);
								
									
					WriteToIPNLog
					(
						"successful payment for listing: ".$listing_id."\n"
					);
				}
			}
		
			else if(strcmp (trim($res), "INVALID") == 0) 
			{

						WriteToIPNLog
						(
							">>>INVALID<<<\n".$strReport."\n"
						);

			}
		}

  

}

WriteToIPNLog
	(
		"Final Status: \n".$strReport."\n\n
		END IPN REPORT\n\n"
	);
?>
