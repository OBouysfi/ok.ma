<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<?php

if(isset($_REQUEST["Delete"])&&isset($_REQUEST["CheckList"]))
{
	$database->SQLDelete("admin_users_type","id",$_REQUEST["CheckList"]);
}
?>
	
<?php
if(isset($_REQUEST["ProceedAddNewGroup"]))
{

	$database->SQLInsert
	(
		"admin_users_type",
		array("type"),
		array($_REQUEST["newtype"])
	);
	
}

?>


<div class="fright">

	<?php
		echo LinkTile
			 (
				"security",
				"new_user",
				$M_NEW_USER,
				$AJOUTER_NOUVEL_UTILISATEUR,
				"yellow"
			 );
	?>
	
	<?php
		echo LinkTile
			 (
				"security",
				"permissions",
				$M_ACCESS_RIGHTS,
				$GROUPS_PERMISSIONS_MANAGEMENT,
				"lila"
			 );
			 
			 echo LinkTile
			 (
				"security",
				"admin",
				$M_USERS_LIST,
				"",
				"red"
			 );
	?>
		
	
</div>
<div class="clear"></div>

<script>
function CallBack()
{
	document.getElementById("main-content").innerHTML =
	top.frames['ajax-ifr'].document.body.innerHTML;
	HideLoadingIcon();
}

</script>

<span class="medium-font" id="page-header"><?php echo $M_ADD_NEW_GROUP;?></span>
<br/>

<form action="index.php" method="post">
<input type="hidden" name="category" value="<?php echo $category;?>">
<input type="hidden" name="action" value="<?php echo $action;?>">
	<br>
		
	<table summary="" border="0">
  		<tr>
  			<td class=basicText><?php echo $NOM;?>: </td>
  			<td class=basicText><input type=text size=30 name=newtype></td>
  		</tr>
    </table>
 
<br>

			<input type="submit" value=" <?php echo $AJOUTER;?> " class=adminButton>


<input type="hidden" name="ProceedAddNewGroup">
</form>


<br/>
<br/>
<span class="medium-font">
<?php echo $M_LIST_CURRENT_GROUPS;?> 
</span>
<br>

<?php

	$arrTDSizes = array("50","*");
	$oCol=array("id","type");
	$oNames=array($ID_MESSAGE,$M_TYPE);
	
	$ORDER_QUERY="ORDER BY id asc";
	
	RenderTable(
	"admin_users_type",$oCol,$oNames,450,
	" ",
	$EFFACER,
	"id",
	"index.php",
	true,
	20,
	false
	
	);
	
?>

<br>
		