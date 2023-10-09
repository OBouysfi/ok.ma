<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>

<script>

function CallBack()
{
	document.getElementById("main-content").innerHTML =
	top.frames['ajax-ifr'].document.body.innerHTML;
	HideLoadingIcon();
}
</script>


<?php
if(isset($_REQUEST["clear"])&&$_REQUEST["clear"]=="all")
{
	$database->Query("DELETE FROM ".$DBprefix."login_log");
}
?>


<div class="fright">

	<?php
	echo LinkTile
		 (
			"home",
			"connections-clear=all",
			$M_CLEAR,
			$M_CLEAR_LOG,
			"red"
		 );
				 
				 
			echo LinkTile
				 (
					"home",
					"password",
					$M_CHANGE_PWD,
					$M_MODIFY_PASSWORD,
					"lila"
				 );
		?>
		
	<?php
			echo LinkTile
				 (
					"security",
					"admin",
					$M_USERS,
					$M_GROUPS_PERMISSIONS,
					"yellow"
				 );
		?>
		
	
</div>
<div class="clear"></div>
<br/><br/>	
<span class="medium-font"><?php echo $M_LOGIN_REPORT;?></span>

		  

<div id="div2">
<?php
	

	
	
	$oCol=array("username","ip","date");
	$oNames=array($M_USERNAME,"IP",$DATE_MESSAGE);
			
	RenderTable("login_log",$oCol,$oNames,550,"WHERE action='login'  ".($AuthUserName=="administrator"?"":"AND username='".$AuthUserName."'"),"","id","index.php",true,5,false,-1,"ORDER BY id DESC");
	
?>
</div>				
			
<br/>
<br/>
<br/>

<span class="medium-font"><?php echo $M_LOGOUT_REPORT;?></span>


<div id="div4">
<?php				
					
	RenderTable("login_log",$oCol,$oNames,550,"WHERE action='error' AND username='$AuthUserName' ","","id","index.php",true,5,false,-1,"ORDER BY id DESC");
			
?>
</div>

<script>

//$('#start-menu').css('visibility','hidden');
</script>
