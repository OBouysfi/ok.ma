<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>

<h3 class="no-margin">Vos offres favorites<?php // echo $M_CURRENT_SAVED;?></h3>
<hr/>
<br/>
<div class="row">
<?php

$RESULTS_PER_PAGE = $website->GetParam("RESULTS_PER_PAGE");
$NUMBER_OF_CATEGORIES_PER_ROW = $website->GetParam("NUMBER_OF_CATEGORIES_PER_ROW");

$skip_query=false;



if(!isset($_COOKIE["saved_listings"])||$_COOKIE["saved_listings"]==""||$_COOKIE["saved_listings"]==",")
{
	$skip_query=true;
}

if(!$skip_query)
{
	$SearchTable = $database->Query
	("
		SELECT 
		".$DBprefix."jobs.id,
		".$DBprefix."jobs.title,
		".$DBprefix."jobs.date,
		".$DBprefix."jobs.salary,
		".$DBprefix."jobs.applications,
		".$DBprefix."jobs.region,
		".$DBprefix."jobs.message,
		".$DBprefix."jobs.ref,
		".$DBprefix."employers.company,
		".$DBprefix."employers.logo
		FROM ".$DBprefix."jobs,".$DBprefix."employers  
		WHERE 
		".$DBprefix."jobs.employer =  ".$DBprefix."employers.username
		AND 
		 ".$DBprefix."jobs.id in (".rtrim($_COOKIE["saved_listings"],",").")
	");
	$iNResults = $database->num_rows($SearchTable);
	
}
	


if($skip_query || $iNResults == 0)
{
	echo "<br/><br/><i>".$M_STILL_NO_SAVED."</i><br/><br/><br/><br/><br/>";
}
else
{

	$iTotResults = 0;

	if(!isset($_REQUEST["num"]))
	{
		$num = 0;
	}
	else
	{
		$website->ms_i($_REQUEST["num"]);
		$num = $_REQUEST["num"] - 1;
	}
		

	$i_listings_counter = 0;

	$_REQUEST["is_saved_page"]=true;

	while($listing = $database->fetch_array($SearchTable))
	{
		
		if($iTotResults>=$num*$RESULTS_PER_PAGE&&$iTotResults<($num+1)*$RESULTS_PER_PAGE)
		{
				
			show_job($listing);
			
		}
		$iTotResults++;
	}
	?>
	
	
	<div class="clear"></div>	
	<?php

	$strSearchString = "";
				
	foreach($_GET as $key=>$value) 
	{ 
		if($key != "num"&&$key!="i_start")
		{
			$strSearchString .= $key."=".$value."&";
		}
	}
	if(isset($_POST["mod"]))
	$strSearchString .= "mod=".$_POST["mod"]."&";
	
	if(isset($_POST["search_by"]))
	$strSearchString .= "search_by=".$_POST["search_by"]."&";


	if(ceil($iTotResults/$RESULTS_PER_PAGE) > 1)
	{
		?>
	
		<ul class="pagination">
		<?php
		
		$inCounter = 0;
		
		if(($num+1) != 1)
		{
			echo "<li><a class=\"pagination-link\" href=\"index.php?".$strSearchString."num=1\"><<</a></li>";
			
			echo "<li><a class=\"pagination-link\" href=\"index.php?".$strSearchString."num=".($num)."\"><</a></li>";
		}
		
		$iStartNumber = ($num+1);
		
		if($iStartNumber > (ceil($iTotResults/$RESULTS_PER_PAGE) - 4))
		{
			$iStartNumber = (ceil($iTotResults/$RESULTS_PER_PAGE) - 4);
		}
		
		if($iStartNumber>3&&($num+1)<(ceil($iTotResults/$RESULTS_PER_PAGE) - 2))
		{
			$iStartNumber=$iStartNumber-2;
		}
		
		if($iStartNumber < 1)
		{
			$iStartNumber = 1;
		}
		
		for($i= $iStartNumber ;$i<=ceil($iTotResults/$RESULTS_PER_PAGE);$i++)
		{
			if($inCounter>=5)
			{
				break;
			}
			
			if($i == ($num+1))
			{
				echo "<li><a><b>".$i."</b></a></li>";
			}
			else
			{
				echo "<li><a class=\"pagination-link\" href=\"index.php?".$strSearchString."num=".$i."\">".$i."</a></li>";
			}
							
			
			$inCounter++;
		}
		
		if(($num+1)<ceil($iTotResults/$RESULTS_PER_PAGE))
		{
			echo "<li><a class=\"pagination-link\" href=\"".($website->GetParam("SEO_URLS")==1?"http://".$DOMAIN_NAME."/":"")."index.php?".$strSearchString."num=".($num+2)."\">></a></li>";
			
			echo "<li><a class=\"pagination-link\" href=\"".($website->GetParam("SEO_URLS")==1?"http://".$DOMAIN_NAME."/":"")."index.php?".$strSearchString."num=".(ceil($iTotResults/$RESULTS_PER_PAGE))."\">>></a></li>";
		}
		?>	
			</ul>
		<?php	
		
	}
}
?>
</div>
<?php
$website->Title($M_SAVED_LISTINGS);
$website->MetaDescription("");
$website->MetaKeywords("");

?>