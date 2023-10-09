<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="page-wrap">
<?php /* <div class="page-header">
	<h3 class="no-margin">Toutes nos offres emploi<?php //echo $M_LATEST_JOBS;?></h3>
</div> */ ?>
<?php
$iTotResults = 0;
$latest_jobs = $database->Query
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
	AND ".$DBprefix."jobs.active='YES'
	AND ".$DBprefix."jobs.status=1
	AND expires>".time()." 
	ORDER BY ".$DBprefix."jobs.date DESC
	LIMIT 0,".(1000*$website->GetParam("PAGE_SIZE"))."
");

if(isset($_REQUEST["num"]))
{
	$website->ms_i($_REQUEST["num"]);
	$num=$_REQUEST["num"];
}
else 
{
	$num=0;
}
	
while($latest_job = $database->fetch_array($latest_jobs))
{

	if($iTotResults>=$num*$website->GetParam("RESULTS_PER_PAGE")&&$iTotResults<($num+1)*$website->GetParam("RESULTS_PER_PAGE"))
	{
		show_job($latest_job);
		
	}
	$iTotResults++;
}



if(ceil($iTotResults/$website->GetParam("RESULTS_PER_PAGE")) > 1)
{

	$strSearchString = "";
			
	foreach ($_POST as $key=>$value) 
	{ 
		if($key != "num"&&$key!="i_start")
		{
			$strSearchString .= $key."=".$value."&";
		}
	}
	
	foreach ($_GET as $key=>$value) 
	{ 
		if($key != "num"&&$key!="i_start")
		{
			$strSearchString .= $key."=".$value."&";
		}
	}
	
	echo '<ul class="pagination">';
	

	
	$inCounter = 0;
	
	if($num>0)
	{
		echo "<li><a style=\"color:#47a5f4 !important\" class=\"pagination-link\" href=\"index.php?".$strSearchString."num=0\"> << </a></li>";
		
		echo "<li><a style=\"color:#47a5f4 !important\" class=\"pagination-link\" href=\"index.php?".$strSearchString."num=".($num-1)."\"> < </a></li>";
	}
	
	$iStartNumber = ($num+1);
	
		
	for($i= ($num-1);$i<($num+5);$i++)
	{
		if($i<1) continue;
		if($inCounter>=5) break;
		if($i>ceil($iTotResults/$website->GetParam("RESULTS_PER_PAGE")))
		{
			break;
		}
		
		if($i == ($num+1))
		{
			echo "<li><a style=\"color:#fff !important; background-color:#47a5f4 \"><b>".$i."</b></a></li>";
		}
		else
		{
			echo "<li><a style=\"color:#47a5f4 !important\" class=\"pagination-link\" href=\"index.php?".$strSearchString."num=".($i-1)."\">".$i."</a></li>";
		}
						
		
		$inCounter++;
	}
	
	if(($num+1)<ceil($iTotResults/$website->GetParam("RESULTS_PER_PAGE")))
	{
		echo "<li><a style=\"color:#47a5f4 !important\"  href=\"index.php?".$strSearchString."num=".($num+1)."\"> ></b></a></li>";
		
		echo "<li><a style=\"color:#47a5f4 !important\"  href=\"index.php?".$strSearchString."num=".(ceil($iTotResults/$website->GetParam("RESULTS_PER_PAGE"))-1)."\"> >> </a></li>";
	}
	
	echo '</ul>';
}
?>
</div>
<?php
$website->Title($M_LATEST_JOBS);
$website->MetaDescription("");
$website->MetaKeywords("");
?>