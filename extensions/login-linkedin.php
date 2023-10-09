<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");

$LINKEDIN_API_KEY=$website->GetParam("LINKEDIN_KEY");
$LINKEDIN_SECRET=$website->GetParam("LINKEDIN_SECRET");

$show_signup_form=true;

if(isset($_REQUEST["proceed_linkedin"])&&$_REQUEST["uid"]!=""&&trim($_REQUEST["user_email"])!="")
{
	$arrChars = array("A","F","B","C","O","Q","W","E","R","T","Z","X","C","V","N");
		
	$password = $arrChars[rand(0,(sizeof($arrChars)-1))]."".rand(1000,9999)
	.$arrChars[rand(0,(sizeof($arrChars)-1))].rand(1000,9999);



	$database->SQLInsert
	(
		"jobseekers",
		array("linked_in","active","date","username","password","first_name","last_name"),
		array($_REQUEST["uid"],"1",time(),$_REQUEST["user_email"],$password,$_REQUEST["first_name"],$_REQUEST["last_name"])
	
	);
		
				
	
	?>
		<form id="login_form" style="display:none" class="no-margin" action="loginaction.php" method="post">
		<input type="hidden" name="Email" value="<?php echo $_REQUEST["user_email"];?>"/>
		<?php
		if($MULTI_LANGUAGE_SITE)
		{
		?>
		<input type="hidden" name="lng" value="<?php echo $website->lang;?>"/>
		<?php
		}
		?>
		<input type="hidden" name="Password" value="<?php echo $password;?>"/>
		</form>

		<script>
		document.getElementById("login_form").submit();
		</script>

	<?php
	
	
}
else
{

	$Error="";
	$process_error=false;
	$config['base_url']             =   "http://".$website->domain."/index.php?mod=login-linkedin";
	$config['callback_url']         =   "http://".$website->domain."/index.php?mod=login-linkedin&logged=1";
	$config['linkedin_access']      =   $LINKEDIN_API_KEY;
	$config['linkedin_secret']      =   $LINKEDIN_SECRET;
	include("include/oauth/linkedin.php");

	$linkedin = new LinkedIn($config['linkedin_access'], $config['linkedin_secret'], $config['callback_url'] );

	$linkedin->debug = false;
		
	if(!isset($_REQUEST["logged"]))
	{

		$linkedin->getRequestToken();
		$_SESSION['requestToken'] = serialize($linkedin->request_token);

		die('<script>document.location.href="'.$linkedin->generateAuthorizeUrl().'";</script>');
		
	}
	else
	{

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

			

			if(!isset($profile_information->id))

			{
			
				$process_error=true;
			}
			else
			{

				
				if($database->SQLCount("jobseekers","WHERE linked_in='".$profile_information->id."'")==0)
				{
					

					?>

					

					
					<br/>
					<i><?php echo $M_JUST_CONFIRM_USERNAME;?></i>

					<br/>

					

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
					<input type="hidden" name="proceed_linkedin" value="1">
					<input type="hidden" name="uid" value="<?php echo $profile_information->id;?>">
					<input type="hidden" name="first_name" value="<?php echo $profile_information->{'first-name'};?>"/>
					<input type="hidden" name="last_name" value="<?php echo $profile_information->{'last-name'};?>"/>
					
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
							<td>

									<?php echo $EMAIL;?>: 

							</td>

							<td>
								<input type="email" required size="44" class="200px-field" name="user_email" id="user_email" value="<?php if(isset($default_email_address)&&$default_email_address!="") echo $default_email_address;else echo get_param("user_email");?>"> 
							</td>

						</tr>
					</table>



					<br><br>

					<input type="submit" value=" <?php echo $M_SUBMIT;?> " class="btn btn-green">
					</form>

					<?php

				

			}
			else
			{
					
					$arrUser=$database->DataArray("jobseekers","linked_in='".$profile_information->id."'");
			
					$username=$arrUser["username"];
					$password=$arrUser["password"];
					
					?>
					<form id="login_form" style="display:none" class="no-margin" action="loginaction.php" method="post">
					<input type="hidden" name="Email" value="<?php echo $username;?>"/>
					<?php
					if($MULTI_LANGUAGE_SITE)
					{
					?>
					<input type="hidden" name="lng" value="<?php echo $website->lang;?>"/>
					<?php
					}
					?>
					<input type="hidden" name="Password" value="<?php echo $password;?>"/>
					</form>
					<script>
					document.getElementById("login_form").submit();
					</script>
				
					<?php
					
					
					
				}

			

			}

			

		}
		catch(Exception $e)
		{
			if($SYSTEM_DEBUG_MODE)
			{
				
			}
		
			$process_error=true;
		}


		if($process_error)
		{

			if(!isset($_REQUEST["li"]))
			{

		?>
			<script>
				document.location.href="index.php?li=1&<?php if(isset($_REQUEST["l_login"])) echo "l_login=1&";?>mod=login-linkedin";
			</script>

		<?php
			}
		}

	}
}
$website->Title($M_LOGIN);
$website->MetaDescription("");
$website->MetaKeywords("");
?>