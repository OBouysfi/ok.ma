<?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="fright">
	<?php
	echo LinkTile
	 (
		"profile",
		"edit",
		$EDIT_YOUR_PROFILE,
		"",
		"green"
	 );
	 
	echo LinkTile
	 (
		"cv",
		"description",
		$EDIT_YOUR_CV,
		"",
		"yellow"
	 );
?>
</div>
<div class="clear"></div>
<br/>
<h3><?php echo $M_JOB_PREFERENCES;?></h3>
<i>
	<?php echo $M_PREFERRED_JOB_CATEGORIES;?>
</i>
<br/><br/>
<?php

if(isset($_POST["proceed_save"]))
{
	$database->SQLUpdate
	(
		"jobseekers",
		array("industry_sector","preferred_locations","profile_description","experience","availability","job_type"),
		array( (isset($_POST["industry_sector"])?serialize($_POST["industry_sector"]):"") ,(isset($_POST["preferred_locations"])?serialize($_POST["preferred_locations"]):""),$_POST["profile_description"],$_POST["experience"],$_POST["availability"],$_POST["job_type"]),
		"username='".$AuthUserName."'"
	);
	
	$arrUser = $database->DataArray("jobseekers","username='".$AuthUserName."'");
}

?>

<form action="index.php" method="post">
<input type="hidden" name="proceed_save" value="1"/>
<input type="hidden" name="category" value="<?php echo $category;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<br/>
<h4><?php echo $BRIEFLY_DESCRIBE;?>:</h4>

<br/><br/>
<textarea id="profile_description" name="profile_description" rows="10" cols="70"><?php echo stripslashes($arrUser["profile_description"]);?></textarea>

<br/>
<br/>


  <i><?php echo $M_JOB_TYPE;?>:</i>
  <br><br>

	<select name="job_type" style="width:300px">
	<?php 
	
		foreach($website->GetParam("arrJobTypes") as $key=>$value)
		{
			echo '<option '.($arrUser["job_type"]==$key?"selected":"").' value="'.$key.'">'.$value.'</option>';
		}
	?>
	</select>
   
	<br><br>

  
  <i><?php echo $M_EXPERIENCE;?>:</i>
  <br><br>

	<select name="experience" style="width:300px">
	<?php 
		foreach($website->GetParam("arrExperienceLevels") as $key=>$value)
		{
			echo '<option '.($arrUser["experience"]==$key?"selected":"").' value="'.$key.'">'.$value.'</option>';
		}
		
	?>
	</select>
   
	<br><br>
  
  <i><?php echo $M_AVAILABILITY;?>:</i>
  <br><br>

	<select name="availability" style="width:250px">
	<?php 
	
		foreach($website->GetParam("arrAvailabilityTypes") as $key=>$value)
		{
			echo '<option '.($arrUser["availability"]==$key?"selected":"").' value="'.$key.'">'.$value.'</option>';
		}
	?>
	</select>
   
	<br><br>



    
	
	<?php
	
	  	$arrSelectedCategories = array(); 
		$arrSelectedLocations = array(); 
		$strLevelExperience = $arrUser["level_experience"]; 
		
		if($arrUser["industry_sector"] != "")
		{
			$arrSelectedCategories = unserialize($arrUser["industry_sector"]); 
		}
	   
   
	   if($arrUser["preferred_locations"] != "" && is_array(unserialize($arrUser["preferred_locations"])))
		{
		
			$arrSelectedLocations = unserialize($arrUser["preferred_locations"]); 
		}
	
	?>
	
	<br/>

	<h4>
		<?php echo $M_PREFERRED_LOCATIONS;?>
	</h4>
	   
	 <div class="clear"></div>
  <br/>
  
  <?php
$iCounter = 0;	
include_once("../locations/locations_array.php");

foreach($loc as $key=>$value)
{
	if(!is_string($value)) continue;
	
	
	echo "<div class=\"col-md-2 col-sm-3\">\n";
	
	echo "\n <input type=\"checkbox\" ".(in_array(trim($key), $arrSelectedLocations)?"checked":"")." value=\"".trim($key)."\" name=\"preferred_locations[]\"> ".trim($value);
		
	echo "</div>\n";
	
	
	$iCounter ++;
}
	
?>
    
    <div class="clear"></div>
	 <br/>
	  <br/>
	  <h4><?php echo $M_JOB_CATEGORIES;?></h4>
	  <br>
	
	   <?php
	  

	   if(!is_array($arrSelectedCategories))
	   {
	   		$arrSelectedCategories=array();
	   }
	  
	   
	   $iCounter = 0;
	   
	   global $lines;
						

	if(file_exists('../categories/categories_'.strtolower($website->lang).'.php'))
	{
		$lines = file('../categories/categories_'.strtolower($website->lang).'.php');
	}
	else
	{
		$lines = file('../categories/categories_en.php');
	}
	
	$arrCategories = array();
	
	foreach ($lines as $line_num => $line) 
	{
		if(trim($line) != "")
		{
			$arrLine = explode(".",$line);
			if(sizeof($arrLine) == 2)
			{
				$arrCategories[trim($arrLine[0])] = trim($arrLine[1]);			
			}
		}
	}

	asort($arrCategories);
						
						
	while (list($key, $val) = each($arrCategories)) 
	{
	
		$arr_sub_cats = get_sub_cats($key,$lines);
		echo "<div class=\"col-md-3 col-sm-4\">";
		
		echo " 
		<h5>
		<input type=\"checkbox\" ".(in_array(trim($key), $arrSelectedCategories)?"checked":"")." value=\"".trim($key)."\" name=\"industry_sector[]\">
		".$val."</h5>";
			
		if(sizeof($arr_sub_cats)>0)
		
		{
			while (list($s_key, $s_val) = each($arr_sub_cats)) 
			{
				echo "
				<span class=\"left-margin-30px small-font\">
				<input type=\"checkbox\" ".(in_array(trim($s_key), $arrSelectedCategories)?"checked":"")." value=\"".trim($s_key)."\" name=\"industry_sector[]\">
				".$s_val."</span>";
				echo "<br>";
				
			}
			$iCounter ++;
		}
		
		echo "</div>";
		
		if($iCounter%4==0)
		{
			echo "<div class=\"clear\"></div>";
		}
	}
				
		?>
	   
	<div class="clear"></div>		
	<br/>
	<input type="submit" class="btn btn-lg btn-primary pull-right" value=" <?php echo $SAUVEGARDER;?> "/>
	
</form>
