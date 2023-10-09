<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}

?>

<div class="fright">
<?php
echo LinkTile
 (
	"settings",
	"subscriptions",
	$M_GO_BACK,
	$M_GO_BACK_PACKS,
	
	"red"
 );
 

?>
	
</div>

<script>

function ValidateForm(x)
{
	if(x.name.value=="")
	{
		x.name.style.background="#edeff3";
		
		document.getElementById("page-header").innerHTML=
		"The name can not be empty!";
		return false;
	}
	
	
	return true;
	
}
function CallBack()
{
	lock_check = false;
	document.getElementById("page-header").innerHTML
	= "<?php echo $M_NEW_PACKAGE_ADDED;?>";

	loadPage("#users-subscriptions");
}
</script>


<div class="clear"></div>
<br>
<span class="medium-font" id="page-header">
<?php echo $M_ADD_NEW_PACKAGE;?>
</span>
<br><br>
<?php


$_REQUEST["select-width"]="260";
$_REQUEST["message-column-width"]="210";

AddNewForm
(
	array
		(
			$NOM.":",
			$M_DESCRIPTION.":",
			$M_MAX_LISTINGS.":",
			$M_MAX_FEATURED_LISTINGS.":",
			$M_MAX_BANNERS.":",
			
			$M_PRICE.":",
			$M_BILLED_MONTHS.":",
		
			
			$M_PAYMENT_CODE
),
array
(
			"name",
			"description",
			"listings",
			"featured_listings",
			"banners",
			"price",
			"billed",
			
			
			"html"
		),
		array
		(
			"textbox_50",
			"textarea_50_3",
			"textbox_5",
			"textbox_5",
			"textbox_5",
			
			"textbox_5",
			"combobox_1_3_6_12_24",
			
			"textarea_50_3"
		),
	$M_ADD,
	"subscriptions",
	"",
	true,
	array(),
	""
);


?>	