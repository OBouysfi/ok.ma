<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
$arrTags = unserialize($website->params[100]);

?>

<div class="fright">

	<?php
		echo LinkTile
			 (
				"extensions",
				"extensions",
				$M_FILES,
				"",
				"blue"
			 );
	
		echo LinkTile
			 (
				"home",
				"modules",
				$M_MODULES,
				"",
				"red"
			 );
	?>
		
</div>
<div class="clear"></div>

<script>
function DeleteTag(strTag)
{
	if(confirm("Are you sure that you want to delete this tag?"))
	{
		document.location.href="index.php?category=extensions&action=tags&ProceedDelete="+strTag;
	}
	
}
</script>
<?php
if(isset($_REQUEST["ProceedDelete"]))
{
	$arrTags = unserialize($website->params[100]);
	$arrNewTags = array();
	
	foreach($arrTags as $arrTag)
	{
		if(strtolower($arrTag[0]) != strtolower($_REQUEST["ProceedDelete"]))
		{
			array_push($arrNewTags, $arrTag);	
		}
	}
	$database->SetParameter(100, serialize($arrNewTags));
	
	$arrTags = $arrNewTags;
	
}
else
if(isset($_REQUEST["ProceedAdd"]))
{
	$arrTags = unserialize($website->params[100]);
	array_push($arrTags, Array($_REQUEST["tag_name"],"none"));	
	$database->SetParameter(100, serialize($arrTags));
}
else
if(isset($_REQUEST["ProceedChange"])&&isset($_REQUEST["tag_name"]))
{
	$arrTags = Array();
	
	$tag_name = $_REQUEST["tag_name"];
	$file_to_use = $_REQUEST["file_to_use"];
	
	for($i=0;$i<sizeof($tag_name);$i++)
	{
		array_push($arrTags,Array($tag_name[$i],$file_to_use[$i]));
	}
	$database->SetParameter(100, serialize($arrTags));
	
	
}
?>

	
<span class="medium-font"><?php echo $ADD_NEW_TAG;?></span>

	<br><br>
	
	<table summary="" border="0">
	 	<tr>
			
	 		<form action="index.php" method="get">
			<input type="hidden" name="ProceedAdd" value="1"/>
			<input type="hidden" name="category" value="extensions"/>
			<input type="hidden" name="action" value="tags"/>
			
	 		<td ><?php echo $TAG_NAME;?>:
			<br>
		
			</td>
	 		<td class=basictext><input type="text" name="tag_name" size="20"/> </td>
			<td><input type="submit" value=" <?php echo $AJOUTER;?> " class="adminButton"/></td>
			</form>
	 	</tr>
	 </table>
 
	 
	<br><br><br>
<span class="medium-font" id="tags-header">

<?php 

if(isset($_REQUEST["ProceedChange"]))
{
	echo $M_NEW_VALUES_SAVED;
}
else
{
	echo $LIST_CUSTOM_TAGS;
}
?>

</span>
<br><br>
<center>
<form action="index.php" method=post>
<input type=hidden name=ProceedChange>
<input type=hidden name=category value="<?php echo $category;?>">
<input type=hidden name=action value="<?php echo $action;?>">

<?php

$selectHTML ="<option>none</option>";
$arrFiles = array("none");
$handle=opendir('../extensions');
		
		while ($file = readdir($handle)) 
		{
		    if ($file != "." && $file != "..") 
			{
				array_push($arrFiles, $file);
		   }
		}


echo "<table width=\"100%\">";
						
						
foreach($arrTags as $arrTag)
{

	if(trim($arrTag[0]) == "")
	{
		continue;
	}
	echo "
				
					<tr>
						<td class=basictext><b><font class=hl_text>".strtoupper($arrTag[0])."</font></b></td> 
							<td width=\"250\"><font face=Courier color=black>&lt;site ".$arrTag[0]."/></font></td>
							<td class=basictext>$FILE: 
							<input type=hidden name=\"tag_name[]\" value=\"".$arrTag[0]."\">
							<select name=\"file_to_use[]\" style=\"width:200px\">
			";
					foreach($arrFiles as $strFile)
					{
						$tag_word_post = strpos($strFile,"_tag");
						
						if($tag_word_post !== false)
						{
							echo "<option ".($strFile==$arrTag[1]?"selected":"").">".$strFile."</option>";
						}
					}						
							
			echo "		</select></td>
							<td width=30 align=right valign=middle>
							<a href=\"javascript:DeleteTag('".$arrTag[0]."')\"><img src=\"images/cancel.gif\" alt=\"delete the custom tag\" width=21 height=20 border=0></a>
							</td>
						</tr>
				
					
				
			";
			
}

echo "</table>";

if(sizeof($arrTags) < 1)
{
	echo "<b>".$NO_CUSTOM_TAGS_AV."</b>";
}
else
{
?>
<br/>

<input type="submit" value=" <?php echo $M_UPDATE;?> " class="adminButton fright"/>		
	
<?php
}
?>	


</form>
</center>
<br>
<span class="medium-font"><?php echo $LIST_STANDART_TAGS;?></span>
<br><br>
<table summary="" border="0" width=750>
	<tr>
		<td width=215><font face=Courier color=black>&lt;site title/></font></td>
		
		<td class=basictext><?php echo $TITLE_OF_THE_PAGE;?></td>
	</tr>
	<tr>
		<td width=215><font face=Courier color=black>&lt;site description/></font></td>
		
		<td class=basictext> <?php echo $META_DESCRIPTION_PAGE;?></td>
	</tr>
	<tr>
		<td width=215><font face=Courier color=black>&lt;site keywords/></font></td>
		
		<td class=basictext><?php echo $META_KEYWORDS_PAGE;?></td>
	</tr>
	<tr>
		<td width=215><font face=Courier color=black>&lt;site menu/></font></td>
		
		<td class=basictext><?php echo $MAIN_N_MENU;?></td>
	</tr>
	<tr>
		<td width=215><font face=Courier color=black>&lt;site languages_menu/></font></td>
		
		<td class=basictext><?php echo $LANGUAGES_MENU_WEBSITE;?> </td>
	</tr>
	<tr>
		<td width=215><font face=Courier color=black>&lt;site content/></font></td>
		
		<td class=basictext><?php echo $MAIN_CONTENT_PAGE;?> </td>
	</tr>
	<tr>
		<td width=215><font face=Courier color=black>&lt;site form/></font></td>
		
		<td class=basictext><?php echo $CUSTOM_SS_FORMS;?></td>
	</tr>
	
</table>

	
