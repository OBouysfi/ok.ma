<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");

$SubmitButtonText = $SAUVEGARDER;

AddEditForm
	(
					array("Title".":","Message".":","Active:","Notification:","Featured:"),
					array("title","message","active","notification","featured"),
					
					array(),
					array("textbox_50","textarea_37_10","combobox_YES_NO","combobox_YES_NO","combobox_YES_NO"),
					"jobs",
					"id",
					$id,
					$LES_VALEURS_MODIFIEES_SUCCES
	);
?>
<br>
<?php
generateBackLink("list");
?>
