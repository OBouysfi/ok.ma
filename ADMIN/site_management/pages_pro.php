<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");

$MMODE= "E";

if(isset($_REQUEST["ProceedChangeLanguage"]))
{
	$language_version=strtolower($_REQUEST["ProceedChangeLanguage"]);
	
	$database->SQLUpdate_SingleValue
	(
		"admin_users",
		"username",
		"'".$AuthUserName."'",
		"bo_lang",
		$language_version
	);
}
else
{
	$language_version = strtolower($LoginInfo["bo_lang"]);
	
}

if($language_version == "")
{
	$default_language = $database->DataArray("languages","default_language=1");
	$language_version = strtolower($default_language["code"]);
	
	$database->SQLUpdate_SingleValue
	(
		"admin_users",
		"username",
		"'".$AuthUserName."'",
		"bo_lang",
		$language_version
	);
}

if(isset($_REQUEST["ProceedDeletePage"]))
{
	$database->SQLDelete("pages","id",array($_REQUEST["id"]));
}
include("pages_str.php");
?>


<div class="fright">

	<?php
			echo LinkTile
				 (
					"site_management",
					"new_page",
					$M_NEW_PAGE,
					$M_ADD_NEW_PAGE,
					"lila"
				 );
		?>
		
	<?php
			echo LinkTile
				 (
					"site_management",
					"hierarchy",
					$M_CHANGE_HIERARCHY,
					$M_MAKE_MAIN_SUB,
					"yellow"
				 );
		?>
		
	
</div>

<br>
<span class="medium-font">
<?php echo $M_SELECT_LANGUAGE_VERSION;?>
<br><br>
<script >
 function LanguageChanged(lng)
 {
	<?php
	if(isset($_REQUEST["folder"]))
	{
	
	}
	else
	{
	?>
		document.location.href="index.php?category=<?php echo $_REQUEST["category"];?>&action=<?php echo $_REQUEST["action"];?>&ProceedChangeLanguage="+lng.value;
	<?php
	}
	?>

 }
</script>
<select style="width:200px" class="medium-font" name="change_language"  onchange="LanguageChanged(this);">
<?php
$tableLanguages=$database->DataTable("languages","");

while($arrLanguages=$database->fetch_array($tableLanguages))
{
	echo "<option value=\"".strtolower($arrLanguages["code"])."\" ".($language_version==strtolower($arrLanguages["code"])?"selected":"").">".$arrLanguages["name"]."</option>";	
}
?>
</select>

</span>
<br><br><br><br>
<?php

if(isset($_REQUEST["SaveExtension"]))
{
	$extension=$_REQUEST["extension"];
	$page=$_REQUEST["page"];
	$website->ms_i($page);
	
	$database->SQLUpdate_SingleValue
	(
		"pages",
		"id",
		$page,
		"custom_link_".strtolower($language_version),
		$extension
	);

}

?>

