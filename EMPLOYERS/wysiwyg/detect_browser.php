<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
$user_agent = $_SERVER["HTTP_USER_AGENT"];

// Android
$android = strpos($user_agent, 'Android') ? true : false;

// BlackBerry
$blackberry = strpos($user_agent, 'BlackBerry') ? true : false;

// iPhone
$iphone = strpos($user_agent, 'iPhone') ? true : false;

// Linux
$linux = strpos($user_agent, 'Linux') ? true : false;

// Macintosh
$mac = strpos($user_agent, 'Macintosh') ? true : false;

// Windows
$win = strpos($user_agent, 'Windows') ? true : false;

$chrome = strpos($user_agent, 'Chrome') ? true : false;

$firefox = strpos($user_agent, 'Firefox') ? true : false;

$firefox_2 = strpos($user_agent, 'Firefox/2.0') ? true : false;

$firefox_3 = strpos($user_agent, 'Firefox/3.0') ? true : false;

$firefox_3_6 = strpos($user_agent, 'Firefox/3.6') ? true : false;

$msie = strpos($user_agent, 'MSIE') ? true : false;

$msie_7 = strpos($user_agent, 'MSIE 7.0') ? true : false;

$msie_8 = strpos($user_agent, 'MSIE 8.0') ? true : false;

$opera = preg_match("/\bOpera\b/i", $user_agent);

$safari = strpos($user_agent, 'Safari') ? true : false; 

$safari_2 = strpos($user_agent, 'Safari/419') ? true : false;

$safari_3 = strpos($user_agent, 'Safari/525') ? true : false;

$safari_3_1 = strpos($user_agent, 'Safari/528') ? true : false;

$safari_4 = strpos($user_agent, 'Safari/531') ? true : false; 
?>