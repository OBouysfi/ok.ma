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
			"profile",
			"edit",
			$M_EDIT,
			"",
			"green"
		 );
			
		echo LinkTile
		(
			"profile",
			"video",
			$M_VIDEO_PRESENTATION,
			"",
			"lila"
		);
	
	
	?>

</div>
<div class="clear"></div>
<?php
if(isset($_REQUEST["ProceedDelete"]))
{

	if($arrUser["logo"] != "")
	{
		
		$database->SQLUpdate_SingleValue
		(
			"employers",
			"username",
			"'".$AuthUserName."'",
			"logo",
			""
		);
		
		
		if(file_exists("../uploaded_images/".$arrUser["logo"].".jpg"))		
		{
			unlink("../uploaded_images/".$arrUser["logo"].".jpg");
		}
		
		if(file_exists("../thumbnails/".$arrUser["logo"].".jpg"))		
		{
			unlink("../thumbnails/".$arrUser["logo"].".jpg");
		}

	}
}

?>


<h3>
	<?php echo $MODIFY_LOGO;?>
</h3>
<br/>
<script> 
var ValidImageExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];    

function ValidateLogo(formObject)
{
	
	if(formObject.logo.value == "")
	{
			alert("Please select the logo image!");   
			return false;   
	}
	
	is_image=false;
	file_name=formObject.logo.value;
	
	
	for (var j = 0; j < ValidImageExtensions.length; j++) 
	{
		var sCurExtension = ValidImageExtensions[j];
		if (file_name.substr(file_name.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) 
		{
			is_image = true;
			break;
		}
    }
	
	if(!is_image)
	{
		alert("The file you selected is not an image!");   
		return false;   
	}

	
	return true; 
}</script>		
<?php

AddEditForm
(
	array($M_LOGO.":"),
	array("logo"),
	array(),
	array("file"),
	"employers",
	"id",
	$arrUser["id"],
	$LES_VALEURS_MODIFIEES_SUCCES,
	"ValidateLogo"
);
?>
		
	
<br><br><br>

<i><?php echo $YOUR_CURRENT_LOGO;?></i>

<a class="pull-right" href="index.php?category=<?php echo $category;?>&action=<?php echo $action;?>&ProceedDelete=logo"><b>[<?php echo strtoupper($EFFACER);?>]</b></a>
  	
<br/><br/>
  
  <?php
  $arrUser = $database->DataArray("employers","username='$AuthUserName'");

  if(trim($arrUser["logo"]) == "" || $arrUser["logo"] == 0)
  {
  	echo "<br><br>".$NO_LOGO_AVAILABLE."";
  }
  else
  {
	echo "<img src=\"../thumbnails/".$arrUser["logo"].".jpg\">";
		
	echo "<br>";
  }
 ?>