<?php
if(!defined('IN_SCRIPT')) die("");
?>
<?php
$id=$_REQUEST["id"];
$website->ms_i($id);

$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
$arrSubscription = $database->DataArray("subscriptions","id=".$id);
	
if($arrSubscription["price"]==0)
{
	$database->SQLUpdate_SingleValue
	(
		"employers",
		"id",
		$arrUser["id"],
		"subscription",
		$id
	);
	
	echo "<br/><h4>".$M_THANK_YOU_PACKAGE_ADDED."</h4>";
}
else
{	
	$database->SQLUpdate_SingleValue
	(
		"employers",
		"id",
		$arrUser["id"],
		"new_subscription",
		$id
	);

	$s_num=rand(100000,999999);
	$database->SQLUpdate_SingleValue
	(
		"employers",
		"id",
		$arrUser["id"],
		"subscription_code",
		$s_num
	);
		
	?>
	<h3>
	<?php echo $M_PLEASE_SELECT_PAYMENT;?>
	</h3>
	<br/>		
				
	<?php
	if(trim($website->GetParam("PAYPAL_ID")) !="")
	{
	?>

	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
	<input type="image" src="../images/paypal.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
	 <input type="hidden" name="cmd" value="_xclick-subscriptions">
	<input type="hidden" name="business" value="<?php echo $website->GetParam("PAYPAL_ID");?>"> 
	<input type="hidden" name="item_name" value="<?php echo $DOMAIN_NAME." ".$M_SUBSCRIPTION." ID#".$arrSubscription["id"]." (".stripslashes($arrSubscription["name"]).")"; ?>"> 
	<input type="hidden" name="item_number" value="<?php echo $s_num;?>"> 
	<input type="hidden" name="no_note" value="1"> 
	<input type="hidden" name="currency_code" value="<?php echo $website->GetParam("CURRENCY_CODE");?>"> 
	<input type="hidden" name="a3" value="<?php echo $arrSubscription["price"]; ?>"> 
	<input type="hidden" name="p3" value="<?php echo $arrSubscription["billed"]; ?>"> 
	<input type="hidden" name="t3" value="M"> 
	<input type="hidden" name="src" value="1"> 
	<input type="hidden" name="sra" value="1"> 
	<input type="hidden" name="return" value="http://<?php echo $DOMAIN_NAME;?>/EMPLOYERS/index.php"> 
	<input type="hidden" name="cancel_return" value="http://<?php echo $DOMAIN_NAME;?>/EMPLOYERS/index.php"> 
	<input type="hidden" name="notify_url" value="<?php echo "http://".$DOMAIN_NAME."/ipn.php";?>">
					
	<input type="hidden" name="custom" value="<?php echo $AuthUserName; ?>"> 
	</form>
	<?php
	}
	
	
	if(trim($website->GetParam("MONEYBOOKERS_ID")) !="")
	{
	?>
		<br/><br/>
			<form action="https://www.moneybookers.com/app/payment.pl" method="post"> 
			<input type="hidden" name="pay_to_email" value="<?php echo $website->GetParam("MONEYBOOKERS_ID");?>"> 
			<input type="hidden" name="status_url" value="<?php echo $website->GetParam("MONEYBOOKERS_ID");?>"> 
			<input type="hidden" name="transaction_id" value="<?php echo $s_num;?>"> 
			<input type="hidden" name="language" value="EN"> 
			<input type="hidden" name="rec_amount" value="<?php echo $arrSubscription["price"]; ?>"> 
			<input type="hidden" name="rec_cycle" value="month"/>
			<input type="hidden" name="rec_period" value="<?php echo $arrSubscription["billed"]; ?>"/>
			<input type="hidden" name="currency" value="<?php echo $website->GetParam("CURRENCY_CODE");?>"> 
			<input type="hidden" name="detail1_description" value="<?php echo $DOMAIN_NAME." ".$M_SUBSCRIPTION." ID#".$arrSubscription["id"]." (".stripslashes($arrSubscription["name"]).")"; ?>"> 
			<input type="hidden" name="detail1_text" value="<?php echo $DOMAIN_NAME." ".$M_SUBSCRIPTION." ID#".$arrSubscription["id"]." (".stripslashes($arrSubscription["name"]).")"; ?>"> 
			<input type="hidden" name="confirmation_note" value=""> 
			<input type="image"  src="../images/skrill.jpg" border="0">
			</form> 
			
	<?php
	}

	if(trim($website->GetParam("2CHECKOUT_ID")) !="")
	{
	?>
	<br/><br/>
	
	<form action="https://www.2checkout.com/2co/buyer/purchase" method="POST">
	<input type="hidden" name="sid" value="<?php echo $website->GetParam("2CHECKOUT_ID");?>">
	<input type="hidden" name="mode" value="2CO">
	<input type="hidden" name="li_1_price" value="<?php echo $arrSubscription["price"]; ?>">
	<input type="hidden" name="li_1_name" value="<?php echo $DOMAIN_NAME." ".$M_SUBSCRIPTION." ID#".$arrSubscription["id"]." (".stripslashes($arrSubscription["name"]).")"; ?>">
	<input type="hidden" name="li_1_tangible" value="N">
	<input type="hidden" name="li_1_quanity" value="1">
	<input type="hidden" name="li_1_startup_fee" value="0">
	<input type="hidden" name="li_1_type" value="product">
	<input type="hidden" name="li_1_recurrence" value="<?php echo $arrSubscription["billed"]; ?> Month">
	<input type="hidden" name="li_1_duration" value="Forever">
	<input type="image" src="../images/2checkout.gif" border="0" name="submit" >
	
	</form>

	<?php
	}


	if(trim($website->GetParam("BANK_ACCOUNT"))!="")
	{
		echo "<br/>";
		echo "<h4>".nl2br(stripslashes($website->GetParam("BANK_ACCOUNT")))."</h4>";
	}

	if(trim($website->GetParam("CHEQUES_ADDRESS"))!="")
	{
		echo "<br/>";
		echo "<h4>".nl2br(stripslashes($website->GetParam("CHEQUES_ADDRESS")))."</h4>";
	}
}
?>