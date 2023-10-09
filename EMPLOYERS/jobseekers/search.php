<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="fright">

	<?php
				 
		echo LinkTile
		(
			"jobseekers",
			"list",
			$M_BROWSE,
			"",
			"yellow"
		);
	
		
	
	?>

</div>
<div class="clear"></div>
<?php
if($website->GetParam("CHARGE_TYPE") == 1&&$arrUser["subscription"]==0)
{
	echo '<h4><span class="red-font">'.$M_NEED_SUBSCRIPTION_RESUMES.'</span>';
	?>
	<br/><br/>
	<a class="underline-link" href="index.php?category=home&action=credits"><?php echo $M_PLEASE_SELECT_TO_FEATURED;?></a></h4>
	<?php
	
}
else
{
?>
<h3>
	<?php echo $SEARCH_CVS;?>
</h3>

<br/>


<?php
if(!isset($_POST["ProceedSearch"]))
{
?>

	<div class="container">
		<form action="index.php" method="post">
		<input type="hidden" name="category" value="<?php echo $category;?>">
		<input type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="ProceedSearch" value="1">
		
		
		
		<h4 class="italic">
		<?php echo $M_EDUCATION;?>
		</h4>
		<br/>
		
		
			<div class="col-md-2">
					<?php 
						echo $M_EDUCATION_LEVEL;
					?>:		
			</div>
			<div class="col-md-4">
				
					<select name="education_level" class="form-control">
						<option value="-1"><?php echo $M_ALL;?></option>
						<?php
						foreach($website->GetParam("arrEducationLevels") as $key=>$value)
						{
								echo "<option value=\"".$key."\">".$value."</option>";
						}
						?>
					</select>
		
			</div>
			<div class="col-md-2">
					<?php 
						echo $M_DEGREE_CERTIFICATE;				
					?>:			
			</div>
			<div class="col-md-4">
				
					<input type="text" name="education_keyword" class="form-control">
		
			</div>
   		<div class="clear"></div>
		<br><br>
		
			<h4 class="italic">
			<?php echo $M_LANGUAGES;?>
			</h4>
			<br/>
			
			<div class="col-md-2">
					<?php 
						echo $M_NATIVE_LANGUAGE;
					?>:		
			</div>
			<div class="col-md-4">
				
					<select name="native_language" class="form-control">
						<option value="-1"><?php echo $M_ALL;?></option>
						<?php
						foreach($website->GetParam("arrResumeLanguages") as $key=>$value)
						{
							echo "<option value=\"".$key."\">".$value."</option>";
						}
						?>
					</select>
		
			</div>
			<div class="col-md-2">
					<?php 
						echo $M_FOREIGN_LANGUAGE;
					?>:			
			</div>
			<div class="col-md-4">
				
					<select name="foreign_language" class="form-control">
						<option value="-1"><?php echo $M_ALL;?></option>
						<?php
						foreach($website->GetParam("arrResumeLanguages") as $key=>$value)
						{
							echo "<option value=\"".$key."\">".$value."</option>";
						}
						?>
					</select>
		
			</div>
   		
		<br><br>
		
		<h4 class="italic">
			<?php echo $M_WORK_HISTORY;?>
		</h4>
		<br>
		
			<div class="col-md-2">
					<?php 
						echo $M_PREVIOUS_EMPLOYER;
					?>:		
			</div>
   			<div class="col-md-4">
				
					<input type="text" size=20 name="previous_employer" class="form-control">
			</div>
   			<div class="col-md-2">
					<?php 
						echo $M_JOB_TITLE_DUTIES				
					?>:			
			</div>
   			<div class="col-md-4">
				<input type="text" size=20 name="job_title" class="form-control">
		
   			</div>
  	
		<div class="clear"></div>	

		<br/>
		<h4 class="italic">
			<?php echo $M_JOB_PREFERENCES;?>
		</h4>
		<br/>
		
			<div class="col-md-2">
					<?php 
						echo $M_CATEGORY				
					?>:		
			</div>
   			<div class="col-md-4">
				
						<select name="job_category" class="form-control">
					
					<?php
				
					echo "<option value=\"\">".$M_ALL."</option>";

						if(file_exists('../categories/categories_'.$website->lang.'.php'))
						{
							$lines = file('../categories/categories_'.$website->lang.'.php');
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
							echo "<option value=\"".trim($key)."\" ".(isset($strVal)&&$strVal==trim($key)?"selected":"")." >".trim($val)."</option>";
							$arr_sub_cats = get_sub_cats($key,$lines);
							
							if(sizeof($arr_sub_cats)>0)
							{
								while (list($s_key, $s_val) = each($arr_sub_cats)) 
								{
									echo "<option value=\"".trim($s_key)."\" ".(isset($strVal)&&$strVal==trim($s_key)?"selected":"")." style=\"font-size:10px\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".trim($s_val)."</option>";
								}
							}
						}
					?>
					</select>
		
		
				</div>
   				<div class="col-md-2">
					<?php 
						echo $M_REGION				
					?>:			
				</div>
   				<div class="col-md-4">
				
				<select name="preferred_location" class="form-control">
				
				<option value="-1"><?php echo $M_ALL;?></option>
				<?php
				if(!isset($loc))
				{
					include_once("../locations/locations_array.php");
				}

				if(isset($loc))
					{
						foreach($loc as $key=>$value)
						{
							if(!is_string($value)) continue;
							echo "\n<option value=\"".$key."\">".$value."</option>";
						}
					}
				?>
				</select>
		
				</div>
   			
  		<div class="clear"></div>		
		 
		<br/>
		
		
			<div class="col-md-2">
					<?php 
						echo $M_TEXT_SEARCH;
					?>:		
			</div>
   			<div class="col-md-4">
				
					<input type="text" size=20 name="searchby" class="form-control">
		
			</div>
   			
  		 
		 <div class="clear"></div>
				
			
		
		
		
		<br>
		<i>
		<?php 
		echo $M_SEARCH_PERFORMED_EXPL;
		?>
		</i>
		
		<br/>
		<br/>
		
		
		<input type="submit" class="btn btn-primary" value=" <?php echo $SEARCH;?> ">
		
		
		</form>
	</div>


<?php
}
else
{

	$strAddQuery = "";
	$include_resumes=false;
	if(get_param("education_level")!=""&&get_param("education_level")!="-1")
	{

		$strAddQuery .= " AND education_level=".get_param("education_level");
		
		$include_resumes=true;
	}
	
	if(get_param("education_keyword")!="")
	{
		$strAddQuery .= " AND 
			(
				school_1_degree LIKE '%".get_param("education_keyword")."%'
				OR
				school_1_courses LIKE '%".get_param("education_keyword")."%'
				OR
				school_2_degree LIKE '%".get_param("education_keyword")."%'
				OR
				school_2_courses LIKE '%".get_param("education_keyword")."%'
				OR
				school_3_degree LIKE '%".get_param("education_keyword")."%'
				OR
				school_3_courses LIKE '%".get_param("education_keyword")."%'
				
			)
		";
		$include_resumes=true;
	}
	
	
	
	if(get_param("native_language")!=""&&get_param("native_language")!="-1")
	{
		$strAddQuery .= " AND native_language=".get_param("native_language");
		$include_resumes=true;
	}
	
	if(get_param("preferred_location")!=""&&get_param("preferred_location")!="-1")
	{
		
		$strAddQuery .= " AND 
			preferred_locations  LIKE '%\"".get_param("preferred_location")."\"%'
		";
	}
	
	if(get_param("job_category")!="")
	{
		$strAddQuery .= " AND 
			(
			industry_sector LIKE '%\"".get_param("job_category")."-%\"%'
			OR
			industry_sector LIKE '%\"".get_param("job_category")."\"%'
			
			)";
			
			
			
	}
	
	if(get_param("foreign_language")!=""&&get_param("foreign_language")!="-1")
	{
		$strAddQuery .= " AND 
			(
				language_1=".get_param("foreign_language")."
				OR
				language_2=".get_param("foreign_language")."
				OR
				language_3=".get_param("foreign_language")."
			)
		";
		$include_resumes=true;
	}
	
	if(get_param("previous_employer")!="")
	{
		$strAddQuery .= " AND 
			(
				employer_name_1  LIKE '%".get_param("previous_employer")."%'
				OR
				employer_name_2  LIKE '%".get_param("previous_employer")."%'
				OR
				employer_name_3  LIKE '%".get_param("previous_employer")."%'
				OR
				employer_name_4  LIKE '%".get_param("previous_employer")."%'
				
			)
		";
		$include_resumes=true;
	}
	
	if(get_param("job_title")!="")
	{
		$strAddQuery .= " AND 
			(
				job_1_title LIKE '%".get_param("job_title")."%'
				OR
				job_1_duties LIKE '%".get_param("job_title")."%'
				OR
				job_2_title LIKE '%".get_param("job_title")."%'
				OR
				job_2_duties LIKE '%".get_param("job_title")."%'
				OR
				job_3_title LIKE '%".get_param("job_title")."%'
				OR
				job_3_duties LIKE '%".get_param("job_title")."%'
				OR
				job_4_title LIKE '%".get_param("job_title")."%'
				OR
				job_4_duties LIKE '%".get_param("job_title")."%'
				
			)
		";
		$include_resumes=true;
	}
	
	$short_s=false;	 
	if($strAddQuery == "")
	{
	   $short_s=true;	 
	}
	
	if(get_param("searchby")!="")
	{	
		
		if($short_s) 
		{
		   $strAddQuery .= " AND 
			(
				skills LIKE '%".get_param("searchby")."%'
				OR
				".$DBprefix."jobseekers.cv LIKE '%".get_param("searchby")."%'
				OR
				".$DBprefix."jobseekers.profile_description LIKE '%".get_param("searchby")."%'
			
			)
		";
		
	
		}
		else
		{
			$strAddQuery .= " AND 
			(
				skills LIKE '%".get_param("searchby")."%'
				OR
				".$DBprefix."jobseekers.cv LIKE '%".get_param("searchby")."%'
				OR
				".$DBprefix."jobseekers.profile_description LIKE '%".get_param("searchby")."%'
			
			)
		";
		}
		
		
		
	}
	
	
	
	$found_users = $database->Query
	("
		SELECT DISTINCT user FROM
		".$DBprefix."files
		WHERE 
		".(get_param("searchby")!=""?"file_text LIKE '%".get_param("searchby")."%' AND":"")."
		 is_resume=1
	
	");
	
	
	
	
	if($database->num_rows($found_users)>0)
	{
		$users_list="";
		$b_first=true;
		while($f_user = $database->fetch_array($found_users))
		{
		
			if(!$b_first) $users_list .= ",";
			$users_list .= "'".$f_user["user"]."'";
			$b_first=false;
		}
		
		
		$strAddQuery .= " OR ".$DBprefix."jobseekers.username IN (".$users_list.")";
	}
	
	
	
	
	
	if($short_s)
	{
		 $QUERY_TO_EXECUTE = 
		"SELECT DISTINCT
			".$DBprefix."jobseekers.first_name,
			".$DBprefix."jobseekers.last_name,
			".$DBprefix."jobseekers.video_id,
			".$DBprefix."jobseekers.title,
			".$DBprefix."jobseekers.preferred_locations,
			".$DBprefix."jobseekers.profile_description,
			".$DBprefix."jobseekers.industry_sector,
			".$DBprefix."jobseekers.gender,
			".$DBprefix."jobseekers.id
		FROM 
		".$DBprefix."jobseekers,
			".$DBprefix."jobseeker_resumes
		WHERE
		
			".$DBprefix."jobseekers.profile_public=1 AND active=1 
			".$strAddQuery."
		";
		
		
		
	}
	else
	{
		$QUERY_TO_EXECUTE = 
		"SELECT DISTINCT
			".$DBprefix."jobseekers.first_name,
			".$DBprefix."jobseekers.last_name,
			".$DBprefix."jobseekers.video_id,
			".$DBprefix."jobseekers.title,
			".$DBprefix."jobseekers.preferred_locations,
			".$DBprefix."jobseekers.profile_description,
			".$DBprefix."jobseekers.industry_sector,
			".$DBprefix."jobseekers.gender,
			".$DBprefix."jobseekers.id
		FROM 
			".$DBprefix."jobseekers,
			".$DBprefix."jobseeker_resumes
		WHERE
			".($include_resumes?$DBprefix."jobseekers.username=".$DBprefix."jobseeker_resumes.username AND ":"")."
			".$DBprefix."jobseekers.profile_public=1 
			AND 
			active=1 
			
			".$strAddQuery."
		";
	
	}
	
	$_REQUEST["hide_refine_search"]=true; 
	$show_detailed_info = true;
		
	RenderTable
	(
		"jobseekers",
		array("ShowCV","first_name","last_name","profile_description"),
		array($M_CV,$FIRST_NAME,$LAST_NAME,$DESCRIPTION),
		"620",
		"",
		"",
		"id",
		
		"index.php?category=".$category."&action=".$action."&ProceedSearch=1&searchby=".get_param("searchby")."&job_title=".get_param("job_title")."&previous_employer=".get_param("previous_employer")."&native_language=".get_param("native_language")."&foreign_language=".get_param("foreign_language")."&education_level=".get_param("education_level")."&education_keyword=".get_param("education_keyword"),
		false,
		20,
		false,
		-1,
		"",
		$QUERY_TO_EXECUTE
	);
	
						
				
}
}
?>

