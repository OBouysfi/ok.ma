<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="fright">
<?php
	echo LinkTile
		 (
			"jobs",
			"my",
			$MY_JOB_ADS,
			"",
			"blue"
		 );
?>
</div>	 
<div class="clear"></div>

<?php 	

$show_post_form = true;

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
	if(isset($_REQUEST["renew"])&&$_REQUEST["renew"]==1)
	{
		$banner = $_REQUEST["banner"];
		
		$website->ms_i($banner);
		
		$arrBanner=$database->DataArray("banners","id=".$banner);
		
		$arrSelectedArea = $database->DataArray("banner_areas","id=".$arrBanner["banner_type"]);
								
		
		$database->SQLUpdate_SingleValue
		(
			"banners",
			"id",
			$banner,
			"expires",
			($arrBanner["expires"]+$arrSelectedArea["days"]*86400)
			
		);	

	}

	if(isset($_POST["Delete"])&&sizeof($_POST["CheckList"])>0)
	{

		$arrImgIds = array();
		foreach($_POST["CheckList"] as $strID)
		{
			$website->ms_i($strID);
			$arrB = $database->DataArray("banners","id=".$strID." AND employer='".$AuthUserName."' ");
			
			if(!isset($arrB["id"]))
			{
				die("");
			}
			
			array_push($arrImgIds,$arrB["image_id"]);		
		}
		
		$database->SQLDelete("image","image_id",$arrImgIds);
		$database->SQLDelete("banners","id",$_POST["CheckList"]);	
	}
	?>
	<span class="medium-font"><?php echo $M_MANAGE_YOUR_BANNERS;?></span>
			
	<br>
	<br>
			
			<i>
				<?php echo $M_SELECT_BANNER_AREA;?>:
			</i>
			
			
			<br><br><br>
			
			<?php
					
			$tableAreas = $database->DataTable("banner_areas","");
			
			while($arrArea = $database->fetch_array($tableAreas))
			{
			?>
			
			<table summary="" border="0" width="100%">
				<tr>
					<td>
					
							<b>
							[<?php echo $M_AREA;?> #<?php echo $arrArea["id"];?>] 
							<?php
							echo $arrArea["name"];
							?>
							</b>
					
					</td>
					<td align="right">
					<b>
					<?php
					
					if($database->SQLCount("banners","WHERE banner_type=".$arrArea["id"]) < ($arrArea["rows"]*$arrArea["cols"]))
					{
					?>
					
							<a href="index.php?category=<?php echo $category;?>&action=add_banner&area_id=<?php echo $arrArea["id"];?>">[<?php echo strtoupper($M_SELECT);?>]</a>
					<?php
					}
					else
					{
					?>
					
					<span class="red-font"><?php echo $M_SOLD_OUT;?></span>
					
					<?php
					}
					?>		
							
					</b>
					</td>
				</tr>
			</table>
			
			<hr width="100%">
		
			<i>
			<?php
			echo $arrArea["description"];
			?>
			</i>
			<br><br>
			<?php echo $M_TOTAL_BANNERS_AREA;?>: <b><?php echo $arrArea["rows"]*$arrArea["cols"];?> </b>
			<span style="font-size:9px">[<?php echo $arrArea["rows"];?> <?php echo $M_ROWS;?> X <?php echo $arrArea["cols"];?> <?php echo $M_COLUMNS;?>]</span>
			&nbsp;
			<?php echo $M_BANNER_SIZE;?>: <b><?php echo $arrArea["width"];?>px</b> X <b><?php echo $arrArea["height"];?>px</b>
			&nbsp;
			
			<?php
			if($website->GetParam("CHARGE_TYPE") == 0)
			{
			?>	
				<?php echo $M_PRICE;?>: 
				<b>
				<?php echo $website->GetParam("WEBSITE_CURRENCY").$arrArea["price"];?>
				</b>
			<?php
			}
			else
			if($website->GetParam("CHARGE_TYPE") == 2)
			{
			?>	
				<?php echo $M_PRICE;?>: 
				<b>
				<?php echo $arrArea["price"];?>
				<?php echo $M_CREDITS;?>
				</b>
			<?php
			}
			?>
			
			&nbsp;
			<?php echo $M_DAYS2;?>: <b><?php echo $arrArea["days"];?></b>
			
			<br><br><br>
			<?php
			}
			mysql_free_result($tableAreas);
			?>
			
			
			
			
			<br>
			
			<span class="medium-font"><?php echo $M_LIST_CURRENT_B;?>:</span>
			
			
			<br>
			
			<?php

			if($database->SQLCount("banners","WHERE employer='".$AuthUserName."' ")==0)
			{
			
				echo "<br>[".$M_CURRENTLY_NO_BANNERS."]";
			
			}
			else
			{
				
				RenderTable
				(
					"banners",
					array("EditNote","RenewBanner","name","active","banner_type","date","image_id"),
					array($MODIFY,$M_RENEW,$NOM,$ACTIVE,$M_AREA2,$DATE_MESSAGE,$M_IMAGE),
					600,
					"WHERE employer='".$AuthUserName."' ",
					$EFFACER,
					"id",
					"index.php"
				);
							
							
		}
}
?>
	