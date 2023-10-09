<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
$LINKEDIN_API_KEY=$website->GetParam("LINKEDIN_KEY");
$LINKEDIN_SECRET=$website->GetParam("LINKEDIN_SECRET");

$show_signup_form=true;
$Error="";
$process_error=false;
$config['base_url']             =   "http://".$DOMAIN_NAME."/include/oauth/login.php";
$config['callback_url']         =   "http://".$DOMAIN_NAME."/index.php?mod=login-linkedin";
$config['linkedin_access']      =   $LINKEDIN_API_KEY;
$config['linkedin_secret']      =   $LINKEDIN_SECRET;
include("include/oauth/linkedin.php");
$linkedin = new LinkedIn($config['linkedin_access'], $config['linkedin_secret'], $config['callback_url'] );
$linkedin->debug = $SYSTEM_DEBUG_MODE;
if(isset($_REQUEST['oauth_verifier']))
{
	$_SESSION['oauth_verifier']     = $_REQUEST['oauth_verifier'];

	$linkedin->request_token    =   unserialize($_SESSION['requestToken']);
	$linkedin->oauth_verifier   =   $_SESSION['oauth_verifier'];
	$linkedin->getAccessToken($_REQUEST['oauth_verifier']);

	$_SESSION['oauth_access_token'] = serialize($linkedin->access_token);
	die("<script>document.location.href='".$config['callback_url']."';</script>");
}
else
{
	$linkedin->request_token    =   unserialize($_SESSION['requestToken']);
	$linkedin->oauth_verifier   =   $_SESSION['oauth_verifier'];
	$linkedin->access_token     =   unserialize($_SESSION['oauth_access_token']);
}

$xml_response = $linkedin->getProfile("~:(id,first-name,last-name,headline,picture-url,date-of-birth,phone-numbers,summary,industry)");
try
{
	$profile_information = new SimpleXMLElement($xml_response);
	
	if(!isset($profile_information->{'first-name'}))
	{
		$process_error=true;
		
	}
	else
	{
		//valid linked in process
	
	
	if(get_param("ProceedSend") == "1")
	{
		
	
		if($database->SQLCount("employers","WHERE username='$user_email' ") > 0 || $database->SQLCount("jobseekers","WHERE username='$user_email' ") > 0)
		{
			
			$Error = $USER_EXISTS;
			
		}
		
		if($Error == "")
		{
			$show_signup_form=false;
			
			$arrChars = array("A","F","B","C","O","Q","W","E","R","T","Z","X","C","V","N");
		
			$password = $arrChars[rand(0,(sizeof($arrChars)-1))]."".rand(1000,9999)
			.$arrChars[rand(0,(sizeof($arrChars)-1))].rand(1000,9999);
		
			
			$iResult = $database->SQLInsert
			(
				"jobseekers",
				array("linked_in","title","username","password","first_name","last_name","active"),
				array($profile_information->id,"",$user_email,$password,$profile_information->{'first-name'},$profile_information->{'last-name'},"1")
			
			);
			if($iResult>0)
			{
				echo('
				<br>'.$M_ACCOUNT_CREATED_SUCCESS.'
				<br><br>
				<form id="login_form" action="loginaction.php" method="Post" style="display:none;margin-top:0px;margin-bottom:0px">
				<input type="hidden" name="Email" value="'.$user_email.'"/>
				<input type="hidden" name="Password" value="'.$password.'"/>
				<input type="submit" value=" '.$M_CONNEXION.' "/>
				</form>');
				?>
				<script>
				document.getElementById("login_form").submit();
				</script>
				<?php
				$show_signup_form=false;
			}
			else
			{
				$process_error = true;
				$show_signup_form=true;
			}
			
		}
		else
		{
			echo "<br><span class=\"redtext\" style=\"font-size:18px;\">".$Error."</span><br><br>";
			
			$STEP = 1;
			$show_signup_form=true;
		}
	}
	

	if($show_signup_form)
	{
		if($Error!="" || !isset($arrUser["id"]) || $arrUser["username"]=="")
		{
		

			?>
			
			
			<i><?php echo $M_JUST_CONFIRM_USERNAME;?></i>
			<br><br>
			
			<script>
			function ValidateSignupForm(x)
			{
			
			
				if(x.user_email.value==""){
					alert("<?php echo $PLEASE_ENTER_YOUR_EMAIL;?>");
					x.user_email.focus();
					return false;
				}	
				
				if(!CheckValidEmail(x.user_email.value) )
				{
					alert(x.user_email.value+" <?php echo $IS_NOT_VALID;?>");
					x.user_email.focus();
					return false;
				}
				
											
				if(x.password.value==""){
					alert("<?php echo $PASSWORD_EMPTY_FIELD_MESSAGE;?>");
					x.password.focus();
					return false;
				}
			}	

			function CheckValidEmail(strEmail) 
			{
				if (strEmail.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) != -1)
				{
					return true;
				}
				else
				{
					return false;
				}
			}			
			</script>
			<form action="index.php" style="margin-left:10px;margin-right:10px;margin-top:0px;margin-bottom:0px" method="post" onsubmit="return ValidateSignupForm(this)">
			<?php
			if(isset($_REQUEST["mod"]))
			{
			?>
			<input type="hidden" name="mod" value="<?php echo $_REQUEST["mod"];?>">
			<?php
			}
			else
			{
			?>
			<input type="hidden" name="page" value="<?php echo $_REQUEST["page"];?>">
			<?php
			}
			?>
			<input type="hidden" name="ProceedSend" value="1">

			<br>

			<table width="100%">
		
			<tr>
		
				<label>
				<?php echo $EMAIL;?>: 
				</td>
			<td class=text valign=middle>
			
			<input type="text" size="44" class="200px-field" name="user_email" id="user_email" value="<?php if($default_email_address!="") echo $default_email_address;else echo get_param("user_email");?>"> 
			
			</td>
		</tr>
		
		<tr height=24>
		
			<td class="text" valign="middle" width="130">
				<?php echo $M_PASSWORD;?>: 
			</td>
			<td class="text" valign="middle">
				<input type="password" size="44" class="200px-field" name="password" id="password"> 
			</td>
		</tr>
	</table>

	<br><br>
		<input type="submit" value=" <?php echo $M_SEND;?> " class="btn btn-green">
			
			
			
			</form>
			<?php
		}
		else
		{


			echo "<i>".$M_REDIRECTED_MOMENT."</i>";


		}
	}
	
	}
	
}
catch(Exception $e)
{

	$process_error=true;
}

if($process_error)
{
	if(!isset($li))
	{
?>
	<script>
		document.location.href="index.php?li=1&<?php if(isset($l_login)) echo "l_login=1&";?>mod=linkedin_signup";
	</script>
<?php
	}
}
?>
