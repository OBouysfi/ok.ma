<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<?php
$posting_id=$_REQUEST["posting_id"];
$apply_id=$_REQUEST["apply_id"];
$id=$_REQUEST["id"];
$website->ms_i($posting_id);
$website->ms_i($apply_id);
?>

<div class="fright">

	<?php
	$strAddURL="&Proceed=1&id=".$posting_id;
	
	echo LinkTile
		 (
			"jobs",
			"applications".$strAddURL,
			$M_GO_BACK,
			"",
			
			"red"
		 );
		?>
</div>
<div class="clear"></div>

<?php
$arrPosting = $database->DataArray("jobs","id=$posting_id ");

if(!isset($arrPosting["id"])) die("");

$arrPostingApply = $database->DataArray("apply","id=$apply_id");

if($arrPostingApply["guest"] == "1")
{
	$arrJobseeker = $database->DataArray("jobseekers_guests","id=".$arrPostingApply["guest_id"]);
}
else
{
	$arrJobseeker = $database->DataArray("jobseekers","username='".$database->escape_string($id)."'");
}
?>
  

						
<table width="100%"><tr><td>

<h3><?php echo $DETAILS_JS;?> <strong><?php echo stripslashes($arrJobseeker["first_name"]." ".$arrJobseeker["last_name"]." (".$arrJobseeker["username"].")");?></strong></h3>


<?php
if(trim($arrPostingApply["message"])!="")
{
?>
<i><?php echo $MESSAGE_SENT_JS;?></i>
<br><br>
<?php
echo stripslashes($arrPostingApply["message"]);
?>
<br><br>
 
<?php } ?>

<?php
$file_types = $website->GetParam("ACCEPTED_FILE_TYPES");

?>
<br><br>
<i><?php echo $LIST_ATTACHED;?>:</i>
<br><br>   
<table width=500>
	<?php
	$userFiles = $database->DataTable("files","WHERE user='$id'");
	
	while($js_file = $database->fetch_array($userFiles))
	{
		$file_show_link = "";
		foreach($file_types as $c_file_type)
		{	
			if(file_exists("../user_files/".$js_file["file_id"].".".$c_file_type[1]))
			{
				$file_show_link = "../user_files/".$js_file["file_id"].".".$c_file_type[1];
				break;
			}
		}
	?>
	
	<a target="_blank" href="<?php echo $file_show_link;?>"><b><?php echo $js_file["file_name"];?></b></a>
	<br>
	<i style="font-size;10px"><?php echo $js_file["description"];?></i>
	<br><br>
	<?php
	}
				?>
				
				</table>
<br><br>


<?php

