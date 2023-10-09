<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<?php
$id=$_REQUEST["id"];
$website->ms_i($id);
if($database->SQLCount("jobs","WHERE employer='".$AuthUserName."' AND id=".$id." ") == 0)
{
	die("");
}
?>
<div class="fright">

	<?php
		echo LinkTile
		 (
			"jobs",
			"my_stat&id=".$id,
			$M_VISITS." (".$database->SQLCount("jobs_stat","WHERE posting_id=".$id).")",
			"",
			"gray"
		 );
		 
		 echo LinkTile
		 (
			"application_management",
			"list&Proceed=1&id=".$id,
			$M_APPLICATIONS." (".$database->SQLCount("apply","WHERE posting_id=".$id).")",
			"",
			"yellow"
		 );
		 
		 
		echo LinkTile
		 (
			"jobs",
			"my",
			$M_GO_BACK,
			"",
			"red"
		 );
	?>
</div>
<div class="clear"></div>
<br/>


<h3>
	<?php echo $MODIFY_SELECTED_ADD;?>
</h3>
<br/>

<?php
if(get_param("featured")=="1")
{

if(get_param("confirm")=="1")
{
	$website->ms_i($id);
	
	$database->SQLUpdate_SingleValue
	(
		"jobs",
		"id",
		$id,
		"featured",
		"1"
	);	
	
	$database->SQLUpdate_SingleValue
	(
		"jobs",
		"id",
		$id,
		"featured_expires",
		time()+86400*$website->GetParam("FEATURED_ADS_EXPIRE")
	);	
	
if(!$website->GetParam("FREE_WEBSITE"))
{	
	$database->SQLUpdate_SingleValue
	(
		"employers",
		"username",
		"'".$AuthUserName."'",
		"credits",
		$arrUser["credits"]-aParameter(703)
	);	
}
?>

<br>
<h3><?php echo $M_THANK_YOU;?>!</h3>
<br><br>
		
	
<?php
}
else
{

?>



		
		<?php
		if(!$website->GetParam("FREE_WEBSITE"))
		{
		?>
		
		
		<?php echo $M_PRICE_CREDITS_ADS_FEATURED;?>:
		
		<b style="font-size:14px"><?php echo aParameter(703);?></b>
		
		<br><br>
		<?php
		}
		?> 
		
		
		<?php
		
		if($arrUser["credits"]<aParameter(703)&&!$website->GetParam("FREE_WEBSITE"))
		{
		
				echo $M_NOT_ENOUGH_CREDITS_TO_MAKE_FEATURED;
		
		}
		else
		{
			
		?>	
			
			<script>
			
			function yesClicked()
			{
				document.location.href="index.php?category=jobs&folder=my&page=edit&featured=1&confirm=1&id=<?php echo $id;?>";	
			}
			
			
			function noClicked()
			{
				document.location.href="index.php?category=jobs&folder=my&page=edit&id=<?php echo $id;?>";
			}
			
			</script>
			
			<form>
			<br><br>
			<i><?php echo $M_PLEASE_CONFIRM_FEATURED;?>:</i>
			<br>
			<br><br>
			<center>
			<input type="button" onclick="javascript:yesClicked()" value=" <?php echo $M_YES;?> " class="adminButton">
			&nbsp;&nbsp;&nbsp;
			<input type="button" onclick="javascript:noClicked()" value=" <?php echo $M_NO;?> " class="adminButton">
			</center>
			</form><br>
			
		<?php		
		}
		?>
		
<?php
}

}
else
{
?>

<?php

$MessageTDLength = 130;

$SubmitButtonText = $SAUVEGARDER;

$strSpecialHiddenFieldsToAdd="";


if(is_array(unserialize(stripslashes(aParameter(280)))))
{
		$arrJobFields = unserialize(stripslashes(aParameter(280)));
}
else
{
		$arrJobFields = array();
}	

	$arrAd = $database->DataArray("jobs","id=".$id);

if(isset($SpecialProcessEditForm))
{
		$iFCounter = 0;

		$arrPValues = array();
			
		$iFCounter = 0;
			
		foreach($arrJobFields as $arrJobField)
		{		
			$arrPValues[$arrJobField[0]]=get_param("pfield".$iFCounter);
			$iFCounter++;
		}		
		
		$database->SQLUpdate_SingleValue
		(
				"jobs",
				"id",
				$id,
				"more_fields",
				serialize($arrPValues)
		);
		$arrAd = $database->DataArray("jobs","id=".$id);

}

		

$arrPropFields = array();
							
if(is_array(unserialize($arrAd["more_fields"])))
{
				
		$arrPropFields = unserialize($arrAd["more_fields"]);
}



$iFCounter = 0;

foreach($arrJobFields as $arrJobField)
{
	
	$strSpecialHiddenFieldsToAdd.="<tr>";
	
	$strSpecialHiddenFieldsToAdd.= "<td ><i>".str_show($arrJobField[0], true).":</i></td>";	
	
	$strSpecialHiddenFieldsToAdd.= "<td >";
	
	if(trim($arrJobField[2]) != "")
	{
			$strSpecialHiddenFieldsToAdd.= "<select  name=\"pfield".$iFCounter."\" style=\"width:150px\">";
			
			
			$arrFieldValues = explode("\n", trim($arrJobField[2]));
					
						
			if(sizeof($arrFieldValues) > 0)
			{
				foreach($arrFieldValues as $strFieldValue)
				{
					$strFieldValue = trim($strFieldValue);
					if(strstr($strFieldValue,"{"))
					{
					
						$strVName = substr($strFieldValue,1,strlen($strFieldValue)-2);
						
						$strSpecialHiddenFieldsToAdd.= "<option ".(trim($$strVName)==$arrPropFields[$arrJobField[0]]?"selected":"").">".trim($$strVName)."</option>";
						
					}
					else
					{
						$strSpecialHiddenFieldsToAdd.= "<option ".(isset($arrPropFields[$arrJobField[0]])&&trim($strFieldValue)==$arrPropFields[$arrJobField[0]]?"selected":"").">".trim($strFieldValue)."</option>";
					}		
				
				}
			}
			
			$strSpecialHiddenFieldsToAdd.= "</select>";
	}
	else
	{
			$strSpecialHiddenFieldsToAdd.= "<input value=\"".(isset($arrPropFields[$arrJobField[0]])?$arrPropFields[$arrJobField[0]]:"")."\" type=text name=\"pfield".$iFCounter."\" style=\"width:150px\">";
	}
	
	$strSpecialHiddenFieldsToAdd.= "</td>";
	
	
		$strSpecialHiddenFieldsToAdd.= "</tr>";
	

	$iFCounter++;		
}
		

  $strJobType="";

foreach($website->GetParam("arrJobTypes") as $key=>$value)
{
	
	$strJobType.="_".$value."^".$key;

}


$SelectWidth = 500;
$MessageTDLength=120;
$strAuthQuery = "employer='".$AuthUserName."'";
?>
<script src="js/nicEdit.js" type="text/javascript"></script>
<script type="text/javascript">
bkLib.onDomLoaded(function() {
	new nicEditor({buttonList : ['fontSize','bold','italic','forecolor','fontFamily','link','unlink','left','center','right','justify','ol','ul','removeformat','indent','outdent','hr','bgcolor','underline','html'],iconsPath : 'js/nicEditorIcons.gif'}).panelInstance('message');
});
</script>

<script>
String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g,"");
}

