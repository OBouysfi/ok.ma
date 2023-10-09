<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
header("Content-type: application/mail");
header("Content-Disposition: attachment; filename=mail.txt");

include_once("../../config.php");

mysql_connect("$DBHost", "$DBUser", "$DBPass");
	mysql_select_db($DBName);
		
	$oDataTable=mysql_query("select * from $DBprefix"."mail"." ");
			
	while ($myArray = $database->fetch_array($oDataTable)) 
	{	
		print $myArray['Email']."\n";	
		//print "aaa";
	}
	
	mysql_close();

?>