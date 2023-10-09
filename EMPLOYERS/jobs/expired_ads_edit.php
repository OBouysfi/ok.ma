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
			"jobs",
			"expired_ads",
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


if($database->SQLCount("jobs","WHERE employer='".$AuthUserName."' AND id=".$id." ") == 0)
{
	die("");
}
$proceed_renew=false;
if($website->GetParam("CHARGE_TYPE") == 0)
{

	$proceed_renew=true;	
	
}
else
if($website->GetParam("CHARGE_TYPE") == 1)
{
	if($arrUser["subscription"]==0)
	{
	
		?>
		<a class="underline-link" href="index.php?category=home&action=credits"><?php echo $M_PLEASE_SELECT_TO_POST;?></a>
		<?php
	}
	else
	{
		
		$arrSubscription = $database->DataArray("subscriptions","id=".$arrUser["subscription"]);
	
		if(($database->SQLCount("jobs","WHERE employer='".$AuthUserName."'") + $database->SQLCount("courses","WHERE employer='".$AuthUserName."'"))>= $arrSubscription["listings"])
		{
			echo '<h4><span class="red-font">'.$M_REACHED_MAXIMUM_SUBSCR.'</span>';
			?>
			<br/><br/>
			<a class="underline-link" href="index.php?category=home&action=credits"><?php echo $M_PLEASE_SELECT_TO_POST;?></a></h4>
			<?php
		
		}
		else
		{
			$proceed_renew=true;	
		}
	
	}
}
else
if($website->GetParam("CHARGE_TYPE") == 2)
{
	if($arrUser["credits"]<=0)
	{
		echo $M_NO_CREDITS_POST;
		?>
		<br/><br/>
		<a class="underline-link" href="index.php?category=home&action=credits"><?php echo $M_PURCHASE_CREDITS_POST;?></a>
		<?php
		$show_post_form = false;
	}
	else
	{
		$database->SQLUpdate_SingleValue
		(
			"employers",
			"id",
			$AdminUser["id"],
			"credits",
			(intval($AdminUser["credits"])-1)
		);
		$proceed_renew=true;	
	}
}

if($proceed_renew)
{

	$database->SQLUpdate_SingleValue
	(
		"jobs",
		"id",
		$id,
		"expires",
		time()+$website->GetParam("EXPIRE_DAYS")*86400
	);
	
	$database->SQLUpdate_SingleValue
	(
		"jobs",
		"id",
		$id,
		"date",
		time()
	);

	?>
	<h3>Your job has been renewed successfully!</h3>
	<?php
}
?>
