<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<script type="text/javascript" src="wysiwyg/scripts/wysiwyg.js"></script>
<script type="text/javascript" src="wysiwyg/scripts/wysiwyg-settings.js"></script>
<script type="text/javascript">
WYSIWYG.attach('cv', full);

</script>

<?php
$arrUser = $database->DataArray("jobseekers","username='".$AuthUserName."'");
$id = $arrUser["id"];
?>

<table summary="" border="0" width="100%">
	<tr>
		<td width=40>
		
		<img src="images/icons2/pencil.png" width="48" height="48" alt="" border="0">
		
		</td>
		
		<td class=basictext>
		<b>
			<?php echo $MANAGE_CV;?>
		</b>
		</td>
		
		
	</tr>
</table>
<br>


<?php

$textAreaWidth = "900px";
$textAreaHeight = "600px";
$MessageTDLength = 0;
$SubmitButtonText=$SAUVEGARDER;
AddEditForm
(
	array(""),
	array("cv"),
	array(),
	array("textarea_68_30"),
	"jobseekers",
	"id",
	$id,
	"<b>$LES_VALEURS_MODIFIEES_SUCCES!</b><br><br>"
);
?>
