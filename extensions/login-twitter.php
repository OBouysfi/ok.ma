<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
require("include/twitter/twitteroauth.php");

if(isset($_REQUEST["proceed_twitter"])&&$_REQUEST["uid"]!=""&&trim($_REQUEST["user_email"])!="")
{
	$arrChars = array("A","F","B","C","O","Q","W","E","R","T","Z","X","C","V","N");
		
	$password = $arrChars[rand(0,(sizeof($arrChars)-1))]."".rand(1000,9999)
	.$arrChars[rand(0,(sizeof($arrChars)-1))].rand(1000,9999);


	$database->SQLInsert
	(
		"jobseekers",
		array("twitter","active","date","username","password","first_name","last_name"),
		array($_REQUEST["uid"],"1",time(),$_REQUEST["user_email"],$password,$_REQUEST["user_name"],"")
	
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
if (!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])) 
{
	$twitteroauth = new TwitterOAuth($website->GetParam("TWITTER_KEY"),$website->GetParam("TWITTER_SECRET"), $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
	$access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']);
    $_SESSION['access_token'] = $access_token;
    $user_profile = $twitteroauth->get('account/verify_credentials');

	$uid=$user_profile->id;
	
	if($database->SQLCount("jobseekers","WHERE twitter=".$uid)==0)
	{
		if(isset($_REQUEST["user_email"])) $website->ms_ew($_REQUEST["user_email"]);
			
		if(
			!isset($_REQUEST["user_email"])
			||
			(
				isset($_REQUEST["user_email"])
				&&
				($database->SQLCount("employers","WHERE username='".$_REQUEST["user_email"]."' ") > 0 || $database->SQLCount("jobseekers","WHERE username='".$_REQUEST["user_email"]."' ") > 0)
			)
		)
		{
			///twitter authorization get email
			?>
			
			<br>
			<i><?php echo $M_JUST_CONFIRM_USERNAME;?></i>
			<br>
			
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
			<input type="hidden" name="token" value="<?php echo $access_token;?>">
			<input type="hidden" name="user_name" value="<?php echo $user_profile->name;?>">
			<input type="hidden" name="uid" value="<?php echo $uid;?>">
			<input type="hidden" name="proceed_twitter" value="1">
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
					<td class="text" valign="middle">
					
					<input type="email" required size="44" class="200px-field" name="user_email" id="user_email" value="<?php echo get_param("user_email");?>"> 
					
					</td>
				</tr>
				
			</table>

			<br><br>
				<input type="submit" value=" <?php echo $M_SUBMIT;?> " class="btn btn-green">
					
			
			
			</form>
			<?php
			
			///end twitter authorization get email
		}
	
	}
	else
	{
	
		$arrUser=$database->DataArray("jobseekers","twitter=".$uid);
		
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
else 
{
	
	$twitteroauth = new TwitterOAuth($website->GetParam("TWITTER_KEY"),$website->GetParam("TWITTER_SECRET"));
	$request_token = $twitteroauth->getRequestToken('http://'.$website->domain.'/index.php?mod=login-twitter');
	
	$_SESSION['oauth_token'] = $request_token['oauth_token'];
	$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
	if ($twitteroauth->http_code == 200)
	{
		$url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']);
		die("<script>document.location.href='".$url."';</script>");
	}
	else
	{
		
		echo "You have to configure the Twitter application by setting the key and secret - check our documentation for details.";
	}
}
?>
<?php
$website->Title($M_LOGIN);
$website->MetaDescription("");
$website->MetaKeywords("");
?>