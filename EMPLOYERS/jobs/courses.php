<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="fright">

	<?php
				 
		echo LinkTile
		(
			"jobs",
			"add_course",
			$M_POST_COURSE,
			"",
			"green"
		);
	
			
	
	?>

</div>
<div class="clear"></div>

<h3>
	<?php echo $M_CURRENT_COURSE_LISTINGS;?>
</h3>
<br/>
<?php

if(isset($_POST["Delete"])&&isset($_POST["CheckList"]))
{
	if(sizeof($_POST["CheckList"])>0)
	{
		$website->ms_ia($_POST["CheckList"]);
		$database->SQLDeletePlus("employer",$AuthUserName,"courses","id",$_POST["CheckList"]);
	}
}


if($database->SQLCount("courses","WHERE employer='".$AuthUserName."'  AND expires>".time()."") == 0)
{

?>
<br/>
<i>
	<?php echo $M_ANY_COURSES;?>
</i>
<br/>
<?php
}
else
{

	$_REQUEST["arrTDSizes"] = array("60","120","*","30");

	$ORDER_QUERY="ORDER BY id DESC";
	RenderTable
	(
		"courses",
		array("EditPosting","date","title","_featured"),
		array($MODIFY,$DATE_MESSAGE,$M_TITLE,$M_FEATURED),
		"630",
		"WHERE employer='".$AuthUserName."'  AND expires>".time()."",
		$EFFACER,
		"id",
		
		"index.php?category=".$category."&action=".$action
	);
}
?>
