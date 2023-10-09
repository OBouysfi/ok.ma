<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
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
		"templates",
		"modify",
		$MODIFY,
		$M_MODIFY_TEMPLATES,
		"gray"
	 );

echo LinkTile
	 (
		"templates",
		"select",
		$M_SELECT ,
		$M_SELECT_TEMPLATE,
		
		"green"
	 );
?>
	
</div>

<script>

function ValidateForm(x)
{
	if(x.name.value=="")
	{
		x.name.style.background="#edeff3";
		
		document.getElementById("page-header").innerHTML=
		"<?php echo $TEMPLATE_NAME_EMPTY;?>!";
		return false;
	}
	
	return true;
	
}

function CallBack()
{
	
	lock_check = false;
	document.getElementById("page-header").innerHTML
	= "<?php echo $M_TEMPLATE_ADDED;?>";

	loadPage("#templates-modify");
	
}
</script>
<div class="clear"></div>


<span class="medium-font" id="page-header"><?php echo $M_ADD_TEMPLATE;?></span>


<br>
<div class="clear"></div>
<br>
<?php
AddNewForm
(
	array($NOM.":",$DESCRIPTION.":","HTML: "),
	array("name","description","html"),
	array("textbox_50","textbox_50","textarea_62_12"),
	$ADD_TEMPLATE,
	"templates",
	$M_TEMPLATE_ADDED,
	true,
	array(),
	""
);

?>	

