<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<h3>
	<?php echo $M_LANGUAGE_FILE;?>
</h3>

<br/>

<?php


if(isset($_POST["poceed_save_file"]))
{
	$content_language_file="";
	
	foreach($_POST as $key=>$value)
	{
		if($key=="poceed_save_file"||$key=="category"||$key=="action")
		{
				continue;
		}

		$content_language_file.='$'.$key.'="'.$value.'";';
		$content_language_file.="\n";
	}
	
	$handle = fopen("../include/texts_en.php", 'w');
	fwrite($handle, "<?php\n".stripslashes(stripslashes(trim($content_language_file)))."\n?>");
	fclose($handle);
	
}

?>


<form action="index.php" method="post">
<input type="hidden" name="poceed_save_file" value="1"/>
<input type="hidden" name="category" value="<?php echo $category;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<?php

$language_file=file_get_contents("../include/texts_en.php");
$language_file=str_replace("<?php","",$language_file);
$language_file=str_replace("?>","",$language_file);
$file_lines=explode("\";",$language_file);

foreach($file_lines as $file_line)
{
	if(trim($file_line)=="") continue;
	
	$line_items = explode("=",$file_line,2);	
	
	if(isset($line_items[0])&&isset($line_items[1]))
	{
		$var_name = str_replace("$","",$line_items[0]);
		$var_value = str_replace("\"","",$line_items[1]);
		
		$pos_seo = strpos($var_name, "_SEO");
		
		if($pos_seo!==false)
		{
			echo '<input type="hidden" style="width:60%" name="'.trim($var_name).'" value="'.trim($var_value).'"/>';
		}
		else
		{
			$var_name=trim($var_name);
			$var_value=trim($var_value);
			
			$pos_new_list = strpos($var_value, "\n");
			if($pos_new_list!==false||strlen($var_value)>75)
			{
				echo '<textarea rows="4" style="width:60%" name="'.$var_name.'">'.$var_value.'</textarea>';
				echo '<span style="color:#999999;margin-left:20px;font-size:12px">['.$var_name.']</span>';
				echo '<br/><br/>';	
			}
			else
			{
				echo '<input type="text" style="width:60%" name="'.trim($var_name).'" value="'.trim($var_value).'"/>';
				echo '<span style="color:#999999;margin-left:20px;font-size:12px">['.$var_name.']</span>';
				echo '<br/><br/>';
			}
		}
	}
	
	
}

?>
<br/>
<input type="submit" value=" <?php echo $M_SAVE;?> " class="btn btn-primary"/>
</form>