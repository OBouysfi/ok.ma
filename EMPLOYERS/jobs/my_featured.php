<?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="pull-right">
<?php
	echo LinkTile
		 (
			"jobs",
			"my",
			$M_GO_BACK,
			"",
			"red"
		 );
	?>
</div>
<div class="clear"></div>
<h3><?php echo $M_MAKE_FEATURED;?></h3>
<?php
$id=$_REQUEST["id"];

$website->ms_i($id);

$show_form=true;

if($website->GetParam("CHARGE_TYPE") == 1)
{

	$arrSubscription = $database->DataArray("subscriptions","id=".$arrUser["subscription"]);

	if(isset($_REQUEST["featured"])&&$_REQUEST["featured"]==0)
	{
		?>
		<br/><br/><h4><?php echo $VALEURS_MODFIEES_SUCCESS;?></h4>
		<?php
	}
	else
	if(($database->SQLCount("jobs","WHERE featured=1 AND employer='".$AuthUserName."'") + $database->SQLCount("courses","WHERE featured=1 AND employer='".$AuthUserName."'"))>= $arrSubscription["featured_listings"])
	{
		$show_form=false;
		echo '<br/><br/><h4><span class="red-font">'.$M_REACHED_MAXIMUM_SUBSCR.'</span>';
		?>
		<br/><br/>
		<a class="underline-link" href="index.php?category=home&action=credits"><?php echo $M_PLEASE_SELECT_TO_FEATURED;?></a></h4>
		<?php
	}
}


if($show_form)
{
	

if($database->SQLCount("jobs","WHERE employer='".$AuthUserName."' AND id=".$id." ") == 0)
{
	die("");
}
?>

<?php
if(get_param("featured")=="1")
{

if(get_param("confirm")=="1")
{
	
	
	if($website->GetParam("CHARGE_TYPE")==3)
	{	
		?>
			<?php
			if(trim($website->GetParam("PAYPAL_ID"))!="")
			{
			?>
				<br/><br/>		
				<form id="paypal_form" name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="business" value="<?php echo $website->GetParam("PAYPAL_ID");?>">
				<input type="hidden" name="currency_code" value="<?php echo $website->GetParam("CURRENCY_CODE");?>">
				<input type="hidden" name="item_name" value="<?php echo "Featured job #".$id." on ".$DOMAIN_NAME;?> ">
				<input type="hidden" name="item_number" value="<?php echo $id;?>">
				<input type="hidden" name="amount" value="<?php echo number_format($website->GetParam("PRICE_FEATURED_JOB"), 2, '.', '');?>">
				<input type="hidden" name="notify_url" value="<?php echo "http://".$DOMAIN_NAME."/ipn_job.php?type=featured";?>">
				<input type="hidden" name="notify_url" value="<?php echo "http://".$DOMAIN_NAME."/EMPLOYERS/index.php?category=jobs&action=my";?>">
				<input type="image"  src="../images/paypal.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
				</form>
				<script>
				document.getElementById("paypal_form").submit();
				</script>
				<br><br><br>
			<?php
			}
	}


	$database->SQLUpdate_SingleValue
	(
		"jobs",
		"id",
		$id,
		"featured",
		"1"
	);	
	
	$database->SQLUpdate_SingleValue
	(
		"jobs",
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
				document.location.href="index.php?category=jobs&action=my_featured&featured=1&confirm=1&id=<?php echo $id;?>";	
			}
			
			
			function noClicked()
			{
				document.location.href="index.php?category=jobs&action=my";
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