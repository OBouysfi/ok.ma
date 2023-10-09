<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
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
	array("$M_ADS_NUM:","$M_VALID_DAYS:","$M_PRICE_CREDITS:","$ACTIVE:"),
		array("ads","valid","price","active"),
	array(),
	array(
		"textbox_4",
		"textbox_4",
		"textbox_4",
		"combobox_YES_NO"
		),
	"packages",
	"id",
	$id,
	$LES_VALEURS_MODIFIEES_SUCCES
	);

?>
<br><br>
<?php
generateBackLink("pack_ads");
?>
