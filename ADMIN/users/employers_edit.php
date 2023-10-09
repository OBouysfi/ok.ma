<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
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
					"employers",
					$M_GO_BACK,
					"",
					
					"red"
				 );
		?>
</div>
<div class="clear"></div>
<h3>
	<?php echo $M_MODIFY_EMPLOYER;?> id #<?php echo $id;?>
</h3>

<?php
$strSpecialHiddenFieldsToAdd="";

if(is_array(unserialize(aParameter(270))))
{
	$arrFields = unserialize(aParameter(270));
}
else
{
	$arrFields = array();
}	


$arrUser = $database->DataArray("employers","id=".$id);


if(isset($_POST["SpecialProcessEditForm"]))
{
		$iFCounter = 0;

		$arrPValues = array();
			
		$iFCounter = 0;
			
		foreach($arrFields as $arrField)
		{		
			$arrPValues[$arrField[0]]=get_param("pfield".$iFCounter);
			$iFCounter++;
		}		
		$id=$_POST["id"];
		$database->SQLUpdate_SingleValue
		(
				"employers",
				"id",
				$id,
				"employer_fields",
				serialize($arrPValues)
		);
		$arrUser = $database->DataArray("employers","id=".$id);

}
		

$arrEmployerFields = array();
							
if(is_array(unserialize($arrUser["employer_fields"])))
{
				
		$arrEmployerFields = unserialize($arrUser["employer_fields"]);
}


$iFCounter = 0;
$SelectWidth=280;

foreach($arrFields as $arrField)
{
	
	$strSpecialHiddenFieldsToAdd.="<tr height=\"38\">";
	
	$strSpecialHiddenFieldsToAdd.= "<td valign=\"middle\">".str_show($arrField[0], true).":</td>";	
	
	$strSpecialHiddenFieldsToAdd.= "<td valign=\"middle\">";
	
	if(trim($arrField[2]) != "")
	{
			$strSpecialHiddenFieldsToAdd.= "<select  name=\"pfield".$iFCounter."\" ".(isset($SelectWidth)?" style=\"width:".$SelectWidth."px !important\"":"").">";
			
			
			$arrFieldValues = explode("\n", trim($arrField[2]));
					
						
			if(sizeof($arrFieldValues) > 0)
			{
				foreach($arrFieldValues as $strFieldValue)
				{
					$strFieldValue = trim($strFieldValue);
					if(strstr($strFieldValue,"{"))
					{
					
						$strVName = substr($strFieldValue,1,strlen($strFieldValue)-2);
						
						$strSpecialHiddenFieldsToAdd.= "<option ".(trim($$strVName)==$arrEmployerFields[$arrField[0]]?"selected":"").">".trim($$strVName)."</option>";
						
					}
					else
					{
						$strSpecialHiddenFieldsToAdd.= "<option ".(isset($arrEmployerFields[$arrField[0]])&&trim($strFieldValue)==$arrEmployerFields[$arrField[0]]?"selected":"").">".trim($strFieldValue)."</option>";
					}		
				
				}
			}
			
			$strSpecialHiddenFieldsToAdd.= "</select>";
	}
	else
	{
			$strSpecialHiddenFieldsToAdd.= "<input value=\"".(isset($arrEmployerFields[$arrField[0]])?$arrEmployerFields[$arrField[0]]:"")."\" type=text name=\"pfield".$iFCounter."\" ".(isset($SelectWidth)?"style=\"width:".$SelectWidth."px !important\"":"").">";
	}
	
	$strSpecialHiddenFieldsToAdd.= "</td>";
	
	
		$strSpecialHiddenFieldsToAdd.= "</tr>";
	

	$iFCounter++;		
}

$_REQUEST["strSpecialHiddenFieldsToAdd"]=$strSpecialHiddenFieldsToAdd;

		

if($website->GetParam("CHARGE_TYPE")==1)
{

	$subscriptions=$database->DataTable("subscriptions","");
	$str_subscr="combobox_".$M_NO_SUBSCRIPTION."^0";
	while($arr_subscription=$database->fetch_array($subscriptions))
	{
		$str_subscr.="_".$arr_subscription["name"]."^".$arr_subscription["id"];
		
	}

	AddEditForm
	(
		array($NOM_DUTILISATEUR.":",$ACTIVE.":",$M_COMPANY.":",$CONTACT_PERSON.":",$M_COMPANY_DESCRIPTION.":",$M_ADDRESS.":",$M_PHONE.":",$FAX.":",$M_WEBSITE.":",$M_SUBSCRIPTION.":"),
		array("username","active","company","contact_person","company_description","address","phone","fax","website","subscription"),
		array(""),
		array("textbox_50","combobox_".$M_YES."^1_".$M_NO."^0","textbox_50","textbox_50","textarea_50_4","textarea_50_4","textbox_50","textbox_50","textbox_50",$str_subscr),
		"employers",
		"id",
		$id,
		$LES_VALEURS_MODIFIEES_SUCCES
	);

}
else
{
	AddEditForm
	(
		array($NOM_DUTILISATEUR.":",$ACTIVE.":",$M_COMPANY.":",$CONTACT_PERSON.":",$M_COMPANY_DESCRIPTION.":",$M_ADDRESS.":",$M_PHONE.":",$FAX.":",$M_WEBSITE.":",$M_CREDITS.":"),
		array("username","active","company","contact_person","company_description","address","phone","fax","website","credits"),
		array("username"),
		array("textbox_50","combobox_".$M_YES."^1_".$M_NO."^0","textbox_50","textbox_50","textarea_50_4","textarea_50_4","textbox_50","textbox_50","textbox_50","textbox_4"),
		"employers",
		"id",
		$id,
		$LES_VALEURS_MODIFIEES_SUCCES
	);
}
?>