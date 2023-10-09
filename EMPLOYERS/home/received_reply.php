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
		"home",
		"received",
		$M_GO_BACK,
		"",
		"blue"
	 );
?>
</div>
<div class="clear"></div>
<h3>
	<?php echo $REPLY_MESSAGE;?>
</h3>
<br/>
<?php
$id=$_REQUEST["id"];
$website->ms_i($id);
$_REQUEST["strSpecialHiddenFieldsToAdd"] = "<input type=\"hidden\" name=\"id\" value=\"".$id."\"/>";
$arrSelectedMessage = $database->DataArray("messages","id=".$id);

if(isset($_POST["SpecialProcessAddForm"]))
{
	$headers  = "From: \"".$AuthUserName."\"<".$AuthUserName.">\n";
				
	mail
	(
		$arrSelectedMessage["user_from"], 
		strip_tags(stripslashes($_REQUEST["subject"])), 
		strip_tags(stripslashes($_REQUEST["message"])), 
		$headers
	);
}	

$_REQUEST["arrNames2"] = array("user_from","user_to","date");
$_REQUEST["arrValues2"] = array($AuthUserName, $arrSelectedMessage["user_from"], time());

AddNewForm
(
	array($SUBJECT.":",$M_MESSAGE.":"),
	array("subject","message"),
	array("textbox_54","textarea_40_6"),
	$ENVOYER,
	"messages",
	$MESSAGE_SENT
);
?>
<br/>

