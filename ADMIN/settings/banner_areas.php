<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!isset($iKEY)||$iKEY!="AZ8007") die("ACCESS DENIED");

?>
<?php
if(isset($_POST["Delete"])&&sizeof($_POST["CheckList"])>0)
{
	$database->SQLDelete("banner_areas","id",$_POST["CheckList"]);
}
?>


<div class="fright">
<?php
	
	echo LinkTile
	 (
		"settings",
		"banners",
		$M_BANNERS,
		"",
		
		"lila"
	 );
	 
	 echo LinkTile
	 (
		"settings",
		"place_banner",
		$M_ADD_NEW_B,
		"",
		
		"yellow"
	 );
	 
	echo LinkTile
	 (
		"settings",
		"add_banner_area",
		$M_NEW_B_AREA,
		$M_ADD_NEW_AREA,
		
		"green"
	 );
	
?>

</div>

<div class="clear"></div>

<span class="medium-font"  id="page-header"><?php echo $M_MANAGE_BANNER_AREAS;?></span>
	
<br/>
<?php

$arrTDSizes=array("50","50","100","*","50","50","50","50","50","50");

RenderTable
	(
		"banner_areas",
		array("EditNote","id","name","rows","cols","width","height","price","days"),
		array($MODIFY,"ID",$NOM,$M_ROWS,$M_COLUMNS,$M_WIDTH,$M_HEIGHT,$M_PRICE,$M_DAYS2),
		750,
		"",
		$EFFACER,
		"id",
		"index.php",
		true,
		20,
		false,
		-1,
		"ORDER BY ID desc"
	);
?>