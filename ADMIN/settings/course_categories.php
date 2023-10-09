
<div class="fright">
	<?php
			 
	echo LinkTile
	 (
		"settings",
		"options",
		$M_CONFIGURATION_OPTIONS,
		"",
		"blue"
	 );
?>
</div>
<div class="clear"></div>
<span id="page-header" class="medium-font">
<?php echo $M_COURSE_CATEGORIES;?>
</span>
<br/>

<form action="index.php" method="post">
<input type="hidden" name="category" value="<?php echo $category;?>">
<input type="hidden" name="action" value="<?php echo $action;?>">
<input type="hidden" name="ProceedSend" value="1">


<?php

$current_languages = $database->DataTable("languages","ORDER BY id");
$arr_languages = array();
while($current_language = $database->fetch_array($current_languages))
{
	if(file_exists('../categories/course_categories_'.strtolower($current_language["code"]).'.php'))
	{
		array_push($arr_languages, strtolower($current_language["code"]) );
	}
}

if(isset($_REQUEST["ProceedSend"]))
{
	foreach($arr_languages as $str_lang)
	{
		$cats=stripslashes(stripslashes($_POST["cats_".$str_lang]));
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
		$cats=str_replace("  "," ",$cats);
		
		
		
		$handle = fopen('../categories/course_categories_'.$str_lang.'.php', 'w');
		fwrite($handle, trim($cats));
		fclose($handle);
		
		$arrLines = explode("\n",trim($cats));
		
		ob_start();
		include("../categories/generator.php");
		$NEW_ARRAY_CODE = ob_get_contents();
		ob_end_clean();
		
		$handle = fopen('../categories/course_categories_array_'.$str_lang.'.php', 'w');
		fwrite($handle,$NEW_ARRAY_CODE);
		fclose($handle);
		
	}
	?>
	<script>
	document.getElementById("page-header").innerHTML="<?php echo $M_NEW_VALUES_SAVED;?>";
	</script>
	<?php
	
}

	
	foreach($arr_languages as $str_lang)
	{
		$code = "";
	
		if(file_exists('../categories/course_categories_'.$str_lang.'.php'))
		{
			$lines = file('../categories/course_categories_'.$str_lang.'.php');
			
			foreach ($lines as $line_num => $line) 
			{
				$code .= $line;
			}

			?>
			<br>
			<?php echo $M_CATEGORIES;?> [<?php echo strtoupper($str_lang);?>]
			<br>
			<textarea name="cats_<?php echo $str_lang;?>" cols="80" rows="15"><?php echo $code;?></textarea>
			<br>
			
			
			<?php

		}
				
	}

?>
<br>
<input type="submit" class="adminButton" value=" <?php echo $M_SAVE;?> "> 
</form>
