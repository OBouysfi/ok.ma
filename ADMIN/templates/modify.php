<?php
if(!defined('IN_SCRIPT')) die("");
?>
<script>
function DeleteTemplate(x)
{
	if(confirm("Are you sure that you want to delete this template?\n\nBe aware that once deleted the template can not be restored!"))
	{
		document.location.href="index.php?category=templates&action=modify&Delete="+x;
	}
}


function CallBack()
{
	document.getElementById("main-content").innerHTML =
	top.frames['ajax-ifr'].document.body.innerHTML;
	HideLoadingIcon();
}

</script>
<?php
if(isset($_REQUEST["Delete"]))
{
	$database->SQLDelete("templates","id",array($_REQUEST["Delete"]));
}
?>


<div class="fright">

		
	<?php
	
	echo LinkTile
		 (
			"templates",
			"add",
			$M_ADD_TEMPLATE,
			"",
			
			"green"
		 );
		 
		 
		echo LinkTile
			 (
				"templates",
				"select",
				$M_SELECT_TEMPLATE ,
				$M_SELECT_TEMPLATE,
				
				"lila"
			 );
		?>
		
	
</div>
<div class="clear"></div>
<br/>
<span class="medium-font">
<?php echo $MODIFY_TEMPLATE;?>
</span>
<br/>
<?php
	
$arrHighlightIds=array($website->aParameter(10));
$strHighlightIdName="id";

RenderTable
(
	"templates",
	array("ModifyTemplate","DeleteTemplate","name","description"),
	array($MODIFY,$EFFACER,$NOM,$DESCRIPTION),
	750,
	"",
	"",
	"id",
	"index.php",
	true,
	20,
	false,
	-1,
	""
);
?>

