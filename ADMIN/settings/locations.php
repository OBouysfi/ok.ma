
<div class="fright">
	<?php
			 
	echo LinkTile
	 (
		"settings",
		"categories",
		$M_CONFIGURATION_OPTIONS,
		"",
		"blue"
	 );
	 
	 echo LinkTile
	 (
		"settings",
		"categories",
		$M_CATEGORIES,
		"",
		"yellow"
	 );
?>
</div>
<div class="clear"></div>
<span id="page-header" class="medium-font">
<?php echo $M_MODIFY_LOCATIONS;?>
</span>
<br/><br/>

<form action="index.php" method="post">
<input type="hidden" name="category" value="<?php echo $category;?>">
<input type="hidden" name="action" value="<?php echo $action;?>">
<input type="hidden" name="ProceedSend" value="1">


<?php

if(!is_writable("../locations"))
{
	echo "<i>Please set write permissions of the locations folder before continue with updating the locations</i><br><br>";
}



if(isset($_REQUEST["ProceedSend"]))
{
	if(!is_writable('../locations/locations.php') || !is_writable('../locations/locations_array.php'))
	{
	
	}
	else
	{
		$current_time=time();
		copy( '../locations/locations.php'  , '../locations/'.$current_time.'_locations.php' );
		copy( '../locations/locations_array.php'  , '../locations/'.$current_time.'_locations_array.php' );
		$cats=stripslashes(stripslashes($_POST["cats"]));
		if(!preg_match("/[0-9]+/", $cats)) 
		{
			$new_ct="";
			$arrLines = explode("\n",$cats);			
			$iCounter=1;
			foreach($arrLines as $strLine)
			{
				$new_ct.=$iCounter.". ".trim($strLine)."\n";
				$iCounter++;
			}
			$cats=trim($new_ct);
		} 
		
		$cats=str_replace("\t","",$cats);
		$pattern = '/([\d.]+)/i';
		$replacement = '${1} ';
		$cats=preg_replace($pattern, $replacement, $cats);
		$cats=str_replace("  "," ",$cats);
		
		
		$handle = fopen('../locations/locations.php', 'w');
		fwrite($handle, trim($cats));
		fclose($handle);
		
		$arrLines = explode("\n",trim($cats));
		
		ob_start();
		include("../locations/generator.php");
		$NEW_ARRAY_CODE = ob_get_contents();
		ob_end_clean();
		
		$handle = fopen('../locations/locations_array.php', 'w');
		fwrite($handle,$NEW_ARRAY_CODE);
		fclose($handle);
	}
	
}

	
	$code = "";
	
	if(file_exists('../locations/locations.php'))
	{
		$lines = file('../locations/locations.php');
		
		foreach ($lines as $line_num => $line) 
		{
			
				$code .= $line;
			
		}

		?>

		<textarea name="cats" cols="90" rows="15"><?php echo $code;?></textarea>
		
		
		
		<?php
	
	}
			

?>
<br>
<input type="submit" class="adminButton" value=" <?php echo $M_SAVE;?> "> 
</form>
