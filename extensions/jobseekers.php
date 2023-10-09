<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?>
<script type="text/javascript">
$(document).ready(function() {
	$(".montrer-form").click(function(){
		$("#enreg").show();
	});
});	
</script>
 <?php
 if(!defined('IN_SCRIPT')) die("");
$ProceedSendSuccess = false;
if(is_array(unserialize($website->GetParam("JOBSEEKER_FIELDS"))))
{
	$arrUserFields = unserialize($website->GetParam("JOBSEEKER_FIELDS"));
}
else
{
	$arrUserFields = array();
}
?>
<h3>ESPACE CANDIDAT: Connectez vous</h3><br/>
<div class="col-md-12" style="margin-left: -30px;">

		<div class="col-md-7">
		 
			<div class="login-form-container">
		 
				<form class="login-form" action="loginaction.php" method="post" onsubmit="return ValidateLoginForm(this)">
					<input type="hidden" name="mod" value="login">
				
					<input type="hidden" name="lang" value="en">
					
					<div class="form-group email">
						<label class="sr-only" for="login-email">Votre Email</label>
						<input id="login-email" name="Email" type="text" class="form-control login-email" placeholder="Votre Email" required>
					</div>
					<div class="form-group password">
						<label class="sr-only" for="login-password">Mot de passe</label>
						<input id="login-password" name="Password" type="password" class="form-control login-password" placeholder="Mot de passe" required>
						<p class="forgot-password" style="margin-top: 10px;">
						   <a class="underline-link" href="index.php?mod=forgotten_password">Vous avez oublié votre mot de passe?</a> 
						</p>
					</div>
					<button type="submit" class="btn btn-green custom-back-color">Connexion</button>
				</form>
			</div>
			
			<br>
		</div>
	</div>
	<p>Vous n'avez pas encore de compte candidat? Inscrivez-vous.</p>
	<a href="#enreg" class="btn btn-green upper-case white-font custom-back-color montrer-form">
		Créez votre compte</a>
