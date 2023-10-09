<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
$id=$_REQUEST["id"];
$website->ms_i($id);
?>
<div class="fright">

<?php
	echo LinkTile
		 (
			"users",
			"jobseekers",
			$M_GO_BACK,
			"",
			
			"red"
		);
?>
</div>
<div class="clear"></div>

<h3><?php echo $M_MODIFY_JOBSEEKER;?> id #<?php echo $id;?></h3>

<?php
$website->ms_i($id);
$arrUser = $database->DataArray("jobseekers","id=".$id);
$strSpecialHiddenFieldsToAdd="";


if(is_array(unserialize(aParameter(260))))
{
		$arrUserFields = unserialize(aParameter(260));
}
else
{
		$arrUserFields = array();
}	


if(isset($_POST["SpecialProcessEditForm"]))
{
	$iFCounter = 0;

	$arrPValues = array();
		
	$iFCounter = 0;
		
	foreach($arrUserFields as $arrUserField)
	{		
		$arrPValues[$arrUserField[0]]=get_param("pfield".$iFCounter);
		$iFCounter++;
	}		
	$id=$_POST["id"];
	$database->SQLUpdate_SingleValue
	(
			"jobseekers",
			"id",
			$id,
			"jobseeker_fields",
			serialize($arrPValues)
	);
	$arrUser = $database->DataArray("jobseekers","id=".$id);

}
		

$arrPropFields = array();
							
if(is_array(unserialize($arrUser["jobseeker_fields"])))
{
				
		$arrPropFields = unserialize($arrUser["jobseeker_fields"]);
}


$iFCounter = 0;
$SelectWidth=280;

foreach($arrUserFields as $arrUserField)
{
	
	$strSpecialHiddenFieldsToAdd.="<tr height=\"38\">";
	
	$strSpecialHiddenFieldsToAdd.= "<td valign=\"middle\">".str_show($arrUserField[0], true).":</td>";	
	
	$strSpecialHiddenFieldsToAdd.= "<td valign=\"middle\">";
	
	if(trim($arrUserField[2]) != "")
	{
			$strSpecialHiddenFieldsToAdd.= "<select  name=\"pfield".$iFCounter."\" ".(isset($SelectWidth)?" style=\"width:".$SelectWidth."px !important\"":"").">";
			
			
			$arrFieldValues = explode("\n", trim($arrUserField[2]));
					
						
			if(sizeof($arrFieldValues) > 0)
			{
				foreach($arrFieldValues as $strFieldValue)
				{
					$strFieldValue = trim($strFieldValue);
					if(strstr($strFieldValue,"{"))
					{
					
						$strVName = substr($strFieldValue,1,strlen($strFieldValue)-2);
						
						$strSpecialHiddenFieldsToAdd.= "<option ".(trim($$strVName)==$arrPropFields[$arrUserField[0]]?"selected":"").">".trim($$strVName)."</option>";
						
					}
					else
					{
						$strSpecialHiddenFieldsToAdd.= "<option ".(isset($arrPropFields[$arrUserField[0]])&&trim($strFieldValue)==$arrPropFields[$arrUserField[0]]?"selected":"").">".trim($strFieldValue)."</option>";
					}		
				
				}
			}
			
			$strSpecialHiddenFieldsToAdd.= "</select>";
	}
	else
	{
			$strSpecialHiddenFieldsToAdd.= "<input ".(isset($SelectWidth)?"style=\"width:".$SelectWidth."px !important\"":"")." value=\"".(isset($arrPropFields[$arrUserField[0]])?$arrPropFields[$arrUserField[0]]:"")."\" type=text name=\"pfield".$iFCounter."\">";
	}
	
	$strSpecialHiddenFieldsToAdd.= "</td>";
	
	
	$strSpecialHiddenFieldsToAdd.= "</tr>";
	

	$iFCounter++;		
}

$_REQUEST["strSpecialHiddenFieldsToAdd"]=$strSpecialHiddenFieldsToAdd;



AddEditForm
(
	array($NOM_DUTILISATEUR.":",$ACTIVE.":",$FIRST_NAME.":",$LAST_NAME.":",$M_ADDRESS.":",$M_PHONE.":"),
	array("username","active","first_name","last_name","address","phone"),
	array("username"),
	array("textbox_50","combobox_$M_YES^1_$M_NO^0","textbox_50","textbox_50","textarea_37_4","textbox_50"),
	"jobseekers",
	"id",
	$id,
	$LES_VALEURS_MODIFIEES_SUCCES
);
?>