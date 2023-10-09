<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
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
if($database->SQLCount("courses","WHERE employer='".$AuthUserName."' AND id=".$id." ") == 0)
{
	die("");
}
?>


<h3>
	<?php echo $MODIFY_SELECTED_ADD;?>
</h3>
<br/>

<?php
if(get_param("featured")=="1")
{

if(get_param("confirm")=="1")
{
	$website->ms_i($id);
	
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
		time()+86400*$FEATURED_ADS_EXPIRE
	);	
	
if(!$website->GetParam("FREE_WEBSITE"))
{	
	$database->SQLUpdate_SingleValue
	(
		"employers",
		"username",
		"'".$AuthUserName."'",
		"credits",
		$arrUser["credits"]-aParameter(703)
	);	
}
?>

<br>
<h3><?php echo $M_THANK_YOU;?>!</h3>
<br><br>
	
	
<?php
}
else
{

?>



		
		<?php
		if(!$website->GetParam("FREE_WEBSITE"))
		{
		?>
		
		
		<?php echo $M_PRICE_CREDITS_ADS_FEATURED;?>:
		
		<b style="font-size:14px"><?php echo aParameter(703);?></b>
		
		<br><br>
		<?php
		}
		?> 
		
		
		<?php
		
		if($arrUser["credits"]<aParameter(703)&&!$website->GetParam("FREE_WEBSITE"))
		{
		
				echo $M_NOT_ENOUGH_CREDITS_TO_MAKE_FEATURED;
		
		}
		else
		{
			
		?>	
			
			<script>
			
			function yesClicked()
			{
				document.location.href="index.php?category=jobs&folder=my&page=edit&featured=1&confirm=1&id=<?php echo $id;?>";	
			}
			
			
			function noClicked()
			{
				document.location.href="index.php?category=jobs&folder=my&page=edit&id=<?php echo $id;?>";
			}
			
			</script>
			
			<form>
			<br><br>
			<i><?php echo $M_PLEASE_CONFIRM_FEATURED;?>:</i>
			<br>
			<br><br>
			<center>
			<input type="button" onclick="javascript:yesClicked()" value=" <?php echo $M_YES;?> " class="adminButton">
			&nbsp;&nbsp;&nbsp;
			<input type="button" onclick="javascript:noClicked()" value=" <?php echo $M_NO;?> " class="adminButton">
			</center>
			</form><br>
			
		<?php		
		}
		?>
		
<?php
}

}
else
{
?>

<?php

$MessageTDLength = 130;

$SubmitButtonText = $SAUVEGARDER;

	$arrAd = $database->DataArray("courses","id=".$id);

		

$strJobType="_".$M_PLEASE_SELECT."^";

foreach($website->GetParam("arrStudyModes") as $key=>$value)
{
	if($value=="") continue;
	$strJobType.="_".$value."^".$key;

}


$strAuthQuery = "employer='".$AuthUserName."'";
?>


<?php
$_REQUEST["message-column-width"]=120;
$_REQUEST["select-width"]=400;

	AddEditForm
	(
		array
		(
			$M_COURSE_SUBJECT.":",
			$M_MODE_STUDY.":",
			$M_TITLE.":",
			$M_DESCRIPTION.":",
			
			$M_QUALIFICATION.":",
			$M_START_DATE.":",
			$M_DURATION.":",
		
			$M_REGION.":",
			$M_ZIP.":",
			$ACTIVE.":"
		),
		array
		(
			"job_category",
			"mode_study",
			"title",
			"message",
			
			"qualification",
			"date_available",
			"duration",
			
			"region",
			"zip",
			"active"
		),
		array(),
		array
		(
			"combobox_special",
			"combobox".$strJobType,
			"textbox_67",
			"textarea_70_10",
			
			"textbox_67",
			"textbox_36",
			"textbox_36",
			
			"combobox_region",
			"textbox_8",
			"combobox_".$M_YES."^YES_".$M_NO."^NO"
		),
		"courses",
		"id",
		$id,
		$VALEURS_MODFIEES_SUCCESS
	);


}
?>
<br>

