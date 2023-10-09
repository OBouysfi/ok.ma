<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<table summary="" border="0" width="100%">
	<tr>
		<td width="40"><img src="images/icons2/reports.gif" width="39" height="40" alt="" border="0"></td>
		<td><b>Bank wire transfer and cheque payments</b></td>
	</tr>
</table>

<br>
<?php



RenderTable(
						"jobseeker_payments",
						array("date","user","method","amount"),
						array("Date","User","Method","Amount"),
						"100%",
						
						"WHERE user<>'' AND method<>'paypal' AND validated=1 ORDER BY ID desc",
						"",
						"id",
						"index.php?action=".$action."&category=".$category
);
?>
