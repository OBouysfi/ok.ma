<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>

  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#by_category" aria-controls="by_category" role="tab" data-toggle="tab"><?php echo $M_BROWSE_CATEGORY;?></a></li>
    <li role="presentation"><a href="http://www.ok.ma/index.php?page=en_Offres+Emploi">Offres emploi</a></li>
	<li role="presentation"><a href="https://www.ok.ma/mod-advanced_search.html">Recherche avancée</a></li>
    <li role="presentation"><a href="https://www.ok.ma/mod-email_alerts.html">Créer une alerte mail</a></li>
    <li role="presentation"><a href="https://www.ok.ma/index.php?page=en_Espace+Recruteurs">Publier une offre</a></li>
	<!--<li role="presentation"><a href="#by_location" aria-controls="by_location" role="tab" data-toggle="tab"><?php echo $M_JOBS_BY_LOCATION;?></a></li>
    <li role="presentation"><a href="#by_company" aria-controls="by_company" role="tab" data-toggle="tab"><?php echo $M_JOBS_BY_COMPANY;?></a></li>-->
  </ul>


  <div class="tab-content padding-5">
    <div role="tabpanel" class="tab-pane active" id="by_category">

		<!--jobs by category-->
	<?php

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
			status=1
			GROUP BY job_category
		");

		while($count_listing = $database->fetch_array($count_jobs))
		{
			
			$strCat = explode(".",$count_listing["job_category"],2);
		
			if(sizeof($strCat)==1)
			{
				$arr_jobs_count[$count_listing["job_category"]] = $count_listing["c"];
			}
			else
			{
				if(!isset($arr_jobs_count[$strCat[0]]))
				{
					$arr_jobs_count[$strCat[0]]=0;
				}
				$arr_jobs_count[$strCat[0]]  += $count_listing["c"];
			}
		}

	}



	$NUMBER_OF_CATEGORIES_PER_ROW = $website->GetParam("NUMBER_OF_CATEGORIES_PER_ROW");

	if(file_exists('categories/categories_'.strtolower($website->lang).'.php'))
	{
		$categories_content = file_get_contents('categories/categories_'.strtolower($website->lang).'.php');
	}
	else
	{
		$categories_content = file_get_contents('categories/categories_en.php');
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

		$strLink = $website->category_link($key,$value);
		
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
	<!--end jobs by category-->
	</div>
	
	
	
	
    <!--<div role="tabpanel" class="tab-pane" id="by_location">
	<!--jobs by location-->
	<?php /*
	$b_first_sub_category = true;
	$i_sub_counter=0;
	$i_category_counter=0;
		
	if(!isset($loc))
	{	
		include("locations/locations_array.php");
	}
	asort($loc);
	foreach($loc as $key=>$value)
	{
		if(!is_string($value)) continue;
		
		$strLink = $website->location_link($key, $value);
		
		
		$b_first_sub_category = true;
		$i_sub_counter=0;
		
		echo "\n<div class=\"col-md-4 no-left-padding margin-bottom-10\">\n";
		
		 
		echo "\n<a href=\"".$strLink."\" class=\"category_link\">".trim($value)."</a>";
		
		if(isset($loc1[$key]))
		{
			foreach($loc1[$key] as $sub_key=>$sub_location)
			{
				if(!is_string($sub_location)) continue;
			
				if($i_sub_counter>=8)
				{
					echo "...";
					break;
				}
				
				if(!$b_first_sub_category) echo ", ";
				
				echo "\n<span class=\"sub_category_link\">".stripslashes(trim($sub_location))."</span>";
				$b_first_sub_category = false;
				$i_sub_counter++;
			}
		}
		
		echo "</div>\n";
		
		$i_category_counter++;
		
		if(($i_category_counter % $NUMBER_OF_CATEGORIES_PER_ROW) == 0)
		{
			echo "\n<div class=\"clear\"></div>";
		}
			
		
	}


		*/
	?>	
	<!--end jobs by location
	</div>
    <div role="tabpanel" class="tab-pane" id="by_company" style="padding-top:20px">
		<div class="col-md-3"><img src="../uploaded_images/24007910.jpg" style="width:100%; height:120px" ></div>
		<div class="col-md-3"><img src="http://www.marocannonces.com/user_images/310/8521436.jpg" style="width:100%; height:120px" ></div>
		<div class="col-md-3"><img src="http://www.marocannonces.com/user_images/309/8056561.jpg" style="width:100%; height:120px" ></div>
		<div class="col-md-3"><img src="http://www.marocannonces.com/user_images/309/7136231.jpg" style="width:100%; height:120px" ></div>
	</div>-->
  </div>


<br/>




