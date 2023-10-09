<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");?>

<?php

if(isset($_REQUEST["ProceedNewPassword"])){
	
	$oArr=$database->DataArray("admin_users","username='$AuthUserName'");
	
	$oldpassword=$_REQUEST["oldpassword"];
	$newpassword1=$_REQUEST["newpassword1"];
	$newpassword2=$_REQUEST["newpassword2"];
	
	if($oArr["password"]!=md5($oldpassword))
	{
		echo '<span class="medium-font">
		'.$PWD_WRONG.'
		</span><br/><br/><br/>';
		
	}
	else
	if($newpassword1!=$newpassword2)
	{
		echo '<span class="medium-font">
		'.$PWD_MISMATCH.'
		</span><br/><br/><br/>';
		
	}
	else
	{
	
		$database->SQLUpdate_SingleValue
		(
			"admin_users",
			"username",
			"'".$AuthUserName."'",
			"password",
			md5($newpassword1)
		);
		
		echo '<span class="medium-font">
		'.$PWD_CHANGED.'
		</span><br/><br/><br/>';
		
		
	}

}

?>


<div class="fright">

	<?php
		echo LinkTile
				 (
					"home",
					"connections",
					$M_LOGIN_REPORT,
					"",
					"blue"
				 );
				 
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
<span class="medium-font"><?php echo $CHANGE_PWD_FOR_USER; ?></span>

		<br><br><br>
<form action="index.php" method="post">
<input type="hidden" name="ProceedNewPassword">
<input type="hidden" name="category" value="home">
<input type="hidden" name="action" value="password">

<table summary="" border="0">
  	<tr>
  		<td><?php echo $CURRENT_PWD; ?>:</td>
  		<td><input type="password" name="oldpassword" size="30"/></td>
  	</tr>
	<tr height=30>
  		<td>&nbsp;</td>
  		<td>&nbsp;</td>
  	</tr>
  	<tr>
  		<td><?php echo $NEW_PWD;?>:</td>
  		<td><input type="password" name="newpassword1" size="30"/></td>
  	</tr>
  	<tr>
  		<td><?php echo $CONFIRM_PWD;?>: </td>
  		<td><input type="password" name="newpassword2" size="30"/></td>
  	</tr>
  </table>
  
<br><br>

<input type="submit" value=" <?php echo $M_SAVE;?> " class="btn btn-primary min-width-100"/>
</form>
		
	
