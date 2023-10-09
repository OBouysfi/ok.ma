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
$area_id = $_REQUEST["area_id"];
$website->ms_i($area_id);
$arrSelectedArea = $database->DataArray("banner_areas","id=".$area_id);

?>
<div class="fright">

	<?php
	echo LinkTile
		 (
			"jobs",
			"banners",
			$M_GO_BACK,
			"",
			
			"red"
		 );
	
		?>
</div>
<div class="clear"></div>
<script>
		
function ValidateForm(x)
{
	if(x.name.value=="")
	{
		alert("<?php echo $M_PLEASE_ENTER_BANNER_NAME;?>!");
		x.name.focus();
		return false;
	}
	
	if(x.image_id.value=="")
	{
		alert("<?php echo $M_PLEASE_SELECT_IMAGE_FILE;?>!");
		x.image_id.focus();
		return false;
	}
	
	return true;	
}

function CallBack()
{

	loadPage("#ads-banners");
}


</script>

<span class="medium-font"><?php echo $M_ADD_BANNER_IN;?> "<?php echo $arrSelectedArea["name"];?>"</span>

<br><br>
		
<?php
		

$_REQUEST["message-column-width"] = 140;
$_REQUEST["select-width"]=260;					
$_REQUEST["arrNames2"]=array("banner_type","employer","date","expires","active","price");
$_REQUEST["arrValues2"]=array($area_id, $AuthUserName, time(), (time()+$arrSelectedArea["days"]*86400) , 0,$arrSelectedArea["price"]);

$_REQUEST["FieldsToAdd"] = "<input type=\"hidden\" name=\"area_id\" value=\"".$area_id."\"> ";
$_REQUEST["HideFormAfterSumit"] = true;


$show_post_form = true;

if($website->GetParam("CHARGE_TYPE") == 2 && $arrUser["credits"] < $arrSelectedArea["price"])
{
	$show_post_form = false;
	?>
	<br/><br/>
	<a class="underline-link" href="index.php?category=home&action=credits"><?php echo $M_PURCHASE_CREDITS_POST;?></a>
	<?php
}
else
if($website->GetParam("CHARGE_TYPE") == 1)
{
	if($arrUser["subscription"]==0)
	{
		$show_post_form = false;
		?>
		<a class="underline-link" href="index.php?category=home&action=credits"><?php echo $M_PLEASE_SELECT_TO_POST;?></a>
		<?php
	}
	else
	{
		
		$arrSubscription = $database->DataArray("subscriptions","id=".$arrUser["subscription"]);
	
		if($database->SQLCount("banners","WHERE employer='".$AuthUserName."'") >= $arrSubscription["banners"])
		{
			echo $M_REACHED_MAXIMUM_SUBSCR;
			?>
			<br/><br/>
			<a href="index.php?category=home&action=credits"><?php echo $M_PLEASE_SELECT_TO_POST;?></a>
			<?php
			$show_post_form = false;
		}
	
	}
}

if($show_post_form)
{
			
	$i_banner_id = AddNewForm
	(
		array($NOM.":",$M_IMAGE.":",$M_LINK_TYPE.":",$M_LINK." (*):"),
		array("name","image_id","link_type","link"),
		array("textbox_54","file","combobox_".$M_MY_ADS_SITE."^1_".$M_EXTERNAL_LINK."^2","textbox_54"),
		$AJOUTER,
		"banners",
		""
	);


	if(isset($_REQUEST["SpecialProcessAddForm"]))
	{
		if($website->GetParam("CHARGE_TYPE") == 0)
		{
	?>
			<?php echo $M_PLEASE_SELECT_PAYMENT;?>
				
				<?php
				if(trim($website->GetParam("PAYPAL_ID")) !="")
				{
				?>	<br/><br/>
					<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
					<input type="hidden" name="cmd" value="_xclick">
					<input type="hidden" name="business" value="<?php echo $website->GetParam("PAYPAL_ID");?>">
					<input type="hidden" name="currency_code" value="<?php echo $website->GetParam("CURRENCY_CODE");?>">
					<input type="hidden" name="item_name" value="Payment for banner id#<?php echo $i_banner_id;?> on <?php echo $DOMAIN_NAME;?>">
					<input type="hidden" name="item_number" value="<?php echo $i_banner_id;?>">
					<input type="hidden" name="amount" value="<?php echo number_format($arrSelectedArea["price"], 2, '.', '');?>">
					<input type="image"  src="../images/paypal.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
					</form>
				<?php
				}
				?>
				
				<?php
				if(trim($website->GetParam("2CHECKOUT_ID")) !="")
				{
				?>	<br/><br/>
				
					<form target="_blank" action="https://www.2checkout.com/cgi-bin/sbuyers/cartpurchase.2c" method="post">
					<input type="hidden" name="sid" value="<?php echo trim($website->GetParam("2CHECKOUT_ID"));?>"> 
					<input type="hidden" name="cart_order_id" value="<?php echo $i_banner_id;?>"> 
					<input type="hidden" name="total" value="<?php echo number_format($arrSelectedArea["price"], 2, '.', '');?>">
					<input type="hidden" name="skip_landing" value="1"> 
					<input type="image" src="../images/2checkout.gif" alt="" border="0">
					</form>
					
				<?php
				}
				
			}
			else
			if($website->GetParam("CHARGE_TYPE") == 2)
			{
			
				$database->SQLUpdate_SingleValue
				(
					"re_users",
					"username",
					"'".$AuthUserName."'",
					"credits",
					$arrUser["credits"]-$arrSelectedArea["price"]
				);	
			
			}
	
	}
	else
	{
		echo "<br/><br/><br/>(*) (".$M_EX." http://www.company.com)<br><br>";
	}
}
?>