<?php
if(!defined('IN_SCRIPT')) die("");
if(!isset($_REQUEST["id"]))
{
	die("The job ID isn't set");
}
$job=$_REQUEST["id"];
$website->ms_i($job);


$arrPosting = $database->DataArray("jobs","id=".$job);
$arrEmployer = $database->DataArray("employers","username='".$arrPosting["employer"]."' ");


$jobseeker_username="";
if(isset($_COOKIE["AuthJ"]))
{
	$cookie_items=explode("~",$_COOKIE["AuthJ"]);
	$jobseeker_username=$cookie_items[0];
}

$database->SQLInsert("jobs_stat", array("date","posting_id","ip","user"), array(time(), $job, $_SERVER["REMOTE_ADDR"],$jobseeker_username));


$strLink = "http://".$DOMAIN_NAME."/".$website->job_link($arrPosting["id"],$arrPosting["title"]);
	
?>
<div class="page-wrap">

	<a id="go_back_button" class="btn btn-default btn-xs pull-right no-decoration margin-bottom-5" href="javascript:GoBack()"><?php echo $M_GO_BACK;?></a>
	<div class="clearfix"></div>
	<div class="job-details-wrap">
	<?php
		
		if(get_param("ProceedSendFriend") != "" && get_param("email_address") != "")
		{
			if($website->GetParam("USE_CAPTCHA_IMAGES") && ( (md5($_POST['code']) != $_SESSION['code'])|| trim($_POST['code']) == "" ) )
			{
				echo "
				<br/>
					<h3>
						".$M_WRONG_CODE."
						<br/><br/>
					</h3>";
			}
			else
			{
				$headers  = "From: \"".$website->GetParam("SYSTEM_EMAIL_FROM")."\"<".$website->GetParam("SYSTEM_EMAIL_ADDRESS").">\n";
						
				$message= get_param("sender_name") ." ".$RECOMMENDS_FOLLOWING.":\n".
				$strLink;
				
				mail(get_param("email_address"), $JO_RECOMENDED_BY." ".get_param("sender_name"), $message, $headers);
				
				echo "
				<br/>
				<h3>
				".$JO_SENT_SUCCESS.": ".get_param("email_address")."
				</h3>
				<br/>";	
			}
		
		}
			
			
	?>
	
	<a rel="nofollow" href="https://www.linkedin.com/shareArticle?mini=true&title=<?php echo urlencode(strip_tags(stripslashes(strip_tags($arrPosting["title"]))));?>&url=<?php echo $strLink;?>" target="_blank"><img src="images/linkedin.gif" width="18" height="18" class="pull-right" alt=""/></a>
	<a rel="nofollow" href="http://plus.google.com/share?url=<?php echo $strLink;?>" target="_blank"><img src="images/googleplus.gif" width="18" height="18" class="pull-right r-margin-7" alt=""/></a>
	<a rel="nofollow" href="http://www.twitter.com/intent/tweet?text=<?php echo urlencode(strip_tags(stripslashes(strip_tags($arrPosting["title"]))));?>&url=<?php echo $strLink;?>" target="_blank"><img src="images/twitter.gif" width="18" height="18" class="pull-right  r-margin-7" alt=""/></a>
	<a rel="nofollow" href="http://www.facebook.com/sharer.php?u=<?php echo $strLink;?>" target="_blank"><img src="images/facebook.gif" width="18" height="18" alt="" class="pull-right r-margin-7"/></a>
	 
	 
	<h2 class="no-margin"><?php echo stripslashes(strip_tags($arrPosting["title"]));?></h2>

	<div class="job-details-info">
		<div class="row">
			<div class="col-md-6">
				<?php 
				if(trim($arrPosting["region"])!="")
				{
					$str_job_location=$website->show_full_location(strip_tags($arrPosting["region"]));
					
					if($str_job_location!="")
					{
						echo "<strong>".$str_job_location."</strong>";
						echo "<br/>";
					}
				}
				
				echo "<strong>".date($website->GetParam("DATE_HOUR_FORMAT"),$arrPosting["date"])."</strong>";
				echo "<br/>";
				echo "<strong>".$arrPosting["applications"]."</strong> ".$M_APPLICATIONS;
				?>
				
			</div>
			<div class="col-md-6">
				
				<div class="row">
					<div class="col-md-4">
						<?php echo $M_JOB_TYPE;?>:
					</div>
					<div class="col-md-8">
						<strong><?php echo $website->job_type($arrPosting["job_type"]);?></strong>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-4">
						<?php echo $M_SALARY;?>:
					</div>
					<div class="col-md-8">
						<strong><?php echo ((trim($arrPosting["salary"])!=""&&$arrPosting["salary"]!="0" )?$arrPosting["salary"]:"[n/a]");?></strong>
					</div>
					<?php
					if(trim($arrPosting["date_available"])!="")
					{
					?>
						<div class="col-md-4">
							<?php echo $M_DATE_AVAILABLE;?>:
						</div>
						<div class="col-md-8">
							<strong><?php echo strip_tags(stripslashes(trim($arrPosting["date_available"])!=""?$arrPosting["date_available"]:"[n/a]"));?></strong>
						</div>
					<?php
					}
					?>
				</div>
				
			
			
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8">
		<?php
			
			$arrPosting["message"]=str_replace("&lt;!--","<!--",$arrPosting["message"]);
			$arrPosting["message"]=str_replace("--&gt;","-->",$arrPosting["message"]);
			echo "<br/>";	
			echo stripslashes(strip_tags($arrPosting["message"],'<a><br><b><li><ul><span><div><p><font><strong><i><u><table><tr><td>')); 


			if(trim($arrPosting["more_fields"]) != "")
			{
				$arrJobFields = array();

				if(is_array(unserialize($arrPosting["more_fields"])))
				{
					$arrJobFields = unserialize($arrPosting["more_fields"]);
				}

				$bFirst = true;
				while (list($key, $val) = each($arrJobFields)) 
				{
					echo "<br/>";
					echo "<b>";
					echo $key;
					echo ":</b>"; 
					echo "<br/> ";
					echo strip_tags($val);
				}
			}
			
				?>
		</div>
		<div class="col-md-4 text-center">
			<a href="<?php echo $website->company_link($arrEmployer["id"],$arrEmployer["company"]);?>">
			<?php	
			if($arrEmployer["logo"]!=""&&file_exists('thumbnails/'.$arrEmployer["logo"].'.jpg'))
			{
				echo '<img class="logo-border img-responsive" src="thumbnails/'.$arrEmployer["logo"].'.jpg" alt="'.$arrEmployer["company"].'"/>';
			}
			else
			{
				echo '<div class="company-wrap">'.$arrEmployer["company"].'</div>';
			}
			?>
			</a>
			<div class="clearfix underline-link"></div>
			<a href="<?php echo $website->company_jobs_link($arrEmployer["id"],$arrEmployer["company"]);?>" class="sub-text underline-link"><?php echo $M_MORE_JOBS_FROM;?> <?php echo stripslashes($arrEmployer["company"]);?></a>
			<br/>
			<a href="<?php echo $website->company_link($arrEmployer["id"],$arrEmployer["company"]);?>" class="sub-text underline-link"><?php echo $M_COMPANY_DETAILS;?></a>
		</div>
	</div>
	
		<div class="clearfix"></div>
	
	 
		<br/><br/><br/>
		
		<div class="pull-right">
			<form action="index.php" method="post" >
				<input type="hidden" name="mod" value="apply"/>
				<input type="hidden" name="posting_id" value="<?php echo $arrPosting["id"];?>"/>
				<?php
				if($MULTI_LANGUAGE_SITE)
				{
				?>
				<input type="hidden" name="lang" value="<?php echo $website->lang;?>"/>
				<?php
				}
				?>
				<input type="submit" class="btn btn-default custom-gradient btn-green" value=" <?php echo $APPLY_THIS_JOB_OFFER;?> ">
			</form>
		</div>
		
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
			

			function ValidateSendForm(x)
			{
			
				if(x.sender_name.value==""){
					alert("<?php echo $PLEASE_ENTER_YOUR_NAME;?>");
					x.sender_name.focus();
					return false;
				}	
				
				if(x.email_address.value==""){
					alert("<?php echo $PLEASE_ENTER_YOUR_FRIENDS_EMAIL;?>");
					x.email_address.focus();
					return false;
				}	
				
				if(!CheckValidEmail(x.email_address.value) )
				{
					alert(x.email_address.value+" <?php echo $IS_NOT_VALID;?>");
					x.email_address.focus();
					return false;
				}
				
				
				return true;
			}
	</script>	

	
	
	<img src="images/email-small-icon.png"/>
	<a  href="#" class="small-link gray-link" data-toggle="collapse" data-target=".email-collapse"><?php echo $M_EMAIL_JOB;?></a>
	
	
	<img class="l-margin-20" src="images/save-small-icon.png" height="12"/>
	<?php
	if(isset($_REQUEST["is_saved_page"]))
	{
		
		echo '<a class="small-link gray-link" href="javascript:DeleteSavedListing('.$arrPosting["id"].')" id="save_'.$arrPosting["id"].'">'.$M_DELETE.'</a>';
	}
	else
	if(isset($_COOKIE["saved_listings"]) && strpos($_COOKIE["saved_listings"], $arrPosting["id"].",") !== false)
	{

		echo '<span class="small-link">'.$M_SAVED.'</span>';

	}
	else
	{
	
		echo '<a class="small-link gray-link" href="javascript:SaveListing('.$arrPosting["id"].')" id="save_'.$arrPosting["id"].'">'.$M_SAVE_JOB.'</a>';

	}
	?>
	
	
	<div class="clearfix"></div>
	<div class="collapse email-collapse text-left">
		<div class="container">		
		<!--email job form-->
			<form action="index.php"  style="margin-top:0px;margin-bottom:0px" method="post" onsubmit="return ValidateSendForm(this)">
				<input type="hidden" name="mod" value="details"/>
				<input type="hidden" name="ProceedSendFriend" value="1"/>
				<input type="hidden" name="id" value="<?php echo $arrPosting["id"];?>"/>
				<?php
				if($MULTI_LANGUAGE_SITE)
				{
				?>
				<input type="hidden" name="lang" value="<?php echo $website->lang;?>"/>
				<?php
				}
				?>
								
							
				<b><?php echo $SEND_OFFER_FRIEND;?></b>
				<br/><br/>
				<?php echo $EMAIL_SEND_FRIEND;?>:
				<br/>
				<input type="text" name="email_address" class="text" class="200px-field">
				<br/><br/>
				<?php echo $M_YOUR_NAME;?>:
				<br/>
				<input type="text" name="sender_name" class="text" class="200px-field">
				
				<br/><br/><br/>
				<?php
				if($website->GetParam("USE_CAPTCHA_IMAGES"))
				{
				?>
								
							
					<img src="include/sec_image.php" width="150" height="30" />
				
				
					<?php echo $M_CODE;?>:
				
					<input type="text" name="code" value="" size="8"/>
					
								
					<br/><br/>
					
				<?php
				}
				?>		
						
				<input type="submit" class="btn custom-gradient btn-primary" value=" <?php echo $M_SEND;?> ">
			</form>
			<!--email job form-->
			<br/>
	
		</div>	
	</div>
	
	<div class="clearfix"></div>
	</div>
</div>

<?php
$website->Title(strip_tags(stripslashes($arrPosting["title"])));
$website->MetaDescription(text_words(strip_tags(stripslashes($arrPosting["message"])),30));
$website->MetaKeywords(text_words(strip_tags(stripslashes($arrPosting["message"])),20));


if($website->multi_language)
{
	
	foreach($website->languages as $language)
	{
		if($language==$website->lang) continue;
		
		if(file_exists("include/texts_".$language.".php"))
		{
			include("include/texts_".$language.".php");
		}
		
		$str_job_lang_link=$website->job_link($arrPosting["id"],$arrPosting["title"],$language,$M_SEO_JOB);
		
		$website->TemplateHTML = 
		str_replace
		(
			'"index.php?lang='.$language.'"',
			$str_job_lang_link,
			$website->TemplateHTML
		);
	}
	include("include/texts_".$website->lang.".php");
}
?>