<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><h3>
<?php echo $MODIFY_LOGO;?>
</h3>
<hr/>
<i><?php echo $M_LOGO_EXPLANATION;?></i>	
<br/>
<br/>
<?php

	AddEditForm
	(
		array($M_LOGO.":",$M_LOGO_TEXT.":"),
		array("logo","logo_text"),
		array(),
		array("file","textbox_40"),
		"admin_users",
		"id",
		"1",
		""
	);
?>

<br/>
<br/>
<?php
  
$adminSettings = $database->DataArray("admin_users","id=1");
	
if(isset($_REQUEST["ProceedDelete"]))
{
	
	if($adminSettings["logo"] != "")
	{
		
		if(file_exists("../uploaded_images/".$adminSettings["logo"].".jpg"))		
		{
			unlink("../uploaded_images/".$adminSettings["logo"].".jpg");
		}
		
		if(file_exists("../thumbnails/".$adminSettings["logo"].".jpg"))		
		{
			unlink("../thumbnails/".$adminSettings["logo"].".jpg");
		}
		
		$database->SQLUpdate_SingleValue
		(
			"admin_users",
			"id",
			"1",
			"logo",
			""
		);
		
		$adminSettings = $database->DataArray("admin_users","id=1");
	}
}

?>

<?php

if(trim($adminSettings["logo"]) == "" || $adminSettings["logo"] == 0)
{
	
}
else
{
	?>
	<h3>
	<?php echo $YOUR_CURRENT_LOGO;?>
	</h3>

	<div class="clear"></div>

	
	
	<?php
	echo "<img src=\"../uploaded_images/".$adminSettings["logo"].".jpg\">";
	
	echo "<br><br>";
	?>
	<a class="btn btn-default" href="index.php?category=<?php echo $category;?>&action=<?php echo $action;?>&ProceedDelete=logo"><b><?php echo $M_DELETE;?></a>

	<?php
}

 ?>