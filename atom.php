<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2014
// Check http://www.netartmedia.net/jobsportal for demos and information
?>
<?php
header ("Content-type: text/xml");
include("ADMIN/Utils.php");
EnsureParams();
if(aParameter(421)=="YES") 
	$USE_MOD_REWRITE = true;
else
	$USE_MOD_REWRITE = false;

function filter_text($str_text)
{
	return preg_replace("/[^[:alnum:]\s'-]/u"," ", stripslashes($str_text) );
}

$ATOM_DATE_FORMAT="Y\-m\-d\TH\:i\:s\Z";

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<feed xmlns=\"http://www.w3.org/2005/Atom\">\n";
echo "<title>Latest jobs on ".$DOMAIN_NAME."</title>\n";
echo "<link href=\"http://www.".$DOMAIN_NAME."\"/>\n";
echo "<updated>".date($ATOM_DATE_FORMAT, time() )."</updated>\n";
echo "<author>\n 
	<name>".$DOMAIN_NAME."</name>\n
</author>\n";
echo "<id>http://www.".$DOMAIN_NAME."/</id>\n";
			
				
	if(get_param("type") == "" || get_param("type") == "jobs" )
	{
		$strWhereQuery = "ORDER BY id DESC";
	}
	else
	if(strstr(get_param("type"), "jobs"))
	{
		$strWhereQuery = "ORDER BY id DESC LIMIT 0,".(str_replace("jobs","",get_param("type"))-1);
	}
	else
	{
		$strWhereQuery = "ORDER BY id DESC";
	}

	
	$arrNotes = DataTable("ext_postings",$strWhereQuery);
	
	while($arrNote = mysqli_fetch_array($arrNotes))
	{
		if(trim($arrNote["title"]) == "")
		{
			continue;
		}

		$strLink = "";
		$display_title=filter_text(strip_tags(stripslashes($arrNote["title"])));
		if($USE_MOD_REWRITE)
		{
			$strLink = "http://www.".$DOMAIN_NAME."/job/".$arrNote["id"]."/".format_str($display_title).".html";
		}
		else
		{
			$strLink = "index.php?mod=search&amp;job=".$arrNote["id"];
		}
		
		echo "<entry>\n";
		echo "<title>".$display_title."</title>\n";
		echo "<link href=\"".$strLink."\"/>\n";
		echo "<id>".$strLink."</id>\n";		
		echo "<updated>".date($ATOM_DATE_FORMAT, $arrNote["date"] )."</updated>\n";					
		
		
		echo "<summary>".text_words(strip_tags(filter_text(stripslashes($arrNote["message"]))),10)." </summary>\n";

		echo "</entry>\n";		
	
	}

				
echo "</feed>\n";
       
?>
