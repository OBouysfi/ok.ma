<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php

include_once("../../jobs_config.php");
include("../security.php");
mysql_connect("$DBHost", "$DBUser", "$DBPass");
mysql_select_db($DBName);


$resQuery = mysql_query("select * from $DBprefix"."jobs ");


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
 
 
 
 		while($arrSelect = $database->fetch_array($resQuery, MYSQL_ASSOC)) 
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

mysql_close();
?>
