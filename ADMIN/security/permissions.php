<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!isset($iKEY)||$iKEY!="AZ8007") die("ACCESS DENIED");
?>
<?php

$ShowFrm=true;

if(isset($_REQUEST["ProceedApplyPermissions"])){

	$database->Query("delete from ".$DBprefix."admin_users_permissions");
	
	$queryToExecute="";
	
	while (list($k, $v) = each($_POST)){
        
		if(substr($k, 0, 1)=="@"){
		
						
			$queryToExecute="
			INSERT INTO 
			".$DBprefix."admin_users_permissions(permission)
			VALUES('".strtr($k,"%%"," ")."');";
			
			$database->Query($queryToExecute);
			
		}
    }
	
	$ShowFrm=false;
	
	$currentUser->LoadPermissions();
}



?>

<?php
if(true)
{
?>

<div class="fright">

	<?php
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
				"admin",
				$M_USERS_LIST,
				"",
				"red"
			 );
	?>
		
	
</div>

<div class="clear"></div>

<form action="index.php" method="post">
<input type="hidden" name="ProceedApplyPermissions" value="1">
<input type="hidden" name="category" value="<?php echo $_REQUEST["category"];?>">
<input type="hidden" name="action" value="<?php echo $_REQUEST["action"];?>">
<br>
<span class="medium-font"><?php echo $GROUPS_PERMISSIONS_MANAGEMENT;?></span>

<br>
<br>
<br>
<?php


$arrGroups=array ();
$Groups=$database->DataTable("admin_users_type","");
$iGroupsCount=$database->num_rows($Groups);


		while($oGroup=$database->fetch_array($Groups)){
				array_push($arrGroups, $oGroup["type"]);
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
						<font color=white>&nbsp;<b>$strText</b></font>
					</td>";
					
	foreach($arrGroups as $strGroup){
			echo "<td class=basictext>
							<font color=white>$strGroup</font>
					</td>";
		}
					
	echo"</tr>";
	
	$evSubLinks=${$strLink."_oLinkActions"};
	$evSubTexts=${$strLink."_oLinkTexts"};
	
	$boolColor=true;
	
	for($j=0;$j<sizeof($evSubLinks);$j++)
	{
	
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
			echo "<td width=150  class=basictext>";
			
			if($strGroup=="Administrators")
			{
				echo "<input type=checkbox checked disabled>";
			}
			else
			{
			
				if(array_search("@$strGroup@$strLink@$strSubLink",$currentUser->arrPermissions,false))
				{
				
					echo "<input type=checkbox checked name=\"".strtr("@$strGroup@$strLink@$strSubLink"," ","%%")."\">";
					
				}
				else
				{
					
				
					echo "<input type=checkbox name=\"".strtr("@$strGroup@$strLink@$strSubLink"," ","%%")."\">";
				}
			}
			
			echo "</td>\n";
		}
	
		echo "</tr>\n";
				
	}
	
	
}

echo "</table>";

?>		
		
<br>

<input type="submit" value=" <?php echo $M_SAVE; ?> " class="adminButton">
	
</form>
<?php
}
?>