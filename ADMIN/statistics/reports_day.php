<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<table summary="" border="0" width=750>
	<tr>
		<td width=45>
		<img src="images/icons<?php echo $DN;?>/email.gif" border="0" width="40" height="34" alt="">
		</td>
		<td class=basictext>
		
		
		<b>
		<?php echo $STATISTICS_DETAILS_FOR;?> <font color=red>[<?php echo urldecode($key);?>]</font>
		</b>
		</td>
	</tr>
</table>
<br>
<?php

$arrTDSizes=array(150,50,"*");
RenderTable(
						"statistics",
						array("date","host","referer"),
						array($DATE_MESSAGE,$HOST,$REFERER),
						750,
						"WHERE date LIKE '".urldecode($key)."%' ",
						"",
						"",
						"index.php?category=statistics&folder=reports&page=day&key=".$key
						);
?>
<br>
<?php
generateBackLink("reports");
?>