<div id="enreg" class="page-wrap" style="display:none">
<?php	
if(isset($_POST["ProceedSend"]))
{
	$user_email=$website->sanitize($_REQUEST["user_email"]);
	

 	if($website->GetParam("USE_CAPTCHA_IMAGES") && ( (md5($_POST['code']) != $_SESSION['code'])|| trim($_POST['code']) == "" ) )
	{
		echo "<br/>
			<span class=\"red-font\">
				".$M_WRONG_CODE."
			</span>
			<br/><br/>";
		
	}
	else
	if($database->SQLCount("employers","WHERE username='".$user_email."' ") > 0 || $database->SQLCount("jobseekers","WHERE username='".$user_email."' ") > 0)
	{
		echo "<br/>
			<span class=\"red_font\">
				".$USER_EXISTS."
			</span>
			<br/><br/>";
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
	
			if($website->GetParam("CHARGE_THE_JOBSEEKERS")||!$website->GetParam("NEW_USERS_EMAIL_VALIDATION_ON_SIGNUP"))
			{
			
					$database->SQLInsert
					(
						"jobseekers",
						array("date","jobseeker_fields","package","active","title","username","password","first_name","last_name","address","phone","mobile","newsletter"),
						array(time(),serialize($arrPValues),get_param("package"),($website->GetParam("CHARGE_THE_JOBSEEKERS")?"0":"1"),$_POST["title"],$_POST["user_email"],$_POST["password"],$_POST["first_name"],$_POST["last_name"],$_POST["address"],$_POST["phone"],$_POST["mobile"],(isset($_POST["newsletter"])?"1":"0"))
					
					);
					
					$database->SQLInsert
					(
						"jobseeker_resumes",
						array("username"),
						array($user_email)
					
					);
					
					if($website->params[104]==1)
					{
						$headers  = "From: \"".$website->GetParam("SYSTEM_EMAIL_FROM")."\"<".$website->GetParam("SYSTEM_EMAIL_ADDRESS").">\n";
					
						mail($user_email, $website->params[110], $website->params[111], $headers);
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
					
					
					if($website->GetParam("CHARGE_THE_JOBSEEKERS"))
					{
						$package=$website->ms_i(get_param("package"));
						$arrPackage = $database->DataArray("jobseeker_packages","id=".$package);
					
						if(get_param("payment_option") == "paypal")
						{
				
						
									
							echo "
							<br><br><i>
								".$PLEASE_CLICK_ICON_PAYPAL."
								<br><br>";
								?>
								
								<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
								<input type="image" src="ADMIN/images/paypal.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
								 <input type="hidden" name="cmd" value="_xclick-subscriptions">
								<input type="hidden" name="business" value="<?php echo $PAYPAL_ACCOUNT;?>"> 
								<input type="hidden" name="item_name" value="<?php echo $DOMAIN_NAME." ".$M_PACKAGE.": ".$arrPackage["id"]; ?>"> 
								<input type="hidden" name="item_number" value="<?php echo $arrPackage["id"]; ?>"> 
								<input type="hidden" name="no_note" value="1"> 
								<input type="hidden" name="currency_code" value="<?php echo $PAYPAL_CURRENCY_CODE; ?>"> 
								<input type="hidden" name="a3" value="<?php echo $arrPackage["price"]; ?>"> 
								<input type="hidden" name="p3" value="<?php echo $arrPackage["billed"]; ?>"> 
								<input type="hidden" name="t3" value="M"> 
								<input type="hidden" name="src" value="1"> 
								<input type="hidden" name="sra" value="1"> 
								<input type="hidden" name="return" value="http://www.<?php echo $DOMAIN_NAME;?>"> 
								<input type="hidden" name="cancel_return" value="http://www.<?php echo $DOMAIN_NAME;?>"> 
								<input type="hidden" name="custom" value="<?php echo $user_email; ?>"> 
								<INPUT TYPE="hidden" NAME="first_name" VALUE="<?php echo get_param("first_name");?>">
								<INPUT TYPE="hidden" NAME="last_name" VALUE="<?php echo get_param("last_name");?>">
								 <input type="hidden" name="notify_url" value="<?php echo "http://".$DOMAIN_NAME."/ipn_jobseeker.php";?>">
																
								</form>
								
								<?php
								echo "<br><br>".$M_ACCOUNT_PAYPAL_NOT_ACTIVE;
								
								echo "</i>
								";
							
				}
				else
				if(get_param("payment_option") == "cheque")
				{
				
						$strAmount = $website->GetParam("CURRENCY").$arrPackage["price"];
						
						
						
						$database->SQLInsert
							( 
								"jobseeker_payments",
								array("user","method","validated","amount"),
								array($user_email,"cheque","0",$arrPackage["price"])
							);
									
						echo "<br><br>
								<i>
								".str_replace("{AMOUNT}","<span class=\"red-text\">".$strAmount."</span>",$M_PLEASE_SEND_CHECK_TO)."
								<br><br>
								".$CHEQUE_ADDRESS."
								<br><br>
								<span class=\"red-text\">".$M_YOUR_ACCOUNT_NOT_ACTIVE."</span>
								</i>
								";
						
				}
				else
				if(get_param("payment_option") == "bank_wire")
				{
						
						$strAmount = $website->GetParam("CURRENCY").$arrPackage["price"];
						
						$database->SQLInsert
							( 
								"jobseeker_payments",
								array("date","user","method","validated","amount"),
								array(time(),$user_email,"bank transfer","0",$arrPackage["price"])
							);
										
						echo "<br><br>
								<i>
								".str_replace("{AMOUNT}","<span class=redtext>".$strAmount."</span>",$M_PLEASE_MAKE_TRANSFER)."
								<br><br>
								".$BANK_WIRE_TRANSFER_INFO."
								<br><br>
								<span class=redtext>$M_YOUR_ACCOUNT_NOT_ACTIVE</span>
								</i>
								";
						
				}
				
					
					}
					
			}
			else
			{
					$arrChars = array("A","F","B","C","O","Q","W","E","R","T","Z","X","C","V","N");
							
					$code = $arrChars[rand(0,(sizeof($arrChars)-1))]."".rand(1000,9999)
					.$arrChars[rand(0,(sizeof($arrChars)-1))].rand(1000,9999);
				
					
					$database->SQLInsert
					(
						"jobseekers",
						array("date","jobseeker_fields","code","title","username","password","first_name","last_name","address","phone","mobile","newsletter"),
						array(time(),serialize($arrPValues),$code,$_POST["title"],$user_email,$_POST["password"],$_POST["first_name"],$_POST["last_name"],$_POST["address"],$_POST["phone"],$_POST["mobile"],$_POST["newsletter"])
					
					);
					$database->SQLInsert
					(
						"jobseeker_resumes",
						array("username"),
						array($user_email)
					
					);
					
					$headers  = "From: \"".$website->GetParam("SYSTEM_EMAIL_FROM")."\"<".$website->GetParam("SYSTEM_EMAIL_ADDRESS").">\n";
					
					$message=str_replace("[ACTIVATE_LINK]",
					"http://".$DOMAIN_NAME."/activate_jobseeker.php?id=".$code,
					$website->GetParam("JOBSEEKER_ACTIVATION_TEXT"));
					
					mail
					(
						$user_email, 
						$website->GetParam("JOBSEEKER_ACTIVATION_SUBJECT"),
						$message, 
						$headers
					);
					
					echo "<h3>".$MESSAGE_SENT_ACTIVATION." ".$user_email."
					<br/><br/>
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

<h3>ESPACE CANDIDAT: Veuillez vous enregistrer</h3>


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
<input type="hidden" name="ProceedSend" value="1">
 	
<br>

		<fieldset>
		
		<ol>
			<li>
		
				<label>
				<?php echo $EMAIL;?>: (*) 
				</label>
			
				<input type="text" name="user_email" id="user_email" value="<?php echo get_param("user_email");?>"/> 
				<!--<br/>
				<span class="small-text"><?php echo $EMAIL_REQUIRED;?></span>-->
			
			</li>
			
	
			<li>
		
				<label>
				<?php echo $M_PASSWORD;?>: (*) 
				</label>
			
				<input type="password" name="password" id="password"/> 
		
			</li>
		
			<li>
		
				<label>
				<?php echo $M_TITLE;?>: (*) 
				</label>
		
				<select name="title">
					<option  <?php if(get_param("title")==$M_MR) echo "selected";?>><?php echo $M_MR;?></option>
					<option <?php if(get_param("title")==$M_MRS) echo "selected";?>><?php echo $M_MRS;?></option>
					<option <?php if(get_param("title")==$M_MSS) echo "selected";?>><?php echo $M_MSS;?></option>
				</select>
			
			</li>
		
			<li>
		
				<label>
				<?php echo $FIRST_NAME;?>: (*) 
				</label>
		
				<input type=text name="first_name" id="first_name" value="<?php echo get_param("first_name");?>">
			
			
			</li>
			<li>
		
				<label>
				<?php echo $LAST_NAME;?>: (*) 
				</label>
			
				<input type="text" name="last_name" id="last_name" value="<?php echo get_param("last_name");?>">
			
			
			</li>
		
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
			
				<input type="text"" name="phone" id="phone" value="<?php echo get_param("phone");?>">
			</li>
			<li>
				<label>
				<?php echo $M_MOBILE;?>:
				</label>
				
					<input type="text" name="mobile" id="mobile" value="<?php echo get_param("mobile");?>">
			
				
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
			
			
						
			
			</ol>
			</fieldset>
			
			
			<?php
			if($website->GetParam("CHARGE_THE_JOBSEEKERS"))
			{
			
				echo "<br><b>".$M_SELECT_YOUR_PACKAGE."</b>:<br>";
			?>
			
				
				
				<?php
				$tablePackages = $database->DataTable("jobseeker_packages","ORDER BY price");
				
				echo "<fieldset>
						<ol>";
				
								
				$iPCounter=1;			
				$bFirst = true;
				$iTotalPackages = 0;
				
				$strFirstPrice = "";
				$bFirstPrice = true;
				$strFirstPaymentOptions = "";
				
				while($arrCurrentPackage = $database->fetch_array($tablePackages))
				{
				
						
						
								
						$iTotalPackages++;
						
						$strPaymentOptions = "";
						$strPayments = "";
						
						
						if($bFirstPrice)
						{
							$strFirstPaymentOptions = $strPaymentOptions;
							$strFirstPrice=$arrCurrentPackage["price"];
							$bFirstPrice = false;
						}
						
						
						$strPayments = trim($strPayments);
						
						if($arrCurrentPackage["price"] == "0.00" || $arrCurrentPackage["price"] == "")
						{
							$strPaymentOptions = "";
						}
				
					echo "<li>";
					
					echo "
						
										<input ".($bFirst?"checked":"")."  type=\"radio\" name=\"package\" value=\"".$arrCurrentPackage["id"]."\">
							
										".$arrCurrentPackage["name"]."
							
					";	
					
					$bFirst = false;	
					
					
					
					if($arrCurrentPackage["price"] == "0.00" || $arrCurrentPackage["price"] == "")			
					{
						echo "<br/>".strtoupper($M_PRICE).":
							<b>".$M_FREE."!</b>";
					
					}
					else
					{
						echo "<br/>".strtoupper($M_PRICE_FOR." ".$arrCurrentPackage["billed"]." ".$MM_MONTHS).":
										<b>".$website->GetParam("CURRENCY").$arrCurrentPackage["price"]."</b>";
						echo "
							<br><i>
							(".$M_PAID_PER." <b>".$arrCurrentPackage["billed"]."</b> ".$MM_MONTHS.", 
							".$M_AVERAGE_PRICE_MONTH.": ".$website->GetParam("CURRENCY").number_format(round($arrCurrentPackage["price"]/$arrCurrentPackage["billed"],2),2,'.','')."</i>)";				
						
						
						
						if(strlen($strPayments)>1)
						{
							$strPayments = substr($strPayments, 0, (strlen($strPayments)-1) );
						}
						
					
						
						
					}
										
					echo "			<br/><br/>
										<i>".$arrCurrentPackage["description"]."</i>
										
					</li>
					";
					$iPCounter++;
				}
				
				echo "</ol></fieldset>";
				
				echo "
				<script>
				var iTotalPackages=".$iTotalPackages.";
				</script>
				";
				
				?>
				
				
				<div id="PaymentOptions" <?php if($strFirstPrice==""||$strFirstPrice=="0.00") echo "style=\"display:none\"";?>>
				<b><?php echo $M_PLEASE_SELECT_YOUR_PAYMENT;?>:</b>
				<br><br>
				
				<table id="table1" <?php if(!$ACCEPT_PAYPAL) echo "style=\"display:none\"";?>>
					<tr><td  width="200" valign=middle><input type=radio checked name=payment_option value=paypal> <b><?php echo $M_PAYPAL;?></b> </td><td width=178 valign=middle ><img src='ADMIN/images/paypal.gif'></td></tr>
				</table>
				
				<table id="table2" <?php if(!$ACCEPT_CHECK) echo "style=\"display:none\"";?>>
						<tr><td  width="200" valign=middle><input type=radio name=payment_option value=cheque> <b><?php echo $M_CHEQUE;?></b> </td><td valign=middle><img src='ADMIN/images/cheque.gif'></td></tr>
				</table>
				
				<table id="table3" <?php if(!$ACCEPT_BANK_WIRE_TRANSFER) echo "style=\"display:none\"";?>>
						<tr><td  width="200" valign=middle><input type=radio name=payment_option value=bank_wire> <b><?php echo $M_BANK_WIRE;?></b> </td><td valign=middle><img src='ADMIN/images/banque.gif'></td></tr>
				</table>
				
				
				</div>



									
			<?php
			}
			?>	
						
			<!--end jobseeker packages-->
			
			<fieldset>
			
			<ol>
				
			<?php
			if($website->GetParam("USE_CAPTCHA_IMAGES"))
			{
			?>
				<li>
					<label>&nbsp;</label>
					<img src="include/sec_image.php" width="150" height="30" >
					<div class="clearfix"></div>
				
					<label><?php echo $M_CODE;?>:</label>
					<input type="text" required name="code" value="" size=8>
				
				</li>
				
			<?php
			}
			?>
				<li>
					
						<input type="checkbox" name="newsletter" value="1">
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
		
function ValidateForm(x){
		
		
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
			
			
			if(x.first_name.value==""){
				alert("<?php echo $PLEASE_ENTER_FIRST_NAME;?>");
				x.first_name.focus();
				return false;
			}	
			
			if(x.last_name.value=="")
			{
				alert("<?php echo $PLEASE_ENTER_LAST_NAME;?>");
				x.last_name.focus();
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
$website->Title($M_ARE_YOU_JOBSEEKER);
$website->MetaDescription("");
$website->MetaKeywords("");
?>