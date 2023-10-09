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
	<td width="43">
			<img src="images/icons2/erase.gif" width="38" height="41" alt="" border="0">
	</td>
		<td>
		<b>
		Validate the job ads packages purchased by the employers
		</b>
		</td>
	</tr>
</table>
<br>

<?php

if($database->SQLCount("packages_employer"," WHERE active=0") == 0)
{
?>
		<table summary="" border="0" width="100%">
  	<tr>
  		<td>
		<br>
		<b>[no packages waiting to be validated]</b>
		
		</td>
  	</tr>
  </table>
		
		
<?php
}
else
{

if(isset($_REQUEST["Delete"]) && isset($_REQUEST["CheckList"]) && sizeof($_REQUEST["CheckList"]) > 0)
{
	SQLUpdateField_MultipleArray
	(
		"packages_employer",
		"active",
		"1",
		"id",
		$_REQUEST["CheckList"]
	);
}

		RenderTable
		(
						"packages_employer",
						array("employer","ads","price"),
						array("USER",$REMAINING_ADS,$PACKAGE_PRICE." "),
						"500",
						" WHERE active=0",
						"Validate",
						"id",
						
						"index.php?category=".$category."&action=".$action
		);
						
}


?>

