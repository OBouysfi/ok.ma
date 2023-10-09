<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<div  id="ColorsMenu" style="visibility:hidden;position:absolute;top:140;left:500">
<?php
include("colorPicker.php");
?>
</div>

<table summary="" border="0" width=750>
	<tr>
		<td class=basictext>
		
		<?php
		//23,
		//25,
		//"textbox_10","textbox_10",
		EditParams(
		"22,24,26,27,28,29,30,31,32,33,34,35,36,37",
		array("textbox_10","textbox_10","combobox_none_solid_dotted_dashed","combobox_0_1_2_3_4","textbox_10","combobox_Verdana_Arial_Tahoma_Comic Sans MS_Compact_Courier_Fixedsys_Georgia_Symbol_Times New Roman","combobox_Verdana_Arial_Tahoma_Comic Sans MS_Compact_Courier_Fixedsys_Georgia_Symbol_Times New Roman","combobox_6_7_8_9_10_11_12_13_14_15_16","combobox_6_7_8_9_10_11_12_13_14_15_16","textbox_10","textbox_10","textbox_10","textbox_10","textbox_10"),
		"Save settings",
		"<b>The new settings have been saved successfully</b>"
		);
	
	?>
		
		
		
		
		</td>
	</tr>
</table>



<?php
generateBackLink("menu");
?>

