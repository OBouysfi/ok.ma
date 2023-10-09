<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="pull-right">
<?php
	echo LinkTile
		 (
			"jobs",
			"courses",
			$M_GO_BACK,
			"",
			"red"
		 );
	?>
</div>
<div class="clear"></div>

<?php
$id=$_REQUEST["id"];

$website->ms_i($id);

if($website->GetParam("CHARGE_TYPE") == 1)
{
	$arrSubscription = $database->DataArray("subscriptions","id=".$arrUser["subscription"]);

	if(($database->SQLCount("jobs","WHERE featured=1 AND employer='".$AuthUserName."'") + $database->SQLCount("courses","WHERE featured=1 AND employer='".$AuthUserName."'"))>= $arrSubscription["featured_listings"])
	{
		echo '<h4><span class="red-font">'.$M_REACHED_MAXIMUM_SUBSCR.'</span>';
		?>
		<br/><br/>
		<a class="underline-link" href="index.php?category=home&action=credits"><?php echo $M_PLEASE_SELECT_TO_FEATURED;?></a></h4>
		<?php
	}
}
else
{

if($database->SQLCount("courses","WHERE employer='".$AuthUserName."' AND id=".$id." ") == 0)
{
	die("");
}
?>
<h3><?php echo $M_MAKE_FEATURED;?></h3>
<?php
if(get_param("featured")=="1")
{

if(get_param("confirm")=="1")
{
	
	$database->SQLUpdate_SingleValue
	(
		"courses",
		"id",
		$id,
		"featured",
		"1"
	);	
	
	$database->SQLUpdate_SingleValue
	(
		"courses",
		"id",
		$id,
		"featured_expires",
		time()+86400*$website->GetParam("FEATURED_ADS_EXPIRE")
	);	
	
if($website->GetParam("CHARGE_TYPE")==2)
{	
	$database->SQLUpdate_SingleValue
	(
		"employers",
		"id",
		$AdminUser["id"],
		"credits",
		$AdminUser["credits"]-aParameter(703)
	);	
}
?>

	<br/><br/>
	<h3><?php echo $M_JOB_SUCCESS_FEATURED;?></h3>
			
		
<?php
}
else
{

?>


		
		<?php
		if($website->GetParam("CHARGE_TYPE")==2)
		{
		?>
		
		<br/>
		<?php echo $M_PRICE_CREDITS_ADS_FEATURED;?>:
		
		<strong><?php echo aParameter(703);?></strong>
		
		<br><br>
		<?php
		}
		?> 
		
		
		<?php
		
		if($AdminUser["credits"]<aParameter(703)&&$website->GetParam("CHARGE_TYPE")==2)
		{
			echo $M_NOT_ENOUGH_CREDITS_TO_MAKE_FEATURED;
		}
		else
		{
			
		?>	
			
			<script>
			
			function yesClicked()
			{
				document.location.href="index.php?category=jobs&action=courses_featured&featured=1&confirm=1&id=<?php echo $id;?>";	
			}
			
			
			function noClicked()
			{
				document.location.href="index.php?category=jobs&action=courses";
			}
			
			</script>
			
			<form>
			<br/>
			
			<i><?php echo $M_PLEASE_CONFIRM_FEATURED;?>:</i>
			<br/>
			<br/>
			<br/>
			<center>
			<input type="button" onclick="javascript:yesClicked()" value=" <?php echo $M_YES;?> " class="btn btn-primary">
			&nbsp;&nbsp;&nbsp;
			<input type="button" onclick="javascript:noClicked()" value=" <?php echo $M_NO;?> " class="btn btn-default">
			</center>
			</form><br>
			
		<?php		
		}
		?>
		
		

<?php
}
}
}
?>