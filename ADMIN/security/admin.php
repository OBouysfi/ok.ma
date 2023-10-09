<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><!--mobile-start--><?php
if(!isset($iKEY)||$iKEY!="AZ8007") die("ACCESS DENIED");
?>

<div class="fright">

	<?php
		echo LinkTile
			 (
				"security",
				"new_user",
				$M_NEW_USER,
				$AJOUTER_NOUVEL_UTILISATEUR,
				"green"
			 );
			 
		echo LinkTile
			 (
				"security",
				"types",
				$M_USER_GROUPS,
				$M_ADD_NEW_GROUP,
				"yellow"
			 );
			 
			 echo LinkTile
			 (
				"security",
				"permissions",
				$M_ACCESS_RIGHTS,
				$GROUPS_PERMISSIONS_MANAGEMENT,
				"lila"
			 );
			 
			
	?>
		
	
</div>
<div class="clear"></div>
<br>
<?php

if(isset($_REQUEST["Delete"])&&isset($_REQUEST["CheckList"]))
{
	
	if(sizeof(array_diff($_REQUEST["CheckList"],array("1")))>0)
	{
	
		$database->SQLDelete("admin_users","id",array_diff($_REQUEST["CheckList"],array("1")));
	
	}

}

?>

			
<span class="medium-font"><?php echo $LISTE_DES_UTILISATEURS;?></span>
<br>			
<?php
$oCol=array("ShowModifierUtilisateur","username","type","email");
$oNames=array($MODIFIER,$UTILISATEUR,$M_TYPE,$EMAIL);
$ORDER_QUERY="ORDER BY type";
RenderTable("admin_users",$oCol,$oNames,550,"WHERE username<>'administrator'  ",$EFFACER,"id","index.php");
?>

<!--mobile-end-->