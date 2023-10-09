<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
$ProceedSendSuccess = false;

if(is_array(unserialize($website->GetParam("EMPLOYER_FIELDS"))))
{
	$arrUserFields = unserialize($website->GetParam("EMPLOYER_FIELDS"));
}
else
{
	$arrUserFields = array();
}	
?>
<div class="page-wrap">
<?php
if(isset($_POST["ProceedSend"]))
{
	$user_email=$website->sanitize($_REQUEST["user_email"]);
	if($website->GetParam("USE_CAPTCHA_IMAGES") && ( (md5($_POST['code']) != $_SESSION['code'])|| trim($_POST['code']) == "" ) )
	{
		echo "<h3 class=\"red_font\">
		".$M_WRONG_CODE."
		</h3>";
		
	}
	else
	if($database->SQLCount("employers","WHERE username='$user_email' ") > 0 || $database->SQLCount("jobseekers","WHERE username='$user_email' ") > 0)
	{
		echo "<h3 class=\"red_font\">
		".$USER_EXISTS."
		</h3>";
	}
	else
	{
	
		$arrPValues = array();
			
		$iFCounter = 0;
			
		foreach($arrUserFields as $arrUserField)
		{		
			$arrPValues[$arrUserField[0]]=get_param("pfield".$iFCounter);
			$iFCounter++;
		}	
	
			if(!$website->GetParam("NEW_USERS_EMAIL_VALIDATION_ON_SIGNUP"))
			{
			
					$database->SQLInsert
					("employers",
					
					
						array("date","employer_fields","active","username","password","company","contact_person","company_description","address","phone","website","newsletter"),
						array(time(),serialize($arrPValues),"1",$user_email,$_POST["password"],$_POST["company"],$_POST["contact_person"],$_POST["company_description"],$_POST["address"],$_POST["phone"],$_POST["website"],(isset($_POST["newsletter"])?"1":"0"))
					
					);
					
					if($website->params[104]==1)
					{
						$headers  = "From: \"".$website->GetParam("SYSTEM_EMAIL_FROM")."\"<".$website->GetParam("SYSTEM_EMAIL_ADDRESS").">\n";
					
						mail($user_email, $website->params[105], $website->params[106], $headers);
					}
					
					echo "<h3>
					".$M_ACCOUNT_CREATED_SUCCESS."
					</h3>";
					?>
					<br/><br/>
					<form class="no-margin" action="loginaction.php" method="post">
						<input type="hidden" name="Email" value="<?php echo $user_email;?>"/>
						<input type="hidden" name="Password" value="<?php echo $_POST["password"];?>"/>
						<input type="submit" class="btn btn-green" value="<?php echo $M_CLICK_LOGIN_ADMIN;?>"/></td>
						<?php
						if($MULTI_LANGUAGE_SITE)
						{
						?>
						<input type="hidden" name="lang" value="<?php echo $website->lang;?>"/>
						<?php
						}
						?>
					</form>
					<?php
					
			}
			else
			{
					$arrChars = array("A","F","B","C","O","Q","W","E","R","T","Z","X","C","V","N");
							
					$code = $arrChars[rand(0,(sizeof($arrChars)-1))]."".rand(1000,9999)
					.$arrChars[rand(0,(sizeof($arrChars)-1))].rand(1000,9999);
				
					
					$database->SQLInsert
					(
						"employers",
						array("date","employer_fields","code","username","password","company","contact_person","company_description","address","phone","website","newsletter"),
						array(time(),serialize($arrPValues),$code,$user_email,$_POST["password"],$_POST["company"],$_POST["contact_person"],$_POST["company_description"],$_POST["address"],$_POST["phone"],$_POST["website"],$_POST["newsletter"])
					);
					
					$headers  = "From: \"".$website->GetParam("SYSTEM_EMAIL_FROM")."\"<".$website->GetParam("SYSTEM_EMAIL_ADDRESS").">\n";
										
					$message=str_replace("[ACTIVATE_LINK]",
					"http://".$DOMAIN_NAME."/activate.php?id=".$code,
					aParameter(814));
					
					mail($user_email, "".aParameter(815)."", $message, $headers);
					
					echo "<h3>".$MESSAGE_SENT_ACTIVATION." ".$user_email."
					
					".$CLICK_ACTIVATE."
					</h3>";
			}
						
					$ProceedSendSuccess = true;
	}

}
?>


