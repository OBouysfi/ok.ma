<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");


?>
<div class="page-wrap">

<?php
if(
	!isset($_REQUEST["search"])&&
	!isset($_REQUEST["category"])
)
{
?>
		
	<h3 class="no-margin"><?php echo $M_SEARCH_COURSE;?></h3>
	<hr/>
	<form name="home_form" id="home_form" action="index.php"  style="margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px" method="post"> 
	<input type="hidden" name="mod" value="courses">
	<input type="hidden" name="search" value="1">
	<?php
	if($MULTI_LANGUAGE_SITE)
	{
	?>
	<input type="hidden" name="lang" value="<?php echo $website->lang;?>"/>
	<?php
	}
	?>
		<div class="col-md-5 form-group group-1">
			<span class="bigger-font"><?php echo $M_KEYWORD;?></span>
			<br/>
			
			<input type="text" name="keyword" class="no-margin form-control" placeholder="">
		</div>
		
		
		<div class="col-md-5 form-group group-2">
		
			<span class="bigger-font"><?php echo $M_CATEGORY;?></span>
			<br/>
			<select name="category" id="category" onchange="dropDownChange(this,'category')" class="form-control">
				<option value="-1"><?php echo $M_ALL;?></option>
				<?php
				
				if(!isset($l))
				{
					if(file_exists("categories/course_categories_array_".$website->lang.".php"))
					{
						include("categories/course_categories_array_".$website->lang.".php");
					}
					else
					{
						include("categories/course_categories_array_en.php");
					}
				}
					foreach($l as $key=>$value)
					{
						
						echo "<option value=\"".$key."@".$value."\">".$value."</option>";
					}
				?>
			</select>
		
		
		</div>
		
		<div class="col-md-2 text-right">
			<br/>
			<button type="submit" class="btn btn-md btn-default custom-gradient btn-green pull-right margin-top-3"><?php echo $M_SEARCH;?></button>
		</div>
		<div class="clearfix"></div>
	</form>	
	
	<div class="clearfix"></div>
	<br/>
	
	
	<h3><?php echo $M_BROWSE_COURSES;?></h3>
	<hr/>
	
		
<?php

$arr_jobs_count = array();

if($website->GetParam("SHOW_LISTINGS_NUMBER")==1)
{

	$count_jobs = $database->Query
	("
		SELECT count(id) c, 
		job_category 
		FROM ".$DBprefix."courses
		WHERE
		".($website->GetParam("ADS_EXPIRE")!=-1?" expires>".time()." AND ":"")."
		status=1
		GROUP BY job_category
	");

	while($count_listing = $database->fetch_array($count_jobs))
	{
		$strCat = explode(".",$count_listing["job_category"],2);
		
		$arr_jobs_count[$count_listing["job_category"]] = $count_listing["c"];
	
		if(!isset($arr_jobs_count[$strCat[0]]))
		{
			$arr_jobs_count[$strCat[0]]=0;
		}
		$arr_jobs_count[$strCat[0]]  += $count_listing["c"];
	}
}

$NUMBER_OF_CATEGORIES_PER_ROW = $website->GetParam("NUMBER_OF_CATEGORIES_PER_ROW");

if(file_exists('categories/course_categories_'.strtolower($website->lang).'.php'))
{
	$categories_content = file_get_contents('categories/course_categories_'.strtolower($website->lang).'.php');
}
else
{
	$categories_content = file_get_contents('categories/course_categories_en.php');
}

$cat_lines = explode("\n", trim($categories_content));

$b_first_sub_category = true;
$i_sub_counter=0;
$i_category_counter=0;

$arr_categories=array();

foreach($cat_lines as $strCategory)
{
	list($key,$value)=explode(". ",$strCategory);
	$arr_categories[trim($key)]=trim($value);
	
	$strLink = $website->course_category_link($key,$value);
	
	if(substr_count($key, '.') == 0)
	{
		if($i_category_counter!=0) echo "\n</div>";
		
		if(($i_category_counter % $NUMBER_OF_CATEGORIES_PER_ROW) == 0)
		{
			echo "\n<div class=\"clear\"></div>";
		}
		
		echo "\n<div class=\"col-md-4 no-left-padding\" >\n";
		
		echo "\n<div class=\"category_link\">";
		echo "<a href=\"".$strLink."\" class=\"main_category_link\" title=\"".trim($value)."\">".trim($value)."</a>";
		if($website->GetParam("SHOW_LISTINGS_NUMBER")==1)
		{
			echo " <span class=\"sub_category_link\">(".(isset($arr_jobs_count[$key])?$arr_jobs_count[$key]:"0").")</span>";
		}
		echo "</div>";
	
		$b_first_sub_category = true;
		$i_sub_counter=0;
		$i_category_counter++;
	}
	else
	if(substr_count($key, '.') == 1)
	{
		
		if($i_sub_counter<8)
		{
													
			echo "<span class=\"sub_category_link\">".($i_sub_counter>0?", ":"")."".trim($value)."</span>";
				
		}
		if($i_sub_counter==8) echo "...";
		$b_first_sub_category = false;
		$i_sub_counter++;
	}
	
}
?>
		</div>	
		<div class="clearfix"></div>
		<br/>
	

<?php

}
else
if(isset($_REQUEST["category"])&&!isset($_REQUEST["search"]))
{
	$category=trim($_REQUEST["category"]);
		
		$website->ms_i(str_replace("-","",$category));
		
		$category=str_replace("-",".",$category);
			
		$SearchTable = $database->Query
		("
			SELECT 
			".$DBprefix."courses.id,
			".$DBprefix."courses.title,
			".$DBprefix."courses.date,
			".$DBprefix."courses.region,
			".$DBprefix."courses.message,
			".$DBprefix."employers.company,
			".$DBprefix."employers.logo
			FROM ".$DBprefix."courses,".$DBprefix."employers  
			WHERE 
			".$DBprefix."courses.employer =  ".$DBprefix."employers.username
			AND 
			".($website->GetParam("ADS_EXPIRE")!=-1?" expires>".time()." AND ":"")."
			".$DBprefix."courses.status = 1
			AND
			(
			job_category='".$category."' 
			OR 
			job_category LIKE '".$category.".%'
			)
			ORDER BY 
			".$DBprefix."courses.featured DESC,
			".$DBprefix."courses.id DESC
		");
		
		
		$arr_jobs_count = array();

		if($website->GetParam("SHOW_jobs_NUMBER")==1)
		{

			$count_jobs = $database->Query
			("
				SELECT count(id) c, 
				job_category 
				FROM ".$DBprefix."courses.
				WHERE
				".($website->GetParam("ADS_EXPIRE")!=-1?" expires>".time()." AND ":"")."
				status=1 AND
				job_category LIKE '".$category.".%'
				GROUP BY job_category
			");

			while($count_listing = $database->fetch_array($count_jobs))
			{
				$c_job_category = $count_listing["job_category"];
				$c_level = substr_count($category, '.');
				
				$c_items = array_slice(explode('.', $c_job_category),0,$c_level+2);
				$category_id = implode('.',$c_items);
				if(!isset($arr_jobs_count[$category_id]))
				{
					$arr_jobs_count[$category_id]=0;
				}
				$arr_jobs_count[$category_id]  += $count_listing["c"];
			}

		}

		if(!isset($categories))
		{
			if(file_exists('categories/course_categories_'.strtolower($website->lang).'.php'))
			{
				$categories_content = file_get_contents('categories/course_categories_'.strtolower($website->lang).'.php');
			}
			else
			{
				$categories_content = file_get_contents('categories/course_categories_en.php');
			}

			$arrCategories = explode("\n", trim($categories_content));

			$categories=array();
			
			foreach($arrCategories as $str_category)
			{
				list($key,$value)=explode(". ",$str_category);
				$categories["".trim($key)]=trim($value);
			}
			asort($categories);
		}
		echo '<div class="page-header">';
		echo "<h3 class=\"no-margin\">".$M_CATEGORY.": ";
		$seo_category_title="";
		if(substr_count($category,".")>0)
		{
			$category_items = explode(".",$category);
			$current_id="";
			$b_first = true;
			for($i=0;$i<sizeof($category_items)-1;$i++)
			{
				if(!$b_first) $current_id.=".";
				$current_id .= $category_items[$i];
				
				$b_first = false;
				
				$current_category = $categories[$current_id];
				
				if($website->GetParam("SEO_URLS")==1)
				{
					if($MULTI_LANGUAGE_SITE)
					{
						$strLink = ($MULTI_LANGUAGE_SITE?$M_SEO_CATEGORY:"category")."-".$website->format_str($current_category)."-".str_replace(".","-",$current_id).".html";
					}
					else
					{
						$strLink = $website->create_cat_link($current_id, $categories);
					}
				}
				else
				{
					$strLink = "index.php?mod=search&category=".str_replace(".","-",$current_id).($MULTI_LANGUAGE_SITE?"&lang=".$website->lang:"");
				}
				
				echo "<a href=\"".$strLink."\">".$current_category."</a>"." > ";
				$seo_category_title.=$current_category." - ";
			}
		}
		if(!isset($categories[trim($category)]))
		{
			die("<script>document.location.href='index.php';</script>");
		}
		else
		{
			echo $categories[trim($category)];
		}
		$seo_category_title.=$categories[trim($category)];
		
		echo "</h3>";
		echo "</div><div class=\"row\">";
		
		$website->Title($seo_category_title." ".$website->GetParam("SEO_APPEND_TITLE"));
		$website->MetaDescription($seo_category_title." ".$website->GetParam("SEO_APPEND_DESCRIPTION"));
		$website->MetaKeywords($website->format_keywords($seo_category_title." ".$website->GetParam("SEO_APPEND_KEYWORDS")));
		
		$i_substr_cat=substr_count($category, ".");
		
		foreach($categories as $key=>$value)
		{
			$i_substr_key=substr_count($key, ".");
			
			if($i_substr_key != ($i_substr_cat+1))
			{
				continue;
			}
			
			if(strpos($key, $category.".", 0) === 0)
			{
			
				$strLink = $website->course_category_link($key,$value);
				
				echo "\n<div class=\"col-sm-4 margin-bottom-10\">\n";
				
				echo "\n<a class=\"sub-cat-result\" href=\"".$strLink."\" title=\"".trim($value)."\" >".trim($value)."</a>";
			
				if($website->GetParam("SHOW_jobs_NUMBER")==1)
				{
					echo " (".(isset($arr_jobs_count[$key])?$arr_jobs_count[$key]:"0").")";
				}
			
				echo "</div>";
			}
		}
		
		
		
		?>
		<div class="clear"></div>
		</div>
		
		<hr/>
		<br/>
		<?php
		
		while($course = $database->fetch_array($SearchTable))
		{
			show_course($course);
		}
		
		if($database->num_rows($SearchTable)==0)
		{
			echo "<i>".$M_NO_RESULTS."</i><br/><br/>";
		}
		
		?>		
		<br/>
	<?php
	
}
else
if(isset($_REQUEST["search"]))
{
	$keyword = $website->sanitize($_REQUEST["keyword"]);
	
?>
	<div class="page-header">
		<h3 class="no-margin">
			<?php 
			if($keyword=="")
			{
				echo $SEARCH_RESULTS;
			}
			else
			{
				echo $M_SEARCH_BY.": ".$keyword;
			}
			?>
		</h3>
	</div>
<?php

	
	$SearchTable = $database->Query
		("
			SELECT 
			".$DBprefix."courses.id,
			".$DBprefix."courses.title,
			".$DBprefix."courses.date,
			".$DBprefix."courses.region,
			".$DBprefix."courses.message,
			".$DBprefix."employers.company,
			".$DBprefix."employers.logo
			FROM ".$DBprefix."courses,".$DBprefix."employers  
			WHERE 
			".$DBprefix."courses.employer =  ".$DBprefix."employers.username
			AND 
			".($website->GetParam("ADS_EXPIRE")!=-1?" expires>".time()." AND ":"")."
			".$DBprefix."courses.status = 1
			AND
			(
				title LIKE '%".$database->escape_string($keyword)."%' 
				OR 
				message LIKE '%".$database->escape_string($keyword)."%' 
				OR 
				company LIKE '%".$database->escape_string($keyword)."%' 
			)
			ORDER BY 
			".$DBprefix."courses.featured DESC,
			".$DBprefix."courses.id DESC
		");
		
		
		while($course = $database->fetch_array($SearchTable))
		{
			show_course($course);
		}
		
		if($database->num_rows($SearchTable)==0)
		{
			echo "<i>".$M_NO_RESULTS."</i><br/><br/><br/><br/>";
		}
		

}
?>

</div>
<?php
$website->Title($M_COURSES);
$website->MetaDescription("");
$website->MetaKeywords("");
?>