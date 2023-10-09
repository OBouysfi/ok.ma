<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<table summary="" border="0" width="100%">
	<tr>
		<td width="41">
		<img src="images/icons2/reports.gif" width="39" height="40" alt="" border="0">
		</td>
		<td>
		<b>
		<?php echo $M_EDIT_PACKAGE;?> id #<?php echo $id;$website->ms_i($id);?>
		</b>
		</td>
	</tr>
</table>
<br>

<?php
$SubmitButtonText = $SAUVEGARDER;

AddEditForm
	(
	array
		(
						"Name:","Description:",
						"Price, ex. \"14.99\" :<br><i>put 0.00 if free</i>",
						"Billed (Months):"
		),
		array
		(
						"name","description",
						"price",
						"billed"
		),
		array(),
		array
		(
						"textbox_67","textarea_50_6","textbox_5",
						
						"combobox_1_3_6_12_24"
		),
	"jobseeker_packages",
	"id",
	$id,
	$LES_VALEURS_MODIFIEES_SUCCES
	);

?>
<br><br>
<?php
generateBackLink("jobseeker_packages");
?>