<script>
var previousSender = null;
function PageClicked(iPageID, sender, e)
{
	menu_hide_lock = false;
	if(!document.all)
	{
		x_position = e.pageX;
		y_position = e.pageY;
	}
	else
	{
		x_position = e.x;
		y_position = e.y;
	}

	document.getElementById("ExtensionsPanel").style.visibility = "hidden";

	if(sender.innerHTML.indexOf("activ")==-1)
	{

		if(false&&sender.innerHTML.indexOf("<sup>")!=-1)
		{
			oContextMenu.Data = Array
				(
					Array("<?php echo $SET_AS_DEFAULT_PAGE;?>","index.php?category=site_management&action=pages_pro&ProceedSetDefault=yes&default_page="+iPageID),
					Array("<?php echo $DESACTIVATE;?>","index.php?category=site_management&action=pages_pro&ProceedActivate=Desactivate&id="+iPageID),
					Array("<?php echo $SET_CUSTOM_EXTENSION;?>","javascript:SetExtension("+iPageID+")"),
					Array("<?php echo $PAGE_SETTINGS;?>","index.php?category=site_management&folder=pages_pro&page=edit&id="+iPageID+""),
					
					Array("<?php echo $DELETE_PAGE;?>","javascript:DeletePage("+iPageID+")")

				);

				oContextMenu.Height = 118;
		}
		else
		{
			oContextMenu.Data = Array
				(
					Array("<?php echo $EDIT_PAGE_CONTENT;?>","index.php?category=site_management&action=edit&id="+iPageID+"&lang=<?php echo $language_version;?>"),
					Array("<?php echo $PAGE_SETTINGS;?>","index.php?category=site_management&folder=pages_pro&page=edit&id="+iPageID+""),
					Array("<?php echo $EDIT_HTML;?>","index.php?category=site_management&folder=pages_pro&page=html&id="+iPageID+"&lang=<?php echo $language_version;?>"),
					
					Array("<?php echo $SET_AS_DEFAULT_PAGE;?>","index.php?category=site_management&action=pages_pro&ProceedSetDefault=yes&default_page="+iPageID),
					Array("<?php echo $DESACTIVATE;?>","index.php?category=site_management&action=pages_pro&ProceedActivate=Desactivate&id="+iPageID),
					Array("<?php echo $SET_CUSTOM_EXTENSION;?>","javascript:SetExtension("+iPageID+")"),
					
					Array("<?php echo $DELETE_PAGE;?>","javascript:DeletePage("+iPageID+")")

				);

				oContextMenu.Height = 166;
		}


	}
	else
	{

		if(false&&sender.innerHTML.indexOf("<sup>")!=-1)
		{
			oContextMenu.Data = Array
					(

						Array("<?php echo $ACTIVATE;?>","index.php?category=site_management&action=pages_pro&ProceedActivate=Activate&id="+iPageID),
						Array("<?php echo $SET_CUSTOM_EXTENSION;?>","javascript:SetExtension("+iPageID+")"),
						Array("<?php echo $PAGE_SETTINGS;?></b>","index.php?category=site_management&folder=pages_pro&page=edit&id="+iPageID+""),
						
						Array("<?php echo $DELETE_PAGE;?>","javascript:DeletePage("+iPageID+")")

					);

			oContextMenu.Height = 96;
		}
		else
		{
			oContextMenu.Data = Array
					(
						Array("<?php echo $EDIT_PAGE_CONTENT;?>","index.php?category=site_management&action=edit&id="+iPageID+"&lang=<?php echo $language_version;?>"),
						Array("<?php echo $PAGE_SETTINGS;?>","index.php?category=site_management&folder=pages_pro&page=edit&id="+iPageID+""),
						Array("<?php echo $EDIT_HTML;?>","index.php?category=site_management&folder=pages_pro&page=html&id="+iPageID+"&lang=<?php echo $language_version;?>"),
						
						Array("<?php echo $ACTIVATE;?>","index.php?category=site_management&action=pages_pro&ProceedActivate=Activate&id="+iPageID),
						Array("<?php echo $SET_CUSTOM_EXTENSION;?>","javascript:SetExtension("+iPageID+")"),
						
						Array("<?php echo $DELETE_PAGE;?>","javascript:DeletePage("+iPageID+")")

					);

			oContextMenu.Height = 142;
		}
	}



	oContextMenu.Show("ContextMenuContainer");

	if(previousSender != null)
	{
		previousSender.style.background = "#f0f1f4";
	}
	
	sender.style.background = "#5ea8de";

	previousSender = sender;
	
	
	document.getElementById("ContextMenu").style.visibility = "visible";
	document.getElementById("ContextMenu").style.left = (x_position + 10)+"px";
	document.getElementById("ContextMenu").style.top = (y_position + 1)+"px";

}

var oContextMenu = new ContextMenu();

oContextMenu.Show("ContextMenuContainer");

function DeletePage(x)
{
	if(confirm("<?php echo $ETES_VOUS_SUR__DE_VOULOIR_EFFACER;?>")){
		document.location.href="index.php?ProceedDeletePage=1&category=site_management&action=pages_pro&id="+x;
	}

}

function StartWizard(x){
	window.open("main.php?LANG=<?php echo $language_version;?>&page="+x,"title","toolbar=0,location=0,directories=0,menuBar=0,scrollbars=0,resizable=0,width=1015,height=640,left=0,top=0");
}

var iLastExtensionPageIdOpened = -1;

function SetExtensionSave(strExtension)
{
	document.location.href="index.php?category=site_management&action=pages_pro&SaveExtension=yes&page="+iLastExtensionPageIdOpened+"&LANG=<?php echo $language_version;?>&extension="+strExtension;
}

