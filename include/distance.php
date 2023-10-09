<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
 
function GetDistance($arrLatLons, $zip1, $zip2, $type)
{
	$lat1= 0;
	$lon1= 0;
	$lat2= 0;
	$lon2 = 0;
	$c = pi()/180.0;
	
	
	foreach($arrLatLons as $arrLatLon)
	{
	
		if($arrLatLon[0] == $zip1)
		{
			$lat1 = $arrLatLon[1];
			$lon1 = $arrLatLon[2] ;
		}
		
		if($arrLatLon[0] == $zip2)
		{
			$lat2 = $arrLatLon[1] ;
			$lon2 = $arrLatLon[2] ;
		}
	}
	
	$lat1 = $c  * $lat1;
	$lat2 = $c  * $lat2;
	$lon1 = $c  * $lon1;
	$lon2 = $c  * $lon2;
	
	
	
	if($type == 1)
	{
		return 6371*acos(sin($lat1)*sin($lat2)+cos($lat1)*cos($lat2)*cos($lon1-$lon2));
	}
	else
	{
		return 3958.864*acos(sin($lat1)*sin($lat2)+cos($lat1)*cos($lat2)*cos($lon1-$lon2));
	}
}

function GetLatLon($arrZips)
{
	$arrResult = array();
	
	@$fp = fopen("include/zips.txt",'r');
	if(!$fp) 
	{
		exit;
	}
	
	$cnt = 0;
	
	while (!feof($fp)) 
	{
	  $location = fgetcsv($fp, 100, ",");
	  
	  if(isset($location[0]) &&isset($location[1])&&isset($location[2]))
	  {
		$zip = $location[0];
		$lat = $location[1];
		$lon = $location[2];
	  }
	  else 
	 {
		
	 }
					
	
		if(in_array($zip, $arrZips, false))
		{
			array_push($arrResult, array($zip, $lat, $lon));
		}
	}
				
		return $arrResult;
}
?>