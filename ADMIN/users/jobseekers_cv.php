<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<?php
$id=$_REQUEST["id"];
$website->ms_i($id);

$arrSeeker = $database->DataArray("jobseekers","id=".$id);

$arrResume = $database->DataArray("jobseeker_resumes","username='".$arrSeeker["username"]."'");


?>

	
	
<div class="fright">
	<?php

		 
	echo LinkTile
	 (
		"users",
		"jobseekers",
		$M_GO_BACK,
		"",
		"red"
	 );
?>
</div>
<div class="clear"></div>

	
	<h3>
		<?php echo $CV_OF;?> <?php echo $arrSeeker["first_name"];?> <?php echo $arrSeeker["last_name"];?>
	</h3>
	<br/>
		
<?php
if($database->SQLCount("files","WHERE user='".$arrSeeker["username"]."'  AND is_resume=1 ","file_id") == 0)
{

}
else
{

?>


		<i><b><?php echo $M_UPLOADED_RESUMES_JOBSEEKER;?>:</b></i>
	
	<br><br>
						
<?php
	$JobseekerFiles=$database->DataTable("files","WHERE user='".$arrSeeker["username"]."' AND is_resume=1");
	
	while($js_file = $database->fetch_array($JobseekerFiles))
	{
		$file_show_link = "../file.php?id=".$js_file["file_id"];
		foreach($website->GetParam("ACCEPTED_FILE_TYPES") as $c_file_type)
		{	
			if(file_exists("../user_files/".$js_file["file_id"].".".$c_file_type[1]))
			{
				$file_show_link = "../user_files/".$js_file["file_id"].".".$c_file_type[1];
				break;
			}
		}
	?>
	
	<a target="_blank" class="underline-link" href="<?php echo $file_show_link;?>"><b><?php echo $js_file["file_name"];?></b></a>
	<br>
	<i style="font-size;10px"><?php echo $js_file["description"];?></i>
	<br><br>
	<?php
	}
	

						
}
?>
		
  
	
<div class="clear"></div>


<?php 
		
		if($arrSeeker["video_id"]>2)
		{
		?>
		<br>
		<a href="index.php?category=jobseekers&folder=search&page=play&video_id=<?php echo $arrSeeker["video_id"];?>"><b><?php echo $M_JOBSEEKER_UPLOADED_VIDEO_RESUME;?></b></a>&nbsp;&nbsp;
		<?php
		}
		?>
		
			<span style="font-size:14px;font-weight:400">
				<i><b><?php echo $M_PERSONAL_INFORMATION;?></b></i>
			</span>
			
		<?php
$MessageTDLength = 140;

$_REQUEST["HideSubmit"] = true;

	AddEditForm
	(
	array(
	
	" <i>".$FIRST_NAME.":</i>",
	" <i>".$LAST_NAME.":</i>",
	" <i>".$M_ADDRESS.":</i>",
	" <i>".$TELEPHONE.":</i>",
	" <i>".$M_MOBILE.":</i>",
	" <i>".$M_EMAIL.":</i>",
	" <i>".$M_DOB.":</i>",
	
	" <i>".$M_PICTURE.":</i>"),
	array("first_name","last_name","address","phone",
	"mobile","username","dob","logo"),
	array("profile_public","title","first_name","last_name","address","phone",
	"mobile","username","dob","logo"),
	array("textbox_30","textbox_30","textarea_50_4","textbox_30",
	"textbox_30","textbox_30","textbox_30","textbox_30"),
	"jobseekers",
	"id",
	$id,
	"",
	"",
	120,
	true
	);

?>


		

<table summary="" border="0" width="100%">
	<tr>
		<td>
		
		
<?php	

$arrJobseeker = $database->DataArray("jobseekers","id=".$id);


if($arrJobseeker["experience"]!=0)
{
?>
	<tr height="24">
		<td width="<?php echo $MessageTDLength;?>">
			<i><?php $M_EXPERIENCE;?>:</i>
		</td>
		<td><?php $website->show_value("arrExperienceLevels",$arrJobseeker["experience"]);?></td>
	</tr>
<?php
}

if($arrJobseeker["availability"]!=0)
{
?>
	<tr height="24">
		<td width="<?php echo $MessageTDLength;?>">
			<i><?php $M_AVAILABILITY;?>:</i>
		</td>
		<td><?php $website->show_value("arrAvailabilityTypes",$arrJobseeker["availability"]);?></td>
	</tr>
<?php
}

