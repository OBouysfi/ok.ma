<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
$arrSeeker = $database->DataArray("jobseekers","id=".$id);

$arrResume = $database->DataArray("jobseeker_resumes","username='".$arrSeeker["username"]."'");
				

?>	
<br>

<table summary="" border="0" width=95%>
	<tr>
		<td class=basictext>


		
		
		
		
		
		
		
		
		<div id="resume_content">
		
		
						<span style="font-size:14px;font-weight:400">
							<i><b><?php echo $M_PERSONAL_INFORMATION;?></b></i>
						</span>
						
						<br><br><br>
					
					
							<?php
$MessageTDLength = 120;

$HideSubmit = true;
$HIDE_NATIONALITY=false;
if($HIDE_NATIONALITY)
{
	AddEditForm
	(
	array(
	" <i>".$M_TITLE.":</i>",
	" <i>".$FIRST_NAME.":</i>",
	" <i>".$LAST_NAME.":</i>",
	" <i>".$M_ADDRESS.":</i>",
	" <i>".$TELEPHONE.":</i>",
	" <i>".$M_MOBILE.":</i>",
	" <i>".$M_EMAIL.":</i>",
	" <i>".$M_DOB.":</i>",
	" <i>".$M_GENDER.":</i>",
	" <i>".$M_PICTURE.":</i>"),
	array("title","first_name","last_name","address","phone",
	"mobile","username","dob","gender","logo"),
	array("profile_public","title","first_name","last_name","address","phone",
	"mobile","username","dob","gender","logo"),
	array("textbox_5","textbox_30","textbox_30","textarea_50_4","textbox_30",
	"textbox_30","textbox_30","textbox_30","textbox_30","textbox_30"),
	"jobseekers",
	"id",
	$id,
	"<b>$LES_VALEURS_MODIFIEES_SUCCES!</b>"
	);

}
else
{
 	AddEditForm
	(
	array(" <i>".$M_TITLE.":</i>",
	" <i>".$FIRST_NAME.":</i>",
	" <i>".$LAST_NAME.":</i>",
	" <i>".$M_ADDRESS.":</i>",
	" <i>".$TELEPHONE.":</i>",
	" <i>".$M_MOBILE.":</i>",
	" <i>".$M_EMAIL.":</i>",
	" <i>".$M_DOB.":</i>",
	" <i>".$M_GENDER.":</i>",
	" <i>".$M_NATIONALITY.":</i>",
	" <i>".$M_PICTURE.":</i>"),
	array("title","first_name","last_name","address","phone",
	"mobile","username","dob","gender","nationality","logo"),
	array("title","first_name","last_name","address","phone",
	"mobile","username","dob","gender","nationality","logo"),
	array("textbox_5","textbox_30","textbox_30","textarea_50_4","textbox_30","textbox_30","textbox_30",
	"textbox_30","textbox_30","textbox_30","textbox_30"),
	"jobseekers",
	"id",
	$id,
	"<b>$LES_VALEURS_MODIFIEES_SUCCES!</b>"
	);
}
?>

<table summary="" border="0" width="95%">
	<tr>
		<td>
		
		
<?php	

$arrJobseeker = $database->DataArray("jobseekers","id=".$id);

if(trim($arrJobseeker["jobseeker_fields"]) != "")
{

$arrPropFields = array();

if(is_array(unserialize($arrJobseeker["jobseeker_fields"])))
{
	$arrPropFields = unserialize($arrJobseeker["jobseeker_fields"]);
}

$bFirst = true;
while (list($key, $val) = each($arrPropFields)) 
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
						
						<br><br><br>
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
						foreach($arrResumeLanguages as $arrResumeLanguage)
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
										foreach($arrResumeLanguages as $arrResumeLanguage)
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
										foreach($arrProficiencies as $arrProficiency)
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
						
						
						
						<br><br><br>
						
						<?php echo $M_EDUCATION_LEVEL;?>:
						<br><br style="line-height:2px">
						<?php
						foreach($arrEducationLevels as $arrEducationLevel)
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
						<br><br><br>
						
						
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
						<br><br><br><br>
						
						
						
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
						<br><br><br><br>
						
						
						
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
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
<br><br>
<?php 

echo $arrSeeker["cv"];

?>

<br><br>










<?php
$website->ms_i($id);
	$arrJobseeker = $database->DataArray("jobseekers","id='$id'");

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
	  $arrCategories = explode("\n", $strJobCategories );

		$bFirst = true;		

				foreach($arrCategories as $strCategory)
				{
				
					$arrCategoryItems = explode(".",$strCategory,2);
					if(is_array($arrSelectedCategories) && sizeof($arrSelectedCategories) == 2)
					{
									if(in_array(trim($arrCategoryItems[1]), $arrSelectedCategories)?"checked":"")
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
  <br><br>
  <b>
  <?php
  	if(is_array($arrSelectedLocations))
	{
				$arrRegions = explode("\n", aParameter(802));

				foreach($arrRegions as $strRegion)
				{
				
					$arrCategoryItems = explode(".",$strRegion,2);
									
					if(in_array(trim($arrCategoryItems[1]), $arrSelectedLocations)?"checked":"")
					{
						echo $arrCategoryItems[1];
					}
				
				}
	}			
				 
		?>
  
  	</b>
  
  
      </TD>
    </TR>

    <TR>
      <TD vAlign=top colSpan=2 class=basictext><br><br><?php echo $BRIEF_DESCRIPTION_PROFILE;?>:

<br><br>
<b>
       <?php echo $arrJobseeker["profile_description"];?>
		
</b>		
      </TD>
    </TR>
  </TBODY>
</TABLE>


</div>


</td>
	</tr>
</table>
<br><br>
<br>
<?php
generateBackLink("jobseekers");
?>