if($arrPostingApply["guest"] == "1")
{

	echo "<i>".$M_APPLIED_AS_A_GUEST."</i>";

}
else
{

$arrSeeker=$arrJobseeker;
$arrResume = $database->DataArray("jobseeker_resumes","username='".$arrSeeker["username"]."'");
$id= $arrSeeker["id"];








?>
<table summary="" border="0" width="100%">
	<tr>
	
	<form id="html_form" action="../ADMIN/pdf/resume.php" method="post">
		<input id="html_field" type="hidden" name="html" value="">
		<input type="hidden" name="jobseeker_image" value="<?php echo $arrJobseeker["logo"];?>">
		</form>
	
	
		
		<td class=basictext>
						<span style="font-size:14px;font-weight:400">
							<i><b><?php echo $JOBSEEKER_CV;?></b></i>
						</span>
						
		
		</td>
		
		
		<td align="right">
		
		
		</td>
		
	</tr>
</table>
<br>

<table summary="" border="0" width="100%">
	<tr>
		<td class=basictext>


		
		
		
		
		
		
		
		
		<div id="resume_content">
		
		
						<span style="font-size:14px;font-weight:400">
							<i><b><?php echo $M_PERSONAL_INFORMATION;?></b></i>
						</span>
						
						<br><br>
					
													 

<table summary="" border="0" width="100%">

<tr height="24">
<td><i><?php echo $FIRST_NAME;?>: </i></td>
<td><?php echo stripslashes($arrJobseeker["first_name"]);?></td>
</tr> 

<tr height="24">
<td><i><?php echo $LAST_NAME;?>: </b></td>
<td><?php echo stripslashes($arrJobseeker["last_name"]);?></td>
</tr>  

<?php if(trim($arrJobseeker["phone"])!=""){ ?>
<tr height="24">
<td><i><?php echo $M_PHONE;?>: </i></td>
<td><?php echo $arrJobseeker["phone"];?></td>
</tr>
<?php
}
?>	 

<?php if(trim($arrJobseeker["mobile"])!=""){ ?>
<tr height="24">
<td><i><?php echo $M_MOBILE;?>: </i></td>
<td><?php echo $arrJobseeker["mobile"];?></td>
</tr>	
<?php
}
?>

<tr height="24">
<td><i><?php echo $EMAIL;?>: </i></td>
<td><?php echo $arrJobseeker["username"];?></td>
</tr>


<?php if(trim($arrJobseeker["address"])!=""){ ?>
<tr height="24">
<td width="120"><i><?php echo $M_ADDRESS;?>:</i></td>
<td> 
<?php echo stripslashes($arrJobseeker["title"]);?>
 <?php echo stripslashes($arrJobseeker["first_name"]);?> 
 <?php echo stripslashes($arrJobseeker["last_name"]);?>
<br>
<?php echo stripslashes($arrJobseeker["address"]);?> </td>
</tr> 
<?php } ?>

<tr height="24">
<td width="120"><i><?php echo $M_PICTURE;?>:</i></td>
<td> 
<br> 
<?php
if($arrJobseeker["logo"]>2&&file_exists("../thumbnails/".$arrJobseeker["logo"].".jpg"))
{
?>
	<img src="../thumbnails/<?php echo $arrJobseeker["logo"];?>.jpg">
<?php
}
else
{
?>
	<img src="../images/no_pic.gif">
<?php
}
?>
</td>
</tr>	
		
<?php	
$arrPropFields = array();

if(is_array(unserialize($arrJobseeker["jobseeker_fields"])))
{
	$arrPropFields = unserialize($arrJobseeker["jobseeker_fields"]);
}

$bFirst = true;
while (list($key, $val) = each($arrPropFields)) 
{
 
if(trim(str_show($val)) != "")
{
?>
<tr height="24">
		<td width="<?php echo $MessageTDLength;?>"><i><?php str_show($key);?>:</i></td>
		<td><?php str_show($val);?></td>
		</tr>
<?php
 }
}

?>

	</tr>
</table>

						
						<br><br><br>
						<span style="font-size:14px;font-weight:400">
							<i><b><?php echo $M_WORK_HISTORY;?></b></i>
						</span>
						
						<?php
						if(trim($arrResume["employer_name_1"])!="")
						{
						?>
						<br><br>
						
						<i><?php echo $M_NAME_RECENT_EMPLOYER;?>:</i>
						
						<br>
						
						
						<?php echo $arrResume["employer_name_1"];?>
						<br><br> 
						
						
						<?php if($arrResume["employer_address_1"]!=""){ ?>
						<i><?php echo $M_EMPLOYER_ADDRESS;?>:</i>
						<br>
						<?php echo $arrResume["employer_address_1"];?>
						<br><br> 
						<?php
						}
						?>
						
						<?php if($arrResume["job_1_dates"]!=""){ ?>
						<i><?php echo $M_DATES_STARTED_ENDED;?>:</i>
						<br><br>
						<?php echo $arrResume["job_1_dates"];?>
						<br><br> 
						<?php } ?>
						
						<?php if($arrResume["job_1_title"]!=""){ ?>
						<i><?php echo $M_YOUR_JOB_TITLE;?>:</i>
						<br><br>
						<?php echo $arrResume["job_1_title"];?>
						<br><br>
						<?php } ?>
						
						<?php if($arrResume["job_1_duties"]!=""){ ?>
						<i><?php echo $M_YOUR_JUB_DUTIES;?>:</i>
						<br><br>
						
						<?php echo $arrResume["job_1_duties"];?>
						<?php } ?>
						
						<?php
						}
						?>
						
						
						<?php
						if(trim($arrResume["employer_name_2"])!="")
						{
						?>
						
						<br><br><br>
				


						
						
						<i><?php echo $M_NAME_PREVIOUS_EMPLOYER;?>:</i>
						
						<br><br>
						<?php echo $arrResume["employer_name_2"];?>
						<br><br>
						
						<?php if($arrResume[""]!="employer_address_2"){ ?>
						<i><?php echo $M_EMPLOYER_ADDRESS;?>:</i>
						<br><br>
						<?php echo $arrResume["employer_address_2"];?>
						<br><br> 
						<?php } ?>
						
						<?php if($arrResume["job_2_dates"]!=""){ ?>
						<i><?php echo $M_DATES_STARTED;?>:</i>
						<br><br>
						<?php echo $arrResume["job_2_dates"];?>
						<br><br> 
						<?php } ?>
						
						<?php if($arrResume["job_2_title"]!=""){ ?>
						<i><?php echo $M_YOUR_JOB_TITLE;?>:</i>
						<br><br>
						<?php echo $arrResume["job_2_title"];?>
						<br><br> 
						<?php } ?>
						 
						<?php if($arrResume["job_2_duties"]!=""){ ?>
						<i><?php echo $M_YOUR_JUB_DUTIES;?>:</i>
						<br><br>
						
						<?php echo $arrResume["job_2_duties"];?>
						<?php } ?>
						
						<?php
						}
						?>
						
						
						<?php
						if(trim($arrResume["employer_name_3"])!="")
						{
						?>
						<br><br><br>
						
						
						
						<i><?php echo $M_NAME_PREVIOUS_EMPLOYER;?>:</i>
						
						<br><br>
						<?php echo $arrResume["employer_name_3"];?>
						<br><br>
						
						<?php if($arrResume["employer_address_3"]!=""){ ?>
						<i><?php echo $M_EMPLOYER_ADDRESS;?>:</i>
						<br><br>
						<?php echo $arrResume["employer_address_3"];?>
						<br><br>
						<?php } ?>
						
						<?php if($arrResume["job_3_dates"]!=""){ ?>
						<i><?php echo $M_DATES_STARTED;?>:</i>
						<br><br>
						<?php echo $arrResume["job_3_dates"];?>
						<br><br> 
						<?php } ?>
						
						<?php if($arrResume["job_3_title"]!=""){ ?>
						<i><?php echo $M_YOUR_JOB_TITLE;?>:</i>
						<br><br>
						<?php echo $arrResume["job_3_title"];?>
						<br><br> 
						<?php } ?>
						
						<?php if($arrResume["job_3_duties"]!=""){ ?>
						<i><?php echo $M_YOUR_JUB_DUTIES;?>:</i>
						<br><br>
						
						<?php echo $arrResume["job_3_duties"];?> 
						<?php } ?>
						
						<?php
						}
						?>
						
						
						<?php
						if(trim($arrResume["employer_name_4"])!="")
						{
						?>
						<br><br>
						
						
						<br><br>
						
						<i><?php echo $M_NAME_PREVIOUS_EMPLOYER;?>:</i>
						
						<br><br>
						<?php echo $arrResume["employer_name_4"];?>
						<br><br>
						
						<?php if($arrResume[""]!="employer_address_4"){ ?>
						<i><?php echo $M_EMPLOYER_ADDRESS;?>:</i>
						<br><br>
						<?php echo $arrResume["employer_address_4"];?>
						<br><br> 
						<?php } ?>
						 
						<?php if($arrResume[""]!="job_4_dates"){ ?>
						<i><?php echo $M_DATES_STARTED;?>:</i>
						<br><br>
						<?php echo $arrResume["job_4_dates"];?>
						<br><br>
						<?php } ?>
						
						<?php if($arrResume[""]!="job_4_title"){ ?>
						<i><?php echo $M_YOUR_JOB_TITLE;?>:</i>
						<br><br>
						<?php echo $arrResume["job_4_title"];?>
						<br><br> 
						<?php } ?>
						 
						<?php if($arrResume[""]!="job_4_duties"){ ?>
						<i><?php echo $M_YOUR_JUB_DUTIES;?>:</i>
						<br><br>
						
					    <?php echo $arrResume["job_4_duties"];?> 
						<?php } ?>
						
						<?php
						}
						?>
						
						
						<br><br>
						
						<span style="font-size:14px;font-weight:400">
							<i><b><?php echo $M_SKILLS;?></b></i>
						</span>
						
						<br><br>
						
						 <?php
						if($arrResume["skills"]!="")
						{
						?>
						<i><?php echo $M_YOUR_SKILLS;?>:</i>
						<br><br>
						<?php echo stripslashes($arrResume["skills"]);?>
						
						<br><br> 
						<?php
						}
						?>
						
						<?php
						if($arrResume["native_language"]!=""&&$arrResume["native_language"]!=0&&$arrResume["native_language"]!=-1)
						{
						?>
						<i><?php echo $M_NATIVE_LANGUAGE;?>:</i>
						<br>
						
						<?php
						foreach($website->GetParam("arrResumeLanguages") as $key=>$value)
						{
							if($key==$arrResume["native_language"])
							{
								echo $value;
							}
							
						}
						?>
											
						<br><br>
						<?php
						}
						?>
						
						
						<?php
						for($i=1;$i<=3;$i++)
						{
						
						if($arrResume["language_".$i]!=-1&&$arrResume["language_".$i]!=""&&$arrResume["language_".$i]!=0)
						{
						?>
						
						<table border="0" cellpadding="0" cellspacing="0">
				      	<tr>
				      		<td width="200">
							
								<i><?php echo $M_FOREIGN_LANGUAGE;?> <?php echo $i;?>:</i>
							
							
							</td>
				      		<td>
							
										<i><?php echo $M_PROFICIENCY;?>:</i>
							
							</td>
				      	</tr>
				      	<tr>
				      		<td>
							
									<?php
										foreach($website->GetParam("arrResumeLanguages") as $key=>$value)
										{
											if($key==$arrResume["language_".$i])
											{
												echo $value;
											
											}
									
										}
										?>
									
							
							</td>
				      		<td>
									
										<?php
										
										
										
										foreach($website->GetParam("arrProficiencies") as $key=>$value)
										{
											if($key==$arrResume["language_".$i."_level"])
											{
												echo $value;
											}
											
										}
										?>
									
							
							
							</td>
				      	</tr>
				      </table>
					  
					  
					  <?php
					  }
					  }
					  ?>
						
						
						
						
						
						
						
						
						
						<br><br>
						
						<span style="font-size:14px;font-weight:400">
							<i><b><?php echo $M_EDUCATION;?></b></i>
						</span>
						
						
						
						
						<?php 
						
						if(trim($arrResume["education_level"]) != ""&&trim($arrResume["education_level"]) != "-1"&&trim($arrResume["education_level"]) != "0")
						{
						?>
						<br><br><br>
						<?php echo $M_EDUCATION_LEVEL;?>:
						<br><br>
						<?php
						foreach($website->GetParam("arrEducationLevels") as $key=>$value)
						{	
						
								if(trim($key)==trim($arrResume["education_level"]))
								{
									echo $value;
								}
						}  
						
						}
						?>
						
						<?php
						if(trim($arrResume["school_1_name"])!="")
						{
						?>
						<br><br><br>
						
						
							<?php echo $M_NAME_LAST_SCHOOL;?>:
						
						<br><br>
						<b><?php echo $arrResume["school_1_name"];?></b>
						<br><br>
						
						<?php echo $M_COURSES_STUDIED;?>:
						<br><br>
						<b><?php echo $arrResume["school_1_courses"];?></b>
						<br><br>
						
						<?php echo $M_DATES_ATTENDED;?>:
						<br><br>
						<b><?php echo $arrResume["school_1_dates"];?></b>
						<br><br>
						
						<?php echo $M_DEGREE_EARNED;?>:
						<br><br>
						<b><?php echo $arrResume["school_1_degree"];?></b>
					
						<?php
						}
						?>
					
					
					<?php
						if(trim($arrResume["school_2_name"])!="")
						{
						?>
						<br><br><br><br>
						
						
						
							<?php echo $M_NAME_PREVIOUS_SCHOOL;?>:
						
						<br><br>
						<b><?php echo $arrResume["school_2_name"];?></b>
						<br><br>
						
						<?php echo $M_COURSES_STUDIED;?>:
						<br><br>
						<b><?php echo $arrResume["school_2_courses"];?></b>
						<br><br>
						
						<?php echo $M_DATES_ATTENDED;?>:
						<br><br>
						<b><?php echo $arrResume["school_2_dates"];?></b>
						<br><br>
						
						<?php echo $M_DEGREE_EARNED;?>:
						<br><br>
						<b><?php echo $arrResume["school_2_degree"];?></b>
					
						<?php
						}
						?>
					
						<?php
						if(trim($arrResume["school_3_name"])!="")
						{
						?>
						<br><br><br><br>
						
						
						
							<?php echo $M_NAME_PREVIOUS_SCHOOL;?>:
						
						<br><br>
						<b><?php echo $arrResume["school_3_name"];?></b>
						<br><br>
						
						<?php echo $M_COURSES_STUDIED;?>:
						<br><br>
						<b><?php echo $arrResume["school_3_courses"];?></b>
						<br><br>
						
						<?php echo $M_DATES_ATTENDED;?>:
						<br><br>
						<b><?php echo $arrResume["school_3_dates"];?></b>
						<br><br>
						
						<?php echo $M_DEGREE_EARNED;?>:
						<br><br>
						<b><?php echo $arrResume["school_3_degree"];?></b>
					
					
						<?php
						}
						?>
						
					<br><br>
		
		
		
<?php
if(trim($arrSeeker["cv"]) !="")
{
?>		
		
<br><br>
<?php 

echo stripslashes($arrSeeker["cv"]);

?>

<br><br>
<?php
}
?>




<span style="font-size:14px;font-weight:400">
							<i><b><?php echo $M_JOB_PREFERENCES;?></b></i>
						</span>
						
<br><br>
<?php
	$arrSelectedCategories = array(); 
		$arrSelectedLocations = array(); 
		$strLevelExperience = $arrJobseeker["level_experience"]; 
		
		if($arrJobseeker["industry_sector"] != "")
		{
			$arrSelectedCategories = unserialize($arrJobseeker["industry_sector"]); 
		}
	   	
	   
	 
	   if($arrJobseeker["preferred_locations"] != "")
		{
		
			$arrSelectedLocations = unserialize($arrJobseeker["preferred_locations"]); 
		}
?>

<TABLE border=0 cellPadding=0 cellSpacing=0>
  <TBODY>
  
  	<?php
	if(trim($arrJobseeker["industry_sector"])!="")
	{
	?>

    <TR>

      <TD vAlign=top colSpan=4 class=basictext><i><?php echo $M_JOB_CATEGORIES;?>:</i></TD>
    </TR>
    <TR>
      <TD colSpan=4>
      
	   <?php
	  
	  
		
		
	   $bfirst=true;  
	   $iCounter = 0;
	 
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
		

				foreach($arrCategories as $strCategory)
				{
				
					$arrCategoryItems = explode(".",$strCategory,2);
					
					if(isset($arrCategoryItems[1])&&is_array($arrSelectedCategories))
					{
					
									if(in_array(trim($arrCategoryItems[1]), $arrSelectedCategories)?"checked":"")
									{ 
									
										if(!$bfirst) {echo ", ";} else {$bfirst=false;}
										echo trim($arrCategoryItems[1]);
									}
									
					}
					
				}
				
				
		?>
	   
	   
	   
      </TD>
    </TR>
	<?php
	}
	?>
   
	<?php
	if(trim($arrJobseeker["preferred_locations"])!="")
	{
	?>

    <TR>
      <TD vAlign=top colSpan=4 height=27  class=basictext><br>
        <i><?php echo $M_PREFERRED_LOCATIONS;?>:</i></TD>
    </TR>
    <TR>
      <TD colSpan=4>
  
 
  <?php
				$arrRegions = explode("\n", aParameter(802));
				  $bfirst=true;  
				foreach($arrRegions as $strRegion)
				{
				
					$arrCategoryItems = explode(".",$strRegion,2);
					
					if(isset($arrCategoryItems[1])&&is_array($arrSelectedLocations))
					{
					
									
									if(in_array(trim($arrCategoryItems[1]), $arrSelectedLocations)?"checked":"")
									{	
										if(!$bfirst) {echo ", ";} else {$bfirst=false;}
										echo $arrCategoryItems[1];
									}
					
					}
				
				}
			
				 
		?>
  
  	
  
  
      </TD>
    </TR>
   
	<?php 
	}
	if(trim($arrJobseeker["profile_description"])!="")
	{
	?>
	
    <TR>
      <TD vAlign=top colSpan=2 class=basictext><br><i><?php echo $BRIEF_DESCRIPTION_PROFILE;?>:</i>


       <?php echo stripslashes($arrJobseeker["profile_description"]);?>
		
	
      </TD>
    </TR> 
	<?php
	 }
	?>
  </TBODY>
</TABLE>


</div>


</td>
	</tr>
</table>
<br><br>

<?php









}



?>
<br><br>

<?php


?>
</td></tr></table>





