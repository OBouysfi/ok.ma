<?php
// Jobs Portal All Rights Reserved
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
				"extensions",
				"tags",
				$M_TAGS,
				"",
				"green"
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



<br/>
<span class="medium-font"><?php echo $M_CURRENT_EXTENSION_FILES;?></span>


<br/><br/>
<table width="100%">
		<?php
		$handle=opendir('../extensions');

		while ($file = readdir($handle)) 
		{
		    if ($file != "." && $file != "..") 
			{
				echo "<tr height=\"30\">";
				
				echo "
				
				<td width=\"250\">
					<b><font class=hl_text>".strtoupper(str_replace(".php","",$file))."</font></b> &nbsp;&nbsp;&nbsp;
				
				</td>
				<td width=250 align=right>
				[".round(filesize("../extensions/".$file)/1000)."KB]
				</td>
				<td width=20>&nbsp;</td>
				<td>
				".date ("F d Y H:i:s.", filemtime('../extensions/'.$file))."
				</td>
				
				";
				
				echo "</tr>";
 		   }
		}
		?>
</table>
<br/><br/>
<?php echo $IN_ORDER_TO;?>
		

