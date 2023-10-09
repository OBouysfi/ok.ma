<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");

?>
<div class="logo">
<?php
if
(
	$this->admin_settings["logo"]!=""
	&&
	file_exists("thumbnails/".$this->admin_settings["logo"].".jpg")
)
{
	echo '<a href="http://'.$this->domain.'">';
	echo '<img src="thumbnails/'.$this->admin_settings["logo"].'.jpg" class="img-responsive"/>';
	echo '</a>';
}
else
if
(
	$this->admin_settings["logo_text"]!=""
)
{
	echo '<a class="navbar-brand text-logo custom-color" href="http://'.$this->domain.'">'.stripslashes($this->admin_settings["logo_text"]).'</a>';
}
else
{
	echo '<img src="images/logo.png" class="img-responsive site-logo"/>';
}


?>
</div>