function SetExtension(x)
{
	iLastExtensionPageIdOpened = x;

	var iCurrentPageId = -1;

	for(i=0;i<pageRealIds.length;i++)
	{
		if(x == pageRealIds[i])
		{
			iCurrentPageId = i;
		}
	}

	var strSearch="";

	if(iCurrentPageId == -1 || pagesExtensions[iCurrentPageId] == "")
	{
		strSearch="none";
	}
	else
	{
		strSearch=pagesExtensions[iCurrentPageId];
	}


	if(document.all)
	{
		document.getElementById("ExtensionsPanel").innerHTML = document.getElementById("ExtensionsPanel").innerHTML.replace('value='+strSearch+'','value='+strSearch+' checked');
	}
	else
	{
		document.getElementById("ExtensionsPanel").innerHTML = document.getElementById("ExtensionsPanel").innerHTML.replace('value="'+strSearch+'"','value="'+strSearch+'" checked');
	}

	document.getElementById("ExtensionsPanel").style.visibility = "visible";
	document.getElementById("ExtensionsPanel").style.top = (parseInt(document.getElementById("ContextMenu").style.top.replace("px","")) + 20)+"px";
	document.getElementById("ExtensionsPanel").style.left = (parseInt(document.getElementById("ContextMenu").style.left.replace("px","")) + 40)+"px";
}
</script>

<div id="ExtensionsPanel" style="position:absolute;top:0px;left:0px;z-Index:5;visibility:hidden">
	<table bgcolor=<?php echo "#5ea8de";?> width="300" style="border-color:#4e98ce;border-width:1px 1px 1px 1px;border-style:solid">
		<?php

		echo "<tr>";
		echo "<td class=basictext width=15><input onclick='javascript:SetExtensionSave(\"\")' type=radio name=\"selectedExtension\" value=\"none\"></td><td class=basictext><font color=white><b>NONE</b></font></td>";
		echo "</tr>";

		$handle=opendir('../extensions');
		$arrFiles = array("none");
	
		while ($file = readdir($handle)) 
		{
		    if ($file != "." && $file != "..") 
			{
				$tag_word_post = strpos($file,"_tag");
				if($tag_word_post === false)
				{		
					array_push($arrFiles, $file);
				}
		   }
		}
		sort($arrFiles);
		foreach($arrFiles as $file)
		{
		    if ($file != "." && $file != "..")
			{
				$pos=strpos($file,"tag");
				
				if($pos == false)
				{
					echo "<tr>";
					echo "<td class=basictext width=15><input type=radio name=\"selectedExtension\" onclick='javascript:SetExtensionSave(this.value)' value=\"".str_replace(".php","",$file)."\"></td><td class=basictext><font color=white><b>".str_replace("_"," ",strtoupper(str_replace(".php","",$file)))."</b></font></td>";
					echo "</tr>";
				}
		   }
		}
		?>
	</table>
</div>

<script>

function getNearestUp(x){


	for(i=x-1;i>=0;i--){
		if(parentIds[i]==parentIds[x])
		{

			return pageIds[i];
		}
	}
}


function getNearestDown(x)
{

	for(i=x+1;i<parentIds.length;i++)
	{

		if(parentIds[i]==parentIds[x])
		{

			return pageIds[i];
		}
	}
}

function MoveUp(pageId)
{

	for(i=1;i<pageIds.length;i++)
	{
			if(pageId == pageIds[i])
			{
				pageNumber = i;
			}
	}
	
	document.location.href="index.php?category=site_management&action=pages_pro&ChangeOrder=up&val1="+getNearestUp(pageNumber)+"&val2="+pageIds[pageNumber];
}

function MoveDown(pageId)
{

	for(i=1;i<pageIds.length;i++)
	{
			if(pageId == pageIds[i])
			{
				pageNumber = i;
			}
	}
	
	document.location.href="index.php?category=site_management&action=pages_pro&ChangeOrder=down&val1="+getNearestDown(pageNumber)+"&val2="+pageIds[pageNumber];
}

</script>

</center>

<?php

if(isset($_REQUEST["ChangeOrder"]))
{

	$ChangeOrder=$_REQUEST["ChangeOrder"];
	$val1=$_REQUEST["val1"];
	$val2=$_REQUEST["val2"];
	
	$website->ms_i($val1);
	$website->ms_i($val2);
	
	
	$database->SQLUpdate("pages",array("parent_id"),array("-1"),"parent_id=$val1");
	$database->SQLUpdate("pages",array("parent_id"),array($val1),"parent_id=$val2");
	$database->SQLUpdate("pages",array("parent_id"),array($val2),"parent_id=-1");

	$database->SQLUpdate("pages",array("id"),array("-1"),"id=$val1");
	$database->SQLUpdate("pages",array("id"),array($val1),"id=$val2");
	$database->SQLUpdate("pages",array("id"),array($val2),"id=-1");


}

