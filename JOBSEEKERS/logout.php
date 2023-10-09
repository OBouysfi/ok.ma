<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php 
setcookie("AuthVendor","",time()-1,"/");
echo "<script>document.location.href='../index.php?l=1".(isset($_REQUEST["show_login"])?"&show_login=1":"").(isset($_REQUEST["lng"])?"&lang=".$_REQUEST["lng"]:"")."';</script>";
?>