<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<?php

if(isset($Delete)){
	
	if(sizeof($CheckList)>0)
	{
	
		SQLDelete("intranet_documents","id",$CheckList);
	
	}

}

?>
	<br>
				<table summary="" border="0" width=750>
				  	<tr>
				  		
				  		<td class=basictext><b>
						
						<?php echo $ADD_NEW_DOCUMENT;?>
						
						</b></td>
				  	</tr>
				  </table>
	  <br>

<?php
AddNewForm(
		array($M_TITLE.":",$DESCRIPTION.":",$FILE.":"),
		array("title","description","file_id"),
		array("textbox_54","textarea_40_5","file"),
		$AJOUTER,
		"intranet_documents",
		$DOCUMENT_ADDED_SUCCESSFULY
	);
?>

<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width=750>
	<TR>
		<td class=basicText>
				<br><br>
				
				
				<table summary="" border="0">
				  	<tr>
				  		
				  		<td class=basictext><b>
						
						<?php echo $LIST_AVAILABLE_DOCUMENTS;?>
						
						</b></td>
				  	</tr>
				  </table>
	  <br>
				<center>
				<?php
					
					$oCol=array("file_name","title","description","file_id");
					$oNames=array($NOM,$M_TITLE,$DESCRIPTION,$FILE);
					$ORDER_QUERY="";
					RenderTable("intranet_documents,".$DBprefix."intranet_files",$oCol,$oNames,750,"WHERE ".$DBprefix."intranet_documents.file_id=".$DBprefix."intranet_files.file_id ",$EFFACER,"id","index.php?action=$action&category=".$category);
		
				?>
				</center>
				<br>
		</td>
	</tr>
	</table>




