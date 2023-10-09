<?php
if(!defined('IN_SCRIPT')) die("");
$indeed_query = "";
$indeed_location = "";
$has_results=false;
?>
<br/>
<?php
if(isset($_POST["category"])&&($_POST["category"]=="-1"||$_POST["category"]=="")){if(isset($_POST["field_category"])&&$_POST["field_category"]!="") $_POST["category"]=$_POST["field_category"];} 
if(isset($_POST["location"])&&($_POST["location"]=="-1"||$_POST["location"]=="")){if(isset($_POST["field_location"])&&$_POST["field_location"]!="") $_POST["location"]=$_POST["field_location"];} 

if(isset($_REQUEST["search"])&&$_REQUEST["search"]==1)
{
		$strSearchQuery = "";
		
		if(get_param("job_type") != "" && get_param("job_type") != "0"&& get_param("job_type") != "-1")
		{
			$website->ms_i(get_param("job_type"));
			$strSearchQuery .= "AND job_type='".get_param("job_type")."' ";
		}
		
		if(get_param("posting_date") != "" && get_param("job_type") != "0")
		{
			$website->ms_i(get_param("posting_date"));
			$number_days=get_param("posting_date");
			$strSearchQuery .= "AND ".$DBprefix."employers.date>".(time()-$number_days*86400)." ";
		}
		
		if(get_param("company_name") != "")
		{
			$search_company=$website->sanitize(get_param("company_name"));
			$strSearchQuery .= "AND ".$DBprefix."employers.company LIKE '%".$database->escape_string($search_company)."%' ";
			$indeed_query  .= get_param("company_name")." ";
		}
		
		if(get_param("location") != "" && get_param("location") != "-1")
		{
			$website->ms_ew(get_param("location"));
			
			$location_items=explode("@",get_param("location"));
			
			$search_location=$location_items[0];
			
			
			$strSearchQuery .= "AND (region='".$search_location."' OR region LIKE '".$search_location.".%')";
			
			
			$indeed_location = $website->show_full_location($search_location);
			
		}
		
		if(get_param("category") != "" && get_param("category") != "-1")
		{
		
			$cat_items=explode("@",get_param("category"));
			$website->ms_i(str_replace(".","",$cat_items[0]));
			$search_category=$cat_items[0];
			$strSearchQuery .= "AND (job_category='".$search_category."' OR job_category LIKE '".$search_category.".%' ) ";
			
			$indeed_query  .= $website->show_category($search_category)." ";
			
		}
		
		if(get_param("job_title") != "")
		{
			$search_title=$website->sanitize(get_param("job_title"));
			$strSearchQuery .= "AND (".$DBprefix."jobs.title LIKE '%".$database->escape_string($search_title)."%' OR ".$DBprefix."jobs.message LIKE '%".$database->escape_string($search_title)."%')";
			$indeed_query  .= get_param("job_title")." ";
		}
	
		$SearchTable = $database->Query
		("
			SELECT 
			".$DBprefix."jobs.id,
			".$DBprefix."jobs.title,
			".$DBprefix."jobs.date,
			".$DBprefix."jobs.zip,
			".$DBprefix."jobs.salary,
			".$DBprefix."jobs.applications,
			".$DBprefix."jobs.region,
			".$DBprefix."jobs.message,
			".$DBprefix."jobs.ref,
			".$DBprefix."employers.company,
			".$DBprefix."employers.id as employer_id,
			".$DBprefix."employers.logo
			FROM 
			".$DBprefix."employers , ".$DBprefix."jobs
			WHERE 
			".$DBprefix."jobs.employer =  ".$DBprefix."employers.username
			AND 
			".($website->GetParam("ADS_EXPIRE")!=-1?" expires>".time()." AND ":"")."
			".$DBprefix."jobs.active='YES'
			".$strSearchQuery." 
			ORDER BY ".$DBprefix."jobs.featured DESC,".$DBprefix."jobs.id DESC,".$DBprefix."employers.company
			
		
		");

}
else
if(isset($_REQUEST["location"]))
{
	if(file_exists("locations/locations_array.php")) include("locations/locations_array.php");
	elseif(file_exists("../locations/locations_array.php")) include("../locations/locations_array.php");
		
	$location=trim($_REQUEST["location"]);
	
	$website->ms_i(str_replace("-","",$location));
	
	$location=str_replace("-",".",$location);
	
	$SearchTable = $database->Query
	("
		SELECT 
		".$DBprefix."jobs.id,
		".$DBprefix."jobs.title,
		".$DBprefix."jobs.date,
		".$DBprefix."jobs.salary,
		".$DBprefix."jobs.zip,
		".$DBprefix."jobs.applications,
		".$DBprefix."jobs.region,
		".$DBprefix."jobs.message,
		".$DBprefix."employers.company,
		".$DBprefix."employers.id as employer_id,
		".$DBprefix."employers.logo
		FROM ".$DBprefix."jobs,".$DBprefix."employers
		WHERE 
		".$DBprefix."jobs.employer =  ".$DBprefix."employers.username
		AND 
		".($website->GetParam("ADS_EXPIRE")!=-1?" expires>".time()." AND ":"")."
		".$DBprefix."jobs.status = 1
		AND
		 (".$DBprefix."jobs.region='".$location."' 
		 OR 
		 ".$DBprefix."jobs.region LIKE '".$location.".%')
		ORDER BY 
		".$DBprefix."jobs.featured DESC,
		".$DBprefix."jobs.id DESC
	");
	
	$selected_location_name = $website->show_full_location($location);
	

	$website->Title($selected_location_name." ".$website->GetParam("SEO_APPEND_TITLE"));
	$website->MetaDescription($selected_location_name." ".$website->GetParam("SEO_APPEND_DESCRIPTION"));
	$website->MetaKeywords($website->format_keywords($selected_location_name." ".$website->GetParam("SEO_APPEND_KEYWORDS")));
	
	
	

	?>
	<div class="page-header">
		
		<h3 class="no-margin">	
			<?php
			echo $M_SELECTED_LOCATION.": 
			".$selected_location_name;
			?>
		</h3>
	</div>
	<?php
	$selected_region=$location;
	$l_slice=array();
	$array_l=explode(".",$selected_region);

	
	switch (sizeof($array_l)) 
	{
		case 1:
			if(isset($loc1[$array_l[0]])) $l_slice=$loc1[$array_l[0]];
        break;
		case 2:
			if(isset($loc2[$array_l[0]][$array_l[1]])) $l_slice=$loc2[$array_l[0]][$array_l[1]];
        break;
		case 3:
			if(isset($loc3[$array_l[0]][$array_l[1]][$array_l[2]]))  $l_slice=$loc3[$array_l[0]][$array_l[1]][$array_l[2]];
		case 4:
			if(isset($loc4[$array_l[0]][$array_l[1]][$array_l[2]][$array_l[3]]))  $l_slice=$loc4[$array_l[0]][$array_l[1]][$array_l[2]][$array_l[3]];
        break;
  	}
	
	$iCounter = 0;
	
	$NUMBER_OF_CATEGORIES_PER_ROW=4;
	
	if(isset($l_slice)&&is_array($l_slice))
	{
		foreach($l_slice as $c_key=>$l_slice_element)
		{
						
			if($website->GetParam("SEO_URLS")==1)
			{
				$strLink = ($MULTI_LANGUAGE_SITE?$M_SEO_LOCATION:"location")."-".$website->format_str($l_slice_element)."-".str_replace(".","-",$selected_region."-".$c_key).".html";
			}
			else
			{
				$strLink = "index.php?mod=search&location=".str_replace(".","-",$selected_region."-".$c_key).($MULTI_LANGUAGE_SITE?"&lang=".$website->lang:"");
			}
			
			if($iCounter==($NUMBER_OF_CATEGORIES_PER_ROW*5))
			{
				echo "<div id=\"sub_locations\" style=\"display:none\">";
			}
			
			echo "<div class=\"col-md-3\">\n";	
				
			echo "<b><a href=\"".$strLink."\" style='text-decoration:none;font-weight:400'>".$l_slice_element."</a></b>";
			echo "</div>";
			
			if(($iCounter+1)%$NUMBER_OF_CATEGORIES_PER_ROW==0)
			{
				echo "<div class=\"clear\"></div>";
			}
			$iCounter ++;
		}
		
		if($iCounter>($NUMBER_OF_CATEGORIES_PER_ROW*5))
		{
			echo "</div>";
			?>
			<div class="clear"></div>
			<script>
			function ShowSubLocations()
			{
				document.getElementById("sub_locations").style.display="block";
				document.getElementById("sub_loc_points").innerHTML="";
				document.getElementById("sub_loc_show").innerHTML="";
			}
			
			</script>
			<span class="pull-left" id="sub_loc_points">...........</span>
			<span class="pull-right underline-link" id="sub_loc_show"><a href="javascript:ShowSubLocations()"><?php echo $M_SEE_ALL;?></a></span>
			
			<div class="clear"></div>
			<br/>
			<?php
		}
	}

	
	//end selected location
}
else
if(get_param("company") != "")
{

	
	$website->ms_i(get_param("company"));
	$company=get_param("company");
	
	$arrCompany=$database->DataArray("employers","id=".$company);
	?>
	<div class="page-header">
		<h3 class="no-margin">
			<?php echo stripslashes($arrCompany["company"])." ".$M_JOBS;?>
		</h3>
	</div>
	<?php
	
	$website->Title(stripslashes($arrCompany["company"])." ".$M_JOBS);
	$website->MetaDescription(stripslashes($arrCompany["company"])." ".$M_JOBS);
	$website->MetaKeywords(stripslashes($arrCompany["company"])." ".$M_JOBS);
	
	$time_start = mktime(0, 0, 0, date('m'), date('d')-30, date('Y'));
	
	$SearchTable = $database->Query
	("
		SELECT 
		".$DBprefix."jobs.id,
		".$DBprefix."jobs.title,
		".$DBprefix."jobs.date,
		".$DBprefix."jobs.salary,
		".$DBprefix."jobs.zip,
		".$DBprefix."jobs.applications,
		".$DBprefix."jobs.region,
		".$DBprefix."jobs.message,
		".$DBprefix."jobs.ref,
		".$DBprefix."employers.company,
		".$DBprefix."employers.id as employer_id,
		".$DBprefix."employers.logo
		FROM ".$DBprefix."employers , ".$DBprefix."jobs
		WHERE 
		".$DBprefix."jobs.employer =  ".$DBprefix."employers.username
		AND 
		".($website->GetParam("ADS_EXPIRE")!=-1?" expires>".time()." AND ":"")."
		".$DBprefix."jobs.active='YES'
		AND
		".$DBprefix."employers.id=".get_param("company")."
		/*AND
		".$DBprefix."jobs.date >=".$time_start."*/
		
		ORDER BY ".$DBprefix."jobs.date DESC
	");
	$indeed_query  .= get_param("company")." ";
}
else
if(isset($_REQUEST["latest"]))
{
	
	$SearchTable = $database->Query
	("
		SELECT 
		".$DBprefix."jobs.id,
		".$DBprefix."jobs.title,
		".$DBprefix."jobs.date,
		".$DBprefix."jobs.salary,
		".$DBprefix."jobs.applications,
		".$DBprefix."jobs.region,
		".$DBprefix."jobs.message,
		".$DBprefix."jobs.ref,
		".$DBprefix."employers.company,
		".$DBprefix."employers.logo
		FROM ".$DBprefix."jobs,".$DBprefix."employers  
		WHERE 
		".$DBprefix."jobs.employer =  ".$DBprefix."employers.username
		AND ".$DBprefix."jobs.active='YES'
		AND ".$DBprefix."jobs.status=1
		AND expires>".time()." 
		ORDER BY ".$DBprefix."jobs.id DESC
	
	");
	?>
	
	<h3 class="no-margin"><?php echo $M_LATEST_JOBS;?></h3>
	<hr/>
	<br/>
	<?php
	$website->Title($M_LATEST_JOBS);
	$website->MetaDescription("");
	$website->MetaKeywords("");
}
else
if(isset($_REQUEST["featured"]))
{
	
	$SearchTable = $database->Query
	("
		SELECT 
		".$DBprefix."jobs.id,
		".$DBprefix."jobs.title,
		".$DBprefix."jobs.date,
		".$DBprefix."jobs.salary,
		".$DBprefix."jobs.applications,
		".$DBprefix."jobs.region,
		".$DBprefix."jobs.message,
		".$DBprefix."jobs.ref,
		".$DBprefix."employers.company,
		".$DBprefix."employers.logo
		FROM ".$DBprefix."jobs,".$DBprefix."employers  
		WHERE 
		".$DBprefix."jobs.employer =  ".$DBprefix."employers.username
		AND ".$DBprefix."jobs.active='YES'
		AND ".$DBprefix."jobs.status=1
		AND ".$DBprefix."jobs.featured=1
		AND expires>".time()." 
		ORDER BY ".$DBprefix."jobs.id DESC
	
	");
	?>
	
	<h3 class="no-margin"><?php echo $FEATURED_JOBS;?></h3>
	<hr/>
	<br/>
	<?php
	$website->Title($FEATURED_JOBS);
	$website->MetaDescription("");
	$website->MetaKeywords("");
}




	if(isset($_REQUEST["num"]))
	{
		$website->ms_i($_REQUEST["num"]);
		$num=$_REQUEST["num"];
	}
	else 
	{
		$num=0;
	}

$bFlag = true;
?>
<div class="page-wrap">
<?php	
if(false&&!$website->GetParam("ENABLE_INDEED_BACKFILL") && $iNResults == 0)
{
	echo "
	<div>
	<i>".$NO_JOB_OFFERS_FOUND."</i>
	</div>
	";
}
else
{

	if
	(
		isset($_REQUEST["category"])
		&&
		!isset($_REQUEST["search"])
	)
	{

		$category=trim($_REQUEST["category"]);
		
		$website->ms_i(str_replace("-","",$category));
		
		$category=str_replace("-",".",$category);
			
		$SearchTable = $database->Query
		("
			SELECT 
			".$DBprefix."jobs.id,
			".$DBprefix."jobs.title,
			".$DBprefix."jobs.date,
			".$DBprefix."jobs.salary,
			".$DBprefix."jobs.zip,
			".$DBprefix."jobs.applications,
			".$DBprefix."jobs.region,
			".$DBprefix."jobs.message,
			".$DBprefix."jobs.ref,
			".$DBprefix."employers.company,
			".$DBprefix."employers.id as employer_id,
			".$DBprefix."employers.logo
			FROM ".$DBprefix."jobs,".$DBprefix."employers  
			WHERE 
			".$DBprefix."jobs.employer =  ".$DBprefix."employers.username
			AND 
			".($website->GetParam("ADS_EXPIRE")!=-1?" expires>".time()." AND ":"")."
			".$DBprefix."jobs.status = 1
			AND
			(
				job_category='".$category."' 
				OR 
				job_category LIKE '".$category.".%'
			)
			ORDER BY 
			".$DBprefix."jobs.featured DESC,
			".$DBprefix."jobs.id DESC
		");
		
		
		$arr_jobs_count = array();

		if($website->GetParam("SHOW_LISTINGS_NUMBER")==1)
		{

			$count_jobs = $database->Query
			("
				SELECT count(id) c, 
				job_category 
				FROM ".$DBprefix."jobs
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
			if(file_exists('categories/categories_'.strtolower($website->lang).'.php'))
			{
				$categories_content = file_get_contents('categories/categories_'.strtolower($website->lang).'.php');
			}
			else
			{
				$categories_content = file_get_contents('categories/categories_en.php');
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
		echo "<h1 class=\"no-margin\">".$M_CATEGORY.": ";
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
						$strLink = "http://".$DOMAIN_NAME."/".$website->create_cat_link($current_id, $categories);
					}
				}
				else
				{
					$strLink = "index.php?mod=search&category=".str_replace(".","-",$current_id).($MULTI_LANGUAGE_SITE?"&lang=".$website->lang:"");
				}
				
				echo "<a class=\"underline-link\" href=\"".$strLink."\">".$current_category."</a>"." > ";
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
		
		echo "</h1>";
		echo "</div>";
		
		$website->Title($seo_category_title." ".$website->GetParam("SEO_APPEND_TITLE"));
		$website->MetaDescription($seo_category_title." ".$website->GetParam("SEO_APPEND_DESCRIPTION"));
		$website->MetaKeywords($website->format_keywords($seo_category_title." ".$website->GetParam("SEO_APPEND_KEYWORDS")));
		
		
		
		if($website->multi_language)
		{
			
			foreach($website->languages as $language)
			{
				if($language==$website->lang) continue;
				
				if(file_exists("include/texts_".$language.".php"))
				{
					include("include/texts_".$language.".php");
				}
				
				$str_category_lang_link=$website->category_link($category,$seo_category_title,$language,$M_SEO_CATEGORY);
				
				$website->TemplateHTML = 
				str_replace
				(
					'"index.php?lang='.$language.'"',
					$str_category_lang_link,
					$website->TemplateHTML
				);
			}
			include("include/texts_".$website->lang.".php");
		}
	
		$indeed_query  .= $categories[trim($category)]." ";
		$i_substr_cat=substr_count($category, ".");
		
		echo '<div class="row">';
		
		foreach($categories as $key=>$value)
		{
			$i_substr_key=substr_count($key, ".");
			
			if($i_substr_key != ($i_substr_cat+1))
			{
				continue;
			}
			
			if(strpos($key, $category.".", 0) === 0)
			{
			
				$strLink = $website->category_link($key,$value);
				
				echo "\n<div class=\"col-sm-4 margin-bottom-10\">\n";
				
				echo "\n<a class=\"sub-cat-result\" href=\"".$strLink."\" title=\"".trim($value)."\" >".trim($value)."</a>";
			
				if($website->GetParam("SHOW_LISTINGS_NUMBER")==1)
				{
					echo " (".(isset($arr_jobs_count[$key])?$arr_jobs_count[$key]:"0").")";
				}
			
				echo "</div>";
			}
		}
		?>
		<div class="clear"></div>
		</div>
		<!-- <hr/> -->
		
		<br/>
		<?php
	}//end selected category

	
?>
<div class="clear"></div>


		 
<?php



//ZIP RADIUS SEARCH

if(get_param("zip_radius") == "1" && get_param("zip") != "")
{
	include("include/distance.php");
	$arrInitZips = array();	
	while($zipAd = $database->fetch_array($SearchTable))
	{
		if($zipAd["zip"] != "")
		{
			array_push($arrInitZips, "".$zipAd["zip"]);
		}
	}
	array_push($arrInitZips, get_param("zip"));
	$arrLatLon = GetLatLon($arrInitZips);
	mysqli_data_seek($SearchTable,0);
}

//END ZIP RADIUS SEARCH
?>
<div class="row">
<?php

$iNResults = $database->num_rows($SearchTable);

$iTotResults = 0;

$bAltFlag = true;
$iJCounter = 0;
while($job = $database->fetch_array($SearchTable))
{
	
	if($iTotResults>=$num*$website->GetParam("RESULTS_PER_PAGE")&&$iTotResults<($num+1)*$website->GetParam("RESULTS_PER_PAGE"))
	{

		if(isset($arrLatLon))
		{
			if(trim($job["zip"]) == "" )
			{
				continue;
			}
			else
			if(trim($job["zip"]) != "" && trim($job["zip"]) == trim(get_param("zip")))
			{
			
			}
			else
			{
				$distance = intval(GetDistance($arrLatLon,$job["zip"],get_param("zip"), get_param("zip_type")));
				
				if($distance == 0 || $distance > intval(get_param("zip_distance")))
				{
					continue;
				}
			}
		}
						
		$iJCounter++;
		
		show_job($job);
		$has_results=true;
		$bFlag = false;
	}
	$iTotResults++;
}

$indeed_results = $website->GetParam("RESULTS_PER_PAGE");
if( ( ($num+1)*$website->GetParam("RESULTS_PER_PAGE") - $iTotResults) >= 0 )
{
	$show_indeed = true;
	$indeed_results = ($num+1)*$website->GetParam("RESULTS_PER_PAGE") - $iTotResults;
}
else
{
	$show_indeed = false;
}

$str_i_co = "";

if(trim($indeed_location)!="")
{
	$arr_indeed_countries=explode("\n",$website->GetParam("INDEED_DEFAULT_COUNTRIES"));	
	
	foreach($arr_indeed_countries as $str_indeed_country)
	{
		$arr_indeed_country=explode("\t",$str_indeed_country);
		
		if(sizeof($arr_indeed_country)==2)
		{
			$pos = strpos($indeed_location, $arr_indeed_country[0]);
			
			if ($pos === false) 
			{
			  
			} 
			else 
			{
				$str_i_co = trim($arr_indeed_country[1]); 
				break;
			}
		}
	}
	
	if($str_i_co=="")
	{
		//$show_indeed = false;
	}
}
	
if(get_param("company")!="")	
{
	$show_indeed = false;
}


if($website->GetParam("FEEDS_USAGE")!=0&&!isset($_REQUEST["company"]))
{
	if(isset($_REQUEST["num"]))
	{
		$website->ms_i($_REQUEST["num"]);
		$num=$_REQUEST["num"];
	}
	else 
	{
		$num=0;
	}

	if(trim($indeed_query)=="")
	$indeed_query = ".";

	$feeds=get_feeds($indeed_query,(isset($selected_location_name)?$selected_location_name:$indeed_location),$str_i_co,$num,20,get_param("zip"),get_param("zip_distance"));
	$iJCounter_indeed=0;
	foreach ($feeds as $feed) 
	{
		show_feed_job($feed);
		$iJCounter_indeed++;
		$has_results=true;
	}
}


if(!$has_results)
{
	$website->NoIndex();
}
?>

  <br>
 

<?php
}

		$strSearchString = "";
			
		foreach ($_POST as $key=>$value) 
		{ 
			if($key != "num"&&$key!="i_start")
			{
				$strSearchString .= $key."=".$value."&";
			}
		}
		
		foreach ($_GET as $key=>$value) 
		{ 
			if($key != "num"&&$key!="i_start")
			{
				$strSearchString .= $key."=".$value."&";
			}
		}
		
		if($website->GetParam("FEEDS_USAGE")!=0&&$iJCounter_indeed>0)
		{
			echo '<ul class="pagination">';
			if(isset($_REQUEST["num"]))
			{
				$website->ms_i($_REQUEST["num"]);
				$num=$_REQUEST["num"];
			}
			else 
			{
				$num=0;
			}
			if($num>0)
			{
				echo "<li><a class=\"pagination-link\" href=\"index.php?".$strSearchString."num=".($num-1)."\"> << ".$M_PREVIOUS." </a></li>";
			}
			
			echo "<li><a class=\"pagination-link\" href=\"index.php?".$strSearchString."num=".($num+1)."\"> ".$M_NEXT." >> </a></li>";
			
			echo '</ul>';
		}
		else
		{
			
			if(ceil($iTotResults/$website->GetParam("RESULTS_PER_PAGE")) > 1)
			{
				echo '<ul class="pagination">';
				
			
				
				$inCounter = 0;
				
				if(($num+1) != 1)
				{
					echo "<li><a class=\"pagination-link\" href=\"index.php?".$strSearchString."num=1\"> << </a></li>";
					
					echo "<li><a class=\"pagination-link\" href=\"index.php?".$strSearchString."num=".($num)."\"> < </a></li>";
				}
				
				$iStartNumber = ($num+1);
				
				if($iStartNumber > (ceil($iTotResults/$website->GetParam("RESULTS_PER_PAGE")) - 2))
				{
					$iStartNumber = (ceil($iTotResults/$website->GetParam("RESULTS_PER_PAGE")) - 2);
				}
				
				if($iStartNumber>3&&($num+1)<(ceil($iTotResults/$website->GetParam("RESULTS_PER_PAGE")) - 1))
				{
					$iStartNumber=$iStartNumber-2;
				}
				
				if($iStartNumber <= 3)
				{
					$iStartNumber = 1;
				}
				
				for($i= $iStartNumber ;$i<=ceil($iTotResults/$website->GetParam("RESULTS_PER_PAGE"));$i++)
				{
					if($inCounter>=10)
					{
						break;
					}
					
					if($i == $num) // ikan corriger $num+1
					{
						echo "<li><a><b>".$i."</b></a></li>";
					}
					else
					{
						echo "<li><a class=\"pagination-link\" href=\"index.php?".$strSearchString."num=".$i."\">".$i."</a></li>";
					}
									
					
					$inCounter++;
				}
				
				if(($num+1)<ceil($iTotResults/$website->GetParam("RESULTS_PER_PAGE")))
				{
					echo "<li><a href=\"index.php?".$strSearchString."num=".($num+2)."\"> ></b></a></li>";
					
					echo "<li><a href=\"index.php?".$strSearchString."num=".(ceil($iTotResults/$website->GetParam("RESULTS_PER_PAGE")))."\"> >> </a></li>";
				}
				
				echo '</ul>';
			}
		}
	?>

	
	<?php	
	if($show_indeed && $website->GetParam("FEEDS_USAGE")!=0 && $website->GetParam("INDEED_PUBLISHER_ID")!="" &&$indeed_results>0 && $iJCounter_indeed > 0)
	{
	?>	<br/>	
	<span id="indeed_at" style="font-size:10px"><a href="http://www.indeed.com/" rel="nofollow">jobs</a> by <a
	href="http://www.indeed.com/" title="Job Search" rel="nofollow"><img
	src="http://www.indeed.com/p/jobsearch.gif" style="border: 0;
	vertical-align: middle;" alt="Indeed job search"></a></span>
	<script type="text/javascript" src="http://www.indeed.com/ads/apiresults.js"></script>
	<?php
	}
	?>

<?php
if(!$has_results)
{
	echo "<i>".$NO_JOB_OFFERS_FOUND."</i>";
}
?>
</div>
</div>
<?php
$website->Title($SEARCH_RESULTS);
$website->MetaDescription("");
$website->MetaKeywords("");
?>