<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
require 'include/facebook/facebook.php';

$facebook = new Facebook
(
	array
	(
        'appId' => $website->GetParam("FACEBOOK_KEY"),
        'secret' => $website->GetParam("FACEBOOK_SECRET"),
    ));

$user = $facebook->getUser();

if($user) 
{
  try 
  {
    $user_profile = $facebook->api('/me');
  } 
  catch (FacebookApiException $e) 
  {
   
    $user = null;
  }

    if (!empty($user_profile)) 
	{
        $username = $user_profile['name'];
		$uid = $user_profile['id'];
		$email = $user_profile['email'];
        
		
		if($database->SQLCount("jobseekers","WHERE facebook_id=".$uid)==0)
		{
			$username=$user_profile["email"];
			
			$arrChars = array("A","F","B","C","O","Q","W","E","R","T","Z","X","C","V","N");
		
			$password = $arrChars[rand(0,(sizeof($arrChars)-1))]."".rand(1000,9999)
			.$arrChars[rand(0,(sizeof($arrChars)-1))].rand(1000,9999);
		
			
			$database->SQLInsert
			(
				"jobseekers",
				array("facebook_id","active","date","username","password","first_name","last_name","newsletter"),
				array($uid,"1",time(),$user_profile["email"],$password,$user_profile["first_name"],$user_profile["last_name"],$_POST["newsletter"])
			
			);
			
		
		}
		else
		{
		
			$arrUser=$database->DataArray("jobseekers","facebook_id=".$uid);
			
			$username=$arrUser["username"];
			$password=$arrUser["password"];
			
		}
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
	else 
	{
       
    }
} 
else 
{
	$login_url = $facebook->getLoginUrl
	(
		array
		( 
			'scope' => 'email',
			'next' => "http://".$DOMAIN_NAME."/index.php?mod=login-facebook&fb_l=1"			
			//'redirect_uri' => 'http://'.$website->domain.'/'.$website->mod_link("login-facebook")
		
		)
		
	);

	if(isset($_REQUEST["fb_l"]))
	{
		die("<script>document.location.href='index.php?mod=jobseekers';</script>");
	}
	else
	{
		die("<script>document.location.href='".$login_url."';</script>");
	}
	//die("<script>document.location.href='".$login_url."';</script>");
}


$website->Title($M_LOGIN);
$website->MetaDescription("");
$website->MetaKeywords("");
?>