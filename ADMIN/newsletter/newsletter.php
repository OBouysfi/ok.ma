<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?><?php 
if(isset($_REQUEST["Export"])){
header("Location: include/exportmail.php");
}
else
if(isset($_REQUEST["Delete"]) && isset($_REQUEST["CheckList"]))
{
	
	SQLDelete("mail","MailId",$_REQUEST["CheckList"]);
	
}

?>


<br>
<span class="medium-font"><?php echo $LIST_ALL_USERS;?> <?php echo date("F j, Y, g:i a");?> </span>
<br><br><br>

<?php

	$QUERY_TO_EXECUTE="SELECT DISTINCT * FROM ".$DBprefix."mail ";

	$oCol=array("Email","title","first_name","last_name","company","position","country");
	$oNames=array("Email","Title","First Name","Last Name","Company","Position","Country");
				
	RenderTable
	(
		"mail",$oCol,$oNames,750,"","Delete","MailId","index.php"
	);

?>

<br>
	