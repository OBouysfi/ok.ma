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
					"jobs",
					"list",
					$M_ADS_LIST,
					"",
					
					"blue"
				 );
		?>
</div>
<div class="clear"></div>

<h3>
	<?php echo $POST_NEW_ADD;?>
</h3>
<!--
<table summary="" border="0" class="pull-right">
  	<tr>
  		<td><img src="images/link_arrow.gif" width="16" height="16" alt="" border="0"></td>
  		<td><a href="index.php?category=<?php echo $category;?>&folder=<?php echo $action;?>&page=export" style="color:#6d6d6d;text-transform:uppercase;font-weight:800"><?php echo $M_EXPORT_OR_IMPORT;?></a></td>
  	</tr>
  </table>
  -->
<br>

<script>
String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g,"");
}

function NewJob(x)
{

	document.getElementById("job_category").value=get_cat_value("category_1");
	document.getElementById("region").value=get_cat_value("region");
	
		
	if(x.title.value=="")
	{
		alert("<?php echo $JOB_TITLE_EMPTY;?>");
		x.title.focus();
		return false;
	}
	
	var wEditor = new nicEditors.findEditor('message');
	
	
	wEditor.saveContent();
	
	if(x.message.value=="")
	{
		alert("<?php echo $JOB_DESCRIPTION_EMPTY;?>");
		x.message.focus();
		return false;
	}
	
	return true;
}

</script>

<?php


$strJobType="";

foreach($website->GetParam("arrJobTypes") as $key=>$value)
{

	$strJobType.="_".$value."^".$key;
}

$jsValidation="NewJob";
$arrOtherValues = array(array("date",date("F j, Y, g:i a")) );

$_REQUEST["arrNames2"] = array("date","expires");
$_REQUEST["arrValues2"] = array(time(), (time() + $website->GetParam("FREE_WEBSITE_ADS_EXPIRE_DAYS")*86400) );
$_REQUEST["message-column-width"]=120;
$_REQUEST["select-width"]=400;

$_REQUEST["hide_form"]=true;

?>


<script src="js/nicEdit.js" type="text/javascript"></script>
<script type="text/javascript">
bkLib.onDomLoaded(function() {
	new nicEditor({buttonList : ['fontSize','bold','italic','forecolor','fontFamily','link','unlink','left','center','right','justify','ol','ul','removeformat','indent','outdent','hr','bgcolor','underline','html'],iconsPath : 'js/nicEditorIcons.gif'}).panelInstance('message');
});
</script>
<?php
$insertID = AddNewForm
(
	array
	(
		$M_EMPLOYER.":",
		$M_CATEGORY.":",
	
		$M_JOB_TYPE.":",
		$M_TITLE.":",
		$M_DESCRIPTION.":",
		$M_REGION.":",
		$M_ZIP.":",
		$M_SALARY.":",
		$M_DATE_AVAILABLE.":",
		$ACTIVE.":"
	),
	array
	(
		"employer",
		"job_category",
		
		"job_type",
		"title",
		"message",
		"region",
		"zip",
		"salary",
		"date_available",
		"active"
	),
	array
	(
		"combobox_table~employers~username~company",
		"global_category",
		
		"combobox".$strJobType,
		"textbox_67",
	
		"textarea_90_12",
		"global_location",
		"textbox_8",
		"textbox_20",
		"textbox_20",
		"combobox_".$M_YES."^YES_".$M_NO."^NO"
	),
	$ADD_POSTING,
	"jobs",
	'<a class="underline-link" href="index.php?category=jobs&action=list">'.$NEW_POSTING_ADDED.'</a>',
	false,
	array(),
	"NewJob"
);

/*
	AddNewForm(
		array($M_EMPLOYER.":","$M_CATEGORY:","$M_REGION:",$M_JOB_TYPE.":",$str_PageNamePage,"$TMESSAGE:",$M_SALARY.":",$M_DATE_AVAILABLE.":","$ACTIVE:","$M_NOTIFICATION:"),
		array("employer","job_category","region","job_type","title","message","salary","date_available","active","notification"),
		array("combobox_special","combobox_special","combobox_special","combobox".$str_types,"textbox_67","textarea_50_10","textbox_8","textbox_8","combobox_YES_NO","combobox_YES_NO"),
		" $AJOUTER ",
		"jobs",
		"<b>$NEW_POSTING_ADDED
		<br><br><br>
		<a style=\"text-decoration:underline\" href=\"index.php?category=job_ads&action=list\">".$M_MANAGE_JOB_ADS."</a>
		
		<br><br><br>
		<a style=\"text-decoration:underline\" href=\"index.php?category=job_ads&action=add\">".$M_POST_NEW_AD."</a>
		</b>"
	);
*/
?>
