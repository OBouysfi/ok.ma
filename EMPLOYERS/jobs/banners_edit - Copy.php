<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?>
<?php

$website->ms_i($id);

$arrBanner = $database->DataArray("banners","id=".$id." AND employer='".$AuthUserName."' ");

if(!isset($arrBanner["id"]))
{
	die("");
}
?>

<table summary="" border="0" width="100%">
	<tr>
		
		
		<td class=basictext>
		<i>
			<?php echo $M_MODIFY_SELECTED_B;?>
		</i>
		</td>
	</tr>
</table>
<br>
<table summary="" border="0" width="100%">
	<tr>
		<td class=basictext>
		
		
		<?php
		
		$SubmitButtonText = $SAUVEGARDER;
		
		
		
		AddEditForm
		(
						array($NOM.":",$M_IMAGE.":",$M_LINK_TYPE.":",$M_LINK." (*):"),
						array("name","image_id","link_type","link"),
						array(),
						array("textbox_54","file","combobox_".$M_JOB_ADS."^1_".$M_EXTERNAL_LINK."^2","textbox_54"),
						"banners",
						"id",
						$id,
						$M_B_MODIFIED_SUCCESS."!<br>
						<br>
						
						"
		);
		
		?>
		
		
		<br>
		
		<?php
		generateBackLink("banners");
		?>
		
		
		</td>
	</tr>
</table>
