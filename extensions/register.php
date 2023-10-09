<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="page-wrap">

	<div class="page-header">
		<h3 class="no-margin"><?php echo $M_ARE_YOU_JOBSEEKER;?></h3>
	</div>
		
		<?php echo $M_REGISTER_APPLY;?>
		<br/><br/>
		<a  href="<?php echo $website->mod_link("jobseekers");?>" class="min-width-200 btn btn-green no-decoration">
			<?php echo $M_SIGNUP;?>
		</a>
		
		
	
	<br/>
	<br/>
	
	<div class="page-header">
		<h3 class="no-margin"><?php echo $M_ARE_YOU_RECRUITER;?></h3>
	</div>
	
	
	
		<?php echo $M_SIGNUP_POST;?>
		<br/><br/>
	
		<a  href="<?php echo $website->mod_link("employers_registration");?>" class="min-width-200 btn btn-green no-decoration">
			<?php echo $M_CREATE_FREE_ACCOUNT;?>
		</a>
	
	<br/>
	<br/>
	
	
	
	
</div>
<br/>
<br/>
<?php
$website->Title($M_REGISTER);
$website->MetaDescription("");
$website->MetaKeywords("");
?>