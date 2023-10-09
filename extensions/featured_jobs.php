<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="page-wrap">
<div class="page-header">
	<h3 class="no-margin"><?php echo $FEATURED_JOBS;?></h3>
</div>
<?php
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
	AND ".$DBprefix."jobs.featured=1
	AND ".$DBprefix."jobs.active='YES'
	AND expires>".time()." 
	ORDER BY ".$DBprefix."jobs.id DESC
	LIMIT 0,".$website->GetParam("PAGE_SIZE")."
");

while($latest_job = $database->fetch_array($latest_jobs))
{
	show_job($latest_job);
}
?>
</div>
<?php
$website->Title($FEATURED_JOBS);
$website->MetaDescription("");
$website->MetaKeywords("");
?>