<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<br/>
<div class="page-wrap">
	<h3 class="no-margin">
	

	<?php
	if(isset($_REQUEST["error"])&&$_REQUEST["error"]=="login")
	{
		echo $LOGIN_ERROR_MESSAGE;
	}
	else
	if(isset($_REQUEST["error"])&&$_REQUEST["error"]=="no")
	{
		echo $LOGIN_EMPTY_FIELD_MESSAGE;
	}
	else
	if(isset($_REQUEST["error"])&&$_REQUEST["error"]=="expired")
	{
		echo $LOGIN_EXPIRED_MESSAGE;
	}
	else
	{
	  echo $M_LOGIN;
	}
	?>
	
	</h3>
<hr/>

<div class="clearfix"></div>

	
		<?php

		$logged_user_type="";

		$AUTH = false;
		
		if((isset($_COOKIE["AuthE"]))&&$_COOKIE["AuthE"]!="")
		{

			list($cookieUser,$cookiePassword,$cookieExpire)=explode("~",$_COOKIE["AuthE"]);
			if($cookieExpire<time())
			{
				
				$AUTH = false;	
				
			}
			else
			{
				$AUTH = true;

				echo '
				<br>
				<center>
				<form class="no-margin" action="EMPLOYERS/index.php" method="post">
					'.($MULTI_LANGUAGE_SITE?'<input type="hidden" name="lng" value="'.$website->lang.'"/>':'').'
					<input type="submit" class="btn btn-green" value=" '.$M_MY_SPACE.' "/>
				</form>
				<form class="no-margin" action="logout.php" method="post">
					'.($MULTI_LANGUAGE_SITE?'<input type="hidden" name="lang" value="'.$website->lang.'"/>':'').'
					<input type="hidden" name="proceed" value="e"/>
					<input type="submit" class="btn btn-green" value=" '.$M_LOGOUT.' "/>
				</form>
				</center>
				';
			}

		}
		else	
		if((isset($_COOKIE["AuthJ"]))&&$_COOKIE["AuthJ"]!="")
		{
			list($cookieUser,$cookiePassword,$cookieExpire)=explode("~",$_COOKIE["AuthJ"]);
			if($cookieExpire<time())
			{
				$AUTH = false;	
			}
			else
			{
				$ProceedApply = true;
				$arrLoginItems = explode("~", $_COOKIE["AuthJ"]);

				$username = $arrLoginItems[0];
				$password = $arrLoginItems[1];

				$AUTH = true;

				echo '

			
				<center>
				<form class="no-margin" action="JOBSEEKERS/index.php" method="post">
					'.($MULTI_LANGUAGE_SITE?'<input type="hidden" name="lng" value="'.$website->lang.'"/>':'').'
					<input type="submit" class="btn btn-green" value=" '.$M_MY_SPACE.' "/>
				</form>

				<form class="no-margin" action="logout.php" method="post">
					'.($MULTI_LANGUAGE_SITE?'<input type="hidden" name="lang" value="'.$website->lang.'"/>':'').'
					<input type="hidden" name="proceed" value="j"/>
					<input type="submit" class="btn btn-green" value=" '.$M_LOGOUT.' "/>
				</form>
				</center>


				';
			}
		}
		else
		{
			?>

			<script>
			function ValidateLoginForm(x)
			{
				if(x.Email.value=="")
				{
					document.getElementById("top_msg_header").innerHTML=
					"<?php echo $USERNAME_EMPTY_FIELD_MESSAGE;?>";
					x.Email.focus();
					return false;
				}
				else
				if(x.Password.value=="")
				{
				
					document.getElementById("top_msg_header").innerHTML=
					"<?php echo $PASSWORD_EMPTY_FIELD_MESSAGE;?>";
					x.Password.focus();
					return false;
				}
				return true;
			}
			</script>
			<?php

			if(isset($_REQUEST["return_url"])&&$_REQUEST["return_url"]!="")
			{

			}
			else
			{
				$return_url="";
				if(isset($_REQUEST["return_category"])) $return_url.="&category=".$_REQUEST["return_category"];
				if(isset($_REQUEST["return_action"])) $return_url.="&action=".$_REQUEST["return_action"];
				
			}


				
			?>
			
			<form class="no-margin" action="loginaction.php" method="post" onsubmit="return ValidateLoginForm(this)">
			<input type="hidden" name="mod" value="login"/>
			<table>
			<?php
			if(isset($MULTI_LANGUAGE_SITE))
			{
			?>
				<input type="hidden" name="lang" value="<?php echo $website->lang;?>">
			<?php
			}
			
			if(isset($_REQUEST["return_url"]))
			{
			?>
				<input type="hidden" name="return_url" value="<?php echo $_REQUEST["return_url"];?>">
			<?php
			}
			?>
				<tr height="36">
				
					<td width="25%"><?php echo $M_USERNAME;?>: </td>
					<td><input type="text" size="40" class="form-field width-100" value="<?php if(isset($_REQUEST["Email"])) echo $_REQUEST["Email"];?>" name="Email"/></td>
					
				</tr>
				<tr>
					<td width="25%"><?php echo $M_PASSWORD;?>: </td>
					<td><input  size="40" class="form-field width-100" type="password" name="Password"/></td>
					
				</tr>
				<tr>
					<td colspan="2">  
					
					<br/>
					<input type="submit" class="pull-right btn btn-green" value="<?php echo $M_LOGIN;?>"/>
					<br/>
					<a class="underline-link" href="<?php echo $website->mod_link("forgotten_password");?>"><?php echo $FORGOTTEN_PASSWORD;?></a> 
			
					</td>
				</tr>
				
			</table>
			</form>
			<br/><br/>
					
					
		<?php
		}
		?>

