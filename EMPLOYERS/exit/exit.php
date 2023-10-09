<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!isset($iKEY)||$iKEY!="AZ8007")
{
	die("ACCESS DENIED");
}
?>
<?php
$database->Query("
	INSERT INTO ".$DBprefix."login_log(username,ip,date,action,cookie) 
	VALUES('".$AuthUserName."','".$_SERVER['REMOTE_ADDR']."','".time()."','logout','')
");

?>
		
<span class="medium-font">
<?php echo $NOUS_VOUS_REMERCIONS;?>
</span>
	
<script>

	setTimeout("document.location.href='logout.php<?php if($MULTI_LANGUAGE_SITE) echo "?lng=".$lang;?>'",2000);
</script>
						
