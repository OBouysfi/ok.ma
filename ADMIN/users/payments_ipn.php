<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<table summary="" border="0" width="100%">
	<tr>
		<td width="40"><img src="images/icons2/reports.gif" width="39" height="40" alt="" border="0"></td>
		<td><b>PayPal payments report based on IPN</b></td>
	</tr>
</table>

<br>
<?php



RenderTable(
						"jobseeker_payments",
						array("date","user","amount"),
						array("Date","User","Amount"),
						"100%",
						
						"WHERE user<>'' AND method='paypal' ORDER BY ID desc",
						"",
						"id",
						"index.php?action=".$action."&category=".$category
);
?>
