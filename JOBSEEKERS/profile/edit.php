<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="fright">

	<?php
	echo LinkTile
	 (
		"profile",
		"current",
		$VIEW_PROFILE ,
		"",
		"green"
	 );
	
	 
	 echo LinkTile
		 (
			"cv",
			"edit",
			$EDIT_YOUR_CV,
			"",
			"blue"
		 );
		?>
		
	
</div>
<div class="clear"></div>


<h3><?php echo $EDIT_YOUR_PROFILE;?></h3>
<br/>

<?php


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
	$arrUser = $database->DataArray("jobseekers","username='$AuthUserName'");

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
	array($M_PUBLIC_PROFILE."(*) :", $str_PageNamePage,$FIRST_NAME.":",$LAST_NAME.":",$M_ADDRESS.":",$TELEPHONE.":",
	$M_MOBILE.":",$M_DOB.":",$M_GENDER.":",$M_PICTURE.":",
	$M_I_WOULD_LIKE_SUBSCRIBE." ".$DOMAIN_NAME." ".$M_NEWSLETTER.":"),
	array("profile_public","title","first_name","last_name","address","phone",
	"mobile","dob","gender","logo",
	"newsletter"),
	array(),
	array("combobox_".$M_YES."^1_".$M_NO."^0","combobox_".$M_MR."_".$M_MRS."_".$M_MSS,"textbox_50","textbox_50","textarea_49_4","textbox_50",
	"textbox_50","textbox_50","combobox_".$M_PLEASE_SELECT."^_".$M_MALE."^1_".$M_FEMALE."^2","file",
	"combobox_".$M_YES."^1_".$M_NO."^0"),
	"jobseekers",
	"id",
	$arrUser["id"],
	$LES_VALEURS_MODIFIEES_SUCCES,
	"",
	170
);

?>
<br/>
<br/>


<i>(*) <?php echo $M_PUBLIC_PROFILE_EXPL;?></i>
		
	



