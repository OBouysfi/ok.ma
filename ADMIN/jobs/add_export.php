<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php

if($ASK_FOR_ZIP)
{
	$arrFieldsToSkip = array("date","places","featured","featured_expires","expires","contact_person","more_fields");
}
else
{
	$arrFieldsToSkip = array("date","places","featured","featured_expires","expires","contact_person","zip","more_fields");
}

if(isset($Export))
{
	header("Location: job_ads/export.php?fs=".implode("-",$exp_fields));
	
}


if(isset($show) && $show ==1)
{



if(isset($proceed))
{

$importedCounter=0;

$deletedCounter=0;
$expiredCounter=0;


		
	foreach($import_ids as $import_id)
	{
	
			if(get_param("import".$import_id) == "0")
			{
			
			}
			else
			if(get_param("import".$import_id) == "1")
			{
					
				
					
					
					mysql_connect($DBHost,$DBUser,$DBPass);
					mysql_select_db($DBName);
				
					mysql_query
					(
						"
							INSERT INTO ".$DBprefix."jobs(date,employer,job_category,region,title,message,active,notification,contact_person,places,featured,expires,zip,job_type,featured_expires,salary,date_available)
							SELECT date,employer,job_category,region,title,message,active,notification,contact_person,places,featured,expires,zip,job_type,featured_expires,salary,date_available FROM ".$DBprefix."imported_ads
							WHERE id=".$import_id." 
						 "
					) ;
					
					$insert_id=mysql_insert_id();
				
					if(true)
					{
								mysql_query
									(
										"UPDATE ".$DBprefix."jobs
											SET 
												date=".(time()).",
												expires=".(time() + $FREE_WEBSITEFREE_WEBSITE_ADS_EXPIRE_DAYS*86400)."
											WHERE id=".$insert_id."
									");
					}
					else
					{
					
									mysql_query
									(
										"UPDATE ".$DBprefix."jobs
											SET 
												date=".(time()).",
												expires=".(time() + $FREE_WEBSITE_ADS_EXPIRE_DAYS*86400)."
											WHERE id=".$insert_id."
									");
					}
								
					mysql_query("DELETE FROM ".$DBprefix."imported_ads WHERE id=".$import_id." ");	
				
					mysql_close();
					
					
					$importedCounter++;
					
			}
			else
			if(get_param("import".$import_id) == "2")
			{
					SQLQuery("DELETE FROM ".$DBprefix."imported_ads WHERE id=".$import_id." ");
					$deletedCounter++;
			}
			else
			if(get_param("import".$import_id) == "3")
			{
					mysql_connect($DBHost,$DBUser,$DBPass);
					mysql_select_db($DBName);
				
					mysql_query
					(
						"
							INSERT INTO ".$DBprefix."jobs(date,employer,job_category,region,title,message,active,notification,contact_person,places,featured,expires,zip,job_type,featured_expires,salary,date_available)
							SELECT date,employer,job_category,region,title,message,active,notification,contact_person,places,featured,expires,zip,job_type,featured_expires,salary,date_available FROM ".$DBprefix."imported_ads
							WHERE id=".$import_id." 
							
						 "
					) ;
				
					$insert_id=mysql_insert_id();
				
					mysql_query
					(
						"UPDATE ".$DBprefix."jobs
							SET 
								date=".(time()-1).",
								expires=".(time()-1)."
							WHERE id=".$insert_id."
					") ;
								
					mysql_query("DELETE FROM ".$DBprefix."imported_ads WHERE id=".$import_id." ");	
				
					mysql_close();
					$expiredCounter=0;
			}
			
				
	}



			
			
echo "<table width=95%><tr><td>";

if($importedCounter>0)
{
	echo "<i><b>".$importedCounter."</b> ".$M_ADS_POSTED_SUCCESS.".</i><br><br>";
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

<table summary="" border="0" width="95%">
	<tr>
		<td>
		<form action="index.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="category" value="<?php echo $category;?>">
				<input type="hidden" name="folder" value="add">
				<input type="hidden" name="page" value="export">
				<input type="hidden" name="show" value="1">
				<input type="hidden" name="proceed" value="1">

						
				
		
				<br style="line-height:4px">
				<i><?php echo $M_ADS_TO_BE_IMPORTED;?></i>
				
				<br><br><br style="line-height:4px">
				
					
				
				<?php
				$tableImported= $database->DataTable("imported_ads","");//WHERE employer=''
				
				
				if($database->num_rows($tableImported) == 0)
				{
					
						echo "<b>".$M_NO_ADS_TO_IMPORT.".</b>";
				
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
									if(true)
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
					 <b><?php echo $M_EMPLOYER;?>:</b>
					
					<?php echo $arrImported["employer"];?>
					<br><br style="line-height:5px">
					<b><?php echo $M_TITLE;?>:</b>
					
					<?php echo $arrImported["title"];?>
					<br><br style="line-height:5px">
					<b><?php echo $M_DESCRIPTION;?>:</b>
					<br>
					<?php echo $arrImported["message"];?>
					<br>
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

<table summary="" border="0" width="95%">
	<tr>
		<td>
		
		<form action="index.php" method="post">
		<input type="hidden" name="category" value="<?php echo $category;?>">
		<input type="hidden" name="folder" value="add">
		<input type="hidden" name="page" value="export">
		<input type="hidden" name="doExport" value="1">
		<input type="hidden" name="Export" value="1">
		
		<br>
		<b><?php echo $M_EXPORT_CSV;?></b>
		
		<br><br><br>
		<i><?php echo $M_SELECT_FIELDS;?>:</i>
		<br><br>
		<table width="95%">
		<?php
		
				$tableProducts = $database->DataTable("jobs","");

				
				if ($database->num_rows($tableProducts) != 0) 
				{
				
 	 				$fields = mysql_num_fields($tableProducts);
  					$i = 0;
					$ic = 0;
  
					  while ($i < $fields)
					  {
					  
					  if(in_array(mysql_field_name($tableProducts, $i), $arrFieldsToSkip))
					  {
					  	$i++;
					  	continue;
						
					   }
					  
					  if($ic%4==0) echo "<tr>";
					  
					  ?>
				  		
						
						
						<td width="20%">
						<input type="checkbox" name="exp_fields[]" value="<?php echo mysql_field_name($tableProducts, $i);?>" checked>
						
						  <?php echo strtoupper(mysql_field_name($tableProducts, $i));?>
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
		
		if(isset($Import))
		{
				  $fcontents = file ($_FILES['import_file']['tmp_name']); 
				  
				  $import_fields=array();
				  $posId=-1;
				  $posUser=-1;
				  				
				  for($i=0; $i<sizeof($fcontents); $i++) 
				  { 
				  
				     $line = trim($fcontents[$i]); 
					 
					 if($i==0)
					 {
					 	
						$line = substr($line, 1, (strlen($line)-2) );
					 	
						 $arr = explode("\",\"", $line); 
						 
						
						 $iCounter=0;
						 foreach($arr as $field)
						 {
						 
						 	$field=strtolower($field);
							
						 	if(strtolower($field)=="id")
							{
								$posId=$iCounter;
							}
							else
							if(strtolower($field)=="employer"&&$AuthUserName!="administrator")
							{
								$posUser=$iCounter;
							}
							else
							{
								array_push( $import_fields, $field);
							}
						 	$iCounter++;
						 }
						
						if($AuthUserName!="administrator")
						{
						  array_push($import_fields,"employer");
						}
						  
					 }
					 else
					 {
					 		$import_values=array();
							
					 		$line = substr($line, 1, (strlen($line)-2) );
							
							
					 		 $iCounter=0;
							 $arr = explode("\",\"", $line); 
							 
							 foreach($arr as $field)
						 	 {
								if($iCounter==$posId||$iCounter==$posUser)
								{
									$iCounter++;
									continue;
								}
								else
								{
									array_push( $import_values, $field);
								}
								
								$iCounter++;
							 }
							
							
							  if($AuthUserName!="administrator")
							  {
							  	array_push($import_values,$AuthUserName);
							  }
							  
							
							  if(sizeof($import_fields)!=sizeof($import_values))
							  {
							  
							  	  echo "<br><br><br><b><font color=\"red\">There was an error while importing your file:<br>Column count doesn't match value count	</font></b><br>";
								    $flag_error=true;
							  }
							  else
							  {
						  	  	SQLInsert("imported_ads",$import_fields,$import_values);
							}
					 }
					 
					
				
				 }
		
			if($i!=0)
			{
				echo "<br><br>";
				$hideUploadForm=true;
				
				if(!isset($flag_error))
				{
			?>
			
				<table summary="" border="0">
				  	<tr>
				  		<td><img src="images/link_arrow.gif" width="16" height="16" alt="" border="0"></td>
				  		<td><a href="index.php?category=job_ads&folder=add&page=export&show=1" style="color:#ff0000;text-transform:uppercase;font-weight:800"><?php echo $M_CLICK_IMPORT;?></a></td>
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
		<input type="hidden" name="category" value="<?php echo $category;?>">
		<input type="hidden" name="folder" value="add">
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
?>
