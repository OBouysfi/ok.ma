<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
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
		$EDIT_YOUR_PROFILE,
		"",
		"green"
	 );
	 
	echo LinkTile
	 (
		"cv",
		"description",
		$EDIT_YOUR_CV,
		"",
		"yellow"
	 );
?>
</div>
<div class="clear"></div>
<h3>
	<?php echo $VIEW_CURRENT_PROFILE;?>
</h3>
<br/>
<?php
if($arrUser["profile_public"]==0)
{
?>
	<span class="red-font"><i><?php echo $M_CURRENTLY_SET_NOT_PUBLIC;?> <?php echo $M_PUBLIC_PROFILE_EXPL;?></i></span>
	
<br/>

<?php
}


$_REQUEST["HideSubmit"] = true;

$website->ms_i($arrUser["id"]);


AddEditForm
(
	array
	(
		"<i>".$str_PageNamePage."</i>",
		"<i>".$FIRST_NAME.":</i>",
		"<i>".$LAST_NAME.":</i>",
		"<i>".$M_ADDRESS.":</i>",
		"<i>".$TELEPHONE.":</i>",
		"<i>".$M_MOBILE.":</i>",
		"<i>".$M_DOB.":</i>",
		"<i>".$M_GENDER.":</i>",
		"<i>".$M_PICTURE.":</i>"
	),
	array("title","first_name","last_name","address","phone",
	"mobile","dob","gender","logo"),
	array("profile_public","title","first_name","last_name","address","phone",
	"mobile","dob","gender","logo"),
	array("textbox_5","textbox_30","textbox_30","textarea_50_4","textbox_30",
	"textbox_30","textbox_30","textbox_30","textbox_30"),
	"jobseekers",
	"id",
	$arrUser["id"],
	"",
	"",
	180

);


?>

<table summary="" border="0" width="100%">
	<tr>
		<td>
		
		
<?php	
$arrPropFields = array();

if(is_array(unserialize($arrUser["jobseeker_fields"])))
{
	$arrPropFields = unserialize($arrUser["jobseeker_fields"]);
}

$bFirst = true;
while (list($key, $val) = each($arrPropFields)) 
{

?>
<tr height="38">
		<td width="180"><i><?php str_show($key);?>:</i></td>
		<td><b><?php str_show($val);?></b></td>
		</tr>
<?php

}

?>
		</td>
	</tr>
</table>
