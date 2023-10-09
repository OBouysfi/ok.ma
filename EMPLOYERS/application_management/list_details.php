<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<?php
$posting_id=$_REQUEST["posting_id"];
$website->ms_i($posting_id);

$arrPosting = $database->DataArray("jobs","id=$posting_id");

if($arrPosting["employer"] != $AuthUserName)
{
	die("");
}

$arrPostingApply = $database->DataArray("apply","id=$apply_id");
$arrJobseeker = $database->DataArray("jobseekers","username='$id'");

if($database->SQLCount_Query
	(
		"SELECT DISTINCT username FROM 
		".$DBprefix."jobs, ".$DBprefix."apply, ".$DBprefix."jobseekers
		WHERE
		".$DBprefix."jobs.id=".$DBprefix."apply.posting_id
		AND
		".$DBprefix."apply.jobseeker=".$DBprefix."jobseekers.username
		AND
		".$DBprefix."jobseekers.username='".$id."'
		"
	) == 0)
{
	die("");
}


?>

<table width="100%"><tr><td>

<td width="39"><img src="images/icons2/user.png" width="48" height="48" alt="" border="0"></td>
<td class=basictext>
<b><?php echo $DETAILS_JS;?> [<?php echo $id;?>]</b>

</td></tr></table>
<br><br>
<table width=<?php echo $tableWidth;?>><tr><td class=basictext>

<b><?php echo $MESSAGE_SENT_JS;?></b>
<br><br>
<?php
echo $arrPostingApply["message"];
?>
<br><br>
<b><?php echo $M_MY_REPLY;?>:</b>
<br><br>
<?php
echo $arrPostingApply["employer_reply"];
?>
				<?php
				$userFiles = $database->DataTable_Query("SELECT * FROM ".$DBprefix."files,".$DBprefix."apply_documents 
				WHERE ".$DBprefix."apply_documents.file_id= ".$DBprefix."files.file_id
				AND apply_id='$apply_id'");
				
				$strFileCode = "";
				
				$strFileCode = "<table width=500>";
				
				$bHasOne = false;
				
				while($userFile = $database->fetch_array($userFiles))
				{
					
					$bHasOne = true;
				
					$strFileCode .= "<tr>";	
					
					
					
					$strFileCode .= "
						<td width=30 class=basictext>
					";
							
				if(strstr($userFile['file_name'],".pdf"))
				{
					$strFileCode .= '
					<a href="../file.php?id='.$userFile['file_id'].'" target=_blank>
						<img src="images/pdf.gif" width="22" height="22" alt="" border="0">
					</a>
					';
				}
				else
				if(strstr($userFile['file_name'],".doc"))
				{
					$strFileCode .= '
					<a href="../file.php?id='.$userFile['file_id'].'"  target=_blank>
						<img src="images/doc.gif" width="22" height="22" alt="" border="0">
					</a>
					';
				}
				else
				if(strstr($userFile['file_name'],".txt"))
				{
					$strFileCode .= '
					<a href="../file.php?id='.$userFile['file_id'].'"  target=_blank>
						<img src="images/text.gif" width="17" height="22" alt="" border="0">
					</a>
					';
				}
				else
				{
					$strResult .= $M_UNKNOWN;				
				}
								
					$strFileCode .= "	</td>
					";
					
					$strFileCode .= "
						<td  width=100 class=basictext>
								".$userFile['file_name']."
						</td>
					";
					
					$strFileCode .= "
						<td class=basictext>
							".$userFile["description"]."
						</td>
					";
					$strFileCode .= "</tr>";	
				}
				
				$strFileCode .= "</table>";
				?>

<?php
if($bHasOne)
{
?>

<br><br><br>

<b><?php echo $LIST_ATTACHED;?>:</b>
<br><br>
<?php echo $strFileCode;?>

<?php
}
?>				
				
<br><br><br>

<b><?php echo $JOBSEEKER_CV;?></b>
<br><br>
<?php
echo $arrJobseeker["cv"];
?>
<br><br>

<?php
if($arrJobseeker["video_id"]!="")
{
?>
	<span style="font-size:14px;font-weight:400">
		<i><b><?php echo $M_VIDEO_RESUME;?></b></i>
	</span>
	<br/><br/>
<?php
	$video_id=$arrJobseeker["video_id"];
	$video_id=str_replace("http://www.youtube.com/watch?v=","",$video_id);
	$video_id=str_replace("https://www.youtube.com/watch?v=","",$video_id);
	$video_id=str_replace("http://youtu.be/","",$video_id);
	$video_id=str_replace("https://youtu.be/","",$video_id);
	?>
	<iframe width="560" height="315" src="http://www.youtube.com/embed/<?php echo $video_id;?>" frameborder="0" allowfullscreen></iframe>
	
	<?php
}
?>
</td></tr></table>



