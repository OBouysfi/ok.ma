<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php 	

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
		$arrB = $database->DataArray("banners","id=".$strID." ");
		
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


<div class="fright">

	<?php
	echo LinkTile
		 (
			"settings",
			"banner_areas",
			$M_BANNER_AREAS,
			"",
			
			"blue"
		 );
		 
	echo LinkTile
		 (
			"settings",
			"place_banner",
			$M_ADD_NEW_B,
			"",
			
			"green"
		 );
		?>
</div>
<div class="clear"></div>
<br/>
		
		<b><?php echo $M_LIST_CURRENT_B;?>:</b>
		
		
		<br>
		
		<?php

		if($database->SQLCount("banners","")==0)
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
				" ",
				$EFFACER,
				"id",
				"index.php"
			);
						
						
		}
		?>
	