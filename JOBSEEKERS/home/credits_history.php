<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<h3>
	<?php echo $M_CREDITS_HISTORY_INVOICES;?>
</h3>
<br/>
<?php
RenderTable
(
	"credits_jobseeker",
	array("date_start","credits","amount","payment"),
	array($DATE_MESSAGE,$M_CREDITS,$M_AMOUNT,$M_PAYMENT),
	600,
	"WHERE jobseeker='$AuthUserName' and status=1   ",
	"",
	"id",
	"index.php?category=home&folder=credits&page=history"
);
?>
