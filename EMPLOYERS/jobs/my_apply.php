<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<?php
if($database->SQLCount("jobs","WHERE employer='".$AuthUserName."' AND id=".$id) == 0)
{
	die("");
}

if(isset($Delete)&&isset($CheckList)&&sizeof($CheckList)>0)
{
	$website->ms_ia($CheckList);
			$database->SQLDelete("apply","id",$CheckList);
}
?>
<br>
<table summary="" border="0" width="100%">
	<tr>
		<td width="40">
		<img src="images/icons/users.gif" width="39" height="38" alt="" border="0">
		</td>
		<td class=basictext>
			<span class="header_title">
			<?php echo $LIST_APPLIED;?>:
			</span>
		</td>
	</tr>
</table>
<br>

<?php

$website->ms_i($id);
if($database->SQLCount("apply","WHERE posting_id=$id") == 0)
{

?>
<table summary="" border="0" width="100%">
	<tr>
		<td class=basictext><br><br><b>
			[<?php echo strtoupper($ANY_APPLIED);?>]
			</b>
		</td>
	</tr>
</table>
<?php
}
else
{

RenderTable(
						"apply",
						array("date","JobseekerDetails","message","employer_reply"),
						array($DATE_MESSAGE,$M_JOBSEEKER,$M_MESSAGE,$MY_REPLY),
						"600",
						"WHERE posting_id=$id ",
						$EFFACER,
						"id",
						
						"index.php?category=".$category."&folder=".$folder."&page=".$page."&id=".$id
						);
}

?>


