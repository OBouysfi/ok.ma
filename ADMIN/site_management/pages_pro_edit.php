<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>

<script>
function SavePage()
{
	document.getElementById("EditForm").submit();
}
</script>
<?php
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
	$language_version = strtolower($LoginInfo["bo_lang"]);
	
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
			"",
			"",
			$M_SAVE,
			"",
			
			"blue",
			"small",
			"true",
			"SavePage"
		 );
		 
		 
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
$oArr=$database->DataArray("pages"," id=".$id);

?>


<?php
include("include/languages_menu_processing.php");

?>


<?php
$HideFormFlag=false;
?>

<br/>


<?php
if(isset($_REQUEST["Proceed"]))
{

	
	if(isset($_REQUEST["extension"]) && $_REQUEST["extension"] =="NONE")
	{
		
			
			$database->SQLUpdate_SingleValue
			(
				"pages",
				"id",
				$id,
				"custom_link_".strtolower($language_version),
				""
			);
		
	}
	else
	if(isset($_REQUEST["extension"]) && $_REQUEST["extension"] !="NONE")
	{
		$extension=$_REQUEST["extension"];
		
		$database->SQLUpdate_SingleValue
		(
			"pages",
			"id",
			$id,
			"custom_link_".strtolower($language_version),
			$extension
		);
	}

	$arrNames=array("active_".$language_version,"name_".$language_version,"description_".$language_version,"keywords_".$language_version,"link_".$language_version,"only_bottom","template_id");
	$arrValues=array($_REQUEST["active"],$_REQUEST["pName"],$_REQUEST["pDescription"],$_REQUEST["pKeywords"],$_REQUEST["pLink"],(isset($_REQUEST["only_bottom"])?$_REQUEST["only_bottom"]:"0"),$_REQUEST["template_name"]);
	$database->SQLUpdate("pages",$arrNames,$arrValues," id=$id");
	$HideFormFlag=true;
}
$language_version=strtolower($language_version);
if($HideFormFlag)
{
?>
<span class="medium-font">
<?php echo $M_NEW_VALUES_SAVED;?>
<br/><br/><br/>
</span>

<?php
}
else
{
?>
<span class="medium-font">
<?php echo stripslashes($oArr['link_'.$language_version]);?>
 -
<?php echo $PAGE_SETTINGS;?>
</span>
<br/><br/><br/>
<?php
}

if(true)
{

$oArr=$database->DataArray("pages"," id=$id");

?>
<form action="index.php" method="post" id="EditForm">
<input type="hidden" name="id" value="<?php echo $id;?>">
<input type="hidden" name="folder" value="pages_pro">
<input type="hidden" name="page" value="edit">
<input type="hidden" name="category" value="site_management">

<table border="0" cellspacing="6">
	<tr>
		<td><b><?php echo $str_PageLinkPage;?></b></td>
		<td>
		<input class="form-edit-field" type="text" name="pLink" size="50" maxlength="256" value="<?php echo stripslashes($oArr['link_'.$language_version]);?>">
		</td>
	</tr>

	<tr>
		<td width=150><b><?php echo $str_PageNamePage;?></b></td>
		<td>
		<input class="form-edit-field" type="text" name="pName" size="50" maxlength="256"  value="<?php echo stripslashes($oArr['name_'.$language_version]);?>">
  		</td>
	</tr>

	

	<tr>
		<td valign=top><b><?php echo $str_PageDescriptionPage;?></b></td>
		<td>
		<textarea class="form-edit-field" name="pDescription" cols="50" rows="4"><?php echo stripslashes($oArr['description_'.$language_version]);?></textarea>
  
		</td>
	</tr>
	<tr>
		<td valign=top><b><?php echo $str_PageKeywordsPage;?></b></td>
		<td>
		<textarea class="form-edit-field" name="pKeywords" cols="50" rows="4"><?php echo stripslashes($oArr['keywords_'.$language_version]);?></textarea>
  
		</td>
	</tr>
	
	
	<tr>
		<td width=150><b><?php echo $ACTIVE;?>:</b></td>
		<td>
		
		<select class="form-edit-field" name="active">
		<option value=1 <?php if($oArr['active_'.$language_version]==1) echo "selected";?>><?php echo $M_YES;?></option>
		<option value=0 <?php if($oArr['active_'.$language_version]==0) echo "selected";?>><?php echo $M_NO;?></option>
		</select>		

  		</td>
	</tr>

<tr>
		<td width=150><b><?php echo $M_SHOW_ONLY_BOTTOM;?>:</b></td>
		<td>
		
		<select class="form-edit-field" name="only_bottom">
		<option value="0" ><?php echo $M_NO;?></option>
		<option value="1" <?php if($oArr['only_bottom']==1) echo "selected";?>><?php echo $M_YES;?></option>
		
		</select>		

  		</td>
	</tr>
	


	<tr>
		<td width=150><b><?php echo $CUSTOM_EXTENSION;?>:</b></td>
		<td>
		
		<select class="form-edit-field" name="extension">
		<option value="NONE"><?php echo $M_NONE;?></option>
		<?php
		$handle=opendir('../extensions');
		
		
		$arrFiles = array("none");
	
		while ($file = readdir($handle)) 
		{
		    if ($file != "." && $file != "..") 
			{
				$tag_word_post = strpos($file,"_tag");
				if($tag_word_post === false)
				{		
					array_push($arrFiles, $file);
				}
		   }
		}
		sort($arrFiles);
		foreach($arrFiles as $file)
		{
		    
				if(str_replace(".php","",$file) == $oArr["custom_link_".$language_version] )
				{
					echo "<option selected>".str_replace(".php","",$file)."</option>";
				}
				else
				{
					echo "<option>".str_replace(".php","",$file)."</option>";
				}
				
		   
		}
		?>
		</select>
		
		
  		</td>
	</tr>
	
	
		<tr>
		<td valign=top><b><?php echo $M_TEMPLATE;?>:</b></td>
		<td>
				<select class="form-edit-field" name="template_name">
				<?php
					$arrTemplates = $database->Query("SELECT name,id FROM ".$DBprefix."templates");
					
					echo "<option value=\"0\" ".($oArr['template_id']=="0"?"selected":"").">".strtoupper($DEFAULT)."</option>";
					
					while($arrTemplate = $database->fetch_array($arrTemplates))
					{
						if(trim($arrTemplate["name"])!="")
						{
							echo "<option value=\"".$arrTemplate["id"]."\" ".($oArr['template_id']==$arrTemplate["id"]?"selected":"").">".$arrTemplate["name"]."</option>";
						}
					}
				?>
				</select>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right">
			<br/>
			<input type="submit" style="width:150px" class="adminButton" value="<?php echo $M_SAVE;?>">

		</td>
	</tr>
</table>
<br/>
<input type="hidden" name="Proceed" value="1">


</form>
<?php
}
?>