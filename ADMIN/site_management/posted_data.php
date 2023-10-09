<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");?>


<div class="fright">

	<?php
		echo LinkTile
				 (
					"site_management",
					"manage",
					$M_MANAGE_THE_FORMS,
					"",
					"blue"
				 );
	?>
</div>
<div class="clear"></div>		
		<?php
		if($database->SQLCount("forms_data","") == 0)
		{
			echo "<span class=\"medium-font\">".$M_NO_NEW_MESSAGES."</span>";
		}
		else
		{
		?>
		
		<br/>
		<br/>
		
		<table width="100%">
		<?php
		$dataTable = $database->DataTable("forms","");
		
		echo "
				<tr>
				<td colspan=\"2\"><i>".$M_DATA_POSTED."</i></td>
				
				<td><i>".$NOM."</i></td>
				
				<td><i>".$M_TOTAL_POSTS."</i></td>
				<td><i>".$M_LAST_POST."</i></td>
							
				<tr>
			";				
		while($arrTable = $database->fetch_array($dataTable))
		{
			$arrPageItems = explode("_", $arrTable["page"]);
			
			if(sizeof($arrPageItems) == 2)
			{
			
			}
			else
			{
				continue;
			}
			echo "
				
				<tr>
				
					<td ><a href=\"index.php?category=$category&folder=$action&page=view&id=".$arrTable["id"]."\">[".$M_VIEW_POSTED_DATA."]</a></td>
					<td> </td>
					<td>".$arrTable["name"]."</td>
					
					<td>".$database->SQLCount("forms_data","WHERE form_id=".$arrTable["id"]." ")."</td>
					<td>".$database->getSingleValue("forms_data","form_id",$arrTable["id"]." ORDER BY id desc","date")."</td>
				
				</tr>
			
			";
		}
		
		?>
		
		</table>
		
		<?php
		}
		?>
	