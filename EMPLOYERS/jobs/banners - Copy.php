<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<?php 	

if(isset($renew)&&$renew==1)
{
		$website->ms_i($banner);
		$arrBanner=$database->DataArray("banners","id=".$banner);
		
		$arrSelectedArea = $database->DataArray("banner_areas","id=".$arrBanner["banner_type"]);
						
		
		if($arrSelectedArea["price"] > $arrUser["credits"])
		{
		
			echo "<script>alert(\"".$M_NO_CREDITS_TO_POST_BANNER."\");</script>";
		
		}
		else
		{
		
				$database->SQLUpdate_SingleValue
				(
					"banners",
					"id",
					$banner,
					"expires",
					($arrBanner["expires"]+$arrSelectedArea["days"]*86400)
					
				);	
		
				$database->SQLUpdate_SingleValue
				(
					"employers",
					"username",
					"'".$AuthUserName."'",
					"credits",
					$arrUser["credits"]-$arrSelectedArea["price"]
				);	
		}
}

if(isset($Delete)&&isset($CheckList)&&sizeof($CheckList)>0)
{

	$arrImgIds = array();
	foreach($CheckList as $strID)
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
	$database->SQLDelete("banners","id",$CheckList);	
}
?>
<table summary="" border="0" width="100%">
	<tr>
		<td width="40">
		
		
			<img src="images/icons2/folder_upload.png" width="48" height="48" alt="" border="0">
		
		
		</td>
		
		<td class=basictext>
		<span class="header_title">
			<?php echo $M_MANAGE_YOUR_BANNERS;?>
		</span>
		</td>
	</tr>
</table>
<br>
<br>
<table summary="" border="0" width="100%">
	<tr>
	
		<td class=basictext>
		
		<?php
		if(isset($area_id))
		{
		?>
		
		<script>
		
		function ValidateAddForm(x)
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
		
		
		</script>
		
		
		<b><?php echo $M_SELECTED_B_AREA;?> #<?php echo $area_id;?></b>
		
		<br><br>
		
		<?php
		$website->ms_i($area_id);
		$arrSelectedArea = $database->DataArray("banner_areas","id=".$area_id);
						
		
		if($arrSelectedArea["price"] > $arrUser["credits"])
		{
		
			echo "<font color=red><b>".$M_NO_CREDITS_TO_POST_BANNER."</b></font>";
		
		}
		else
		{
						
						
						
						$MessageTDLength = 100;
						$SelectWidth=300;
						
						
						$jsValidation = "ValidateAddForm";
								
						$_REQUEST["arrNames2"]=array("banner_type","employer","date","expires","active","price");
						$_REQUEST["arrValues2"]=array($area_id, $AuthUserName, time(), (time()+$arrSelectedArea["days"]*86400) , ($JOB_PACKAGES_AND_BANNERS_ACTIVATED_BY_DEFAULT?1:1),$arrSelectedArea["price"]);
						
						$strSpecialHiddenFieldsToAdd="<input type=\"hidden\" name=\"area_id\" value=\"".$area_id."\"> ";
								
						AddNewForm
						(
										array($NOM.":",$M_IMAGE.":",$M_LINK_TYPE.":",$M_LINK." (*):"),
										array("name","image_id","link_type","link"),
										array("textbox_54","file","combobox_".$M_JOB_ADS."^1_".$M_EXTERNAL_LINK."^2","textbox_54"),
										" $AJOUTER ",
										"banners",
										$M_BANNER_ADDED_SUCCESS."!<br>
										<br>
										
										"
						);
						
						if(isset($SpecialProcessAddForm))
						{
							if(!$JOB_PACKAGES_AND_BANNERS_ACTIVATED_BY_DEFAULT)
							{
							 
							 	$database->SQLUpdate_SingleValue
								(
									"employers",
									"username",
									"'".$AuthUserName."'",
									"credits",
									$arrUser["credits"]-$arrSelectedArea["price"]
								);	
							 
							 
							}
							else
							{
				
				
							
								if($SEND_PAYMENT_EMAILS)
								{
								
									$headers  = "From: \"".$SYSTEM_EMAIL_FROM."\"<".$SYSTEM_EMAIL_ADDRESS.">\n";
				
									$PAYMENT_EMAIL_TEXT = str_replace("[AMOUNT]",$arrSelectedArea["price"],$PAYMENT_EMAIL_TEXT);
									
									mail($AuthUserName,$PAYMENT_EMAIL_SUBJECT,$PAYMENT_EMAIL_TEXT , $headers);	
								
									echo "<br>".$PAYMENT_EMAIL_TEXT;
								}
								
							
							}
						}
						else
						{
							echo "<br>(*) (".$M_EX." http://www.company.com)<br><br>";
						}
						
		}
		
?>
		
		<?php
		}
		else
		{
		?>
		
		
		<b>
			<?php echo $M_SELECT_BANNER_AREA;?>:
		</b>
		
		
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
				
				
				if($database->SQLCount("banners","WHERE expires>".time()." AND banner_type=".$arrArea["id"]) < ($arrArea["rows"]*$arrArea["cols"]))
				{
				?>
				
						<a href="index.php?category=<?php echo $category;?>&action=<?php echo $action;?>&area_id=<?php echo $arrArea["id"];?>">[<?php echo strtoupper($M_SELECT);?>]</a>
				<?php
				}
				else
				{
				?>
				
				<?php echo $M_SOLD_OUT;?>
				
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
		<?php echo $M_PRICE;?>: <b><?php echo $arrArea["price"];?> <?php echo $M_CREDITS;?></b>
		&nbsp;
		<?php echo $M_DAYS2;?>: <b><?php echo $arrArea["days"];?></b>
		
		<br><br><br>
		<?php
		}
		
		?>
		
		
		<?php
		}
		?>		
		
		
		<br>
		
		<b><?php echo $M_LIST_CURRENT_B;?>:</b>
		
		
		<br><br>
		
		<?php

		$arrTDSizes=array("50","50","50","100","*","50","50","50","50","50","50");

		if($database->SQLCount("banners","WHERE employer='".$AuthUserName."' ")==0)
		{
		
			echo "<br>[".$M_CURRENTLY_NO_BANNERS."]";
		
		}
		else
		{
			
			
				
						RenderTable
						(
										"banners",
										array("EditCar","RenewBanner","name","active","banner_type","date","image_id"),
										array($MODIFY,$M_RENEW,$NOM,$ACTIVE,$M_AREA2,$DATE_MESSAGE,$M_IMAGE),
										750,
										"WHERE employer='".$AuthUserName."' ",
										$EFFACER,
										"id",
										"index.php?action=".$action."&category=".$category
						);
						
						
		}
		?>
		
		
		
		
		
		</td>
	</tr>
</table>
<br>
