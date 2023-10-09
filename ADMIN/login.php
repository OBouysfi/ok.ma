<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jobs Portal Admin Panel Log In</title>
<link rel="stylesheet" href="css/main.css"/>
<meta name="viewport" content="width=device-width">
<link href="css/bootstrap.css" rel="stylesheet">

</head>
<body>
<div class="container">
	<div class="container text-center">
	<?php
	include("texts_en.php");
	?>
	<br/><br/>
	<a href="http://www.netartmedia.net/jobsportal" target="_blank"><h1><strong>Jobs Portal</strong></h1></a>
	
	<br/>
	
		<?php
		if(isset($_REQUEST["error"])&&$_REQUEST["error"]!="expired")
		{
			echo '<span class="medium-font">'.$LOGIN_ERROR_MESSAGE.'</span>';
		}
		else
		{
			echo '<span class="hide-sm medium-font">'.$M_LOG_IN.'<br/><br/></span>';
		}
		?>
	
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
					<img src="images/signin-user.png" width="100" width="100"/>
					<div class="clear"></div>
					<br/>
				
					<input name="Email" type="text" value="<?php echo $M_USERNAME;?>" onmousedown="if(this.value=='<?php echo $M_USERNAME;?>') this.value=''" class="login-field" />
					<input name="Password" type="password" placeholder="<?php echo $MOT_DE_PASSE;?>" class="login-field no-top-border" />
					
					<div class="clear"></div>
					
					<input type="submit" class="btn btn-xl btn-primary login-button" value="Log in"/>
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
	<hr style="margin-bottom:5px"/>
	
	<span class="fleft"><!--<a target="_blank" style="text-decoration:none" href="http://www.netartmedia.net">A software product of NetArt Media</a>--></span>
	<span class="fright"><a target="_blank" href="http://www.netartmedia.net/en_Contact.html" style="color:#0293aa;text-decoration:none">Need help?</a></span>
	</div>
	
</div>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>