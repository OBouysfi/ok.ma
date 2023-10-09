<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php 
setcookie("AuthVendor","",time()-1,"/");
echo "<script>document.location.href='../index.php?l=1".(isset($_REQUEST["show_login"])?"&show_login=1":"").(isset($_REQUEST["lng"])?"&lang=".$_REQUEST["lng"]:"")."';</script>";
?>