<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="page-wrap">

	<div class="page-header">
		
			<h3 class="no-margin"><?php echo $M_SEARCH_COMPANY;?></h3>
			<br/><br/>
			<form name="home_form" id="home_form" action="index.php"  style="margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px" method="post"> 
			<input type="hidden" name="mod" value="recruiters">
			<input type="hidden" name="search" value="1">
			
				<div class="col-md-3 form-group group-1 padding-top-10">
					<label for="searchjob" class="label"><?php echo $COMPANY_NAME;?></label>
					
				</div>
				<div class="col-md-7 form-group">
					
					<input type="text" name="search_company" class="no-margin input-job" placeholder="">
				</div>
				
				<div class="col-md-2 form-group">
					<button type="submit" class="btn btn-lg btn-default btn-green pull-right no-margin"><?php echo $M_SEARCH;?></button>
				</div>
				<div class="clearfix"></div>
			</form>	
		
	</div>

	<div class="clearfix"></div>
	
		<h3><?php echo $M_LATEST_REVIEWS;?></h3>
		<hr/>
	
<?php

$tableComments = $database->DataTable("company_reviews","ORDER BY id DESC LIMIT 0,10");

if($database->num_rows($tableComments) == 0)											
{
	echo "<br/><i>".$M_STILL_NO_REVIEWS."</i><br/><br/><br/><br/><br/><br/><br/>";
}

while($arrComment = $database->fetch_array($tableComments))
{
	echo show_stars($arrComment["vote"]);
	echo '<b style="position:relative;left:10px;top:-5px">'.strip_tags(stripslashes($arrComment["title"])).'</b>';
	echo "<br/>".$M_BY." <b>".$arrComment["author"]."</b>";
	echo ', '.date($website->GetParam("DATE_FORMAT"), $arrComment["date"]);
	echo '<hr style="margin:5px"/>';
	echo '
	
	'.strip_tags(stripslashes($arrComment["html"])).'
	';	
	
	
			
		
	echo '<br><br><br>';
}



?>
</div>
<?php

//end user opinions and reviews
$website->Title($M_REVIEWS);
$website->MetaDescription("");
$website->MetaKeywords("");
?>