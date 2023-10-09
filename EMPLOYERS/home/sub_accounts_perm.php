<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
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
			"sub_accounts",
			$M_GO_BACK,
			"",
			"red"
		 );
	?>

</div>
<div class="clear"></div>
<?php

	
$tableSubAccounts=$database->DataTable("sub_accounts","WHERE employer='".$AuthUserName."'");

$arrSubA = array();

$strWhere=" WHERE ";
$bFirst = true;
while($aSubA = $database->fetch_array($tableSubAccounts))
{

	array_push($arrSubA, $aSubA["username"]);
	
	if(!$bFirst)
	{
		$strWhere .= " OR ";
	}
	
	$strWhere .= "permission LIKE '~~".$aSubA["username"]."~~%' ";
	$bFirst = false;
}

if(sizeof($arrSubA) == 0)
{
	$strWhere="";
}

if(sizeof($arrSubA) == 0)
{
?>
<br/>
<i><?php echo $M_ANY_SUB_ACCOUNTS;?></i>
<br/>
<?php
}
else
{

$arrPermissions=array("PermissionsArray");
$Permissions=$database->DataTable("sub_accounts_permissions",$strWhere);

while($oPermission=$database->fetch_array($Permissions))
{

	array_push($arrPermissions, $oPermission["permission"]);
}

$ShowFrm=true;

if(isset($_REQUEST["ProceedApplyPermissions"]))
{
	$database->Query("delete from ".$DBprefix."sub_accounts_permissions ".$strWhere);
	
	$queryToExecute="";
	
	foreach ($_POST as $k => $v)
	{
		if(substr($k, 0, 2)=="~~")
		{
				
			$queryToExecute="
			INSERT INTO 
			".$DBprefix."sub_accounts_permissions(permission)
			VALUES('".strtr($v,"%%"," ")."');";
			
			$database->Query($queryToExecute);
			
		}
    }
	
	echo "<br><h4>".$M_NEW_PERM_SAVED."</h4><br/>";

	//$ShowFrm=false;

}
else
{


?>

<?php
if($ShowFrm)
{
?>
<br/>
<h4><?php echo $M_PERM_EXPL;?></h4>
<br/>

<form action="index.php" method="post">
<input type="hidden" name="ProceedApplyPermissions" value="">
<input type="hidden" name="category" value="<?php echo $category;?>">
<?php
if(isset($_REQUEST["action"]))
{
?>
<input type="hidden" name="action" value="<?php echo $action;?>">
<?php
}
else
{
?>
<input type="hidden" name="page" value="<?php echo $page;?>">
<input type="hidden" name="folder" value="<?php echo $folder;?>">
<?php
}
?>
<br>
<?php


$arrGroups=array ();
$Groups=$database->DataTable("sub_accounts","WHERE employer='".$AuthUserName."' ");
$iGroupsCount=$database->num_rows($Groups);


		while($oGroup=$database->fetch_array($Groups))
		{
				array_push($arrGroups, $oGroup["username"]);
		}

array_multisort($arrGroups);
		
echo "<table width=\"100%\" celpadding=0 cellspacing=0 style='border-style:solid;border-color:#cecfce;border-width:1px 1px 1px 1px'>";

include("pages_structure.php");

for($i=0;$i<sizeof($oLinkTexts);$i++)
{

	$strLink=$oLinkActions[$i];
	$strText=$oLinkTexts[$i];
	
	echo "<tr height=20 bgcolor=#cecfce>
					<td class=basictext>
						&nbsp;<b>$strText</b>
					</td>";
					
	foreach($arrGroups as $strGroup){
			echo "<td class=basictext>
							<b>$strGroup</b>
					</td>";
		}
					
	echo"</tr>";
	
	eval("\$evSubLinks=\$".$strLink."_oLinkActions;");
	eval("\$evSubTexts=\$".$strLink."_oLinkTexts;");
	
	$boolColor=true;
	
	for($j=0;$j<sizeof($evSubLinks);$j++){
	
		$strSubLink=$evSubLinks[$j];
		$strSubText=$evSubTexts[$j];
	
		echo "<tr height=20 bgcolor=".($boolColor?"#ffffff":"#efefef").">";
		
		if($boolColor){
			$boolColor=false;
		}
		else{
			$boolColor=true;
		}
		
	
		echo "<td class=basictext>&nbsp;$strSubText</td>";
		
		foreach($arrGroups as $strGroup){
			echo "<td width=100  class=basictext>";
			
			if($strGroup=="Administrators"){
				echo "<input type=checkbox checked disabled>";
			}
			else
			{
		
				if(array_search("~~$strGroup~~$strLink~~$strSubLink",$arrPermissions,false)){
				
					echo "<input type=checkbox checked name=\"".strtr("~~$strGroup~~$strLink~~$strSubLink"," ","%%")."\" value=\"".strtr("~~$strGroup~~$strLink~~$strSubLink"," ","%%")."\">";
					
				}
				else{
					
				
					echo "<input type=checkbox value=\"".strtr("~~$strGroup~~$strLink~~$strSubLink"," ","%%")."\" name=\"".strtr("~~$strGroup~~$strLink~~$strSubLink"," ","%%")."\">";
				}
			}
			
			echo "</td>\n";
		}
	
		echo "</tr>\n";
				
	}
	
	
}

echo "</table>";

?>		
		</td>
	</tr>
</table>

<br>

<input type="submit" value=" <?php echo $SAUVEGARDER;?> " class="btn btn-primary">

</form>
<?php
}
}
}
?>




