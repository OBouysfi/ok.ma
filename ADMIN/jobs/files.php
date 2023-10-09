<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?><TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width="100%">
	<TR>
		<td class=basicText>
				
				
				
				<table summary="" border="0">
				  	<tr>
				  		
				  		<td class=basictext><b>
						
						Files uploaded by the jobseekers
						
						</b></td>
				  	</tr>
				  </table>
	  <br>
				<center>
				<?php
				
			 RenderTable(
						"files",
						array("file_id","user","file_date","file_size","file_name","description"),
						array($M_OPEN,"User",$DATE_MESSAGE,$SIZE,$NOM,$DESCRIPTION),
						700,
						"",
						$EFFACER,
						"file_id",
						"index.php?category=$category&action=$action"
						);
				?>
				</center>
				<br>
		</td>
	</tr>
	</table>

