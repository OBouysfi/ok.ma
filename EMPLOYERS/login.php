<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Vendors Admin</title>
<link rel="stylesheet" href="css/main.css"/>
<meta name="viewport" content="width=device-width">
<link href="css/bootstrap.css" rel="stylesheet">

</head>
<body>
<div class="container">
	<div class="container">
	<?php
	include("texts_en.php");
	?>
	<br/><br/>
	<img src="../images/logo.png"/>
		
	<br/>
	<br/>
	<span class="medium-font">
	
		<?php
		if(isset($_REQUEST["error"])&&$_REQUEST["error"]!="expired")
		{
			echo $LOGIN_ERROR_MESSAGE;
		}
		else
		{
			echo $M_LOG_IN;
		}
		?>
	
	</span>
	<br/>
	<br/>
	<br/>
	<!--main content area-->
		
		<div class="login-advert draw-shadow">
		
			<script>
				function ValidateLoginForm(x)
				{
					if(x.Email.value=="")
					{
						document.getElementById("main-title").innerHTML=
						"<?php echo $USERNAME_EMPTY_FIELD_MESSAGE;?>";
						x.Email.focus();
						return false;
					}
					else
					if(x.Password.value=="")
					{
						document.getElementById("main-title").innerHTML=
						"<?php echo $PASSWORD_EMPTY_FIELD_MESSAGE;?>";
						x.Password.focus();
						return false;
					}
					return true;
				}
				</script>

				<form action="loginaction.php" method="post" onsubmit="return ValidateLoginForm(this)">
					<br/>
					<br/>
					<img src="../images/signin-user.png" width="100" width="100"/>
					<div class="clear"></div>
					<br/>
				
					<input name="Email" type="text" value="<?php echo $M_USERNAME;?>" onmousedown="if(this.value=='<?php echo $M_USERNAME;?>') this.value=''" class="login-field" />
					<input name="Password" type="password" placeholder="<?php echo $MOT_DE_PASSE;?>" class="login-field no-top-border" />
					
					<div class="clear"></div>
					
					<input type="submit" class="btn btn-xl btn-success login-button" value="Log in"/>
					<br/>
					<br/>
					<br/>
					<br/>
				</form>
			</div>
			
			
	
	</div>	
	<div class="clear"></div>
	<br/>
	
	<br/>	
	</div>
	
</div>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>