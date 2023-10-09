<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?><table summary="" border="0" width="100%">
	<tr>
		<td width="45">
			<img src="images/icons2/users.gif" width="39" height="38" alt="" border="0">
		</td>
		<td>
		<b>
				<?php echo $M_MANAGE_CONTACT_PERSONS;?>
		</b>
		</td>
	</tr>
</table>
<br>
<?php

if(isset($_REQUEST["Delete"]) && isset($_REQUEST["CheckList"]) && sizeof($_REQUEST["CheckList"]) > 0)
{
		$website->ms_ia($_REQUEST["CheckList"]);
		$database->SQLDelete("contact_persons","id",$_REQUEST["CheckList"]);
}
?>


<?php

if($database->SQLCount("contact_persons","")==0)
{
?>

<br>

<table summary="" border="0" width="100%">
	<tr>
		<td>
		
			[<?php echo $M_ANY_CONTACT_PERSONS;?>]
		
		</td>
	</tr>
</table>


	
	
	

<?php
}
else
{

			RenderTable(
						"contact_persons",
						array("name","email","phone","employer"),
						array($NOM,$EMAIL,$M_PHONE,$M_EMPLOYER),
						
						"100%",
						"",
						$EFFACER,
						"id",
						"index.php?category=$category&action=$action"
			);
}
?>
