<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if($this->GetParam("FACEBOOK_PAGE_URL")!="")
{
	echo '<a target="_blank" href="'.$this->GetParam("FACEBOOK_PAGE_URL").'" rel="nofollow"><img src="images/facebook-icon.png" class="bottom-icon"/></a>';	
}

if($this->GetParam("TWITTER_PAGE_URL")!="")
{
	echo '<a target="_blank" href="'.$this->GetParam("TWITTER_PAGE_URL").'" rel="nofollow"><img src="images/twitter-icon.png" class="bottom-icon"/></a>';	
}

if($this->GetParam("GOOGLE_PAGE_URL")!="")
{
	echo '<a target="_blank" href="'.$this->GetParam("GOOGLE_PAGE_URL").'" rel="publisher"><img src="images/googleplus-icon.png" class="bottom-icon"/></a>';	
}
?>