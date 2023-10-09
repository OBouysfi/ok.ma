<?php
if(!defined('IN_SCRIPT')) die("");
?>
<?php
if(isset($_POST["Delete"])&&isset($_POST["CheckList"]))
{
	
	if(sizeof($_POST["CheckList"])>0)
	{
		$website->ms_ia($_POST["CheckList"]);
		$database->SQLDeletePlus("employer",$AuthUserName,"sub_accounts","id",$_POST["CheckList"]);
	}

}

$iSA=$database->SQLCount("sub_accounts","WHERE employer='".$AuthUserName."' ");
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
		
		echo LinkTile
		 (
			"home",
			"sub_accounts_perm",
			$M_PERMISSIONS,
			"",
			"yellow"
		 );
	?>

</div>
<div class="clear"></div>

<h3>
	<?php echo $M_MANAGE_YOUR_SUB_ACCOUNTS;?>
</h3>

<?php
if($iSA>0)
{
?>

<div class="pull-right">
	<a href="index.php?category=<?php echo $category;?>&folder=<?php echo $action;?>&page=perm" style="text-transform:uppercase"><?php echo $M_CLICK_SUB_ACCOUNTS;?></a>
</div>			  

<?php
}
?>
<br>

<?php
if(!isset($_POST["SpecialProcessAddForm"]))
{
?>
<br/>
<i><?php echo $M_CREATE_NEW_SUB_ACCOUNT;?></i>

<br/><br/>
<?php
}
?>


<?php

$_REQUEST["arrNames2"]=array("employer");
$_REQUEST["arrValues2"]=array($AuthUserName);


if(isset($_POST["SpecialProcessAddForm"])&&(strlen($_POST["username"])<6||strlen($_POST["password"])<6))
{

	echo "<span class=\"red-font\"><i>".$M_AT_LEAST_3."</i></span><br/><br/>";
	unset($_REQUEST["SpecialProcessAddForm"]);
}
else
if(isset($_POST["SpecialProcessAddForm"])&&($database->SQLCount("sub_accounts","WHERE username='".$_POST["username"]."'")>=1||!preg_match("/^[a-zA-Z0-9_\-.@]+$/i", $_POST["username"])))
{

	echo "<span class=\"red-font\"><i>".$M_USERNAME_TAKEN."</i></span><br/><br/>";
	unset($_REQUEST["SpecialProcessAddForm"]);
}

AddNewForm
(
	array($M_USERNAME.":",$M_PASSWORD.":",$NOM.":",$TELEPHONE.":"),
	array("username","password","name","phone"),
	array("textbox_30","textbox_30","textbox_30","textbox_30"),
	$AJOUTER,
	"sub_accounts",
	$M_NEW_SUB_ACCOUNT_CREATED
);

?>
<br/>
<br/>

<?php

$arrTDSizes = array("50","*","*","*","*");

if($iSA==0)
{
?>
	<i><?php echo $M_ANY_SUB_ACCOUNTS;?></i>
<?php
}
else
{

	RenderTable
	(
		"sub_accounts",
		array("ShowFormEdit","username","name","phone"),
		array($MODIFY,$M_USERNAME,$NOM,$TELEPHONE),
		500,
		"WHERE employer='".$AuthUserName."' ",
		$EFFACER,
		"id",
		"index.php?action=$action&category=$category"
	);
}
?>
