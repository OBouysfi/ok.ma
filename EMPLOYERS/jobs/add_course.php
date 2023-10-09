<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="fright">

	<?php
		echo LinkTile
		 (
			"jobs",
			"courses",
			$M_GO_BACK,
			"",
			"red"
		 );
	?>
</div>
<div class="clear"></div>

<h3 class="no-top-margin">
	<?php echo $M_POST_COURSE;?>
</h3>

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
	

		if(($database->SQLCount("jobs","WHERE employer='".$AuthUserName."'") + $database->SQLCount("courses","WHERE employer='".$AuthUserName."'"))>= $arrSubscription["listings"])
		{
			echo '<h4><span class="red-font">'.$M_REACHED_MAXIMUM_SUBSCR.'</span>';
			?>
			<br/><br/>
			<a class="underline-link" href="index.php?category=home&action=credits"><?php echo $M_PLEASE_SELECT_TO_POST;?></a></h4>
			<?php
			$show_post_form = false;
		}
	
	}
}
else
if($website->GetParam("CHARGE_TYPE") == 2)
{
	if($arrUser["credits"]<=0)
	{
		echo "<br/>".$M_NO_CREDITS_POST;
		?>
		<br/><br/>
		<a class="underline-link" href="index.php?category=home&action=credits"><?php echo $M_PURCHASE_CREDITS_POST;?></a>
		<?php
		$show_post_form = false;
	}
	else
	{
		
	}
}

?>

<?php
if($show_post_form)
{
?>	

<script>
String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g,"");
}

function NewJob(x)
{

document.getElementById("job_category").value=get_cat_value("category_1");
	document.getElementById("region").value=get_cat_value("region");
	
	if(x.title.value=="")
	{
		alert("<?php echo $JOB_TITLE_EMPTY;?>");
		x.title.focus();
		return false;
	}
	

	if(x.message.value=="")
	{
		alert("<?php echo $JOB_DESCRIPTION_EMPTY;?>");
		x.message.focus();
		return false;
	}
	
	return true;
}

</script>

<?php

$jsValidation="NewJob";
$arrOtherValues = array(array("date",date("F j, Y, g:i a")) , array("employer",$AuthUserName));

if(isset($_POST["SpecialProcessAddForm"]))
{

	if(trim($_POST["title"]) == "")
	{
		echo "
		<span class=\"red-font\">".$JOB_TITLE_EMPTY."</span>
		<br/>";
		$doNotAdd = true;
		unset($_REQUEST["SpecialProcessAddForm"]);
	}
	
	if(trim($_POST["message"]) == "")
	{
		echo "
		<span class=\"red-font\">".$JOB_DESCRIPTION_EMPTY."</span>";
		$doNotAdd = true;
		unset($_REQUEST["SpecialProcessAddForm"]);
	}
	
	
}



?>

<?php		

	$_REQUEST["arrNames2"] = array("date","employer","expires");
$_REQUEST["arrValues2"] = array(time(),$AuthUserName, (time() + $website->GetParam("EXPIRE_DAYS")*86400) );
			

if(isset($arrPValues))
{
	array_push($_REQUEST["arrNames2"],"more_fields");
	array_push($_REQUEST["arrValues2"],serialize($arrPValues));
}

$iLId = -1;

$strJobType="_".$M_PLEASE_SELECT."^";

foreach($website->GetParam("arrStudyModes") as $key=>$value)
{
	if($value=="") continue;
	$strJobType.="_".$value."^".$key;

}

?>
	

<?php

$arrLines = explode("\n",implode('', file('../locations/locations.php')));

if(isset($region)) $region=str_replace("~",".",$region);

$_REQUEST["message-column-width"]=140;
$_REQUEST["select-width"]=400;

$insertID = AddNewForm
(
	array
	(
		$M_COURSE_SUBJECT.":",
		$M_MODE_STUDY.":",
		$M_TITLE.":",
		$M_DESCRIPTION.":",
		
		$M_QUALIFICATION.":",
		$M_START_DATE.":",
		$M_DURATION.":",
		
		$M_REGION.":",
		$M_ZIP.":",
		$ACTIVE.":"
	),
	array
	(
		"job_category",
		"mode_study",
		"title",
		"message",
		
		"qualification",
		"date_available",
		"duration",
		
		"region",
		"zip",
		"active"
	),
	array
	(
		"global_category",
		"combobox".$strJobType,
		"textbox_67",
		"textarea_70_10",
		
		"textbox_67",
		"textbox_36",
		"textbox_36",
		
		"global_location",
		"textbox_8",
		"combobox_".$M_YES."^YES_".$M_NO."^NO"
	),
	$M_SUBMIT,
	"courses",
	'<a class="underline-link" href="index.php?category=jobs&action=courses">'.$NEW_POSTING_ADDED.'</a>',
	false,
	array(),
	"NewJob"
);



if($insertID > 0)	
{
	if(!isset($doNotAdd))
	{
			
		if($website->GetParam("CHARGE_TYPE")==2)
		{	
			$database->SQLUpdate_SingleValue
			(
				"employers",
				"id",
				$AdminUser["id"],
				"credits",
				(intval($AdminUser["credits"])-1)
			);
		}
				
	}

}


}
?>
