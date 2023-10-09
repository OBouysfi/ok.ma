<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
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
			"settings",
			"banners",
			$M_GO_BACK,
			"",
			
			"red"
		 );
	
		?>
</div>

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
	alert("sdfsdf");
}


</script>

<h3><?php echo $M_ADD_BANNER_IN;?> "<?php echo $arrSelectedArea["name"];?>"</h3>

<br><br>
		
<?php
		

$_REQUEST["message-column-width"] = 140;
$_REQUEST["select-width"]=260;					
$_REQUEST["arrNames2"]=array("banner_type","date","expires","active","price");
$_REQUEST["arrValues2"]=array($area_id, time(), (time()+$arrSelectedArea["days"]*86400) , 1,$arrSelectedArea["price"]);

$_REQUEST["FieldsToAdd"] = "<input type=\"hidden\" name=\"area_id\" value=\"".$area_id."\"> ";
$_REQUEST["HideFormAfterSumit"] = true;
$M_MY_ADS_SITE="User Ads on the Website";		
$i_banner_id = AddNewForm
(
	array("User",$NOM.":",$M_IMAGE.":",$M_LINK_TYPE.":",$M_LINK.":"),
	array("employer","name","image_id","link_type","link"),
	array("combobox_table~employers~username~company","textbox_54","file","combobox_".$M_MY_ADS_SITE."^1_".$M_EXTERNAL_LINK."^2","textbox_54"),
	$AJOUTER,
	"banners",
	"The banner has been added successfully!",
	false,
	array(),
	""
);

?>