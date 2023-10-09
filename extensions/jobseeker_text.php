<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><div class="fb-connect-button">
	
<?php
	
if($ENABLE_FACEBOOK_LOGIN)
{

?>
	<div id="fb-root"></div>
	  <script>
	  window.fbAsyncInit = function() {
		FB.init({
		  appId   : '<?php echo $FACEBOOK_APPID; ?>',
		  cookie: true,
          xfbml: true,
          oauth: true
		});

	
		FB.Event.subscribe('auth.login', function() {
		if(document.location.href=="index.php?fb=1&p_login=1&mod=facebook_signup" ||document.location.href=="index.php?p_login=1&mod=facebook_signup" || document.location.href=="index.php?p_login=1&mod=facebook_signup" || document.location.href=="http://www.<?php echo $DOMAIN_NAME;?>/index.php?p_login=1&mod=facebook_signup" || document.location.href=="http://www.<?php echo $DOMAIN_NAME;?>/index.php?fb=1&p_login=1&mod=facebook_signup")
		{
		
		}
		else
		{
			if(!glob_lock)
			{
				document.location.href="http://www.<?php echo $DOMAIN_NAME;?>/index.php?p_login=1&mod=facebook_signup";
			}
		}
			
		});
	  };

	  (function() {
        var e = document.createElement('script'); e.async = true;
        e.src = document.location.protocol +
          '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
      }());
	</script>
	
	<?php
	
	if(isset($me) && $me)
	{
	?>
		
		<a href="index.php?p_login=1&mod=facebook_signup";?>">
		<img src="images/facebook_connect.png">
		</a>
	<?php
	}
	else
	{
	
	?>
	<script>
	function FacebookAuthorization() {
  FB.login(function(response) {
    if (response.session) {
      if (response.perms) {
 
      } else {
        
      }
    } else {
      // user is not logged in
    }
  }, {perms:'email'});
}
</script>

	<?php
	if($ENABLE_FACEBOOK_LOGIN)
	{
	?>
	<a href="#" onclick="FacebookAuthorization();"><img src="images/facebook_connect.png"></a>
	<?php
	}
	?>	


	
	<?php
	}
		
?>

<?php
}
?>
<script>
function LinkedinAuthorization()
{
	document.location.href="include/oauth/login.php";
}
</script>

<?php
if(trim($LINKEDIN_API_KEY)!=""&&trim($LINKEDIN_SECRET)!="")
{
?>
<a href="#" onclick="LinkedinAuthorization();"><img src="images/linkedin_connect.png" width="84" height="22" style="margin-top:10px"></a>
<?php
}
?>	




</div>
