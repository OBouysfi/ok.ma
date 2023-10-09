<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
$process_error="";
if(isset($_POST["SubmitContact"]))
{	

	if($website->GetParam("USE_CAPTCHA_IMAGES") && ( (md5($_POST['code']) != $_SESSION['code'])|| trim($_POST['code']) == "" ) )
	
	{
		$process_error=$M_WRONG_CODE;
		echo "<h3>".$M_WRONG_CODE."</h3>";
	}
	else
	{
		if($_POST["name"]!=""&&$_POST["message"]!=""&&$_POST["email"]!="")
		{
			$_POST["name"]=strip_tags(stripslashes($_POST["name"]));
			$_POST["message"]=strip_tags(stripslashes($_POST["message"]));
			$_POST["email"]=strip_tags(stripslashes($_POST["email"]));
			$_POST["phone"]=strip_tags(stripslashes($_POST["phone"]));
			
			$headers  = "From: \"".strip_tags(stripslashes($_POST["name"]))."\"<".strip_tags(stripslashes($_POST["email"])).">\n";
				
			$email_text = $M_SENT_BY.": ".strip_tags(stripslashes($_POST["name"])).
			", ".$M_EMAIL.": ".strip_tags(stripslashes($_POST["email"]));
			if($_POST["phone"]!="")
			{
				$email_text .= ", ".$M_PHONE.": ".strip_tags(stripslashes($_POST["phone"]));
			}
			
			$email_text .= "\n\n".stripslashes($_POST["message"]);

		
			
				$database->SQLInsert
				(
					"messages",
					array
					(
						"date",
						"subject",
						"message",
						"name",
						"email",
						"phone"
					),
					array
					(
						time(),
						$_POST["subject"],
						$_POST["message"],
						$_POST["name"],
						$_POST["email"],
						$_POST["phone"]
					)
				);
				
				mail
				(
					$website->GetParam("SYSTEM_EMAIL_ADDRESS"),
					strip_tags(stripslashes($_POST["subject"])),
					$email_text, 
					$headers
				);
				?>
				<h3><?php echo $MESSAGE_SENT;?></h3>
				<?php
			
		}
	}

}
else
{
if($process_error!="")
{
	?>
	<h2><?php echo $process_error;?></h2>
	<?php
}

?>

<form id="main" action="index.php" method="post"  enctype="multipart/form-data">
	
	<?php
	if(isset($_REQUEST["mod"]))
	{
	?>
	<input type="hidden" name="mod" value="<?php echo $_REQUEST["mod"];?>"/>
	<?php
	}
	else
	{
	?>
	<input type="hidden" name="page" value="<?php echo $_REQUEST["page"];?>"/>
	<?php
	}
	?>
	
	<input type="hidden" name="SubmitContact" value="1"/>
	<fieldset>
		<legend><?php echo $M_ENTER_MESSAGE_OR_QUESTIONS;?></legend>
		<ol>
			<li>
				<label for="subject"><?php echo $M_SUBJECT;?>(*)
				<br>
				
				</label>
				<input id="subject" <?php if(isset($_REQUEST["subject"])) echo "value=\"".$_REQUEST["subject"]."\"";?> name="subject" placeholder="" type="text" required/>
			
			</li>
			<li>
				<label for="description"><?php echo $M_MESSAGE_TEXT;?>(*)
				<br>
				
				</label>
				<textarea id="message" name="message" rows="8" required><?php if(isset($_REQUEST["message"])) echo stripslashes($_REQUEST["message"]);?></textarea>
			</li>
	</ol>
	</fieldset>
	<fieldset>
		<legend><?php echo $M_YOUR_DETAILS;?></legend>
		<ol>
			
			<li>
				<label for="name"><?php echo $M_NAME;?>(*)</label>
				<input id="name" <?php if(isset($_REQUEST["name"])) echo "value=\"".$_REQUEST["name"]."\"";?> name="name" placeholder="" type="text" required/>
			</li>
			<li>
				<label for="email"><?php echo $M_YOUR_EMAIL;?>(*)</label>
				<input id="email" <?php if(isset($_REQUEST["email"])) echo "value=\"".$_REQUEST["email"]."\"";?> name="email" placeholder="example@domain.com" type="email" required/>
				
			</li>
			<li>
				<label for="phone"><?php echo $M_PHONE;?></label>
				<input id="phone" <?php if(isset($_REQUEST["phone"])) echo "value=\"".$_REQUEST["phone"]."\"";?> name="phone" placeholder="" type="text"/>
			</li>
			<?php
			if($website->GetParam("USE_CAPTCHA_IMAGES")==1)
			{
			?>
			<li>
				<label for="code">
				<img src="include/sec_image.php" width="100" height="30"/>
				</label>
				<input id="code" name="code" placeholder="<?php echo $M_PLEASE_ENTER_CODE;?>" type="text" required/>
			</li>
			<?php
			}
			?>
		</ol>
	</fieldset>
	<fieldset>
		<button type="submit" class="btn btn-green pull-right"><?php echo $M_SEND;?></button>
	</fieldset>
</form>
<?php
}
?>