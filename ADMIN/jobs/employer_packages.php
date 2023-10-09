<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<table summary="" border="0" width="100%">
	<tr>
	<td width="35">
			<img src="images/icons2/calculator.gif" width="33" height="36" alt="" border="0">
	</td>
		<td>
		<b>
		<?php echo $M_VIEW_CURRENT_PACKAGES;?>
		</b>
		</td>
	</tr>
</table>
<br>

<?php

if(isset($_REQUEST["Delete"]) && isset($_REQUEST["CheckList"]) && sizeof($_REQUEST["CheckList"]) > 0)
{
	$website->ms_ia($_REQUEST["CheckList"]);
	$database->SQLDelete("packages_employer","id",$_REQUEST["CheckList"]);
}

					RenderTable
					(
						"packages_employer",
						array("employer","ads","price"),
						array($UTILISATEUR,$REMAINING_ADS,$M_PRICE_CREDITS),
						"700",
						" WHERE active<>0 AND ads>0",
						$EFFACER,
						"id",
						
						"index.php?category=".$category."&action=".$action
					);
?>

