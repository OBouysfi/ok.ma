<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="fright">

	<?php
		echo LinkTile
		 (
			"jobs",
			"my",
			$MY_JOB_ADS,
			"",
			"blue"
		 );
	?>
</div>
<div class="clear"></div>
<?php
if(isset($_POST["Delete"])&&isset($_POST["CheckList"]))
{
	if(sizeof($_POST["CheckList"])>0)
	{
		$website->ms_ia($_POST["CheckList"]);
		$database->SQLDeletePlus("employer",$AuthUserName,"jobs","id",$_POST["CheckList"]);
	}
}
?>
<h3>
	<?php echo $M_RENEW_YOUR_ADS;?>
</h3>
<br/>

<?php

if($database->SQLCount("jobs","WHERE employer='".$AuthUserName."' AND expires<".time()."") == 0)
{
			echo "<br/><i>".$ANY_EXPIRED_ADS."</i><br/>";

}
else
{
		$arrTDSizes = array("60","60","100","*");

					RenderTable
					(
						"jobs",
						array("EditNote","date","title"),
						array($M_RENEW,$DATE_MESSAGE,$M_TITLE),
						"630",
						"WHERE employer='$AuthUserName'  AND expires<".time()."",
						$EFFACER,
						"id",
						
						"index.php?category=".$category."&action=".$action
					);
}
?>
