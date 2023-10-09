<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<h3 class="no-margin">ESPACE RECRUTEUR: Connectez vous</h3>
<div class="clearfix"></div>
<br/>
<div class="page-wrap">

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
	
	<br>
</div>


<?php
if(isset($_REQUEST["search"])||isset($_REQUEST["browse_recruiters"]))
{

}
else
{

	if(!isset($_POST["ProceedSend"]))
	{
	?>

		<p>Vous n'avez pas encore de compte recruteur? Inscrivez-vous.</p>
	
	<?php //echo $M_SIGNUP_POST;?>

	<a  href="<?php echo $website->mod_link("employers_registration");?>" class="btn btn-green upper-case white-font custom-back-color">
		<?php echo $M_CREATE_FREE_ACCOUNT;?>
	</a>
	
	<?php
	}
}
?>
<div class="clearfix"></div>
<br/><br/>	
	
	<?php 
/*	if(isset($_REQUEST["search"]))
	{
		echo '<h3 class="no-margin">'.$SEARCH_RESULTS.'</h3>';
	}
	else
	{
	?>
		<i><a href="javascript:ShowHide('rec_search_form')" class="pull-right underline-link r-margin-15"><?php echo $M_SEARCH;?></a></i>
	
	<?php
		echo '<h3 class="no-margin">'.$M_BROWSE_RECRUITERS.'</h3>';
	
	}
	?>
	<hr/>
	
	<div id="rec_search_form" style="display:none">
	
		<form name="home_form" id="home_form" action="index.php"  style="margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px" method="post"> 
			<input type="hidden" name="mod" value="recruiters">
			<input type="hidden" name="search" value="1">
			
				<div class="col-md-3 padding-top-10">
					<?php echo $COMPANY_NAME;?>
					
				</div>
				<div class="col-md-7 no-padding">
				
					<input type="text" name="search_company" class="form-control" placeholder="">
				</div>
				
				<div class="col-md-2">
					<button type="submit" class="btn btn-md btn-default btn-green pull-right no-margin width-100"><?php echo $M_SEARCH;?></button>
				</div>
				<div class="clearfix"></div>
		</form>	
		<br/><br/><br/>
	</div>

<?php
$search_query="";

if(isset($_REQUEST["search_company"]))
{
	$search_company = $website->sanitize($_REQUEST["search_company"]);
	$search_query.=" AND company LIKE '%".$database->escape_string($search_company)."%'";
}

$table_recruiters = $database->DataTable("employers","WHERE active=1 ".$search_query);

$iTotResults = 0;
$RESULTS_PER_PAGE=5;

$iNResults = $database->num_rows($table_recruiters);

$strSearchString = "";
				
foreach($_GET as $key=>$value) 
{ 
	if($key != "num"&&$key!="i_start"&&$key!="order_by")
	{
		if(trim($value)!="")
		{
			$strSearchString .= $key."=".$value."&";
		}
	}
}

foreach($_POST as $key=>$value) 
{ 
	if($key != "num"&&$key!="i_start"&&$key!="order_by")
	{
		if(trim($value)!="")
		{
			$strSearchString .= $key."=".$value."&";
		}
	}
}

if(isset($_REQUEST["search_recruiters"])||isset($_REQUEST["browse_recruiters"]))
{
	if($database->num_rows($table_recruiters)==0)
	{
		echo $M_NO_RECRUITERS_FOUND;
	}
}


if(!isset($_REQUEST["num"]))
{
	$num = 0;
}
else
{
	$website->ms_i($_REQUEST["num"]);
	$num = $_REQUEST["num"] - 1;
}

if($database->num_rows($table_recruiters)==0)
{
	echo "<br/><br/><i>".$M_NO_RESULTS."</i>";
}

while($current_recruiter = $database->fetch_array($table_recruiters))
{
	if($iTotResults>=$num*$RESULTS_PER_PAGE&&$iTotResults<($num+1)*$RESULTS_PER_PAGE)
	{
		$strCompanyLink=$website->company_link($current_recruiter["id"],$current_recruiter["company"]);
		$strRecruiterJobsLink=$website->company_jobs_link($current_recruiter["id"],$current_recruiter["company"]);
		?>
		<div class="search-result">
			<h4>
				<a href="<?php echo $strCompanyLink;?>"><?php echo strip_tags(stripslashes($current_recruiter["company"]));?></a>
				
				<div class="n-jobs-back">
					<a class="white-link" href="<?php echo $strRecruiterJobsLink;?>">
					<?php echo $database->SQLCount("jobs","WHERE ".($website->GetParam("ADS_EXPIRE")!=-1?" expires>".time()." AND ":"")." employer='".$current_recruiter["username"]."'")." ".$M_JOBS;?>
					</a>
				</div>
			</h4>
			<div class="panel panel-default">
		
				<div class="panel-body padding-10">
						<div class="row no-padding">
							<div class="col-md-3 col-xs-12">
								<a  href="<?php echo $strCompanyLink;?>">
								<?php
								if(trim($current_recruiter["logo"])!=""&&file_exists("thumbnails/".$current_recruiter["logo"].".jpg"))
								{
								?>
									<img src="thumbnails/<?php echo $current_recruiter["logo"];?>.jpg" class="img-right-margin img-responsive" align="left" />
								<?php
								
								}
								?>
								</a>
							</div>
							<div class="col-md-4 col-xs-12">
							
								<?php
								if(trim($current_recruiter["address"])!="")
								{
								?>
									<?php echo $M_ADDRESS;?>:
									<br/>
									<?php echo strip_tags(stripslashes($current_recruiter["address"]));?>	
									<br/>
								<?php
								}
								?>
								
								<?php
								if(trim($current_recruiter["phone"])!="")
								{
								?>
									<img src="images/phone_icon.png" alt="phone icon"/>
									<?php echo strip_tags(stripslashes($current_recruiter["phone"]));?>	
									<br/>
								<?php
								}
								?>
								
								<?php
								if(trim($current_recruiter["website"])!="")
								{
									$website_url=strip_tags(stripslashes($current_recruiter["website"]));
									$website_url=str_ireplace("http://","",$website_url);
									
								?>
									<a href="http://<?php echo $website_url;?>" rel="nofollow" target="_blank"><?php echo $website_url;?></a>
									<br/>
								<?php
								}
								?>
								
							</div>
							<div class="col-md-5 col-xs-12 min-height-150">
								<?php echo $M_LATEST_JOBS;?>
								<ul class="padding-left-15 top-bottom-margin">
								<?php
									$latest_listings=$database->DataTable("jobs","WHERE ".($website->GetParam("ADS_EXPIRE")!=-1?" expires>".time()." AND ":"")." employer='".$current_recruiter["username"]."' ORDER BY id DESC LIMIT 0,3");
									$i_latest_counter=0;
									while($latest_listing = $database->fetch_array($latest_listings))
									{
										if($i_latest_counter>=5)
										{
											break;
										}
										$headline = stripslashes($latest_listing["title"]);
			
										$strLink = $website->job_link($latest_listing["id"],$latest_listing["title"]);
										
									?>
									<li>
										<a title="<?php echo stripslashes($headline);?>" href="<?php echo $strLink;?>"><?php echo $headline;?></a>
									</li>
									<?php
										$i_latest_counter++;
									}
									
									
										?>
									</ul>
									
										<a class="small-font underline-link" href="<?php echo $strRecruiterJobsLink;?>"><?php echo $M_SEE_ALL;?></a>
										<?php
									
									
								?>
							
								
							</div>
						</div>
						
					</div>
				</div>
				</div>
				<hr/>
		<?php
	}
	$iTotResults++;
}
?>

<div class="clear"></div>	
	<?php


	if(ceil($iTotResults/$RESULTS_PER_PAGE) > 1)
	{
		?>
	
		<ul class="pagination">
		<?php
		
		$inCounter = 0;
		
		if(($num+1) != 1)
		{
			echo "<li><a class=\"pagination-link\" href=\"index.php?".$strSearchString."num=1\"><<</a></li>";
			
			echo "<li><a class=\"pagination-link\" href=\"index.php?".$strSearchString."num=".($num)."\"><</a></li>";
		}
		
		$iStartNumber = ($num+1);
		
		if($iStartNumber > (ceil($iTotResults/$RESULTS_PER_PAGE) - 4))
		{
			$iStartNumber = (ceil($iTotResults/$RESULTS_PER_PAGE) - 4);
		}
		
		if($iStartNumber>3&&($num+1)<(ceil($iTotResults/$RESULTS_PER_PAGE) - 2))
		{
			$iStartNumber=$iStartNumber-2;
		}
		
		if($iStartNumber < 1)
		{
			$iStartNumber = 1;
		}
		
		for($i= $iStartNumber ;$i<=ceil($iTotResults/$RESULTS_PER_PAGE);$i++)
		{
			if($inCounter>=5)
			{
				break;
			}
			
			if($i == ($num+1))
			{
				echo "<li><a><b>".$i."</b></a></li>";
			}
			else
			{
				echo "<li><a class=\"pagination-link\" href=\"index.php?".$strSearchString."num=".$i."\">".$i."</a></li>";
			}
							
			
			$inCounter++;
		}
		
		if(($num+1)<ceil($iTotResults/$RESULTS_PER_PAGE))
		{
			echo "<li><a class=\"pagination-link\" href=\"".($website->GetParam("SEO_URLS")==1?"http://".$DOMAIN_NAME."/":"")."index.php?".$strSearchString."num=".($num+2)."\">></a></li>";
			
			echo "<li><a class=\"pagination-link\" href=\"".($website->GetParam("SEO_URLS")==1?"http://".$DOMAIN_NAME."/":"")."index.php?".$strSearchString."num=".(ceil($iTotResults/$RESULTS_PER_PAGE))."\">>></a></li>";
		}
		?>	
			</ul>
		<?php	
		
	}

*/
?>
</div>
<?php
$website->Title($SEARCH_RESULTS);
$website->MetaDescription("");
$website->MetaKeywords("");
?>