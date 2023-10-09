<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
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

setcookie("Auth","",time()-1);
?>
		
<span class="medium-font">
<?php echo $NOUS_VOUS_REMERCIONS;?>
</span>
	
<script>

	setTimeout("document.location.href='login.php'",2000);
</script>
						
