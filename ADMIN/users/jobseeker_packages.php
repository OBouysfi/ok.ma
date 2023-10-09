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
		<td width=52><img src="images/icons2/write.gif" width="49" height="45" alt="" border="0"></td>
		<td>&nbsp;<b>
		
		<?php echo $M_ADD_NEW_JOBSEEKER_PACKAGE;?>
		
		</b></td>
	</tr>
</table>


<div id="addnews" >
<?php

$MessageTDLength = 130;

AddNewForm(
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
		array
		(
						"textbox_67","textarea_50_6","textbox_5",
						
						"combobox_1_3_6_12_24"
		),

		" $AJOUTER",
		"jobseeker_packages",
		$M_NEW_PACKAGE_ADDED_SUCC."<br><br>"
	);
?>
</div>

<?php
if(isset($_REQUEST["Delete"]) && isset($_REQUEST["CheckList"]))
{
	
	if(isset($_REQUEST["CheckList"])&&sizeof($_REQUEST["CheckList"])>0)
	{
	
		$database->SQLDelete("jobseeker_packages","id",$_REQUEST["CheckList"]);
	
	}

}
?>

<br>
<?php

$arrTDSizes = array("50","20","100","*","100","100","50","50");

RenderTable(
						"jobseeker_packages",
						array("EditCar","id","name","description","price","billed"),
						array("Modify","ID","Name","Description","Price","Billed"),
						"100%",
						
						(isset($order_type)?"":"ORDER BY id DESC"),
						$EFFACER,
						"id",
						"index.php?action=".$action."&category=".$category
);
?>


