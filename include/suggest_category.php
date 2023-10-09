<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
error_reporting(0);
$lang="en";
if(isset($_REQUEST["lang"]))
{
	$lang=$_REQUEST["lang"];
}
if(file_exists("../categories/categories_array_".$lang.".php"))
{
	include("../categories/categories_array_".$lang.".php");
}
else
{
	include("../categories/categories_array_en.php");
}

$q=trim($_GET["q"]);
 $hint="";
if(isset($_GET["location"])) $location=trim($_GET["location"]);else $location="";

if (true)
{
 
  $l_slice=array();
  $array_l=explode(".",$location);

  if(trim($location)=="") $l_slice=$l;
  elseif(sizeof($array_l)==1) {$l_slice=$l1[$array_l[0]];}
  elseif (sizeof($array_l)==2) $l_slice=$l2[$array_l[0]][$array_l[1]];
  elseif (sizeof($array_l)==3) $l_slice=$l3[$array_l[0]][$array_l[1]][$array_l[2]];
  elseif (sizeof($array_l)==4) $l_slice=$l4[$array_l[0]][$array_l[1]][$array_l[2]][$array_l[3]];
  else die("");
asort($l_slice);
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