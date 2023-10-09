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
$id = $_REQUEST["id"];
$website->ms_i($id);

$arrBanner = $database->DataArray("banners","id=".$id." AND employer='".$AuthUserName."' ");

if(!isset($arrBanner["id"]))
{
	die("");
}
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


<h3>
	<?php echo $M_MODIFY_SELECTED_B;?>
	"<?php echo stripslashes($arrBanner["name"]);?>"
</h3>
		
<br>

		<?php
		$_REQUEST["message-column-width"] = 140;
		$_REQUEST["select-width"]=260;	
		AddEditForm
		(
			array($NOM.":",$M_IMAGE.":",$M_LINK_TYPE.":",$M_LINK." (*):"),
			array("name","image_id","link_type","link"),
			array(),
			array("textbox_54","file","combobox_".$M_MY_ADS_SITE."^1_".$M_EXTERNAL_LINK."^2","textbox_54"),
			"banners",
			"id",
			$id,
			$M_B_MODIFIED_SUCCESS
		);
		
		?>
		
		
		<br>
	
