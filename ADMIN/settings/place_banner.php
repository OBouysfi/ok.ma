<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?>	
<div class="fright">
<?php
	
	echo LinkTile
	 (
		"settings",
		"banners",
		$M_GO_BACK,
		"",
		
		"red"
	 );
	 
	echo LinkTile
	 (
		"settings",
		"add_banner_area",
		$M_NEW_B_AREA,
		$M_ADD_NEW_AREA,
		
		"green"
	 );
	
?>

</div>

<div class="clear"></div>

<i>
	<?php echo $M_SELECT_BANNER_AREA;?>:
</i>


<br><br><br>

<?php
		
$tableAreas = $database->DataTable("banner_areas","");

while($arrArea = $database->fetch_array($tableAreas))
{
?>

<table summary="" border="0" width="100%">
	<tr>
		<td>
		
				<b>
				[<?php echo $M_AREA;?> #<?php echo $arrArea["id"];?>] 
				<?php
				echo $arrArea["name"];
				?>
				</b>
		
		</td>
		<td align="right">
		<b>
		<?php
		
		if($database->SQLCount("banners","WHERE banner_type=".$arrArea["id"]) < ($arrArea["rows"]*$arrArea["cols"]))
		{
		?>
		
				<a href="index.php?category=<?php echo $category;?>&action=add_banner&area_id=<?php echo $arrArea["id"];?>">[<?php echo strtoupper($M_SELECT);?>]</a>
		<?php
		}
		else
		{
		?>
		
		<span class="red-font"><?php echo $M_SOLD_OUT;?></span>
		
		<?php
		}
		?>		
				
		</b>
		</td>
	</tr>
</table>

<hr width="100%">

<i>
<?php
echo $arrArea["description"];
?>
</i>
<br><br>
<?php echo $M_TOTAL_BANNERS_AREA;?>: <b><?php echo $arrArea["rows"]*$arrArea["cols"];?> </b>
<span style="font-size:9px">[<?php echo $arrArea["rows"];?> <?php echo $M_ROWS;?> X <?php echo $arrArea["cols"];?> <?php echo $M_COLUMNS;?>]</span>
&nbsp;
<?php echo $M_BANNER_SIZE;?>: <b><?php echo $arrArea["width"];?>px</b> X <b><?php echo $arrArea["height"];?>px</b>
&nbsp;
<?php echo $M_PRICE;?>: <b><?php echo $website->GetParam("WEBSITE_CURRENCY").$arrArea["price"];?></b>
&nbsp;
<?php echo $M_DAYS2;?>: <b><?php echo $arrArea["days"];?></b>

<br><br><br>
<?php
}

?>
		
		
		
		