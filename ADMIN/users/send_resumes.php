<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<table summary="" border="0" width="100%">
	<tr>
		<td width="45"><img src="images/icons2/users.gif" width="39" height="38" alt="" border="0"></td>
		<td><b>Send resumes to selected employer</b></td>
	</tr>
</table>

<div style="width:100%;text-align:left">
<?php 

$html_code_to_add = "Send the resumes to employer : ";
$html_code_to_add .='<select name="selected_employer" id="selected_employer">';

$employers = $database->DataTable("employers","ORDER by username");

while($employer = $database->fetch_array($employers))
{
	$html_code_to_add .= "<option>".$employer["username"]."</option>";
}

$html_code_to_add .= "</select>";

?>
</div>

<?php

if(isset($_REQUEST["Delete"]) && isset($_REQUEST["CheckList"]) && sizeof($_REQUEST["CheckList"]) > 0)
{
	$website->ms_ia($_REQUEST["CheckList"]);
	
	require("mailer/attach_mailer_class.php");

	$test = new attach_mailer($name = $SYSTEM_EMAIL_FROM, $from = $SYSTEM_EMAIL_ADDRESS, $to = $selected_employer, $cc = "", $bcc = "", $subject = "Forwarded resumes from ".$DOMAIN_NAME);
	$test->tbody = "You may find the resumes as attachment\n\n";
	
		
	foreach($_REQUEST["CheckList"] as $CheckID)
	{
		$jobseeker = $database->DataArray("jobseekers","id=".$CheckID);
		
		$file_to_attach="../user_files/"
		.strtolower(trim($jobseeker["first_name"]))
		."-".strtolower(trim($jobseeker["last_name"])).".pdf";
		copy("http://www.".$DOMAIN_NAME."/resume.php?id=".$CheckID,$file_to_attach);
		$test->add_attach_file($file_to_attach);
		
	}
	$test->process_mail();
}

$ORDER_QUERY="ORDER BY id DESC";

RenderTable
(
	"jobseekers",
	array("username","first_name","last_name","phone","ShowComments"),
	array($NOM_DUTILISATEUR,$FIRST_NAME,$LAST_NAME,$M_PHONE,$M_CV),
	"100%",
	" ",
	$ENVOYER,
	"id",
	
	"index.php?category=".$category."&action=".$action
);
?>
