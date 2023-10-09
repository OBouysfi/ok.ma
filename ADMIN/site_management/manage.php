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
					"design",
					$M_CREATE_FORM,
					"",
					"green",
					"small",
					true
				 );
				 
			echo LinkTile
				 (
					"site_management",
					"posted_data",
					$M_POSTED_DATA,
					"",
					"yellow"
				 );
		?>
		
	
</div>
<div class="clear"></div>
<br/>
<span id="page-header" class="medium-font"><?php echo $MANAGEMENT_FORMS_2;?></span>
	
<br/><br/>
<?php

if(isset($_REQUEST["ProceedDelete"]))
{
	$id=$_REQUEST["id"];
	$website->ms_i($id);
	$database->SQLDelete("forms","id",array($id));
}


if(isset($_REQUEST["SpecialProcessAddForm"]))
{
	$SpecialProcessAddForm=$_REQUEST["SpecialProcessAddForm"];
	$website->ms_i($SpecialProcessAddForm);
	
	$arrSelectedForm = $database->DataArray("forms","id=".$SpecialProcessAddForm);
	
	$database->SQLInsert("forms",
	array("name","description","code","submit","message"),
	array("Copy of ".$arrSelectedForm["name"],$arrSelectedForm["description"],$arrSelectedForm["code"],$arrSelectedForm["submit"],$arrSelectedForm["message"])
	);
	
	
}

if(isset($_REQUEST["FormSubmitted"]))
{

	$arrForms=$database->DataTable("forms","");
	
	while($arrForm=$database->fetch_array($arrForms))
	{
	
		$database->SQLUpdate_SingleValue
		(
				"forms",
				"id",
				$arrForm["id"],
				"page",
				urldecode($_REQUEST["pg_".$arrForm["id"]])
			);
	}
	?>
	<script>
		document.getElementById("page-header").innerHTML="<?php echo $M_NEW_VALUES_SAVED;?>";
	</script>
	<?php
}

$arrLngTable=$database->DataTable("languages","ORDER BY code");

$arrFrmLanguages=array();

while($arrLng=$database->fetch_array($arrLngTable))
{
	array_push($arrFrmLanguages,strtolower($arrLng["code"]));
}

$arrTable=$database->DataTable("pages","ORDER BY id");


$arrFrmPages=array();

while($arrFrm=$database->fetch_array($arrTable)){
	
	foreach($arrFrmLanguages as $lng){
		if(trim($arrFrm["link_".strtolower($lng)])!=""){
			array_push($arrFrmPages,urlencode(strtolower($lng)."_".$arrFrm["link_".strtolower($lng)]));
		}
	}

	
}

$_REQUEST["frm-pages"]=$arrFrmPages;
?>


<?php

$arrTDSizes=array("150","100","60","60","60","60");
$customFormEnd=true;
RenderTable
(
	"forms",
	array("name","ShowAssignForm","ShowFormDelete","ShowFormPreview","BackupForm"),
	array($NOM,$M_PAGE, $EFFACER,$M_SETTINGS,$M_COPY),
	750,
	"ORDER BY id DESC",
	"#".$M_SAVE,
	"id",
	"index.php"
);
			
?>



