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
			"users",
			"empl_fields",
			$M_EMPLOYER_FIELDS,
			"",
			
			"lila"
		 );
		 
		 
		echo LinkTile
		 (
			"jobs",
			"fields",
			$M_JOBS." ".$M_FIELDS,
			"",
			
			"blue"
		 );
?>
</div>
<div class="clear"></div>

<h3><?php echo $M_CUSTOM_DEFINED_FIELDS_JOBSEEKER;?></h3>

<?php
$strCValue=aParameter(260);

if(is_array(unserialize(stripslashes($strCValue))))
{
	$arrUserFields = unserialize(stripslashes($strCValue));
}
else
{
	$arrUserFields = array();
}


if(isset($_REQUEST["pdel"]))
{
	$arrNewUserFields = array();
	$iFCounter = 0;
	foreach($arrUserFields as $arrUserField)
	{
		if($iFCounter != $_REQUEST["f"])
		{
			array_push($arrNewUserFields, $arrUserField);
		}
		$iFCounter++;
	}
	
	$database->SetParameter
	(
	260,
	serialize($arrNewUserFields)
	);
	
		
	$arrUserFields = $arrNewUserFields;
	
}
else
if(isset($_REQUEST["padd"])&&trim($_REQUEST["field_name"])!="")
{
	array_push($arrUserFields, array($_REQUEST["field_name"],"",trim($_REQUEST["field_values"])));	
	
	$database->SetParameter
	(
		260,
		serialize($arrUserFields)
	);
	
}

?>

		
			<i><?php echo $M_ADD_NEW_FIELD;?></i>
			<br><br>
			
			<form action="index.php" method="post">
			<input type="hidden" name="padd" value="1">
		
			<input type="hidden" name="category" value="<?php echo $category;?>">
			<input type="hidden" name="action" value="<?php echo $action;?>">
			
				<table summary="" border="0" >
				   	<tr>
				   		<td><?php echo $NOM;?>:</td>
				   		<td><input type=text size=40 name="field_name"></td>
				   	</tr>
				   	<tr style="display:none">
				   		<td><?php echo $M_SIZE_PX;?>:</td>
				   		<td><input type=text size=5 name="field_size" value="120"></td>
				   	</tr>
				   	<tr>
				   		<td><?php echo $M_POSSIBLE_VALUES;?>(*):</td>
				   		<td><textarea name="field_values" rows="4" cols="40"></textarea></td>
				   	</tr>
					<tr>
				   		<td colspan="2"><input type="submit" value=" <?php echo $AJOUTER;?> " class="btn btn-primary"/> </td>
				   		
				   	</tr>
				   </table>
			<br>
			(*) <?php echo $M_ONE_PER_LINE_DROP;?>
			<br>
			</form>
			
			
			<br/><br/>
			<i><?php echo $M_LIST_FIELDS_JOBSEEKERS;?>:</i>
			<br><br>
			
			<table>
			<?php
			
			$iFCounter = 0;
			foreach($arrUserFields as $arrUserField)
			{
				echo "<tr>";
				
					echo "<td><a href=\"index.php?category=".$category."&action=".$action."&pdel=1&f=".$iFCounter."\"><img src=\"images/cancel.gif\" alt=\"delete the field\" width=21 height=20 border=0></a></td>";
					echo "<td><b>".$arrUserField[0]."</b></td>";	
					echo "<td></td>";	
					
					$strFValues = "";
					
					$arrFieldValues = explode("\n", trim($arrUserField[2]));
					
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
					
					echo "<td>".$strFValues."</td>";
					
				echo "</tr>";	
				
				$iFCounter++;		
			}
			
			?>
			</table>
		
