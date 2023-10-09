<?php
require("config.php");
if(!$DEBUG_MODE) error_reporting(0);
require("include/SiteManager.class.php");
include("include/Database.class.php");

$website = new SiteManager();
$database = new Database();

/// Connect to the website database
$database->Connect($DBHost, $DBUser,$DBPass );
$database->SelectDB($DBName);
$website->SetDatabase($database);
$website->LoadSettings();

$log_file = "include/IPN_REPORT.php";   

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
							
					WriteToIPNLog
						(
							"\nSUCCESSFUL PAYMENT\n"
						);
					
					if($website->GetParam("CHARGE_TYPE")==2)
					{
						$purchase_id = $_POST["custom"];
						$arrCdts = $database->DataArray("credits","id=".$purchase_id);
						$arrAgent = $database->DataArray("employers","username='".$arrCdts["employer"]."'");
					
						$database->SQLUpdate_SingleValue
							(
								"employers",
								"username",
								"'".$arrCdts["employer"]."'",
								"credits",
								$arrCdts["credits"]+$arrAgent["credits"]
							);
							
							$database->SQLUpdate_SingleValue
							(
								"credits",
								"id",
								$purchase_id,
								"status",
								"1"
							);
										
					}
					else
					{
								$username = $_POST["custom"];
								$arrUser = $database->DataArray("employers","username='".$username."'");
								$arrPackage = $database->DataArray("subscriptions","id=".$arrUser["new_subscription"]);

								  if($database->SQLCount("employers","WHERE username='".$username."' ")==1) 
								  {
							
							   
									if(isset($_POST["txn_type"]) &&strtolower($_POST["txn_type"]) == "subscr_payment") 
									{
											
											
											if($arrUser["new_subscription"] != 0 && $arrUser["new_subscription"]!=$arrUser["subscription"])
											{
												
														$database->SQLUpdate_SingleValue
														(
															"employers",
															"username",
															"'".$username."'",
															"subscription",
															$arrUser["new_subscription"]
														);
														$arrPackage = $database->DataArray("subscriptions","id=".$arrUser["subscription"]);
														
											}
											
											
											
											WriteToIPNLog
											(
												"successful payment for user: ".$username."\n"
											);
							
										} 
										else
										 if(
											isset($_POST["txn_type"]) 
											 &&
											(
												strtolower($_POST["txn_type"]) == "subscr_cancel"
												||
												strtolower($_POST["txn_type"]) == "subscr_failed"
											) 
											)
										{
								
												$database->SQLUpdate_SingleValue
												(
													"employers",
													"id",
													$arrUser["id"],
													"subscription",
													"0"
												);
												
												WriteToIPNLog
												(
													"txn_type: ".$_POST["txn_type"]." user:".$username."\n"
												);
											
								
									} 

						 }
					 
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
