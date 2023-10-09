<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>

<h3>
	<?php echo $MANAGE_YOUR_JOB_ADS;?>
</h3>
<br/>
<table summary="" border="0" width="100%">
	<tr>
		<td align="right">
		
		<table summary="" border="0">
  	<tr>
  		<td><img src="images/link_arrow.gif" width="16" height="16" alt="" border="0"></td>
  		<td><a href="index.php?category=<?php echo $category;?>&folder=<?php echo $action;?>&page=export" style="color:#6d6d6d;text-transform:uppercase;font-weight:800"><?php echo $M_EXPORT_OR_IMPORT;?></a></td>
  	</tr>
  </table>
		
		
		</td>
	</tr>
</table>


<?php

if(isset($_POST["Delete"])&&isset($_POST["CheckList"]))
{
	if(sizeof($_POST["CheckList"])>0)
	{
		$website->ms_ia($_POST["CheckList"]);
		$database->SQLDeletePlus("employer",$AuthUserName,"jobs","id",$_POST["CheckList"]);
	}
}


if($database->SQLCount("jobs","WHERE employer='".$AuthUserName."'  AND expires>".time()."") == 0)
{

?>
<table summary="" border="0" width="100%">
	<tr>
		<td class=basictext><br><br><b>
			[<?php echo strtoupper($ANY_JOB_ADS);?>]
			</b>
		</td>
	</tr>
</table>
<?php
}
else
{

	$arrTDSizes = array("60","60","60","100","*");

	$ORDER_QUERY="ORDER BY id DESC";
	RenderTable
	(
		"jobs",
		array("EditPosting","EditFeatured","StatPosting","date","title"),
		array($MODIFY,$M_FEATURED,$M_STATISTICS,$DATE_MESSAGE,$M_TITLE),
		"630",
		"WHERE employer='$AuthUserName'  AND expires>".time()."",
		$EFFACER,
		"id",
		
		"index.php?category=".$category."&action=".$action
	);
}
?>
