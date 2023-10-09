<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
$id = $_REQUEST["id"];
$website->ms_i($id);

$arrBanner = $database->DataArray("banners","id=".$id."  ");


?>
<div class="fright">

	<?php
	echo LinkTile
		 (
			"settings",
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
			array($ACTIVE,$NOM.":",$M_LINK_TYPE.":",$M_LINK." (*):"),
			array("active","name","link_type","link"),
			array(),
			array("combobox_".$M_YES."^1_".$M_NO."^0","textbox_54","combobox_".$M_MY_ADS_SITE."^1_".$M_EXTERNAL_LINK."^2","textbox_54"),
			"banners",
			"id",
			$id,
			$M_B_MODIFIED_SUCCESS
		);
		
		?>
		
		
		<br>
	
