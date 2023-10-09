<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?>
<div class="fright">
	<?php
		

	
	echo LinkTile
	 (
		"links_directory",
		"home",
		$M_DASHBOARD,
		$M_GO_BACK_DASH,
		"green"
	 );
	 
	
?>
</div>
<div class="clear"></div>

<?php

function startsWith($haystack, $needle)
{
    return $needle === "" || strpos($haystack, $needle) === 0;
}


if(true)
{
	
	
	
	echo "<span class=\"medium-font\">".$M_ADD_FIELD."</span>";
		
	///processing
	
	$current_fields = $database->DataArray("fields","cat_id=0");
	
	if(isset($current_fields["fields"]) && is_array(unserialize(stripslashes($current_fields["fields"]))))
	{
		$arrPropertyFields = unserialize(stripslashes($current_fields["fields"]));
	}
	else
	{
		$arrPropertyFields = array();
	}
	

	if(!isset($current_fields["id"])&&isset($_REQUEST["field_name"])&&trim($_REQUEST["field_name"])!="")
	{

		$database->SQLInsert
		(
			"fields",
			array("cat_id","fields"),
			array(0,"")
		);
	}
	

	if(isset($_REQUEST["pdel"]))
	{
		$arrNewPropertyFields = array();
		$iFCounter = 0;
		$f=$_REQUEST["f"];
		foreach($arrPropertyFields as $arrPropertyField)
		{
			if($iFCounter != $f)
			{
				array_push($arrNewPropertyFields, $arrPropertyField);
			}
			$iFCounter++;
		}
		
		$database->SQLUpdate_SingleValue
		(
			"fields",
			"cat_id",
			"0",
			"fields",
			serialize($arrNewPropertyFields)
		);
		
		$current_fields = $database->DataArray("fields","cat_id=0");
	
		if(isset($current_fields["fields"]) && is_array(unserialize(stripslashes($current_fields["fields"]))))
		{
			$arrPropertyFields = unserialize(stripslashes($current_fields["fields"]));
		}
		else
		{
			$arrPropertyFields = array();
		}
		
	}
	else
	if(isset($_REQUEST["pedit"]))
	{
		$arrNewPropertyFields = array();
		$iFCounter = 0;
		$f=$_REQUEST["f"];
		foreach($arrPropertyFields as $arrPropertyField)
		{
			if($iFCounter != $f)
			{
				array_push($arrNewPropertyFields, $arrPropertyField);
			}
			else
			{
				$arrPropertyField[1] = trim($_POST["edit-".$f]);
				array_push($arrNewPropertyFields, $arrPropertyField);
			}
			$iFCounter++;
		}
		
		$database->SQLUpdate_SingleValue
		(
			"fields",
			"cat_id",
			"0",
			"fields",
			serialize($arrNewPropertyFields)
		);
		
		$current_fields = $database->DataArray("fields","cat_id=0");
	
		if(isset($current_fields["fields"]) && is_array(unserialize(stripslashes($current_fields["fields"]))))
		{
			$arrPropertyFields = unserialize(stripslashes($current_fields["fields"]));
		}
		else
		{
			$arrPropertyFields = array();
		}
		
	}
	else
	if(isset($_REQUEST["padd"])&&trim($_REQUEST["field_name"])!="")
	{
		array_push($arrPropertyFields, array($_REQUEST["field_name"],trim($_REQUEST["field_values"])));	
		
		$database->SQLUpdate_SingleValue
		(
			"fields",
			"cat_id",
			"0",
			"fields",
			serialize($arrPropertyFields)
		);
			
		$current_fields = $database->DataArray("fields","cat_id=0");
	
		if(isset($current_fields["fields"]) && is_array(unserialize(stripslashes($current_fields["fields"]))))
		{
			$arrPropertyFields = unserialize(stripslashes($current_fields["fields"]));
		}
		else
		{
			$arrPropertyFields = array();
		}
		
	}

	///end processing
?>

	<br/>
	<br/>
	<br/>
	<form action="index.php" method="post">
	<input type="hidden" name="padd" value="1">
	
	<input type="hidden" name="category" value="<?php echo $category;?>">
	<input type="hidden" name="action" value="<?php echo $action;?>">
	
		<table summary="" border="0" >
			<tr>
				<td><?php echo $NOM;?>:</td>
				<td><input type="text" size="30" name="field_name"></td>
			</tr>
			
			<tr>
				<td><?php echo $M_POSSIBLE_VALUES;?>(*):</td>
				<td><textarea name="field_values" rows="4" cols="30"></textarea></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value=" <?php echo $AJOUTER;?> " class="adminButton"> </td>
				
			</tr>
		   </table>
	<br>
	(*) <?php echo $M_ONE_PER_LINE;?> 
	<br>
	</form>
	
	
	
	
	<?php
	if(sizeof($arrPropertyFields)>0)
	{
	?>
	<br>
	<i><?php echo $M_LIST_FIELDS;?>:</i>
	<br><br>
	<?php
	}
	?>
	<script>
	function SaveEdit(x)
	{
		document.getElementById("edit-form-"+x).submit();
	}
	
	function ShowEdit(x)
	{
		document.getElementById("show-"+x).style.display="none";
		document.getElementById("edit-"+x).style.display="block";
		document.getElementById("edit-link-"+x).style.display="none";
		document.getElementById("save-link-"+x).style.display="block";
	
	}
	</script>
	<table>
	<?php
	
	$iFCounter = 0;
	foreach($arrPropertyFields as $arrPropertyField)
	{
		echo "<tr height=\"38\">";
		
			echo "<td valign=top><a href=\"index.php?category=".$category."&action=".$action."&pdel=1&f=".$iFCounter."\"><img src=\"images/cancel.gif\" alt=\"delete the field\" width=21 height=20 border=0></a></td>";
			echo "<td valign=top>
			
<b>".$arrPropertyField[0]."</b>";	
			
			$strFValues = "";
			
			if(is_array($arrPropertyField[1]))
			{
				$arrFieldValues = $arrPropertyField[1];
			}
			else
			{
				$arrFieldValues = explode("\n", trim($arrPropertyField[1]));
			}
			
			$bF = true;
			
			if(sizeof($arrFieldValues) > 0)
			{
				foreach($arrFieldValues as $strFieldValue)
				{
					if(!$bF)
					{
						$strFValues .= " / ";
					}
					
					$strFValues .= $strFieldValue;
					
					$bF = false;	
				}
			}
			echo "</td><td valign=\"top\">";
			echo '<div style="margin:0" id="show-'.$iFCounter.'">'.$strFValues.'</div>';
			
			echo '<form style="margin:0" id="edit-form-'.$iFCounter.'" action="index.php" method="post">';
			echo '<input type="hidden" name="category" value="'.$category.'">';
			echo '<input type="hidden" name="action" value="'.$action.'">';

			echo '<input type="hidden" name="pedit" value="1">';
			echo '<input type="hidden" name="f" value="'.$iFCounter.'">';
			
			echo '<textarea style="display:none" id="edit-'.$iFCounter.'" name="edit-'.$iFCounter.'" rows="4" cols="30">'.str_replace(" / ","\n",$strFValues).'</textarea>';
			echo '</form>';
			echo "</td>";
			echo "<td valign=\"top\">";
			
			if($strFValues!="")
			{
				echo "<span id=\"edit-link-".$iFCounter."\" style=\"margin-left:20px\">[<a href=\"javascript:ShowEdit(".$iFCounter.")\">".$MODIFY."</a>]</span>";
				echo "<span id=\"save-link-".$iFCounter."\" style=\"display:none;margin-left:20px\">[<a href=\"javascript:SaveEdit(".$iFCounter.")\">".$M_SAVE."</a>]</span>";
			}
			echo "</td>";
				
		echo "</tr>";	
		
		$iFCounter++;		
	}
	
	?>
	</table>
	
		


<?php
}

?>