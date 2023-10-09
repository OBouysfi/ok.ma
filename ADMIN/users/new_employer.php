<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?><div class="fright"> 
  <?php 
   echo LinkTile 
    ( 
		"users", 
		"employers", 
		$M_GO_BACK, 
		"", 
		"red" 
    ); 
  ?> 
</div> 
<div class="clear"></div> 
<h3><?php echo $M_ADD_NEW_EMPLOYER;?></h3>
<br/>	
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

	function ValidateSignupForm(x){
		
		
			if(x.username.value==""){
				alert("<?php echo $PLEASE_ENTER_YOUR_EMAIL;?>");
				x.username.focus();
				return false;
			}	
			
			
						
			if(x.password.value==""){
				alert("<?php echo $PASSWORD_EMPTY_FIELD_MESSAGE;?>");
				x.password.focus();
				return false;
			}	
						
			if(x.user_email.value != x.confirm_email.value)
			{
				alert("<?php echo $EMAILS_MISMATCH;?>");
				x.user_email.focus();
				return false;
			}	
			
			if(x.company.value==""){
				alert("<?php echo $ENTER_COMPANY_NAME;?>");
				x.company.focus();
				return false;
			}	
			
			
			return true;
		}
</script>
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

if($website->GetParam("CHARGE_TYPE")==1)
{

	$subscriptions=$database->DataTable("subscriptions","");
	$str_subscr="combobox_".$M_NO_SUBSCRIPTION."^0";
	while($arr_subscription=$database->fetch_array($subscriptions))
	{
		$str_subscr.="_".$arr_subscription["name"]."^".$arr_subscription["id"];
		
	}

	AddNewForm
	(

		array($M_EMAIL.":",$M_PASSWORD.":",$M_COMPANY.":",$CONTACT_PERSON.":",$M_COMPANY_DESCRIPTION.":",$M_ADDRESS.":",$M_PHONE.":",$M_WEBSITE.":",$M_SUBSCRIPTION.":"),
		array("username","password","company","contact_person","company_description","address","phone","website","subscription"),
					
		array("textbox_40","textbox_40","textbox_40","textbox_40","textarea_50_4","textarea_50_4","textbox_40","textbox_40",$str_subscr),
					
		$AJOUTER,
		"employers",
		$M_NEW_EMPLOYER_ADDED,
		false,
		array(),
		"ValidateSignupForm"
	);

}
else
{

	AddNewForm
	(

		array($M_EMAIL.":",$M_PASSWORD.":",$M_COMPANY.":",$CONTACT_PERSON.":",$M_COMPANY_DESCRIPTION.":",$M_ADDRESS.":",$M_PHONE.":",$M_WEBSITE.":",$M_CREDITS.":"),
		array("username","password","company","contact_person","company_description","address","phone","website","credits"),
					
		array("textbox_40","textbox_40","textbox_40","textbox_40","textarea_50_4","textarea_50_4","textbox_40","textbox_40","textbox_4"),
					
		$AJOUTER,
		"employers",
		$M_NEW_EMPLOYER_ADDED,
		false,
		array(),
		"ValidateSignupForm"
	);
}
?>

