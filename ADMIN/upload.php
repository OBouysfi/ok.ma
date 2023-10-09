<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
define("IN_SCRIPT","1");
include("../config.php");
include("../include/Database.class.php");
$database = new Database();
$database->Connect($DBHost, $DBUser,$DBPass );
$database->SelectDB($DBName);
include("security.php");
///images processing
$str_images_list = "";
$path="../";	
include("../include/images_processing.php");
///end images processing
?>
<script>
parent.UploadSuccess(<?php echo $str_images_list;?>);
</script>