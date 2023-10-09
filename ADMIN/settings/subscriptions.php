<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><script>
lock_check = false;

function DeleteTemplate(x)
{
	if(confirm("<?php echo $M_SURE_DELETE_PACKAGE;?>"))
	{
		document.location.href="index.php?category=links_directory&action=packages&Delete="+x;
	}
}


function CallBack()
{
	document.getElementById("main-content").innerHTML =
	top.frames['ajax-ifr'].document.body.innerHTML;
	HideLoadingIcon();
}

</script>

<div class="fright">

		
	<?php
	
	echo LinkTile
	(
		"settings",
		"payments",
		$M_GO_BACK,
		"",
		
		"red"
	);
	 
	 
	echo LinkTile
		 (
			"settings",
			"payments",
			$M_PAYMENTS." - ".$M_SETTINGS,
			"",
			
			"lila"
		 );
		 
		 
	echo LinkTile
		 (
			"settings",
			"add_subscription",
			$M_NEW_SUBSCRIPTION,
			"",
			
			"green"
		 );
		
		 
		?>
		
	
</div>
<div class="clear"></div>

<br/>
<br/>

<?php
if(isset($_REQUEST["Delete"])&&isset($_REQUEST["CheckList"]))
{
	$database->SQLDelete("subscriptions","id",$_REQUEST["CheckList"]);
}
?>


<span class="medium-font">
	Manage the subscriptions
</span>
<br>
<?php

$arrTDSizes = array("50","20","100","*","100","100","50","50");

RenderTable
(
		"subscriptions",
		array("EditNote","id","name","description","listings","price","billed"),
		array($MODIFY,"ID",$NOM,$M_DESCRIPTION,$M_MAX_LISTINGS,$M_PRICE,$M_BILLED),
		740,
		
		(isset($order_type)?"":"ORDER BY id DESC"),
		$EFFACER,
		"id",
		"index.php?action=".$action."&category=".$category
);
?>