<?php
if(!$ProceedSendSuccess)
{
?>


<?php
	echo "<h3>Création compte recruteur</h3>";
?>




<form id="main" action="index.php" method="post" onsubmit="return ValidateSignupForm(this)">
<?php
if($MULTI_LANGUAGE_SITE)
{
?>
<input type="hidden" name="lang" value="<?php echo $website->lang;?>"/>
<?php
}
?>
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
<input type="hidden" name="ProceedSend" value="1"/>
 	
<br>

		<fieldset>
	
		<ol>
			<li>
		
				<label>
				<?php echo $EMAIL;?>: (*) 
				</label>
			
				<input type="text" name="user_email" id="ser_email" value="<?php echo get_param("user_email");?>"/> 
				
			</li>
		
			
		
		<li>
		
				<label>
				<?php echo $M_PASSWORD;?>: (*) 
				</label>
			
				<input type="password" name="password" id="password"/> 
		
			
			</li>
		
		<li>
		
				<label>
				<?php echo $M_COMPANY;?>: (*) 
				</label>
		
					<input type="text" name="company" id="company" required value="<?php echo get_param("company");?>">
			
			</li>
			<li>
		
				<label>
				<?php echo $CONTACT_PERSON;?>: (*) 
				</label>
		
					<input type="text" name="contact_person" id="contact_person" required value="<?php echo get_param("contact_person");?>"/>
			
			</li>
		
			<li>
				<label>
				<?php echo $M_COMPANY_DESCRIPTION;?>:
				</label>
					<textarea name="company_description" cols=32 rows=3><?php echo get_param("company_description");?></textarea>
			<li>
				<label>

				<?php echo $M_ADDRESS;?>:
				</label>
					<textarea name="address" cols=32 rows=3><?php echo get_param("address");?></textarea>
			</li>
			<li>
				<label>
				<?php echo $M_PHONE;?>:
				</label>
			
					<input type="text" name="phone" id="phone" value="<?php echo get_param("phone");?>">
			</li>
			<li>
				<label>
					<?php echo $M_WEBSITE;?>:
				</label>
		
					<input type="text" name="website" id="website" value="<?php echo get_param("website");?>">
			</li>
			
			<?php
			$iFCounter = 0;	

			
			foreach($arrUserFields as $arrUserField)
			{
				
				echo "<li>";
				
				echo  "<label>".str_show($arrUserField[0], true).":</label>";	
				
				
				if(trim($arrUserField[2]) != "")
				{
						echo  "<select  name=\"pfield".$iFCounter."\" class=\"280px-field\">";
						
						
						$arrFieldValues = explode("\n", trim($arrUserField[2]));
								
									
						if(sizeof($arrFieldValues) > 0)
						{
							foreach($arrFieldValues as $strFieldValue)
							{
								$strFieldValue = trim($strFieldValue);
								if(strstr($strFieldValue,"{"))
								{
								
									$strVName = substr($strFieldValue,1,strlen($strFieldValue)-2);
									
									echo  "<option ".(trim($$strVName)==$arrPropFields[$arrUserField[0]]?"selected":"").">".trim($$strVName)."</option>";
									
								}
								else
								{
									echo  "<option ".(isset($arrPropFields[$arrUserField[0]])&&trim($strFieldValue)==$arrPropFields[$arrUserField[0]]?"selected":"").">".trim($strFieldValue)."</option>";
								}		
							
							}
						}
						
						echo  "</select>";
				}
				else
				{
						echo  "<input value=\"".(get_param("pfield".$iFCounter)!=""?get_param("pfield".$iFCounter):"")."\" type=text name=\"pfield".$iFCounter."\" class=\"280px-field\">";
				}
				
				echo  "</li>";
				
				
				$iFCounter++;		
			}
					
			?>
			
			
			<?php
			if($website->GetParam("USE_CAPTCHA_IMAGES"))
			{
			?>
			<li>
				<label>&nbsp;</label>
				<img src="include/sec_image.php" width="150" height="30" >
				<div class="clearfix"></div>
			
				<label><?php echo $M_CODE;?>:</label>
				<input type="text" required name="code" value="" size="8"/>
			
			 </li>
				
			<?php
			}
			?>
			<li>
				<input type="checkbox" name="newsletter" value="1"/>
				<?php echo $M_I_WOULD_LIKE_SUBSCRIBE;?>
				<?php echo $DOMAIN_NAME;?>
				<?php echo $M_NEWSLETTER;?>							
			</li>
			
			</ol>
			</fieldset>
			<div class="clearfix"></div>
			<span class="l-margin-35">(*) <?php echo $OBLIGATORY_FIELDS;?></span>
			<br/>
			<button type="submit" class="btn btn-green pull-right"><?php echo $M_SUBMIT;?></button>
			<div class="clearfix"></div>		
			
			<br/>
			
					
			</form>
			
		<script>

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
		
		function ValidateForm(x)
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
			
			return true;
		}
		function ValidateSignupForm(x){
		
		
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
		
			
			if(x.company.value==""){
				alert("<?php echo $ENTER_COMPANY_NAME;?>");
				x.company.focus();
				return false;
			}	
			
			
			return true;
		}
</script>

<?php
}
?>														

</div>

<?php
$website->Title($M_SIGNUP_EMPLOYER);
$website->MetaDescription("");
$website->MetaKeywords("");
?>