if($arrJobseeker["job_type"]!=0)
{
?>
	<tr height="24">
		<td width="<?php echo $MessageTDLength;?>">
			<i><?php $M_JOB_TYPE;?>:</i>
		</td>
		<td><?php $website->show_value("arrJobTypes",$arrJobseeker["job_type"]);?></td>
	</tr>
<?php
}



if(trim($arrJobseeker["jobseeker_fields"]) != "")
{

$arrEmployerFields = array();

if(is_array(unserialize($arrJobseeker["jobseeker_fields"])))
{
	$arrEmployerFields = unserialize($arrJobseeker["jobseeker_fields"]);
}

$bFirst = true;
while (list($key, $val) = each($arrEmployerFields)) 
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
</td>
	</tr>
</table>



	<br><br>
						<span style="font-size:14px;font-weight:400">
							<i><b><?php echo $M_WORK_HISTORY;?></b></i>
						</span>
						
						<?php
						if(trim($arrResume["employer_name_1"])!="")
						{
						?>
						<br><br>
						
						<?php echo $M_NAME_RECENT_EMPLOYER;?>:
						
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["employer_name_1"];?></b>
						<br><br>
						
						<?php echo $M_EMPLOYER_ADDRESS;?>:
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["employer_address_1"];?></b>
						<br><br>
						
						<?php echo $M_DATES_STARTED_ENDED;?>:
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["job_1_dates"];?></b>
						<br><br>
						
						<?php echo $M_YOUR_JOB_TITLE;?>:
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["job_1_title"];?></b>
						<br><br>
						
						<?php echo $M_YOUR_JUB_DUTIES;?>:
						<br><br style="line-height:2px">
						
						<b><?php echo $arrResume["job_1_duties"];?></b>
						
						
						<?php
						}
						?>
						
						
						<?php
						if(trim($arrResume["employer_name_2"])!="")
						{
						?>
						
						<br><br>
				


						<br><br>
						
						<?php echo $M_NAME_PREVIOUS_EMPLOYER;?>:
						
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["employer_name_2"];?></b>
						<br><br>
						
						<?php echo $M_EMPLOYER_ADDRESS;?>:
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["employer_address_2"];?></b>
						<br><br>
						
						<?php echo $M_DATES_STARTED;?>:
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["job_2_dates"];?></b>
						<br><br>
						
						<?php echo $M_YOUR_JOB_TITLE;?>:
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["job_2_title"];?></b>
						<br><br>
						
						<?php echo $M_YOUR_JUB_DUTIES;?>:
						<br><br style="line-height:2px">
						
						<b><?php echo $arrResume["job_2_duties"];?></b>
						
						<?php
						}
						?>
						
						
						<?php
						if(trim($arrResume["employer_name_3"])!="")
						{
						?>
						<br><br>
						
						
						
						<br><br>
						
						<?php echo $M_NAME_PREVIOUS_EMPLOYER;?>:
						
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["employer_name_3"];?></b>
						<br><br>
						
						<?php echo $M_EMPLOYER_ADDRESS;?>:
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["employer_address_3"];?></b>
						<br><br>
						
						<?php echo $M_DATES_STARTED;?>:
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["job_3_dates"];?></b>
						<br><br>
						
						<?php echo $M_YOUR_JOB_TITLE;?>:
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["job_3_title"];?></b>
						<br><br>
						
						<?php echo $M_YOUR_JUB_DUTIES;?>:
						<br><br style="line-height:2px">
						
						<b><?php echo $arrResume["job_3_duties"];?></b>
						
						<?php
						}
						?>
						
						
						<?php
						if(trim($arrResume["employer_name_4"])!="")
						{
						?>
						<br><br>
						
						
						<br><br>
						
						<?php echo $M_NAME_PREVIOUS_EMPLOYER;?>:
						
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["employer_name_4"];?></b>
						<br><br>
						
						<?php echo $M_EMPLOYER_ADDRESS;?>:
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["employer_address_4"];?></b>
						<br><br>
						
						<?php echo $M_DATES_STARTED;?>:
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["job_4_dates"];?></b>
						<br><br>
						
						<?php echo $M_YOUR_JOB_TITLE;?>:
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["job_4_title"];?></b>
						<br><br>
						
						<?php echo $M_YOUR_JUB_DUTIES;?>:
						<br><br style="line-height:2px">
						
						<b><?php echo $arrResume["job_4_duties"];?></b>
						
						<?php
						}
						?>
						
						
						<br><br>
				
				
				
						
						
						<br><br>
						
						<span style="font-size:14px;font-weight:400">
							<i><b><?php echo $M_SKILLS;?></b></i>
						</span>
						
						<br><br>
						<?php
						if(trim($arrResume["skills"]) != "")
						{
						?>
						<?php echo $M_YOUR_SKILLS;?>:
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["skills"];?></b>
						
						<br><br>
						<?php
						}
						?>
						
						
						<?php echo $M_NATIVE_LANGUAGE;?>:
						<br><br style="line-height:2px">
						<b>
						<?php
						foreach($website->GetParam("arrResumeLanguages") as $arrResumeLanguage)
						{
							if($arrResumeLanguage[0]==$arrResume["native_language"])
							{
								echo $arrResumeLanguage[1];
							}
							
						}
						?>
						</b>
						
						<br><br>
						
						
						<?php
						for($i=1;$i<=3;$i++)
						{
						
						if($arrResume["language_".$i]!=-1)
						{
						?>
						
						<table summary="" border="0">
				      	<tr>
				      		<td>
							
								<?php echo $M_FOREIGN_LANGUAGE;?> <?php echo $i;?>:
							
							
							</td>
				      		<td>
							
										<?php echo $M_PROFICIENCY;?>:
							
							</td>
				      	</tr>
				      	<tr>
				      		<td>
							<b>
									<?php
										foreach($website->GetParam("arrResumeLanguages") as $arrResumeLanguage)
										{
											if($arrResumeLanguage[0]==$arrResume["language_".$i])
											{
												echo $arrResumeLanguage[1];
											
											}
									
										}
										?>
									</b>	
									
							
							</td>
				      		<td>
							<b>
										<?php
										foreach($website->GetParam("arrProficiencies") as $arrProficiency)
										{
											if($arrProficiency[0]==$arrResume["language_".$i."_level"])
											{
												echo $arrProficiency[1];
											}
											
										}
										?>
									</b>	
							
							
							</td>
				      	</tr>
				      </table>
					  
					  <br>
					  
					  <?php
					  }
					  }
					  ?>
						
						
						
						
						
						
						
						
						
						<br><br>
						
						<span style="font-size:14px;font-weight:400">
							<i><b><?php echo $M_EDUCATION;?></b></i>
						</span>
						
						
						
						<br><br>
						
						<?php echo $M_EDUCATION_LEVEL;?>:
						<br><br style="line-height:2px">
						<?php
						foreach($website->GetParam("arrEducationLevels") as $arrEducationLevel)
						{
								if($arrEducationLevel[0]==$arrResume["education_level"])
								{
									echo $arrEducationLevel[1];
								}
						}
						?>
						
						<?php
						if(trim($arrResume["school_1_name"])!="")
						{
						?>
						<br><br>
						
						
							<?php echo $M_NAME_LAST_SCHOOL;?>:
						
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["school_1_name"];?></b>
						<br><br>
						
						<?php echo $M_COURSES_STUDIED;?>:
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["school_1_courses"];?></b>
						<br><br>
						
						<?php echo $M_DATES_ATTENDED;?>:
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["school_1_dates"];?></b>
						<br><br>
						
						<?php echo $M_DEGREE_EARNED;?>:
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["school_1_degree"];?></b>
					
						<?php
						}
						?>
					
					
					<?php
						if(trim($arrResume["school_2_name"])!="")
						{
						?>
						<br><br><br>
						
						
						
							<?php echo $M_NAME_PREVIOUS_SCHOOL;?>:
						
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["school_2_name"];?></b>
						<br><br>
						
						<?php echo $M_COURSES_STUDIED;?>:
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["school_2_courses"];?></b>
						<br><br>
						
						<?php echo $M_DATES_ATTENDED;?>:
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["school_2_dates"];?></b>
						<br><br>
						
						<?php echo $M_DEGREE_EARNED;?>:
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["school_2_degree"];?></b>
					
						<?php
						}
						?>
					
						<?php
						if(trim($arrResume["school_3_name"])!="")
						{
						?>
						<br><br><br>
						
						
						
							<?php echo $M_NAME_PREVIOUS_SCHOOL;?>:
						
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["school_3_name"];?></b>
						<br><br>
						
						<?php echo $M_COURSES_STUDIED;?>:
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["school_3_courses"];?></b>
						<br><br>
						
						<?php echo $M_DATES_ATTENDED;?>:
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["school_3_dates"];?></b>
						<br><br>
						
						<?php echo $M_DEGREE_EARNED;?>:
						<br><br style="line-height:2px">
						<b><?php echo $arrResume["school_3_degree"];?></b>
					
					
						<?php
						}
						?>
						
					<br><br>
		
<?php
if(trim($arrSeeker["cv"])!="")
{
?>		
	<br><br>
	<?php 
	echo $arrSeeker["cv"];
	?>
	<br><br>
<?php
}
?>


<span style="font-size:14px;font-weight:400">
			<i><b><?php echo $M_JOB_PREFERENCES;?></b></i>
		</span>
						
<br><br>


<TABLE border=0 cellPadding=0 cellSpacing=0>
  <TBODY>
    <TR>

      <TD vAlign=top colSpan=4 class=basictext><?php echo $M_JOB_CATEGORIES;?>:</TD>
    </TR>
    <TR>
      <TD colSpan=4>
       <b>
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
	
	
		$bFirst = true;		

		foreach($arrCategories as $strCategory)
		{
		
			$arrCategoryItems = explode(".",$strCategory,2);
			if(is_array($arrCategoryItems) && sizeof($arrCategoryItems) == 2)
			{
				if(in_array(trim($arrCategoryItems[0]), $arrSelectedCategories))
				{
					if(!$bFirst) echo ", ";
					echo trim($arrCategoryItems[1]);
					$bFirst = false;
				}
			}
			
		}
				
				
		?>
	   
	   </b>
	   
      </TD>
    </TR>

   


    <TR>
      <TD vAlign=top colSpan=4 height=27  class=basictext><BR><br>
        <?php echo $M_PREFERRED_LOCATIONS;?>:</TD>
    </TR>
    <TR>
      <TD colSpan=4>
 
  <b>
  <?php
  	if(is_array($arrSelectedLocations))
	{
	
		if(!isset($l))
		{
			include_once("../locations/locations_array.php");
		}

		$b_first = true;
		foreach($arrSelectedLocations as $loc_id)
		{
			if(!$b_first) echo ", ";
			
			if(isset($l[$loc_id]))
			{
			echo $l[$loc_id];
			
			$b_first = false;
			
			}
		}
				
	}			
				 
		?>
  
  	</b>
  
  
      </TD>
    </TR>

    <TR>
      <TD valign="top" colspan="2" class="basictext"><br><br><?php echo $BRIEF_DESCRIPTION_PROFILE;?>:

<br><br>
<b>
       <?php echo $arrJobseeker["profile_description"];?>
		
</b>		
      </TD>
    </TR>
  </TBODY>
</TABLE>

<br>



<?php
if($database->SQLCount("files","WHERE user='".$arrSeeker["username"]."'  AND is_resume=0 ","file_id") == 0)
{

}
else
{
?>
<br><br>
	<span style="font-size:14px;font-weight:400">
		<i><b><?php echo $M_FILES_UPLOADED_JOBSEEKER;?>:</b></i>
	</span>
	<br><br>
						
<?php
	$JobseekerFiles=$database->DataTable("files","WHERE user='".$arrSeeker["username"]."' AND is_resume=0");
	
	while($js_file = $database->fetch_array($JobseekerFiles))
	{
		$file_show_link = "../file.php?id=".$js_file["file_id"];
		foreach($website->GetParam("ACCEPTED_FILE_TYPES") as $c_file_type)
		{	
			if(file_exists("../user_files/".$js_file["file_id"].".".$c_file_type[1]))
			{
				$file_show_link = "../user_files/".$js_file["file_id"].".".$c_file_type[1];
				break;
			}
		}
	?>
	
	<a target="_blank" href="<?php echo $file_show_link;?>"><b><?php echo $js_file["file_name"];?></b></a>
	&nbsp;(<?php echo $js_file["file_name"];?>)
	<?php
	}
	

						
}
?>

<br><br>



<?php
if($arrJobseeker["video_id"]!="")
{
?>
	<span style="font-size:14px;font-weight:400">
		<i><b><?php echo $M_VIDEO_RESUME;?></b></i>
	</span>
	<br/><br/>
<?php
	$video_id=$arrJobseeker["video_id"];
	$video_id=str_replace("http://www.youtube.com/watch?v=","",$video_id);
	$video_id=str_replace("https://www.youtube.com/watch?v=","",$video_id);
	$video_id=str_replace("http://youtu.be/","",$video_id);
	$video_id=str_replace("https://youtu.be/","",$video_id);
	?>
	<iframe width="560" height="315" src="http://www.youtube.com/embed/<?php echo $video_id;?>" frameborder="0" allowfullscreen></iframe>
	
	<?php
}
?>

		