function EditJob(x)
{

	
		
	if(x.title.value=="")
	{
		alert("<?php echo $JOB_TITLE_EMPTY;?>");
		x.title.focus();
		return false;
	}
	
	var wEditor = new nicEditors.findEditor('message');
	
	
	wEditor.saveContent();
	
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

$_REQUEST["message-column-width"]=120;
$_REQUEST["select-width"]=400;

AddEditForm
(
	array
	(
		$M_CATEGORY.":",
		$M_JOB_TYPE.":",
		$M_TITLE.":",
		$M_DESCRIPTION.":",
		$M_REGION.":",
		$M_ZIP.":",
	
		$M_SALARY.":",
		$M_DATE_AVAILABLE.":",
		$ACTIVE.":"
	),
	array
	(
		"job_category",
		
		"job_type",
		"title",
		"message",
		"region",
		"zip",
		"salary",
		"date_available",
		"active"
	),
	array(),
	array
	(
		"combobox_special",
		
		"combobox".$strJobType,
		"textbox_67",
		"textarea_75_10",
		"combobox_region",
		"textbox_5",
		
		"textbox_8",
		"textbox_8",
		"combobox_".$M_YES."^YES_".$M_NO."^NO"
	),
	"jobs",
	"id",
	$id,
	$VALEURS_MODFIEES_SUCCESS,
	"EditJob"
);


}
?>
<br/>