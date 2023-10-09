<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
	<div class="fright">

	<?php
		echo LinkTile
		 (
			"home",
			"welcome",
			$M_DASHBOARD,
			"",
			"blue"
		 );
	
	?>

</div>
<div class="clear"></div>
<h3>
	<?php echo $CONSULT_LIST_RECEIVED;?>
</h3>
<br/>

<?php

if(isset($_POST["Delete"])&&isset($_POST["CheckList"])&&sizeof($_POST["CheckList"])>0)
{
	$website->ms_ia($_POST["CheckList"]);
	$database->SQLDeletePlus("user_to",$AuthUserName,"user_messages","id",$_POST["CheckList"]);
}

?>
<br/>

<?php

if($database->SQLCount("user_messages","WHERE user_to='$AuthUserName'") == 0)
{
	echo "<i>".$ANY_MESSAGES."</i>";
}
else
{

		RenderTable
		(
			"user_messages",
			array("EditNote","date","user_from","subject","message"),
			array($M_REPLY,$DATE_MESSAGE,$M_FROM,$SUBJECT,$M_MESSAGE),
			"100%",
			" WHERE user_to='".$AuthUserName."' ",
			$EFFACER,
			"id",
			
			"index.php?category=".$category."&action=".$action
		);
		
}
?>