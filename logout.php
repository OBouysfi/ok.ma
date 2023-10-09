<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
ob_start();
setcookie("AuthE","",time()-1);
setcookie("AuthJ","",time()-1);
echo "<script>document.location.href='index.php".(isset($_REQUEST["lang"])?"?lang=".$_REQUEST["lang"]:"")."';</script>";

ob_end_flush();
?>