if(isset($_REQUEST["ProceedActivate"]))
{
	$ProceedActivate=$_REQUEST["ProceedActivate"];
	$id=$_REQUEST["id"];
	$website->ms_i($id);
	
	if($ProceedActivate=="Activate")
	{
		$database->SQLUpdate("pages",array("active_".$language_version),array("1"),"id=".$id);
	}
	else{
		$database->SQLUpdate("pages",array("active_".$language_version),array("0"),"id=".$id);
	}
}

if(isset($_REQUEST["ProceedSetDefault"]))
{
	$default_page=$_REQUEST["default_page"];
	
	
	$database->SetParameter
	(
		"1",
		$default_page
	);
	$strDefaultPageId = $default_page;
}
else
{
	$strDefaultPageId = $website->params[1];
}
?>

<script>
var menu_hide_lock = false;

function MenuOut()
{
	menu_hide_lock = true;
}

function OutClick()
{
	if(menu_hide_lock)
	{
		document.getElementById("ContextMenu").style.visibility = "hidden";
	}
}
</script>

<div id="ExpertStructure" style="z-index:-100 !important;" onclick="javascript:OutClick()">




<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td  style="padding:0 !important;position:relative;left:4px" width="40" align="center" valign=middle bgcolor="#5ea8de">
		<img src="images/point-mouse.png" />
		</td>
		<td valign=top style="padding:0 !important">

		
<?php
///PAGES STRUCTURE START

$arrPages = array();

$oRows=$database->Query("SELECT * FROM ".$DBprefix."pages order by parent_id,id");

$scriptPageIds="var pageIds=Array(''";
$scriptRealPageIds="var pageRealIds=Array(''";
$scriptParentIds="var parentIds=Array(''";
$scriptExtensions="var pagesExtensions=Array(''";
			
while ($row = $database->fetch_array($oRows))
{
	$strRowActive = "";
	$strRowExtension = "";
	$strRowDefault = "";
	
	if($row["active_".$language_version] == 0)
	{
		$strRowActive = "[$NOT_ACTIVE]"; 
	}
	
	if($row["id"] == $strDefaultPageId)
	{
		$strRowDefault = "[$DEFAULT]";
	}
	
	if($row["custom_link_".$language_version]!="")
	{
		$strRowExtension = "<sup><font color=red>".$row["custom_link_".$language_version].".php</font></sup>";
	}
	
	
	
	array_push($arrPages, array($row['id'], $row['parent_id'], $row["link_".$language_version],$strRowDefault,$strRowActive,$strRowExtension));

	$scriptRealPageIds.=",'".$row['id']."'";

	if(trim($row["custom_link_".$language_version])!="")
	{
		$scriptExtensions .=",'".$row["custom_link_".$language_version]."'";
	}
	else
	{
		$scriptExtensions .=",''";
	}


		$scriptPageIds.=",'".$row['id']."'";
		$scriptParentIds.=",'".$row['parent_id']."'";
}


$scriptExtensions.=");\n";
$scriptPageIds.=");\n";
$scriptParentIds.=");\n";
$scriptRealPageIds.=");\n";


echo "<script>
		$scriptRealPageIds
		$scriptExtensions
		$scriptPageIds
		$scriptParentIds
		</script>";
?>



<?php
function GetKinds($parent)
{

global $arrPages;
$arrParents = array();

for($j = (sizeof($arrPages)-1);$j>=0;$j--)
{
	if($arrPages[$j][0] == $parent)	
	{
		$parent = $arrPages[$j][1];

		array_push($arrParents, $parent);
	}
}

$arrKinds = array();

$iParentsCounter = 0;
$currentParent = -1;

for($j = (sizeof($arrPages)-1);$j>=0;$j--)
{
	if($arrParents[$iParentsCounter] == $arrPages[$j][0])
	{
		if($currentParent == $arrPages[$j][1])
		{
			array_push($arrKinds, "2");
		}
		else
		{
			array_push($arrKinds, "1");
		}
		
		$iParentsCounter++;
	}

	$currentParent = $arrPages[$j][1];
}

$arrKinds = array_reverse($arrKinds);

return $arrKinds;
}



