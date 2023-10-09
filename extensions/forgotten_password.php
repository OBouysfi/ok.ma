<?php
if(!defined('IN_SCRIPT')) die("");
if(isset($_REQUEST["ProceedSend"]))
{
	$user_email=$_REQUEST["user_email"];
	
	$website->ms_ew($user_email);
	
	if($database->SQLCount("jobseekers","WHERE username='".$user_email."'") == 1)
	{
		$arrUser = $database->DataArray("jobseekers","username='".$user_email."'");
		
		$headers  = "From: \"".$website->GetParam("SYSTEM_EMAIL_FROM")."\"<".$website->GetParam("SYSTEM_EMAIL_ADDRESS").">\n";
											
		if(mail($user_email, $M_PASSWORD_REMINDER_FOR." ".$DOMAIN_NAME, str_replace("[password]", $arrUser['password'],$M_FORGOTTEN_PASSWORD_TEXT), $headers))
		{
				echo "<b>".$M_PWD_SENT_SUCCESS." ".$user_email."</b>";
		}
		else
		{
				echo "<b>".$M_ERROR_WHILE_SENDING." ".$user_email."</b>";
		}
	}
	else
	if($database->SQLCount("employers","WHERE username='".$user_email."'") == 1)
	{
	$arrUser = $database->DataArray("employers","username='".$user_email."'");
		
		$headers  = "From: \"".$website->GetParam("SYSTEM_EMAIL_FROM")."\"<".$website->GetParam("SYSTEM_EMAIL_ADDRESS").">\n";
											
		if(mail($user_email, $M_PASSWORD_REMINDER_FOR." ".$DOMAIN_NAME, str_replace("[password]", $arrUser['password'],$M_FORGOTTEN_PASSWORD_TEXT), $headers))
		{
				echo "<b>".$M_PWD_SENT_SUCCESS." ".$user_email."</b>";
		}
		else
		{
				echo "<b>".$M_ERROR_WHILE_SENDING." ".$user_email."</b>";
		}
	}
	else
	{
		echo "<b>".$M_WRONG_EMAIL_ADDRESS."</b>";
	}
}
else
{
?>

<h3><?php echo $M_PLEASE_ENTER_PWD_;?></h3>
<br/>
<form id="main" action="index.php" method="post">
<?php
if(isset($_REQUEST["mod"]))
{
?>
<input type="hidden" name="mod" value="<?php echo $_REQUEST["mod"];?>"/>
<?php
}
?>
<?php
if(isset($_REQUEST["page"]))
{
?>
<input type="hidden" name="page" value="<?php echo $_REQUEST["page"];?>"/>
<?php
}
?>
<input type="hidden" name="ProceedSend" value="1"/>

<fieldset>
	<br/>
	<ol>
		<li>
			
			<label><?php echo $EMAIL;?>:</label>
			
			<input type="text" size="20" name="user_email"/> 
		</li>
	</ol>
</fieldset>
<button type="submit" class="btn btn-green pull-right"><?php echo $GET_MY_PWD;?></button>
<div class="clearfix"></div>
</form>
<?php
}
?>
<?php
$website->Title($FORGOTTEN_PASSWORD);
$website->MetaDescription("");
$website->MetaKeywords("");
?>