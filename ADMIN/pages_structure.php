<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
$ProductName="Jobs Portal v4.2";

$oLinkTexts=array($M_HOME,$M_JOBS,$M_USERS,$M_SETTINGS,$H_WEBSITE,$M_TEMPLATE,$M_EXTENSIONS,$M_STATISTICS,$M_ADMIN_USERS);
$oLinkActions=array("home","jobs","users","settings","site_management","templates","extensions","statistics","security");

$jobs_oLinkTexts=array($M_ADS_LIST,$M_NEW_JOB_AD,$M_USER_MESSAGES,$M_JOB_ALERTS2,$M_FIELDS,$M_APPLICATIONS,$M_UPLOADED_FILES);
$jobs_oLinkActions=array("list","add","messages","job_alerts","fields","applications","uploaded_files");

$users_oLinkTexts=array($M_EMPLOYERS,$M_JOBSEEKERS,$M_JOBSEEKER_FIELDS,$M_EMPLOYER_FIELDS,$M_REVIEWS);
$users_oLinkActions=array("employers","jobseekers","fields","empl_fields","reviews");
	
$home_oLinkTexts=array($M_DASHBOARD,$M_MESSAGES,$M_LOGIN_REPORT,$M_CHANGE_PWD);
$home_oLinkActions=array("welcome","messages","connections","password");

$settings_oLinkTexts=array($M_CONFIGURATION_OPTIONS,$M_PAYMENTS,$M_JOB_FEEDS,$M_JOB_CATEGORIES,$M_LOCATIONS,$M_BANNER_AREAS,$M_FIELD_VALUES,$M_COURSE_CATEGORIES);
$settings_oLinkActions=array("options","payments","feeds","categories","locations","banner_areas","field_values","course_categories");

$site_management_oLinkTexts=array($PAGES,$M_NEWS,$M_LANGUAGE_VERSIONS,$M_LANGUAGE_FILE);
$site_management_oLinkActions=array("pages_pro","news","languages","language_file");

$statistics_oLinkTexts=array($H_REPORTS,$H_REFERALS);
$statistics_oLinkActions=array("reports","referals");

$extensions_oLinkTexts=array($M_FILES,$M_TAGS,$M_FAQ_MANAGER." [".$M_ADD_ON."]",$M_NEWSLETTER." [".$M_ADD_ON."]");
$extensions_oLinkActions=array("extensions","tags","faq_manager","newsletter");

$templates_oLinkTexts=array($MODIFY,$M_LOGO,$M_LAYOUT_COLORS,$M_HOME_SLIDER,$M_GOOGLE_ADSENSE);
$templates_oLinkActions=array("modify","logo","layout","home_slider","adsense");

$news_oLinkTexts=array($DESCRIPTION,$M_NEWS);
$news_oLinkActions=array("description","news");

$faq_manager_oLinkTexts=array($M_QUESTIONS);
$faq_manager_oLinkActions=array("home");

$newsletter_oLinkTexts=array($DESCRIPTION,$M_CATEGORIES,$M_NEWSLETTER,$M_LIST,$ENVOYER,$M_LOG,$M_SETTINGS);
$newsletter_oLinkActions=array("description","categories","newsletter2","newsletter","send","log","settings");

$security_oLinkTexts=array($M_USER_GROUPS,$M_NEW_USER,$M_USERS_LIST,$M_ACCESS_RIGHTS);
$security_oLinkActions=array("types","new_user","admin","permissions");


$exit_oLinkTexts=array($M_THANK_YOU);
$exit_oLinkActions=array("exit");
?>