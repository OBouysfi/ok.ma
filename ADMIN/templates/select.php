<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<script>
function CallBack()
{
	document.getElementById("main-content").innerHTML =
	top.frames['ajax-ifr'].document.body.innerHTML;
	HideLoadingIcon();
	document.getElementById("page-header").innerHTML
	= "<?php echo $M_TEMPLATE_SELECTED_SUCCESS;?>";
}

</script>

<div class="fright">

	<?php
			echo LinkTile
				 (
					"templates",
					"add",
					$M_ADD,
					$M_ADD_TEMPLATE,
					
					"lila"
				 );
		?>
		
	<?php
			echo LinkTile
				 (
					"templates",
					"modify",
					$MODIFY,
					$M_MODIFY_TEMPLATES,
					"red"
				 );
		?>
		
	
</div>
<div class="clear"></div>
<br/>
<span class="medium-font" id="page-header"><?php echo $TEMPLATE_CHOICE;?></span>
	
<br/><br/>
<?php

$selected_template = $website->aParameter(10);

if(isset($_REQUEST["CheckList"]))
{
	$database->SetParameter(10,$_REQUEST["CheckList"]);
	
	$selected_template = $_REQUEST["CheckList"];
}

RenderTable
(
	"templates",
	array("name","description"),
	array($NOM,$DESCRIPTION),
	700,
	"",
	$M_SELECT,
	"id",
	"index.php",
	true,
	20,
	true,
	$selected_template
);
?>
