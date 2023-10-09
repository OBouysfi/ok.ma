<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
?>

<?php
if($website->GetParam("CHARGE_TYPE") == 1)
{
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
		
		?>

	</div>
	<div class="clear"></div>


	<span class="medium-font"><?php echo $M_SUBSCRIPTIONS;?></span>
	<br/><br/><br/>
	<i><?php echo $M_PURCHASE_SUBSCRIPTION_EXPL;?></i>
	<br/><br/>
	<?php
	if($arrUser["subscription"]==0)
	{
	?>
		<?php echo $M_ANY_SUBSCRIPTION;?>
		<br/><br/>
	<?php
	}
	else
	{
	?>
		<h3><?php echo $M_YOUR_CURRENT_SUBSCRIPTION;?>:</h3>
		
	<?php
		$arrSubscription = $database->DataArray("subscriptions","id=".$arrUser["subscription"]);
	
		echo "<b>".stripslashes($arrSubscription["name"])."</b><br/>".stripslashes($arrSubscription["description"]);
		echo "<br/><br/>"
		.$M_MAX_LISTINGS.": <b>".$arrSubscription["listings"]."</b>, ".
		$M_MAX_FEATURED_LISTINGS.": <b>".$arrSubscription["featured_listings"]."</b>, ".
		$M_MAX_BANNERS.": <b>".$arrSubscription["banners"]."</b>";
	}
	?>
	<br/><br/>
	<h3>
	<?php
	echo $M_CHOOSE_NEW_SUBSCRIPTION;
	?>
	</h3>
	<hr/>
	<?php
	$subscriptions = $database->DataTable("subscriptions","WHERE id<>".$arrUser["subscription"]);
	
	while($current_subscription = $database->fetch_array($subscriptions))
	{
		echo "<a style=\"float:right;display:block;text-align:center;width:120px\" href=\"index.php?category=home&action=new_subscription&id=".$current_subscription["id"]."\" class=\"btn btn-default btn-gradient\">".$M_SELECT."</a>";
		
		echo "<b>".stripslashes($current_subscription["name"]).", ".$M_PRICE.": ".$website->GetParam("WEBSITE_CURRENCY").$current_subscription["price"]." / ".$current_subscription["billed"]." ".($current_subscription["billed"]==1?$M_MONTHS:$M_MONTHS)."</b><br/><br/>".stripslashes($current_subscription["description"]);
		echo "<br/><br/>"
		.$M_MAX_LISTINGS.": ".$current_subscription["listings"].", ".
		$M_MAX_FEATURED_LISTINGS.": ".$current_subscription["featured_listings"].", ".
		$M_MAX_BANNERS.": ".$current_subscription["banners"];
		echo "<br/>";
		echo "<hr/><br/><br/>";
	}
	
	?>

<?php
}
?>	
	
<?php
if($website->GetParam("CHARGE_TYPE") == 2)
{
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
			"home",
			"credits_purchase",
			$M_PURCHASE_CREDITS,
			"",
			"green"
		 );
	?>

</div>
<div class="clear"></div>
	<h3><?php echo $M_CREDIT_PURCHASE;?></h3>
					
	<br/>
		
		
		<?php echo $M_CURRENTLY_YOU_HAVE;?> <font color="red"><?php if($arrUser["credits"]>=0) echo $arrUser["credits"];else echo "0";?> <?php echo $M_CREDITS;?> </font>
		&nbsp;
		,&nbsp; <?php echo $M_PRICE_FOR;?> 1 <?php echo $M_CREDIT;?> 
		<font color=red>
		<?php echo $website->GetParam("WEBSITE_CURRENCY");?><?php echo aParameter(700);?>
		</font>
		
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="index.php?category=home&folder=credits&page=purchase">[<?php echo $M_PURCHASE_CREDITS;?>]</a>
		
		
		<br><br><br><br><br>
		<b><?php echo $M_VIEW_CANCEL_PENDING_PAYMENTS;?>:</b>
		<br><br>
	
		<?php
		
		if(isset($_REQUEST["Delete"])&&isset($_REQUEST["CheckList"]))
		{
			$website->ms_ia($_REQUEST["CheckList"]);
			$database->SQLDeletePlus("employer",$AuthUserName,"credits","id",$_REQUEST["CheckList"]);
		}
		
		if($database->SQLCount("credits","WHERE employer='".$AuthUserName."' and status=0   ")==0)
		{
			echo "<br>[".$M_ANY_PENDING_PAYMENTS."]";
		
		}
		else
		{
			
			RenderTable
			(
				"credits",
				array("date_start","credits","amount","payment"),
				array($DATE_MESSAGE,$M_CREDITS,$M_AMOUNT,$M_PAYMENT),
				"600",
				"WHERE employer='$AuthUserName' and status=0   ",
				"Cancel",
				"id",
				"index.php?action=".$action."&category=".$category
			);
			
		}
				
		?>
		<div class="clearfix"></div>
		<br/>
		<br/>
		<br/>
		<h3><?php echo $M_PRICES_CREDITS;?></h3>
		<br>	
			<strong><?php echo $M_SUBMIT_LISTING;?></strong>
			<br/>
			<?php echo $M_CREDITS;?>: <font color=red><b><?php echo $website->GetParam("PRICE_LISTING_CREDITS");?></b></font>
			
			<br><br>
						
			<strong><?php echo $M_PRICE_FEATURED_AD;?></strong>
			<br/>
			<?php echo $M_CREDITS;?>: <font color=red><b><?php echo aParameter(703);?></b></font>
			
			<br><br>
			
			<?php
			if($database->SQLCount("banners","")>0)
			{
			?>
			
			<strong><?php echo $M_BANNERS;?></strong>
		<br>
			
			<?php echo $M_PRICES_FROM;?>
			<?php echo $M_CREDITS;?>: <font color=red><b><?php echo $database->SQLMin("banner_areas","price");?></b></font>
			&nbsp; <?php echo strtolower($M_TO);?> &nbsp; 
			<?php echo $M_CREDITS;?>: <font color=red><b><?php echo $database->SQLMax("banner_areas","price");?></b></font>
			&nbsp;&nbsp; 
			<?php echo $M_DEPENDING_ZONE;?>
			<br><br>
		
			<?php
			}
			?>
		
		
<?php
}
?>	