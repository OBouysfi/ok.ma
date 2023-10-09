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
			"jobmail",
			"rules",
			$M_RULES,
			"",
			"blue"
		 );
	
	
	
	?>

</div>
<div class="clear"></div>
<h3>
	<?php echo $ADD_NEW_RULE;?>
</h3>
<br/>
<script>
function NewRule(x)
{

	document.getElementById("job_category").value=get_cat_value("category_1");
	document.getElementById("region").value=get_cat_value("region");
}
</script>

<?php

if(isset($SpecialProcessAddForm))
{
	if($SpecialProcessAddForm=="")
	{
		$doNotAdd=true;
	}
}


$_REQUEST["message-column-width"] = 120;
$_REQUEST["select-width"]=300;

$_REQUEST["arrNames2"] = array("user");
$_REQUEST["arrValues2"] = array($AuthUserName);

$arrLines = explode("\n",implode('', file('../locations/locations.php')));

if(isset($region)) $region=str_replace("~",".",$region);

AddNewForm
(
	array($M_REGION.":",$M_KEYWORD.":",$M_CATEGORY.":"),
	array("region","rule","job_category"),
					
	array("global_location","textbox_26","global_category"),
	$AJOUTER,
	"rules",
	"<br/>$RULE_ADDED!
	<br/><br/>
	<a href='index.php?category=jobmail&action=rules'>$MANAGE_RULES</a>
	<br/>
	",
	false,
	array(),
	"NewRule"
);
?>
