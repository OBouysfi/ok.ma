<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="fright">

	<?php
		echo LinkTile
		 (
			"cv",
			"description",
			$M_GO_BACK,
			"",
			"red"
		 );
	
	?>

</div>
<div class="clear"></div>		
		<?php
		if(isset($_POST["ProceedSaveResume"]))
		{
			if($database->SQLCount("jobseeker_resumes","WHERE username='".$AuthUserName."'") == 0)
			{
				$database->SQLInsert("jobseeker_resumes",array("username"),array($AuthUserName));
			}

			$database->SQLUpdate
				(
					"jobseeker_resumes",
					
					array
					(
						 		 "employer_name_1",
								  "employer_address_1",
								  "job_1_dates",
								  "job_1_title",
								  "job_1_duties",
								  "employer_name_2",
								  "employer_address_2",
								  "job_2_dates",
								  "job_2_title",
								  "job_2_duties",
								  "employer_name_3",
								  "employer_address_3",
								  "job_3_dates",
								  "job_3_title",
								  "job_3_duties",
								  "employer_name_4",
								  "employer_address_4",
								  "job_4_dates",
								  "job_4_title",
								  "job_4_duties",
								  "skills",
								  "experience_level",
								  "education_level",
								  "native_language",
								  "language_1",
								  "language_1_level",
								  "language_2",
								  "language_2_level",
								  "language_3",
								  "language_3_level",
								  "school_1_name",
								  "school_1_courses",
								  "school_1_dates",
								  "school_1_degree",
								  "school_2_name",
								  "school_2_courses",
								  "school_2_dates",
								  "school_2_degree",
								  "school_3_name",
								  "school_3_courses",
								  "school_3_dates",
								  "school_3_degree"
					)
					,
					array
					(
						 		  get_param("employer_name_1"),
								  get_param("employer_address_1"),
								  get_param("job_1_dates"),
								  get_param("job_1_title"),
								  get_param("job_1_duties"),
								  get_param("employer_name_2"),
								  get_param("employer_address_2"),
								  get_param("job_2_dates"),
								  get_param("job_2_title"),
								  get_param("job_2_duties"),
								  get_param("employer_name_3"),
								  get_param("employer_address_3"),
								  get_param("job_3_dates"),
								  get_param("job_3_title"),
								  get_param("job_3_duties"),
								  get_param("employer_name_4"),
								  get_param("employer_address_4"),
								  get_param("job_4_dates"),
								  get_param("job_4_title"),
								  get_param("job_4_duties"),
								  get_param("skills"),
								  get_param("experience_level"),
								  get_param("education_level"),
								  get_param( "native_language"),
								  get_param("language_1"),
								  get_param("language_1_level"),
								  get_param("language_2"),
								  get_param("language_2_level"),
								  get_param("language_3"),
								  get_param("language_3_level"),
								  get_param("school_1_name"),
								  get_param("school_1_courses"),
								  get_param("school_1_dates"),
								  get_param("school_1_degree"),
								  get_param("school_2_name"),
								  get_param("school_2_courses"),
								  get_param("school_2_dates"),
								  get_param("school_2_degree"),
								  get_param("school_3_name"),
								  get_param("school_3_courses"),
								  get_param("school_3_dates"),
								  get_param("school_3_degree")
					)
					,
					
					"username='".$AuthUserName."'"
				);
				
				
		
		}
		
		
		
		$arrResume = $database->DataArray("jobseeker_resumes","username='".$AuthUserName."'");
		
		
		?>
		
						<br>
						
						<form action="index.php" method="post">
						<input type="hidden" name="ProceedSaveResume" value="1">
						<input type="hidden" name="action" value="<?php echo $action;?>">
						<input type="hidden" name="category" value="<?php echo $category;?>">
					
						
						<span style="font-size:14px;font-weight:400">
							<i><b><?php echo $M_PERSONAL_INFORMATION;?></b></i>
						</span>
						
						<br><br><br>
						
						<?php echo $M_VIEW_MODIFY_PROFILE;?>
						<a href="index.php?category=profile&action=edit"><?php echo $M_PROFILE_MODIFY;?></a> 
						<?php echo $M_PAGE;?>!
						
						<br><br><br>
						<span style="font-size:14px;font-weight:400">
							<i><b><?php echo $M_WORK_HISTORY;?></b></i>
						</span>
						<br><br>
						<font size=1><i><?php echo $M_WORK_HISTORY_EXPL;?> </i></font>
						
						<br><br>
						
						<b><?php echo $M_NAME_RECENT_EMPLOYER;?></b>
						
						<br><br style="line-height:2px">
						<input type="text" value="<?php echo $arrResume["employer_name_1"];?>" name="employer_name_1" style="width:350px">
						<br><br>
						
						<b><?php echo $M_EMPLOYER_ADDRESS;?></b>
						<br><br style="line-height:2px">
						<textarea name="employer_address_1" style="height:60px;width:350px"><?php echo $arrResume["employer_address_1"];?></textarea>
						
						<br><br>
						
						<b><?php echo $M_DATES_STARTED_ENDED;?></b>
						<br><br style="line-height:2px">
						<input type="text" name="job_1_dates" value="<?php echo $arrResume["job_1_dates"];?>" style="width:350px">
						<br><br>
						
						<b><?php echo $M_YOUR_JOB_TITLE;?></b>
						<br><br style="line-height:2px">
						<input type="text" name="job_1_title" value="<?php echo $arrResume["job_1_title"];?>" style="width:350px">
						<br><br>
						
						<b><?php echo $M_YOUR_JUB_DUTIES;?></b>
						<br><br style="line-height:2px">
						
						<textarea name="job_1_duties" style="height:60px;width:350px"><?php echo $arrResume["job_1_duties"];?></textarea>
						
						<br><br>
				


						<br><br>
						
						<b><?php echo $M_NAME_PREVIOUS_EMPLOYER;?></b>
						
						<br><br style="line-height:2px">
						<input type="text" name="employer_name_2" value="<?php echo $arrResume["employer_name_2"];?>" style="width:350px">
						<br><br>
						
						<b><?php echo $M_EMPLOYER_ADDRESS;?></b>
						<br><br style="line-height:2px">
						<textarea name="employer_address_2" style="height:60px;width:350px"><?php echo $arrResume["employer_address_2"];?></textarea>
						
						
						<br><br>
						
						<b><?php echo $M_DATES_STARTED;?> </b>
						<br><br style="line-height:2px">
						<input type="text" name="job_2_dates" value="<?php echo $arrResume["job_2_dates"];?>" style="width:350px">
						<br><br>
						
						<b><?php echo $M_YOUR_JOB_TITLE;?></b>
						<br><br style="line-height:2px">
						<input type="text" name="job_2_title" value="<?php echo $arrResume["job_2_title"];?>" style="width:350px">
						<br><br>
						
						<b><?php echo $M_YOUR_JUB_DUTIES;?></b>
						<br><br style="line-height:2px">
						
						<textarea name="job_2_duties" style="height:60px;width:350px"><?php echo $arrResume["job_2_duties"];?></textarea>
						
						<br><br>
						
						
						
						<br><br>
						
						<b><?php echo $M_NAME_PREVIOUS_EMPLOYER;?></b>
						
						<br><br style="line-height:2px">
						<input type="text" name="employer_name_3" value="<?php echo $arrResume["employer_name_3"];?>" style="width:350px">
						<br><br>
						
						<b><?php echo $M_EMPLOYER_ADDRESS;?></b>
						<br><br style="line-height:2px">
						<textarea name="employer_address_3" style="height:60px;width:350px"><?php echo $arrResume["employer_address_3"];?></textarea>
						<br><br>
						
						<b><?php echo $M_DATES_STARTED;?></b>
						<br><br style="line-height:2px">
						<input type="text" name="job_3_dates" value="<?php echo $arrResume["job_3_dates"];?>" style="width:350px">
						<br><br>
						
						<b><?php echo $M_YOUR_JOB_TITLE;?></b>
						<br><br style="line-height:2px">
						<input type="text" name="job_3_title" value="<?php echo $arrResume["job_3_title"];?>" style="width:350px">
						<br><br>
						
						<b><?php echo $M_YOUR_JUB_DUTIES;?></b>
						<br><br style="line-height:2px">
						
						<textarea name="job_3_duties" style="height:60px;width:350px"><?php echo $arrResume["job_3_duties"];?></textarea>
						
						<br><br>
						
						
						<br><br>
						
						<b><?php echo $M_NAME_PREVIOUS_EMPLOYER;?></b>
						
						<br><br style="line-height:2px">
						<input type="text" name="employer_name_4" value="<?php echo $arrResume["employer_name_4"];?>" style="width:350px">
						<br><br>
						
						<b><?php echo $M_EMPLOYER_ADDRESS;?></b>
						<br><br style="line-height:2px">
						<textarea name="employer_address_4" style="height:60px;width:350px"><?php echo $arrResume["employer_address_4"];?></textarea>
						<br><br>
						
						<b><?php echo $M_DATES_STARTED;?></b>
						<br><br style="line-height:2px">
						<input type="text" name="job_4_dates" value="<?php echo $arrResume["job_4_dates"];?>" style="width:350px">
						<br><br>
						
						<b><?php echo $M_YOUR_JOB_TITLE;?></b>
						<br><br style="line-height:2px">
						<input type="text" name="job_4_title" value="<?php echo $arrResume["job_4_title"];?>" style="width:350px">
						<br><br>
						
						<b><?php echo $M_YOUR_JUB_DUTIES;?></b>
						<br><br style="line-height:2px">
						
						<textarea name="job_4_duties" style="height:60px;width:350px"><?php echo $arrResume["job_4_duties"];?></textarea>
						
						<br><br>
						
						
						<br><br>
						
						<span style="font-size:14px;font-weight:400">
							<i><b><?php echo $M_SKILLS;?></b></i>
						</span>
						
						<br><br>
						
						
						<b><?php echo $M_YOUR_SKILLS;?></b>
						<br><br style="line-height:2px">
						<textarea name="skills" style="height:150px;width:350px"><?php echo $arrResume["skills"];?></textarea>
						
						<br><br>
						<b><?php echo $M_NATIVE_LANGUAGE;?></b>
						<br><br style="line-height:2px">
						<select name="native_language">
						<option value="-1"><?php echo $M_PLEASE_SELECT;?></option>
						<?php
						foreach($website->GetParam("arrResumeLanguages") as $key=>$value)
						{
							echo "<option value=\"".$key."\" ".($key==$arrResume["native_language"]?"selected":"").">".$value."</option>";
						}
						?>
						</select>
						
						<br><br>
						
						
						<?php
						for($i=1;$i<=3;$i++)
						{
						?>
						
						<table summary="" border="0">
				      	<tr>
				      		<td>
							
								<b><?php echo $M_FOREIGN_LANGUAGE;?> <?php echo $i;?></b>
							
							
							</td>
							<td> &nbsp; </td>
				      		<td>
							
										<b><?php echo $M_PROFICIENCY;?></b>
							
							</td>
				      	</tr>
				      	<tr>
				      		<td>
									<select name="language_<?php echo $i;?>">
										<option value="-1"><?php echo $M_PLEASE_SELECT;?></option>
										<?php
										foreach($website->GetParam("arrResumeLanguages") as $key=>$value)
										{
											echo "<option value=\"".$key."\" ".($key==$arrResume["language_".$i]?"selected":"").">".$value."</option>";
										}
										?>
										</select>
									
							
							</td>
							<td> &nbsp; </td>
				      		<td>
							
										<select name="language_<?php echo $i;?>_level">
										<option value="-1"><?php echo $M_PLEASE_SELECT;?></option>
										<?php
										foreach($website->GetParam("arrProficiencies") as $key=>$value)
										{
											echo "<option value=\"".$key."\" ".($key==$arrResume["language_".$i."_level"]?"selected":"").">".$value."</option>";
										}
										?>
										</select>
							
							
							</td>
				      	</tr>
				      </table>
					  
					  <br>
					  
					  <?php
					  }
					  ?>
						
						
						
						
						
						
						
						
						
						<br><br>
						
						<span style="font-size:14px;font-weight:400">
							<i><b><?php echo $M_EDUCATION;?></b></i>
						</span>
						<br><br>
						
						<font size=1><i>
						<?php echo $M_EDUCATION_EXPL;?>
						</i></font>
						
						<br><br><br>
						
						<b><?php echo $M_EDUCATION_LEVEL;?> </b>
						<br><br style="line-height:2px">
						<select name="education_level">
						<option value="-1"><?php echo $M_PLEASE_SELECT;?></option>
						<?php
						foreach($website->GetParam("arrEducationLevels") as $key=>$value)
						{
								echo "<option value=\"".$key."\" ".($key==$arrResume["education_level"]?"selected":"").">".$value."</option>";
						}
						?>
						</select>
						
						<br><br><br>
						
						
							<b><?php echo $M_NAME_LAST_SCHOOL;?></b>
						
						<br><br style="line-height:2px">
						<input type="text" name="school_1_name" value="<?php echo $arrResume["school_1_name"];?>" style="width:350px">
						<br><br>
						
						<b><?php echo $M_COURSES_STUDIED;?></b>
						<br><br style="line-height:2px">
						<input type="text" name="school_1_courses" value="<?php echo $arrResume["school_1_courses"];?>" style="width:350px">
						<br><br>
						
						<b><?php echo $M_DATES_ATTENDED;?> </b>
						<br><br style="line-height:2px">
						<input type="text" name="school_1_dates" value="<?php echo $arrResume["school_1_dates"];?>" style="width:350px">
						<br>
						<font size=1><i><?php echo $M_CURRENT_EDUCATION_EXPL;?></i></font>
						<br><br>
						
						<b><?php echo $M_DEGREE_EARNED;?></b>
						<br><br style="line-height:2px">
						<input type="text" name="school_1_degree" value="<?php echo $arrResume["school_1_degree"];?>" style="width:350px">
					
						<br><br><br><br>
						
						
						
							<b><?php echo $M_NAME_PREVIOUS_SCHOOL;?></b>
						
						<br><br style="line-height:2px">
						<input type="text" name="school_2_name" value="<?php echo $arrResume["school_2_name"];?>" style="width:350px">
						<br><br>
						
						<b><?php echo $M_COURSES_STUDIED;?></b>
						<br><br style="line-height:2px">
						<input type="text" name="school_2_courses" value="<?php echo $arrResume["school_2_courses"];?>" style="width:350px">
						<br><br>
						
						<b><?php echo $M_DATES_ATTENDED;?> </b>
						<br><br style="line-height:2px">
						<input type="text" name="school_2_dates" value="<?php echo $arrResume["school_2_dates"];?>" style="width:350px">
						<br><br>
						
						<b><?php echo $M_DEGREE_EARNED;?></b>
						<br><br style="line-height:2px">
						<input type="text" name="school_2_degree" value="<?php echo $arrResume["school_2_degree"];?>" style="width:350px">
					
						<br><br><br><br>
						
						
						
							<b><?php echo $M_NAME_PREVIOUS_SCHOOL;?></b>
						
						<br><br style="line-height:2px">
						<input type="text" name="school_3_name" value="<?php echo $arrResume["school_3_name"];?>" style="width:350px">
						<br><br>
						
						<b><?php echo $M_COURSES_STUDIED;?></b>
						<br><br style="line-height:2px">
						<input type="text" name="school_3_courses" value="<?php echo $arrResume["school_3_courses"];?>" style="width:350px">
						<br><br>
						
						<b><?php echo $M_DATES_ATTENDED;?> </b>
						<br><br style="line-height:2px">
						<input type="text" name="school_3_dates" value="<?php echo $arrResume["school_3_dates"];?>" style="width:350px">
						<br><br>
						
						<b><?php echo $M_DEGREE_EARNED;?></b>
						<br><br style="line-height:2px">
						<input type="text" name="school_3_degree" value="<?php echo $arrResume["school_3_degree"];?>" style="width:350px">
					
					<br><br>
					<br>
						<table summary="" border="0" width="100%">
				      	<tr>
				      		<td align="left">
								<input type="submit" value=" <?php echo $SAUVEGARDER;?> " class="btn btn-primary">
							</td>
				      	</tr>
				      </table>
						
						</form>
		
		<?php
		
		?>