function GetSubArray($parent,$arrPages)
{
	$arrResult = array();

	for($i=0;$i<sizeof($arrPages);$i++)
	{
		if($arrPages[$i][1] == $parent)
		{
			array_push($arrResult, $arrPages[$i]);
		}
	}

	return $arrResult;

}

function GeneratePrefix($x,$parent)
{
	$strResult = "";

	$arrKinds = GetKinds($parent);

	for($i=0;$i<$x;$i++)
	{
		if($i == ($x-1))
		{
			$strResult .= "<img src=\"images/g.gif\" width=\"60\" height=\"54\" alt=\"\"/>";
		}
		else
		{
			$strResult .= "<img src=\"images/g_blank2.gif\" width=\"60\" height=\"54\" alt=\"\"/>";
		}
	}

	return $strResult;
}

$levelCounter = 0;


function GetPageArray($parent,$arrPages)
{
	
	$arrResult = array();
	if(!isset($arrPages)||!is_array($arrPages))
	{
		return array();
	}
	foreach($arrPages as $arrPage)
	{
		if($arrPage[0] == $parent)
		{
			$arrResult = $arrPage;
			break;
		}
	}
	
	return $arrResult;
}

function IsLastInGroup($pageId, $parent,$arrPages)
{
	
	
		$bResult = false;
	
		
		foreach($arrPages as $arrPage)
		{
		
			if($arrPage[1] == $parent)
			{
			
			 	if($arrPage[0] == $pageId)
				{
					$bResult = true;		
				}
				else
				{
					$bResult = false;		
				}
			
			}
			
						
		}
		
				
		return $bResult;
}


function IsFirstInGroup($pageId, $parent, $arrPages)
{

		$bResult = false;
	
		
		foreach($arrPages as $arrPage)
		{
			if($arrPage[1] == $parent)
			{
			
							if($arrPage[0] == $pageId)
							{
								$bResult = true;		
							}	
							
					break;
			}
					
		}
		
		return $bResult;
}



