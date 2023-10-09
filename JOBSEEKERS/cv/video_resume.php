<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>

<div class="fright">

	<?php
	
		echo LinkTile
		 (
			"home",
			"welcome",
			$M_DASHBOARD,
			"",
			"blue"
		 );
		 
	echo LinkTile
	 (
		"cv",
		"resume_creator",
		$M_RESUME_CREATOR,
		"",
		"green"
	 );
	
	
	?>

</div>
<div class="clear"></div>
<?php


if(isset($_REQUEST["process_form"]))	
{
	
	$database->SQLUpdate_SingleValue("jobseekers","username","'".$AuthUserName."'","video_id",strip_tags($_REQUEST["video_file"]));
}

if(isset($_REQUEST["process_delete"]))
{

	$database->SQLUpdate_SingleValue("jobseekers","username","'".$AuthUserName."'","video_id","");
	$arrUser["video_id"]="";	
}
?>
<script>
function DeleteVideo()
{
	if(confirm("<?php echo $M_ARE_YOU_SURE_DELETE;?>"))
	{
		document.location.href="index.php?category=cv&action=video_resume&process_delete=1";
	}
}

</script>

<h3>
	<?php echo $M_MANAGE_YOUR_VIDEO_RESUME;?>
</h3>
<br>
	
		<?php
		
		if($arrUser["video_id"]!=""&&$arrUser["video_id"]!="0")
		{
		?>
		<br/>
				<table summary="" border="0">
			  	<tr>
			  		<td><img src="images/link_arrow.gif" width="16" height="16" alt="" border="0"></td>
			  		<td><a href="index.php?category=<?php echo $category;?>&folder=<?php echo $action;?>&page=play"><b><?php echo $M_PLAY_VIDEO_PRESENTATION;?></b></a></td>
					<td width="70">&nbsp;</td>
			  		<td><img src="images/link_arrow.gif" width="16" height="16" alt="" border="0"></td>
			  		<td><a href="javascript:DeleteVideo()"><b><?php echo $M_DELETE_VIDEO_PRESENTATION;?></b></a></td>
			  	</tr>
			  </table>
		<?php
		}
		?>		
	<br/>
	<br/>
	<form action="index.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="process_form" value="1">
	<input type="hidden" name="process_update" value="1">
	<input type="hidden" name="category" value="<?php echo $category;?>">
	<input type="hidden" name="action" value="<?php echo $action;?>">
	<?php echo $M_VIDEO_ID_URL;?>: <input type="text" name="video_file" value="<?php if(isset($_POST["video_file"])) echo $_POST["video_file"];else echo $arrUser["video_id"];?>" size="40"/>
	<br><br><br>
	<input type="submit" value=" <?php echo $M_SAVE;?> " class="btn btn-primary">
	
	</form>
				
	