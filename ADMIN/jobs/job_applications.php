<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<table summary="" border="0" width="100%">
	<tr>
		<td width="46">
		<img src="images/icons2/open.gif" width="44" height="32" alt="" border="0">
		</td>
		<td class=basictext>
		
		<b>
		View the job applications for a selected job ad
		</b>
		
		</td>
	</tr>
</table>

<br>

<table summary="" border="0" width=95%>
	<tr>
		<td class=basictext>
		
		<form action=index.php method=post>
		
		<b><?php echo $PLEASE_SELECT_AD;?></b>
		&nbsp;
		
		
		<input type=hidden name="Proceed">
		<input type=hidden name="category" value="<?php echo $category;?>">
		<input type=hidden name="action" value="<?php echo $action;?>">
		
		
		<?php
		
		
		
		HtmlComboBox_Query
			(
				"SELECT * FROM ".$DBprefix."jobs ORDER BY id",
				"id",
				"title"
			);
		?>
		
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type=submit class=adminButton value=" <?php echo $AFFICHER;?> ">
		
		</form>
		
			
		</td>
	</tr>
</table>


<?php
if(isset($Proceed))
{
?>

<?php
if(isset($_REQUEST["Delete"])&&isset($_REQUEST["CheckList"])&& sizeof($_REQUEST["CheckList"]) > 0)
{
	if(sizeof($_REQUEST["CheckList"])>1)
	{
			$database->SQLDelete("apply","id",$_REQUEST["CheckList"]);
	}
}
?>

<br>

<?php

if(isset($id) && $id != "")
{

RenderTable
(
						"apply",
						array("jobseeker_status","jobseeker","JobseekerDetails","message","employer_reply"),
						array("Status",$M_JOBSEEKER,"Details",$M_MESSAGE,"Reply"),
						"620",
						"WHERE posting_id=$id AND status = '0' ",
						$EFFACER,
						"id",
						
						"index.php?category=".$category."&action=".$action
						);
}
?>




<?php
}
?>

