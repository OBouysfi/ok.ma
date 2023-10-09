<?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="fright">

	<?php
		
		echo LinkTile
				 (
					"home",
					"sub_accounts",
					$M_GO_BACK,
					"",
					"red"
				 );
	
		?>

</div>
<div class="clear"></div>
<?php
$id=$_REQUEST["id"];
$website->ms_i($id);
$arrContactPerson = $database->DataArray("sub_accounts","id=".$id);

if($arrContactPerson["employer"] != $AuthUserName)
{
	die("");
}
?>

<br/>
<?php
$SubmitButtonText = $SAUVEGARDER;



if(isset($SpecialProcessEditForm)&&strlen($password)<6)
{

	echo "<span class=\"red-font\"><i>".$M_AT_LEAST_3."</i></span><br/><br/>";
}
else
{


	AddEditForm
	(
	array($M_USERNAME.":",$M_PASSWORD.":",$NOM.":",$TELEPHONE.":"),
	array("username","password","name","phone"),
	array("username"),
	array("textbox_30","textbox_30","textbox_30","textbox_30"),
	"sub_accounts",
	"id",
	$id,
	$LES_VALEURS_MODIFIEES_SUCCES
	);
	
}
?>