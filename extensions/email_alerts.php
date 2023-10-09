<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if (!defined('IN_SCRIPT')) die("");
$bShowForm = true;
$website->Title($M_EMAIL_ALERT_ACTIVATION);
$website->MetaDescription("");
$website->MetaKeywords("");
	
if(isset($_POST["ProceedSend"])&&$_POST["ProceedSend"] != "")
{
	

	$bShowForm = false;

	if($website->GetParam("USE_CAPTCHA_IMAGES") && ( (md5($_POST['code']) != $_SESSION['code'])|| trim($_POST['code']) == "" ) )
	{
	
										
			echo "<br><br><span class=\"warning_text\">".$M_WRONG_CODE."</span><br><br>";
											
			$bShowForm = true;
	}
	else
	{
	
		$arrChars = array("A","F","B","C","O","Q","W","E","R","T","Z","X","C","V","N");
							
		$code = $arrChars[rand(0,(sizeof($arrChars)-1))]."".rand(1000,9999)
		.$arrChars[rand(0,(sizeof($arrChars)-1))].rand(1000,9999);
		
	
		$database->SQLInsert
			(	
				"rules",
				array
				(
					"rule",
					"region",
					"job_category",
				
					"first_name",
					"last_name",
					"email",
					"code",
					"active",
					"ip"
				
				),
				array
				(
					$_POST["keyword"],
					$_POST["location"],
					$_POST["category"],					
				
					$_POST["first_name"],
					$_POST["last_name"],
					$_POST["email"],
					$code,
					0,
					$_SERVER['REMOTE_ADDR']
				)
			);
			
			$SYSTEM_EMAIL_FROM=$website->GetParam("SYSTEM_EMAIL_FROM");
			$SYSTEM_EMAIL_ADDRESS=$website->GetParam("SYSTEM_EMAIL_ADDRESS");
		
			
			$headers  = "From: \"".$SYSTEM_EMAIL_FROM."\"<".$SYSTEM_EMAIL_ADDRESS.">\n";

			$message=str_replace("[ACTIVATE_LINK]",
			"http://".$DOMAIN_NAME."/alert.php?id=".$code,
			$M_EMAIL_ACTIVATION);
			
			$message=str_replace("[DEACTIVATE_LINK]",
			"http://".$DOMAIN_NAME."/alert.php?id=".$code."&cancel=1",
			$message);
			
			$message=str_replace("[USER]",$_POST["first_name"],$message);
			$message=str_replace("[DOMAIN_NAME]",$DOMAIN_NAME,$message);
							
			mail($_REQUEST["email"], $M_EMAIL_ALERT_ACTIVATION, $message, $headers);
			
			echo "<br/><b>".$MESSAGE_SENT_ACTIVATION." ".$_REQUEST["email"]."
			<br/><br/>
			".$CLICK_ACTIVATE."
			</b><br/><br/><br/><br/>";
		}

}


if($bShowForm)
{
?>
<h3>
<?php echo $M_CREATE_NEW_EMAIL_ALERT;?>
</h3>
<br/>
<script>
	function SubmitForm2(x)
	{
	
		
		
		if(x.first_name.value=="")
		{
			alert("<?php echo $PLEASE_ENTER_FIRST_NAME;?>");
			x.first_name.focus();
			return false;
		}	
		
		if(x.email.value=="")
		{
			alert("<?php echo $M_PLEASE_ENTER_EMAIL;?>");
			x.email.focus();
			return false;
		}

		if(x.code.value=="")
		{
			alert("<?php echo $M_PLEASE_ENTER_CODE;?>");
			x.code.focus();
			return false;
		}		
		
		if(!CheckValidEmail(x.email.value) )
		{
			alert(x.email.value+" <?php echo $IS_NOT_VALID;?>");
			x.email.focus();
			return false;
		}
									
		return true;
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

	<form action="<?php if($website->GetParam("SEO_URLS")==1) echo "http://".$DOMAIN_NAME."/";?>index.php" style="margin-bottom:0px;margin-top:10px" method=post name="main" id="main" onsubmit="return SubmitForm2(this)">	
	<input type="hidden" name="ProceedSend" id="ProceedSend" value="1">
	<input type="hidden" name="mod" value="email_alerts">
	<input type="hidden" name="lang" value="<?php echo strtolower($website->lang);?>">
	
	
	<fieldset>
		<legend>
			<?php echo $M_PLEASE_FILL_NOTIFIED;?>	
		</legend>
		<ol>
			<li>
				<label for="keyword">
					<?php echo $M_KEYWORD;?>:
				</label>
			
				<input type="text" value="<?php if(isset($_REQUEST["keyword"])) echo $_REQUEST["keyword"];?>" name="keyword"/>
			</li>
		
			<li>
				<input type="hidden" name="field_category" id="field_category" value=""/>
				<script>var cancel_category="<?php echo $M_CATEGORY;?>";</script>
				
				<label id="label_category" for="category">
				<?php echo $M_CATEGORY;?>:
				</label>
			
				<select required name="category" id="category" onchange="dropDownChange(this,'category')" class="form-control">
					<option value="-1"><?php echo $M_ALL;?></option>
					<?php
					
					if(!isset($l))
					{
						include("categories/categories_array_".$website->lang.".php");
					}
						foreach($l as $key=>$value)
						{
							
							echo "<option value=\"".$key."@".$value."\">".$value."</option>";
						}
					?>
				</select>
			</li>
			
			<li>
				<input type="hidden" name="field_location" id="field_location" value=""/>
				<script>var cancel_location="<?php echo $LOCATION;?>";</script>
				
				<label for="category">
				<span id="label_location"><?php echo $LOCATION;?></span>:
				</label>
			
				<select name="location" id="location" class="drop_down_menu"  onchange="dropDownChange(this,'location')">
					<option value=""><?php echo $M_ALL;?></option>
					<?php
					
					if(!isset($loc))
					{
						include("locations/locations_array.php");
					}
					
					if(isset($loc))
					{
						foreach($loc as $key=>$value)
						{
							if(!is_string($value)) continue;
							echo "\n<option value=\"".$key."@".$value."\">".$value."</option>";
						}
					}
					
					?>
				</select>
			</li>
	
		
  	<li>
		<label for="first_name"><?php echo $FIRST_NAME;?>: </label>
  		<input type="text" value="<?php if(isset($_REQUEST["first_name"])) echo $_REQUEST["first_name"];?>" name="first_name" required/>
  	</li>
  	<li>
		<label for="last_name"><?php echo $LAST_NAME;?>: </label>
  		<input type="text" value="<?php if(isset($_REQUEST["last_name"])) echo $_REQUEST["last_name"];?>" name="last_name" required/>
  	</li>
  	<li>
  		<label for="email"><?php echo $M_EMAIL;?>: </label>
  		<input type="text" value="<?php if(isset($_REQUEST["email"])) echo $_REQUEST["email"];?>" name="email" required/>
  	</li>


	<?php
	if($website->GetParam("USE_CAPTCHA_IMAGES"))
	{
	?>
		<li>
			<label>&nbsp;</label>
			<img src="include/sec_image.php" width="150" height="30"/>
			<div class="clearfix"></div>
		
			<label><?php echo $M_CODE;?>:</label>
			<input type="text" name="code" required value="" size="8"/>
		
		</li>
		
	<?php
	}
	?>		

	</ol>
	</fieldset>
	<fieldset>
		<button type="submit" class="btn btn-green pull-right"><?php echo $M_SUBMIT;?></button>
	</fieldset>
	 
	</form>
	<br>
<?php
}

?>
<br/><br/>