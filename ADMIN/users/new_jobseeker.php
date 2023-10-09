<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?><div class="fright"> 
  <?php 
   echo LinkTile 
    ( 
		"users", 
		"jobseekers", 
		$M_GO_BACK, 
		"", 
		"red" 
    ); 
  ?> 
</div> 
<div class="clear"></div> 

<h3><?php echo $M_ADD_JOBSEEKER;?></h3>
<script>
function validateEmail(email) 
{ 
 var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/ 
 
 if(email.match(re))
 {
	return true;
 }
 else
 {
	alert(email+" <?php echo $IS_NOT_VALID;?>");
	return false;
 }
}

function ValidateSignupForm(x)
{
	if(x.username.value=="")
	{
		alert("<?php echo $PLEASE_ENTER_YOUR_EMAIL;?>");
		x.username.focus();
		return false;
	}	
		
	if(x.password.value==""){
		alert("<?php echo $PASSWORD_EMPTY_FIELD_MESSAGE;?>");
		x.password.focus();
		return false;
	}	
				
	
	
	if(x.first_name.value==""){
		alert("<?php echo $PLEASE_ENTER_FIRST_NAME;?>");
		x.first_name.focus();
		return false;
	}	
	
	if(x.last_name.value=="")
	{
		alert("<?php echo $PLEASE_ENTER_LAST_NAME;?>");
		x.last_name.focus();
		return false;
	}	
	
	
	return true;
}
</script>

<br>
<?php

$_REQUEST["arrNames2"] = array("active","date");
$_REQUEST["arrValues2"] = array("1",time());


if(isset($_REQUEST["SpecialProcessAddForm"]))
{
	$user_email=$_REQUEST["username"];
	if($database->SQLCount("employers","WHERE username='$user_email' ") > 0 || $database->SQLCount("jobseekers","WHERE username='$user_email' ") > 0)
	{
		echo "<h3 class=\"red_font\">
		There is already an user registered with this email address - 
		please choose a different email address!
		</h3><br/><br/>";
		
		unset($_REQUEST["SpecialProcessAddForm"]);
	}
}


AddNewForm
(
	array($M_EMAIL.":",$M_PASSWORD.":",$FIRST_NAME.":",$LAST_NAME.":",$M_ADDRESS.":",$M_PHONE.":",$M_MOBILE.":",$M_DOB.":"),
	array("username","password","first_name","last_name","address","phone","mobile","dob"),
	array("textbox_50","textbox_50","textbox_50","textbox_50","textarea_37_4","textbox_50","textbox_50","textbox_50"),
	$AJOUTER,
	"jobseekers",
	$M_JOBSEEKER_ADDED,
	false,
	array(),
	"ValidateSignupForm"
);
?>

