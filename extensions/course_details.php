<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
if(!isset($_REQUEST["id"]))
{
	die("The job ID isn't set");
}
$job=$_REQUEST["id"];
$website->ms_i($job);


$arrPosting = $database->DataArray("courses","id=".$job);
$arrEmployer = $company = $database->DataArray("employers","username='".$arrPosting["employer"]."' ");
$strLink = $website->course_link($arrPosting["id"],$arrPosting["title"]);
	
?>
<div class="page-wrap">

	<a id="go_back_button" class="btn btn-default btn-xs pull-right no-decoration margin-bottom-5" href="javascript:GoBack()"><?php echo $M_GO_BACK;?></a>
	<div class="clearfix"></div>
	<div class="job-details-wrap">
	<?php
		
		if(get_param("ProceedSendFriend") != "" && get_param("email_address") != "")
		{
			if($website->GetParam("USE_CAPTCHA_IMAGES") && ( (strtoupper($_POST['code']) != $_SESSION['code'])|| trim($_POST['code']) == "" ) )
			{
				echo "
				<br/>
					<span class=\"red_font\">
						".$M_WRONG_CODE."
						<br/><br/>
					</span>";
			}
			else
			{
				$headers  = "From: \"".$website->GetParam("SYSTEM_EMAIL_FROM")."\"<".$website->GetParam("SYSTEM_EMAIL_ADDRESS").">\n";
						
				$message= get_param("sender_name") ." ".$RECOMMENDS_FOLLOWING.":\n".
				$strLink;
				
				mail(get_param("email_address"), $JO_RECOMENDED_BY." ".get_param("sender_name"), $message, $headers);
				
				echo "
				<br/>
				<b>
				".$JO_SENT_SUCCESS.": ".get_param("email_address")."
				</b>
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
				
				?>
				
			</div>
			<div class="col-md-6">
				
				<div class="row">
					
					<?php
					if(trim($arrPosting["date_available"])!="")
					{
					?>
						<div class="col-md-5">
							<?php echo $M_DATE_AVAILABLE;?>:
						</div>
						<div class="col-md-7">
							<strong><?php echo strip_tags(stripslashes(trim($arrPosting["date_available"])!=""?$arrPosting["date_available"]:"[n/a]"));?></strong>
						</div>
					<?php
					}
					?>
					
					
					<?php
					if(trim($arrPosting["mode_study"])!=""&&$arrPosting["mode_study"]!=0)
					{
					?>
						<div class="col-md-5">
							<?php echo $M_MODE_STUDY;?>:
						</div>
						<div class="col-md-7">
							<strong>
							<?php 
							$study_modes=$website->GetParam("arrStudyModes");
							if(isset($study_modes[$arrPosting["mode_study"]])) echo $study_modes[$arrPosting["mode_study"]];
							?>
							</strong>
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
			echo "<br/>";
			echo "<br/>";	
			
			if(trim($company["address"])!="")
			{
			?>
				<?php echo $M_ADDRESS;?>:
				<br/>
				<b>
				<?php
				echo strip_tags(stripslashes($company["address"]));
				?>
				</b>

			<br/><br/>
			<?php
			}
			
			if(trim($company["website"])!="")
			{
			?>
			<?php echo $M_WEBSITE;?>: <b><a class="underline-link" <?php if($company["dofollow"]!=1) echo "rel=\"nofollow\"";?> title="<?php echo $company["website"];?>" href="http://<?php echo $company["website"];?>" target="_blank"><?php echo $company["website"];?></a></b>

			<br/><br/>
			<?php
			}
			
			if(trim($company["phone"])!="")
			{
			?>
			<?php echo $M_PHONE;?>: &nbsp;  <b><?php echo strip_tags($company["phone"]);?></b>
			<br/>
			<?php
			}
			
			
			if(trim($company["employer_fields"]) != "")
			{
				$arrJobFields = array();

				if(is_array(unserialize($company["employer_fields"])))
				{
					$arrJobFields = unserialize($company["employer_fields"]);
				}

				$bFirst = true;
				while (list($key, $val) = each($arrJobFields)) 
				{
					echo "<br/><br/>";
					echo "<b>";
					str_show($key);
					echo ":</b>"; 
					echo "<br/> ";
					str_show(stripslashes(stripslashes(strip_tags($val))));
				}
			}
			?>
				
		</div>
		<div class="col-md-4 text-center">
			<br/>
			<a href="<?php echo $website->company_link($arrEmployer["id"],$arrEmployer["company"]);?>">
			<?php	
			if($arrEmployer["logo"]!=""&&file_exists('thumbnails/'.$arrEmployer["logo"].'.jpg'))
			{
				echo '<img class="img-responsive logo-border" src="thumbnails/'.$arrEmployer["logo"].'.jpg" alt="'.$arrEmployer["company"].'"/>';
			}
			else
			{
				echo '<div class="company-wrap">'.$arrEmployer["company"].'</div>';
			}
			?>
			</a>
			<div class="clearfix underline-link"></div>
		
			<a href="<?php echo $website->company_link($arrEmployer["id"],$arrEmployer["company"]);?>" class="sub-text"><?php echo $M_COMPANY_DETAILS;?></a>
		</div>
	</div>
	<div class="clearfix"></div>
	<br/><br/><br/>
	</div>
</div>
<?php
$website->Title(strip_tags(stripslashes($arrPosting["title"])));
$website->MetaDescription(text_words(strip_tags(stripslashes($arrPosting["message"])),30));
$website->MetaKeywords(text_words(strip_tags(stripslashes($arrPosting["message"])),20));
?>