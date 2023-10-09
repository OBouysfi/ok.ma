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
			"",
			"",
			$M_GO_BACK,
			"",
			
			"red",
			"small",
			"true",
			"window.history.back"
		 );
	?>
</div>
<div class="clear"></div>
<h3>
	<?php echo $SEND_PRIVATE_MESSAGE;?>
</h3>



<?php
$id=$_REQUEST["id"];
$website->ms_i($id);

$_REQUEST["strSpecialHiddenFieldsToAdd"] = '<input type="hidden" name="id" value="'.$id.'"/>';
$arrSelectedUser = $database->DataArray("jobseekers","id=".$id);

$_REQUEST["arrNames2"] = array("user_from","user_to","date");
$_REQUEST["arrValues2"] = array($AuthUserName, $arrSelectedUser["username"], time());


if(isset($_REQUEST["SpecialProcessAddForm"]))
{
	
	$headers  = "From: \"".$AuthUserName."\"<".$AuthUserName.">\n";
				
	mail($arrSelectedUser["username"], strip_tags(stripslashes($_REQUEST["subject"])), strip_tags(stripslashes($_REQUEST["message"])), $headers);

	
}		

AddNewForm
(
		array($SUBJECT.":",$M_MESSAGE.":"),
		array("subject","message"),
		array("textbox_50","textarea_50_6"),
		$ENVOYER,
		"user_messages",
		"$MESSAGE_SENT"
	);
?>
<br>
