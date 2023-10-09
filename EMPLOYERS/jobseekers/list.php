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
			"jobseekers",
			"search",
			$SEARCH,
			"",
			"green"
		);
	
		
	
	?>

</div>
<div class="clear"></div>

<?php
if($website->GetParam("CHARGE_TYPE") == 1&&$arrUser["subscription"]==0)
{
	echo '<h4><span class="red-font">'.$M_NEED_SUBSCRIPTION_RESUMES.'</span>';
	?>
	<br/><br/>
	<a class="underline-link" href="index.php?category=home&action=credits"><?php echo $M_PLEASE_SELECT_TO_FEATURED;?></a></h4>
	<?php
	
}
else
{
?>

<h3>
	<?php echo $BROWSE_JS;?>
</h3>

<br/>


<?php
$show_detailed_info = true;

if(!isset($l))
{
	include_once("../locations/locations_array.php");
}

$_REQUEST["hide_refine_search"]=true; 

RenderTable
(
	"jobseekers",
	array("ShowCV","first_name","last_name","profile_description"),
	array($M_CV,$FIRST_NAME,$LAST_NAME,$DESCRIPTION),
	"100%",
	"WHERE profile_public=1 AND active=1",
	"",
	"id",
	
	"index.php?category=".$category."&action=".$action
);


}

?>