<?php
if($website->GetParam("ENABLE_FACEBOOK_LOGIN")==1||$website->GetParam("ENABLE_TWITTER_LOGIN")==1||$website->GetParam("ENABLE_LINKEDIN_LOGIN")==1)
{
?>
	<br/><br/>
	<h3>
		<?php echo $M_LOGIN_WITH;?>
		<?php
		$list_accounts="";
		if($website->GetParam("ENABLE_FACEBOOK_LOGIN")==1)
		{
			$list_accounts="Facebook";
		}
		
		if($website->GetParam("ENABLE_TWITTER_LOGIN")==1)
		{
			if($list_accounts!="") $list_accounts.=" ".$M_OR." ";
			$list_accounts.="Twitter";
		}
		
		if($website->GetParam("ENABLE_LINKEDIN_LOGIN")==1)
		{
			if($list_accounts!="") $list_accounts.=" ".$M_OR." ";
			$list_accounts.="LinkedIn";
		}
		echo $list_accounts;
		?>
		<?php echo $M_ACCOUNT;?>
	</h3>
	<hr/>
		<?php echo $M_CLICK_LOGIN_FB;?>
	<br/><br/>
	<?php
	if($website->GetParam("ENABLE_FACEBOOK_LOGIN")==1)
	{
	?>
		<a href="index.php?mod=login-facebook<?php if($MULTI_LANGUAGE_SITE) echo "&lang=".$website->lang;?>"><img src="images/facebook-signin.png" height="22" alt=""/></a>
	<?php
	}
	
	if($website->GetParam("ENABLE_TWITTER_LOGIN")==1)
	{
	?>
	
		<a href="<?php echo $website->mod_link("login-twitter");?>"><img src="images/twitter-signin.png" height="22" class="l-margin-40" alt=""/></a>
	<?php
	}
	
	
	if($website->GetParam("ENABLE_LINKEDIN_LOGIN")==1)
	{
	?>
	
		<a href="<?php echo $website->mod_link("login-linkedin");?>"><img src="images/linkedin-signin.png" height="22" class="l-margin-40" alt=""/></a>
	<?php
	}
	?>

<?php
}
?>

<?php
$website->Title($M_LOGIN);
$website->MetaDescription("");
$website->MetaKeywords("");
?>
</div>


<div class="clearfix"></div>

<br/><br/>