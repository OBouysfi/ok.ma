<?php
if(!defined('IN_SCRIPT')) die("");
?>
<?php
$arrFieldsToSkip = array("employer","date","places","featured","featured_expires","expires","contact_person","more_fields");

if(isset($_POST["Export"]))
{
	header("Location: jobs/export.php?fs=".implode("-",$_POST["exp_fields"]));
}


if(isset($_POST["show"]) && $_POST["show"] ==1)
{



	if(isset($_POST["proceed"]))
	{

		$importedCounter=0;

		$deletedCounter=0;
		$expiredCounter=0;

		if(!$website->GetParam("FREE_WEBSITE"))
		{
			$arrPackageEmployer = $database->DataArray("packages_employer","id=$selected_package AND employer='".$AuthUserName."'");
		}
				
			foreach($import_ids as $import_id)
			{
			
					if(get_param("import".$import_id) == "0")
					{
					
					}
					else
					if(get_param("import".$import_id) == "1")
					{
							
							if(!$website->GetParam("FREE_WEBSITE"))
							{
											if($importedCounter >= $arrPackageEmployer["ads"])
											{
												continue;
											} 
							}
							
							
							
							$insert_id=$database->Query
							(
								"
									INSERT INTO ".$DBprefix."jobs(date,employer,job_category,region,title,message,active,notification,contact_person,places,featured,expires,zip,job_type,featured_expires,salary,date_available)
									SELECT date,employer,job_category,region,title,message,active,notification,contact_person,places,featured,expires,zip,job_type,featured_expires,salary,date_available FROM ".$DBprefix."imported_ads
									WHERE id=".$import_id." 
									AND employer='".$AuthUserName."' 
								 "
							) ;
							
							
						
							if($website->GetParam("FREE_WEBSITE"))
							{
										$database->Query
											(
												"UPDATE ".$DBprefix."jobs
													SET 
														date=".(time()).",
														expires=".(time() + $website->GetParam("FREE_WEBSITE_ADS_EXPIRE_DAYS")*86400)."
													WHERE id=".$insert_id."
											");
							}
							else
							{
							
											$database->Query
											(
												"UPDATE ".$DBprefix."jobs
													SET 
														date=".(time()).",
														expires=".(time() + $arrPackageEmployer["valid"]*86400)."
													WHERE id=".$insert_id."
											");
							}
										
							$database->Query("DELETE FROM ".$DBprefix."imported_ads WHERE id=".$import_id." AND employer='".$AuthUserName."' ");	
						
							
							$importedCounter++;
							
					}
					else
					if(get_param("import".$import_id) == "2")
					{
							$database->Query("DELETE FROM ".$DBprefix."imported_ads WHERE id=".$import_id." AND employer='".$AuthUserName."' ");
							$deletedCounter++;
					}
					else
					if(get_param("import".$import_id) == "3")
					{
						
							$insert_id=$database->Query
							(
								"
									INSERT INTO ".$DBprefix."jobs(date,employer,job_category,region,title,message,active,notification,contact_person,places,featured,expires,zip,job_type,featured_expires,salary,date_available)
									SELECT date,employer,job_category,region,title,message,active,notification,contact_person,places,featured,expires,zip,job_type,featured_expires,salary,date_available FROM ".$DBprefix."imported_ads
									WHERE id=".$import_id." 
									AND employer='".$AuthUserName."' 
								 "
							) ;
						
							$database->Query
							(
								"UPDATE ".$DBprefix."jobs
									SET 
										date=".(time()-1).",
										expires=".(time()-1)."
									WHERE id=".$insert_id."
							") ;
										
							$database->Query("DELETE FROM ".$DBprefix."imported_ads WHERE id=".$import_id." AND employer='".$AuthUserName."' ");	
						
						
							$expiredCounter=0;
					}
					
						
			}


		if(!$website->GetParam("FREE_WEBSITE") && $importedCounter>0)	
		{
						$database->SQLUpdate_SingleValue
						(
										"packages_employer",
										"id",
										$selected_package,
										"ads",
										(intval($arrPackageEmployer["ads"])-$importedCounter)
						);
		}
					
					
		echo "<table width=\"100%\"><tr><td>";

		if($importedCounter>0)
		{
			echo "<a href=\"index.php?category=jobs&action=my\"><i><b>".$importedCounter."</b> ".$M_ADS_POSTED_SUCCESS.".</i></a><br><br>";
		}

		if($deletedCounter>0)
		{
			echo "<i><b>".$deletedCounter."</b> ".$M_ADS_DELETED_SUCCESS.".</i><br><br>";
		}

		if($expiredCounter>0)
		{
			echo "<i><b>".$expiredCounter."</b> ".$M_ADS_SET_EXPIRED_SUCCESS.".</i><br><br>";
		}			
					
		echo "</td></tr></table>";		
									
	}

	?>

	<table summary="" border="0" width="100%">
		<tr>
			<td>
			<form action="index.php" method="post" enctype="multipart/form-data">
					<input type="hidden" name="category" value="<?php echo $_REQUEST["category"];?>">
					<input type="hidden" name="folder" value="my">
					<input type="hidden" name="page" value="export">
					<input type="hidden" name="show" value="1">
					<input type="hidden" name="proceed" value="1">

							
					
			
					<br style="line-height:4px">
					<i><?php echo $M_ADS_TO_BE_IMPORTED;?></i>
					
					<br><br><br style="line-height:4px">
					
					<?php
					if(!$website->GetParam("FREE_WEBSITE"))
					{
					?>
					<div id="package-selection">
					<b><?php echo $M_PACKAGE_TO_IMPORT;?>:
					</b>
					<br><br>
					
					
					<?php
	$hasPackages = false;

	$packages = $database->DataTable("packages_employer","WHERE ads>0 AND active=1 AND employer='".$AuthUserName."'");

	if($database->num_rows($packages) == 0)
	{
		echo "<i>".$M_IMPORT_EXPL."</i>";
	}
	else
	{
					
					echo '<select name="selected_package">';
					
					while($oPackage = $database->fetch_array($packages))
					{
						echo "<option value=\"".$oPackage["id"]."\">".$M_JOB_ADS.": ".$oPackage["ads"].", ".$M_VALID." ".$oPackage["valid"]." $M_DAYS, $PRICE_WHOLE_PACKAGE: ".$oPackage["price"]." ".$M_CREDITS."</option>";
						echo $oPackage["id"];	
						
					}
					echo '</select><br><br><br><br>';

				$hasPackages = true;

	}
	?>
					</div>
					<?php
					}
					?>
					
					
					<?php
					$tableImported= $database->DataTable("imported_ads","WHERE employer='".$AuthUserName."'");
					
					
					if($database->num_rows($tableImported) == 0)
					{
						
							echo "<b>".$M_NO_ADS_TO_IMPORT.".</b>";
					?>
							<script>document.getElementById("package-selection").style.display='none';</script>
					<?php
					}
					else
					{
					
					while($arrImported = $database->fetch_array($tableImported))
					{
					?>
					
					
						<table summary="" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td align="right">
										<input type="hidden" name="import_ids[]" value="<?php echo $arrImported["id"];?>">
										
										<input type="radio" checked name="import<?php echo $arrImported["id"];?>" value="0">
										<?php echo $M_NO_ACTION;?>
										<?php
										if($website->GetParam("FREE_WEBSITE")||$hasPackages)
										{
										?>
										
											<input type="radio"  name="import<?php echo $arrImported["id"];?>" value="1">
											<?php echo $M_IMPORT;?>
											&nbsp;
										<?php
										}
										?>
										<input type="radio" name="import<?php echo $arrImported["id"];?>" value="2">
										<?php echo $EFFACER;?>
										
										<input type="radio" name="import<?php echo $arrImported["id"];?>" value="3">
										<?php echo $M_SET_EXPIRED;?>
								
								</td>
							</tr>
						 </table>
						<b><?php echo $M_TITLE;?>:</b>
						<br>
						<?php echo $arrImported["title"];?>
						<br><br>
						<b><?php echo $M_DESCRIPTION;?>:</b>
						<br>
						<?php echo $arrImported["message"];?>
						<br><br>
						<hr size="1" width="100%">
						
						
						<br>
						<?php
						}
					
						?>
					
					<br>
					
					<input type="submit" class="adminButton" value=" <?php echo $M_PROCEED;?> ">
					
					
					
					</form>
					
					<?php
					}
					?>
					
					
			</td>
		</tr>
	</table>

	<?php

}
else
{


?>

<table summary="" border="0" width="100%">
	<tr>
		<td>
		
		<form action="index.php" method="post">
		<input type="hidden" name="category" value="<?php echo $_REQUEST["category"];?>">
		<input type="hidden" name="folder" value="my">
		<input type="hidden" name="page" value="export">
		<input type="hidden" name="doExport" value="1">
		<input type="hidden" name="Export" value="1">
		
		<br>
		<b><?php echo $M_EXPORT_CSV;?></b>
		
		<br><br><br>
		<i><?php echo $M_SELECT_FIELDS;?>:</i>
		<br><br>
		<table width="100%">
		<?php
		
				$arr_fields=$database->GetFieldsInTable("jobs");
			
				
				if (sizeof($arr_fields) > 0) 
				{
				
 	 				$fields = count($arr_fields);
  					$i = 0;
					$ic = 0;
  
					  while ($i < $fields)
					  {
					  
						  if(in_array($arr_fields[$i], $arrFieldsToSkip))
						  {
							$i++;
							continue;
							
						   }
						  
						  if($ic%4==0) echo "<tr>";
						  
						  ?>
							
							
							
							<td width="20%">
							<input type="checkbox" name="exp_fields[]" value="<?php echo $arr_fields[$i];?>" checked>
							
							  <?php echo strtoupper($arr_fields[$i]);?>
							</td>
							
							  
							<?php
							
							 if(($ic+1)%4==0) echo "</tr>";
							 
							  $i++;
							  $ic++;
					  }
				  
				  }
  
		?>
		</table>
		<br>
		
		<input type="submit" value=" <?php echo $M_EXPORT;?> " class="adminButton">
		
		
		
		</form>
		
		
		<?php
		
		$hideUploadForm=false;
		

		$map_fields = array();
		$map_fields["job_category"]="job_category";
		$map_fields["region"]="region";
		$map_fields["title"]="title";
		$map_fields["message"]="message";
		$map_fields["active"]="active";
		$map_fields["notification"]="notification";
		$map_fields["zip"]="zip";
		$map_fields["job_type"]="job_type";
		$map_fields["salary"]="salary";
		$map_fields["date_available"]="date_available";
		
		
		if(isset($_POST["Import"]))
		{
			
			$result=parse_csv($_FILES['import_file']['tmp_name']);
			
			$import_counter = 0;
			
			foreach($result as $line)
			{
				$arr_import_fields=array();
				$arr_import_values=array();
		
				foreach($map_fields as $key=>$value)
				{
					if(isset($line[$key]))
					{
						array_push($arr_import_fields, trim($value));
						array_push($arr_import_values, trim($line[$key]));
					}
				}
				
				
				if (!in_array('employer', $arr_import_fields))
				{
					array_push($arr_import_fields,"employer");
					array_push($arr_import_values,$AuthUserName);
				}
				
				$database->SQLInsert("imported_ads",$arr_import_fields,$arr_import_values);
				$import_counter++;
			}
			
			
			
			if($import_counter!=0)
			{
				echo "<br><br>";
				$hideUploadForm=true;
				
				if(true)
				{
				?>
					<script>
					document.location.href='index.php?category=jobs&folder=my&page=export&show=1';
					</script>
					<table summary="" border="0">
						<tr>
							<td><img src="images/link_arrow.gif" width="16" height="16" alt="" border="0"></td>
							<td><a href="index.php?category=jobs&folder=my&page=export&show=1" style="color:#ff0000;text-transform:uppercase;font-weight:800"><?php echo $M_CLICK_IMPORT;?></a></td>
						</tr>
					  </table>
					
				
					
					
				<?php	
				}
			
			}
			
			
			
		}
		
		?>
		
		<?php
		if(!$hideUploadForm)
		{
		?>
		<br><br>
		
		<b><?php echo $M_IMPORT_CSV;?></b>
		<br><br>
		
		<i><?php echo $M_SELECT_TO_BE_IMPORTED;?>:</i>
		<br><br>
		
		<form action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="category" value="<?php echo $_REQUEST["category"];?>">
		<input type="hidden" name="folder" value="my">
		<input type="hidden" name="page" value="export">
		<input type="hidden" name="Import" value="1">
		<?php echo $FILE;?>:
		<input type="file" name="import_file">
		
		<br><br>
		
		<input type="submit" value=" <?php echo $M_IMPORT;?> " class="adminButton">
		
		</form>
		
		<br><br>
		

		
		<table summary="" border="0">
  	<tr>
  		<td><img src="images/link_arrow.gif" width="16" height="16" alt="" border="0"></td>
  		<td><a href="index.php?category=<?php echo $category;?>&folder=<?php echo $folder;?>&page=<?php echo $page;?>&show=1" style="color:#6d6d6d;text-transform:uppercase;font-weight:800"><?php echo $M_NOT_IMPORTED;?></a></td>
  	</tr>
  </table>
		
		
		<?php
		}
		?>
		
		</td>
	</tr>
</table>

<?php
}


function parse_csv($file, $options = null) 
{
	$res=array();
	$delimiter = empty($options['delimiter']) ? "," : $options['delimiter'];
	$expr="/$delimiter(?=(?:[^\"]*\"[^\"]*\")*(?![^\"]*\"))/"; // added
	$str = file_get_contents ($file);
	
	
	$lines = preg_split('~\R~', $str);
	
	$field_names = explode($delimiter, trim(array_shift($lines)));
	
	foreach ($lines as $line) 
	{
	
		if (empty($line)) continue;
		$fields = preg_split($expr,trim($line)); // added
		$fields = preg_replace("/^\"(.*)\"$/s","$1",$fields); //added
		
		$_res = array();
		foreach ($field_names as $key => $f) 
		{
			if(isset($fields[$key]))
			{
				$_res[trim($f,"\"")] = $fields[$key];
			}
		}
		
		$check_empty = implode('', $_res);
		
		if(empty($check_empty)) 
		{ 
		
		}
		else
		{
			$res[] = $_res;
		}
		
		
	}
	return $res;
} 
?>
