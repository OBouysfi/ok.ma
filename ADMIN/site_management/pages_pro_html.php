<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");

if(isset($_REQUEST["ProceedChangeLanguage"]))
{
	$language_version=strtolower($_REQUEST["ProceedChangeLanguage"]);
	
	$database->SQLUpdate_SingleValue
	(
		"admin_users",
		"username",
		"'".$AuthUserName."'",
		"bo_lang",
		$language_version
	);
}
else
{
	$language_version = $LoginInfo["bo_lang"];
	
}

if($language_version == "")
{
	$default_language = $database->DataArray("languages","default_language=1");
	$language_version = strtolower($default_language["code"]);
	
	$database->SQLUpdate_SingleValue
	(
		"admin_users",
		"username",
		"'".$AuthUserName."'",
		"bo_lang",
		$language_version
	);
}
include("pages_str.php");
?>

<div class="fright">
	<?php
	echo LinkTile
	 (
		"site_management",
		"pages_pro",
		$M_GO_BACK,
		"",
		"red"
	 );
?>
</div>


<?php
$id = $_REQUEST["id"];
$website->ms_i($id);
?>

<b>
<?php
if(isset($_REQUEST["ProceedSave"]))
{
	array_push($database->allowed_html_fields,"html_".$language_version);
	
	$database->SQLUpdate_SingleValue(
		"pages",
		"id",
		$id,
		"html_".$language_version,
		$_REQUEST["html"]
	);
	
	
	echo $M_NEW_VALUES_SAVED."<br><br>";
}
?>
</b>

<?php
$arrPage=$database->DataArray("pages","id=".$id);

?>

<br/>
<span class="medium-font">
<?php echo stripslashes($arrPage['link_'.$language_version]);?>
 -
<?php echo $EDIT_HTML;?>
</span>
<br/><br/><br/>

<form action="index.php" method="post">
<input type="hidden" name="category" value="site_management">
<input type="hidden" name="folder" value="pages_pro">
<input type="hidden" name="page" value="html">
<input type="hidden" name="ProceedSave" value="1">
<input type="hidden" name="id" value="<?php echo $id;?>">

<textarea name="html" cols="80" rows="15"><?php echo stripslashes($arrPage["html_".$language_version]);?></textarea>

<br><br>
<input type="submit" class="adminButton" value=" <?php echo $M_SAVE;?>">
</form>