<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="fright">

	<?php
		echo LinkTile
		 (
			"profile",
			"edit",
			$M_EDIT,
			"",
			"green"
		 );
		 
		echo LinkTile
		(
			"profile",
			"logo",
			$M_LOGO,
			"",
			"yellow"
		);
	
		echo LinkTile
		(
			"profile",
			"video",
			$M_VIDEO_PRESENTATION,
			"",
			"lila"
		);
	
	
	?>

</div>
<div class="clear"></div>
<h3>
	<?php echo $VIEW_PROFILE;?>
</h3>
<br/>

<?php

$_REQUEST["HideSubmit"] = true;

$MessageTDLength = 130;
$website->ms_i($arrUser["id"]);
 AddEditForm
	(
	array("$NOM_DUTILISATEUR:","$M_COMPANY:","$M_COMPANY_DESCRIPTION:","$CONTACT_PERSON:","$M_ADDRESS:","$TELEPHONE:","$FAX:","$M_WEBSITE:"),
	array("username","company","company_description","contact_person","address","phone","fax","website"),
	array("username","company","company_description","contact_person","address","phone","fax","website"),
	array("textbox_30","textbox_30","textarea_50_4","textbox_30","textarea_50_4","textbox_30","textbox_30","textbox_30"),
	"employers",
	"id",
	$arrUser["id"],
	"<b>$LES_VALEURS_MODIFIEES_SUCCES!</b>"
	);
?>

		
<table summary="" border="0" width="100%">
	<tr>
		<td>
<?php	
$arrEmployerFields = array();

if(trim($arrUser["employer_fields"]) != "")
{

if(is_array(unserialize($arrUser["employer_fields"])))
{
	$arrEmployerFields = unserialize($arrUser["employer_fields"]);
}

$bFirst = true;
while (list($key, $val) = each($arrEmployerFields)) 
{

?>
	<tr height="38">
		<td width="120"><i><?php str_show($key);?>:</i></td>
		<td><b><?php str_show($val);?></b></td>
	</tr>
<?php

}

}
?>
	</td>
	</tr>
</table>