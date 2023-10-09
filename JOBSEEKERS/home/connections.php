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
			"home",
			"welcome",
			$M_DASHBOARD,
			"",
			"green"
		 );
				 
				 
		echo LinkTile
		 (
			"profile",
			"password",
			$M_CHANGE_PWD,
			$M_MODIFY_PASSWORD,
			"lila"
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
			
	RenderTable("login_log",$oCol,$oNames,550,"WHERE action='login' AND username='".$AuthUserName."'","","id","index.php",true,5,false,-1,"ORDER BY id DESC");
	
?>
</div>				
			
<br/>
<br/>
<br/>

<span class="medium-font"><?php echo $M_LOGOUT_REPORT;?></span>


<div id="div4">
<?php				
					
	RenderTable("login_log",$oCol,$oNames,550,"WHERE action='error' AND username='".$AuthUserName."' ","","id","index.php",true,5,false,-1,"ORDER BY id DESC");
			
?>
</div>
