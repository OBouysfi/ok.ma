<?php
error_reporting(0);
if(file_exists("../locations/locations_array.php"))
{
	include("../locations/locations_array.php");
}
else
{
	die("");
}

$q=trim($_GET["q"]);
 $hint="";
if(isset($_GET["location"])) $location=trim($_GET["location"]);else $location="";

if (true)
{
 
  $l_slice=array();
  $array_l=explode(".",$location);

  if(trim($location)=="") $l_slice=$loc;
  elseif(sizeof($array_l)==1) {$l_slice=$loc1[$array_l[0]];}
  elseif (sizeof($array_l)==2) $l_slice=$loc2[$array_l[0]][$array_l[1]];
  elseif (sizeof($array_l)==3) $l_slice=$loc3[$array_l[0]][$array_l[1]][$array_l[2]];
  elseif (sizeof($array_l)==4) $l_slice=$loc4[$array_l[0]][$array_l[1]][$array_l[2]][$array_l[3]];
  else die("");

	foreach($l_slice as $l_slice_element)
	{
		if(!is_string($l_slice_element)) continue;
		
		 if($q==""||strtolower($q)==strtolower(substr($l_slice_element,0,strlen($q))))
		{
		
			$keys = array_keys($l_slice, $l_slice_element); 
			if(sizeof($keys)==0) continue;
			$current_location=($location==""?"":$location.".").$keys[0];
		
			  if ($hint=="")
			  {
					$hint=$l_slice_element."#".$current_location;
			  }
			  else
			  {
					$hint=$hint."~".$l_slice_element."#".$current_location;
			  
			  }
		}
	
	}
	 
   
}

	if ($hint == "")
	{
		$response="no suggestion";
	}
	else
	{
		$response=$hint;
	}


echo $response;
?>