function WriteLevel($parent, $iLevel, $arrPages)
{

	if(sizeof(GetSubArray($parent,$arrPages)) == 0)
	{
		$arrCurrentPageArray = GetPageArray($parent,$arrPages);
		
		if(isset($arrCurrentPageArray) && sizeof($arrCurrentPageArray))
		{
			echo "<table  cellpadding=0 cellspacing=0><tr><td style=\"padding:0 !important\">".GeneratePrefix($iLevel,$parent)."</td><td valign=bottom style=\"padding:0 !important\">
			
			<div class=\"page-tile blue-back\"  onmousedown=\"javascript:PageClicked(".$parent.",this,event)\"><div class=\"page-tile-text\"><b>".$arrCurrentPageArray[2]."</b>&nbsp;&nbsp;".$arrCurrentPageArray[3]."&nbsp;".$arrCurrentPageArray[4]."&nbsp;".$arrCurrentPageArray[5]."</div></div>
			
			</td>";
			
			
			if
			(
				IsFirstInGroup($arrCurrentPageArray[0], $arrCurrentPageArray[1],$arrPages)
				&&
				IsLastInGroup($arrCurrentPageArray[0], $arrCurrentPageArray[1],$arrPages)
			)
			{
				echo "
					<td style=\"padding:0 !important\" valign=bottom width=40 align=right>&nbsp;</td>
					<td style=\"padding:0 !important\" valign=bottom align=center>&nbsp;</td>
				";
			}
			else
			if(IsFirstInGroup($arrCurrentPageArray[0], $arrCurrentPageArray[1],$arrPages))
			{
				echo "
					<td style=\"padding:0 !important\" valign=bottom width=40 align=right><a href='javascript:MoveDown(".$arrCurrentPageArray[0].")'><img src=\"images/arrow-down.gif\" width=\"8\" height=\"26\" alt=\"\" border=\"0\"/></a></td>
					<td style=\"padding:0 !important\" valign=bottom align=center>&nbsp;</td>
				";
			}
			else
			if(IsLastInGroup($arrCurrentPageArray[0], $arrCurrentPageArray[1],$arrPages))
			{
				echo "
					<td style=\"padding:0 !important\" valign=bottom width=40 align=right><a href='javascript:MoveUp(".$arrCurrentPageArray[0].")'><img src=\"images/arrow-up.gif\" style=\"position:relative;left:-15px;top:-11px\" width=\"8\" height=\"26\" alt='' border=0></a></td>
					<td style=\"padding:0 !important\" valign=bottom  align=center>&nbsp;</td>
				";
			}
			else
			{
			
				echo "
					<td style=\"padding:0 !important\" valign=bottom width=40 align=right><a href='javascript:MoveUp(".$arrCurrentPageArray[0].")'><img src=\"images/arrow-up.gif\" style=\"position:relative;left:-15px;top:-11px\" width=\"8\" height=\"26\" alt='' border=0></a></td>
					<td style=\"padding:0 !important\" valign=bottom width=25><a href='javascript:MoveDown(".$arrCurrentPageArray[0].")'><img src='images/arrow-down.gif' style=\"position:relative;left:5px;top:-10px\" width=8 height=26 alt='' border=0></a></td>
				";
			}
			
			echo "</tr></table>";
		}
	}
	else
	{
		if($parent != 0)
		{
		
			$arrCurrentPageArray = GetPageArray($parent,$arrPages);
			
			echo "<table cellpadding=0 cellspacing=0><tr><td style=\"padding:0 !important\" >".GeneratePrefix($iLevel,$parent)."</td><td style=\"padding:0 !important\" valign=bottom>
			
			<div class=\"page-tile blue-back\"  onmousedown=\"javascript:PageClicked(".$parent.",this,event)\"><div class=\"page-tile-text\"><b>".$arrCurrentPageArray[2]."</b>&nbsp;&nbsp;".$arrCurrentPageArray[3]."&nbsp;".$arrCurrentPageArray[4]."&nbsp;".$arrCurrentPageArray[5]."</div></div>
			
			
			</td>";
			
			if
			(
				IsFirstInGroup($arrCurrentPageArray[0], $arrCurrentPageArray[1],$arrPages)
				&&
				IsLastInGroup($arrCurrentPageArray[0], $arrCurrentPageArray[1],$arrPages)
			)
			{
				echo "
					<td style=\"padding:0 !important\" valign=bottom width=40 align=right>&nbsp;</td>
					<td style=\"padding:0 !important\" valign=bottom align=center>&nbsp;</td>
				";
			}
			else
			if(IsFirstInGroup($arrCurrentPageArray[0], $arrCurrentPageArray[1],$arrPages))
			{
				echo "
					<td style=\"padding:0 !important\" valign=bottom width=40 align=right><a href='javascript:MoveDown(".$arrCurrentPageArray[0].")'><img src='images/arrow-down.gif' style=\"position:relative;left:5px;top:-10px\" width=8 height=26 alt='' border=0></a></td>
					<td style=\"padding:0 !important\" valign=bottom align=center>&nbsp;</td>
				";
			}
			else
			if(IsLastInGroup($arrCurrentPageArray[0], $arrCurrentPageArray[1],$arrPages))
			{
				echo "
					<td style=\"padding:0 !important\" valign=bottom width=40 align=right><a href='javascript:MoveUp(".$arrCurrentPageArray[0].")'><img src=\"images/arrow-up.gif\" style=\"position:relative;left:-15px;top:-11px\" width=\"8\" height=\"26\" alt='' border=0></a></td>
					<td style=\"padding:0 !important\" valign=bottom  align=center>&nbsp;</td>
				";
			}
			else
			{
			
				echo "
					<td style=\"padding:0 !important\" valign=bottom width=40 align=right><a href='javascript:MoveUp(".$arrCurrentPageArray[0].")'><img src=\"images/arrow-up.gif\" style=\"position:relative;left:-15px;top:-11px\" width=\"8\" height=\"26\" alt='' border=0></a></td>
					<td style=\"padding:0 !important\" valign=bottom width=25><a href='javascript:MoveDown(".$arrCurrentPageArray[0].")'><img src='images/arrow-down.gif' style=\"position:relative;left:5px;top:-10px\" width=8 height=26 alt='' border=0></a></td>
				";
			}
			
			echo "</tr></table>";
		}
		
		++$iLevel;
		foreach(GetSubArray($parent,$arrPages) as $levelArray)
		{
			WriteLevel($levelArray[0], $iLevel, $arrPages);
		}
	}
}



WriteLevel("0", 0, $arrPages);

///PAGES STRUCTURE END
?>
	</td>
	
	
	<td width=200>
			&nbsp;
	</td>
	</tr>
</table>


<br>
<br>
<br>

<i>
<?php echo $PAGE_CONTEXT_MENU;?>
</i>

</div>






















