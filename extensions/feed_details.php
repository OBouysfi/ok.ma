<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
if(!isset($_REQUEST["id"]))
{
	die("The job ID isn't set");
}
$ijob=$_REQUEST["id"];


$indeed_url = "http://api.indeed.com/ads/apigetjobs?publisher=".$website->GetParam("INDEED_PUBLISHER_ID")."&jobkeys=".$ijob."&v=2";

$xml = simplexml_load_file($indeed_url);
$r = $xml->results->result;	
$strLink = $website->current_url();

?>
<div class="page-wrap">

	<a id="go_back_button" class="btn btn-default btn-xs pull-right no-decoration margin-bottom-5" href="javascript:GoBack()"><?php echo $M_GO_BACK;?></a>
	<div class="clearfix"></div>
	<div class="job-details-wrap">
	<?php
					
	?>
	<a rel="nofollow" href="https://www.linkedin.com/shareArticle?mini=true&title=<?php echo urlencode(strip_tags(stripslashes(strip_tags($r->jobtitle))));?>&url=<?php echo $strLink;?>" target="_blank"><img src="images/linkedin.gif" width="18" height="18" class="pull-right" alt=""/></a>
	<a rel="nofollow" href="http://plus.google.com/share?url=<?php echo $strLink;?>" target="_blank"><img src="images/googleplus.gif" width="18" height="18" class="pull-right r-margin-7" alt=""/></a>
	<a rel="nofollow" href="http://www.twitter.com/intent/tweet?text=<?php echo urlencode(strip_tags(stripslashes(strip_tags($r->jobtitle))));?>&url=<?php echo $strLink;?>" target="_blank"><img src="images/twitter.gif" width="18" height="18" class="pull-right  r-margin-7" alt=""/></a>
	<a rel="nofollow" href="http://www.facebook.com/sharer.php?u=<?php echo $strLink;?>" target="_blank"><img src="images/facebook.gif" width="18" height="18" alt="" class="pull-right r-margin-7"/></a>

	 
	<h2 class="no-margin"><?php echo stripslashes(strip_tags($r->jobtitle));?></h2>

	<div class="job-details-info">
		<div class="row">
			<div class="col-md-6">
				<?php 
				echo $LOCATION.":<br/>";
				echo "<strong>".$r->formattedLocationFull."</strong>";
				echo "<br/>";
				
				?>
				
			</div>
			<div class="col-md-6">
				
				<div class="row">
					
					<?php
					echo $M_POSTED_ON.":<br/>";
					echo "<strong>".$r->formattedRelativeTime."</strong>";
					echo "<br/>";
					?>
					
				</div>
				
			
			
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-7">
		<?php
			
				
			echo stripslashes($r->snippet); 

			
				?>
		</div>
		<div class="col-md-5 text-center">
			<?php	

			echo '<div  class="save-job-link">'.$M_POSTED_BY.':</div>';
		
			echo '<span class="feed-company">'.$r->company.'</span>';
	
			?>
			
		</div>
	</div>
	
		<div class="clearfix"></div>
	
	 
		<br/><br/><br/>
		
		<div class="pull-right">
			<form target="_blank" action="<?php echo $r->url;?>&indpubnum=<?php echo $website->GetParam("INDEED_PUBLISHER_ID");?>&from=vj" method="post" >
	
				<input type="submit" class="btn btn-default btn-green" value=" <?php echo $M_READ_APPLY_THIS_JOB_OFFER;?> ">
			</form>
		</div>
		<div class="clearfix"></div>
		<br/>
		
	</div>
	
	<div class="clearfix"></div>
	
</div>

<?php
$website->Title(strip_tags(stripslashes($r->jobtitle)));
$website->MetaDescription(text_words(strip_tags(stripslashes($r->snippet)),30));
$website->MetaKeywords(text_words(strip_tags(stripslashes($r->snippet)),20));
?>