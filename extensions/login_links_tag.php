<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
$link_suffix="";

if($MULTI_LANGUAGE_SITE)
{
	$link_suffix="lang=".$this->lang;
}

if(isset($_COOKIE["AuthJ"])&&$_COOKIE["AuthJ"]!="")
{
	?>
	<li><a class="btn btn-green custom-back-color" href="JOBSEEKERS/index.php<?php if($MULTI_LANGUAGE_SITE) echo "?lng=".$this->lang;?>"><span class="btn-main-login"><?php echo $M_MY_SPACE;?></span></a></li>
	<?php
}
else
if(isset($_COOKIE["AuthE"])&&$_COOKIE["AuthE"]!="")
{
	?>
	<li><a class="login-trigger btn btn-green custom-back-color" href="EMPLOYERS/index.php<?php if($MULTI_LANGUAGE_SITE) echo "?lng=".$this->lang;?>"><span class="btn-main-login"><?php echo $M_MY_SPACE;?></span></a></li>
	<?php
}
else
{

?>
	<li style="margin-top: -5px;"><button type="button" class="login-trigger btn btn-green custom-back-color" data-toggle="modal" data-target="#login-modal"><?php echo $M_LOGIN;?></button></li>

<?php
}
?>