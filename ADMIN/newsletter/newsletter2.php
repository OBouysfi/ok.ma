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
					"newsletter",
					"home",
					$M_GO_BACK,
					"",
					
					"red"
				 );
		?>
</div>
<div class="clear"></div>
<?php

if(isset($_REQUEST["CheckList"])&&sizeof($_REQUEST["CheckList"])>0)
{

	$database->SQLDelete("newsletter","id",$_REQUEST["CheckList"]);

}


?>

<script>
function ValidateForm()
{
		
	return true;
	
}
function CallBack()
{
	lock_check = false;
	document.getElementById("page-header").innerHTML
	= "<?php echo $NEWSLETTER_ADDED;?>";

	loadPage("#newsletter-newsletter2");
}
</script>

<span id="page-header" class="medium-font"><?php echo $ADD_NEWSLETTER;?></span>
	

<br><br>
<?php

AddNewForm
(
	array("Subject:","Message:"),
	array("subject","html"),
	
	array("textbox_57","textarea_70_8"),
	$AJOUTER,
	"newsletter",
	$NEWSLETTER_ADDED,
	true,
	array(),
	""
);
?>	

<br>

<?php

$arrTDSizes = array("50","50","200","*");

RenderTable
(
	"newsletter",
	array("id","EditNote","subject","html"),
	array("ID",$MODIFY,$SUBJECT,$M_MESSAGE),
	700,
	"",
	$EFFACER,
	"id",
	"index.php"
);
						

?>