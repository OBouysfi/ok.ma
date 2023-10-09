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
		"site_management",
		"menu",
		$M_GO_BACK,
		"",
		"red"
	 );
	 ?>
	 
	<?php
	echo LinkTile
	 (
		"site_management",
		"pages_pro",
		$H_WEBSITE,
		$M_WEBSITE_MANAGEMENT,
		"blue"
	 );
	 ?>
</div>

<div  id="ColorsMenu" style="visibility:hidden;position:absolute;top:240;left:600">
<?php
include("colorPicker.php");
?>
</div>
<br/>
<span class="medium-font">
<?php echo $M_MENU_SETTINGS;?>
</span>
<br/><br/><br/>
<div id="Params">
		
	<?php
		
		$firstTDLength = 250;
		
		$EditColumns = 2;
		$FirstTDAlign = "left";
		$SelectWidth = "100px";
		$TextboxWidth = "100px";
		$TableWidth = 500;
		
		EditParams(
		"29,30,31,32,33,34,38,39,40,41,53,54,55,56,57,58,310,311,312,313,314,315,316,317,318,319,320,321",
		array(
		"combobox_Verdana_Arial_Tahoma_Comic Sans MS_Compact_Courier_Fixedsys_Georgia_Symbol_Times New Roman",
		"combobox_Verdana_Arial_Tahoma_Comic Sans MS_Compact_Courier_Fixedsys_Georgia_Symbol_Times New Roman",
		"combobox_6_7_8_9_10_11_12_13_14_15_16",
		"combobox_6_7_8_9_10_11_12_13_14_15_16",
		"textbox_10",
		"textbox_10",
		"combobox_none_bold_italic_underline",
		"combobox_none_bold_italic_underline",
		"combobox_none_bold_italic_underline",
		"combobox_none_bold_italic_underline",
		"textbox_10","textbox_10","textbox_10","textbox_10","textbox_10","textbox_10",
		"textbox_10","textbox_10","textbox_10","textbox_10","textbox_10","textbox_10",
		"combobox_none_solid","combobox_none_solid",
		"textbox_10","textbox_10","combobox_YES_NO",
		"combobox_HORIZONTAL_VERTICAL"
		),
		$SAVE_SETTINGS,
		"<b>".$M_NEW_VALUES_SAVED."</b>"
		);
	
	?>
	
	
	


<br>
<table summary="" border="0" width=750>
	<tr>
		<td>
		
		(*) When this option is set to "YES", the images previously set 
			from the Customized Menu ->	Contruct page will be used. If there is no
			image set for a particular menu item, then the settings from this page will
			apply to it.
		
		</td>
	</tr>
</table>

</div>

