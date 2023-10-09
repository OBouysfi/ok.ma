<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(isset($_REQUEST["color"]))
{
	$color= preg_replace("/[^ \w]+/", "",$_REQUEST["color"]); 

	$database->SQLUpdate_SingleValue
	(
		"admin_users",
		"username",
		"'".$AuthUserName."'",
		"custom_color",
		$color
	);
	echo "<h3>".$M_NEW_SETTINGS_SUCCESS."</h3>";
	echo '<a class="btn btn-default" target="_blank" href="../index.php?p='.$AuthUserName.'">'.$M_PREVIEW_YOUR_STORE.'</a><br/><br/>';
}

if(isset($_REQUEST["layout"]))
{
	
	$database->SQLUpdate_SingleValue
	(
		"admin_users",
		"id",
		"1",
		"layout_mode",
		$website->sanitize($_REQUEST["layout"])
	);
	echo "<h3>".$M_NEW_SETTINGS_SUCCESS."</h3>";
	echo '<a class="btn btn-default" target="_blank" href="../index.php">'.$M_PREVIEW_YOUR_STORE.'</a><br/><br/>';
}

if(isset($_REQUEST["background"]))
{
	$database->SQLUpdate_SingleValue
	(
		"admin_users",
		"id",
		"1",
		"background",
		$website->sanitize($_REQUEST["background"])
	);
	echo "<h3>".$M_NEW_SETTINGS_SUCCESS."</h3>";
	echo '<a class="btn btn-default" target="_blank" href="../index.php">'.$M_PREVIEW_YOUR_STORE.'</a><br/><br/>';
}



$adminSettings = $database->DataArray("admin_users","id=1");
?>
<br/>
<h3><?php echo $M_P_SKINS;?></h3>
<hr class="bottom-top-10"/>
<a href="index.php?category=templates&action=layout&color=279fbb" style="display:block;float:left;margin-right:10px;margin-bottom:10px;width:25px;height:25px;background:#279fbb"></a>
<a href="index.php?category=templates&action=layout&color=26ae91" style="display:block;float:left;margin-right:10px;margin-bottom:10px;width:25px;height:25px;background:#26ae91"></a>
<a href="index.php?category=templates&action=layout&color=d14836" style="display:block;float:left;margin-right:10px;margin-bottom:10px;width:25px;height:25px;background:#d14836"></a>
<a href="index.php?category=templates&action=layout&color=bb3b6b" style="display:block;float:left;margin-right:10px;margin-bottom:10px;width:25px;height:25px;background:#bb3b6b"></a>
<a href="index.php?category=templates&action=layout&color=5f5d5c" style="display:block;float:left;margin-right:10px;margin-bottom:10px;width:25px;height:25px;background:#5f5d5c"></a>
<a href="index.php?category=templates&action=layout&color=2580b1" style="display:block;float:left;margin-right:10px;margin-bottom:10px;width:25px;height:25px;background:#2580b1"></a>
<a href="index.php?category=templates&action=layout&color=9b9e40" style="display:block;float:left;margin-right:10px;margin-bottom:10px;width:25px;height:25px;background:#9b9e40"></a>
<a href="index.php?category=templates&action=layout&color=dd6153" style="display:block;float:left;margin-right:10px;margin-bottom:10px;width:25px;height:25px;background:#dd6153"></a>
<a href="index.php?category=templates&action=layout&color=9d634c" style="display:block;float:left;margin-right:10px;margin-bottom:10px;width:25px;height:25px;background:#9d634c"></a>
<a href="index.php?category=templates&action=layout&color=d06f71" style="display:block;float:left;margin-right:10px;margin-bottom:10px;width:25px;height:25px;background:#d06f71"></a>
<div class="clear"></div>
<a class="underline-link" href="index.php?category=templates&action=layout&color="><?php echo $M_CLEAR_SET_DEFAULT;?></a>

<div class="clear"></div>
<br/>

<h3><?php echo $M_ACCENT_COLOR;?></h3>
<hr class="bottom-top-10"/>
	<form action="index.php" method="post">
	<input type="hidden" name="category" value="templates"/>
	<input type="hidden" name="action" value="layout"/>
	<input name="color" style="width:80px" class="color" value="<?php if(isset($adminSettings["custom_color"])&&trim($adminSettings["custom_color"])!="") echo "#".$adminSettings["custom_color"];else echo "#279FBB";?>" class="form-field"/>
	<input type="submit" class="btn btn-default" value="<?php echo $M_SAVE;?>"/>
	</form>

	
<div class="clear"></div>
<br/>


<h3><?php echo $M_BACKGROUNDS;?></h3>
<hr class="bottom-top-10"/>
<a href="index.php?category=templates&action=layout&background=1" style="display:block;float:left;margin-right:10px;margin-bottom:10px;width:25px;height:25px;background-image:url('../images/backgrounds/1.png')"></a>
<a href="index.php?category=templates&action=layout&background=2" style="display:block;float:left;margin-right:10px;margin-bottom:10px;width:25px;height:25px;background-image:url('../images/backgrounds/2.png')"></a>
<a href="index.php?category=templates&action=layout&background=3" style="display:block;float:left;margin-right:10px;margin-bottom:10px;width:25px;height:25px;background-image:url('../images/backgrounds/3.png')"></a>
<a href="index.php?category=templates&action=layout&background=4" style="display:block;float:left;margin-right:10px;margin-bottom:10px;width:25px;height:25px;background-image:url('../images/backgrounds/4.png')"></a>
<a href="index.php?category=templates&action=layout&background=5" style="display:block;float:left;margin-right:10px;margin-bottom:10px;width:25px;height:25px;background-image:url('../images/backgrounds/5.png')"></a>
<a href="index.php?category=templates&action=layout&background=6" style="display:block;float:left;margin-right:10px;margin-bottom:10px;width:25px;height:25px;background-image:url('../images/backgrounds/6.png')"></a>
<a href="index.php?category=templates&action=layout&background=7" style="display:block;float:left;margin-right:10px;margin-bottom:10px;width:25px;height:25px;background-image:url('../images/backgrounds/7.png')"></a>
<a href="index.php?category=templates&action=layout&background=8" style="display:block;float:left;margin-right:10px;margin-bottom:10px;width:25px;height:25px;background-image:url('../images/backgrounds/8.png')"></a>
<a href="index.php?category=templates&action=layout&background=9" style="display:block;float:left;margin-right:10px;margin-bottom:10px;width:25px;height:25px;background-image:url('../images/backgrounds/9.png')"></a>
<a href="index.php?category=templates&action=layout&background=10" style="display:block;float:left;margin-right:10px;margin-bottom:10px;width:25px;height:25px;background-image:url('../images/backgrounds/10.png')"></a>
<div class="clear"></div>
<a class="underline-link" href="index.php?category=templates&action=layout&background="><?php echo $M_CLEAR_SET_DEFAULT;?></a>

