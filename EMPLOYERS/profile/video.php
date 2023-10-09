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
			"profile",
			"edit",
			$M_EDIT,
			"",
			"green"
		 );
		 
		echo LinkTile
		(
			"profile",
			"logo",
			$M_LOGO,
			"",
			"yellow"
		);
	
	
	?>

</div>
<div class="clear"></div>
<?php


if(isset($_POST["process_form"]))	
{
	$database->SQLUpdate_SingleValue("employers","username","'".$AuthUserName."'","video_id",$_REQUEST["video_file"]);
	$arrUser = $database->DataArray("employers","username='".$AuthUserName."'");

}

if(isset($_REQUEST["process_delete"]))
{
	$database->SQLUpdate_SingleValue("employers","username","'".$AuthUserName."'","video_id","");
	$arrUser["video_id"]="";	
}
?>
<script>
function DeleteVideo()
{
	if(confirm("<?php echo $M_ARE_YOU_SURE_DELETE;?>"))
	{
		document.location.href="index.php?category=profile&action=video&process_delete=1";
	}
}

</script>

<h3>
	<?php echo $M_CREATE_VIDEO_PRESENTATION;?>
</h3>
<br>
	
		<?php
		
		if($arrUser["video_id"]!=""&&$arrUser["video_id"]!="0")
		{
		?>
		<br/>
				<table summary="" border="0">
			  	<tr>
			  		<td><img src="images/link_arrow.gif" width="16" height="16" alt="" border="0"> </td>
			  		<td><a href="index.php?category=<?php echo $category;?>&folder=<?php echo $action;?>&page=play"><b><?php echo $M_PLAY_VIDEO_PRESENTATION;?></b></a></td>
					<td width="70">&nbsp;</td>
			  		<td><img src="images/link_arrow.gif" width="16" height="16" alt="" border="0"> </td>
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
	<?php echo $M_VIDEO_ID_URL;?>: <input type="text" name="video_file" value="<?php if(isset($_POST["video_file"])) echo $_POST["video_file"];?>" size="40"/>
	<br><br><br>
	<input type="submit" value=" <?php echo $M_SAVE;?> " class="btn btn-primary">
	
	</form>
				
	