<?php
if(!defined('IN_SCRIPT')) die("");
?>
	<div class="container">
			<button  class="btn btn-gradient jobs-location-link pull-right" type="button" data-toggle="collapse" data-target=".cat-collapse">
				<?php echo $M_JOBS_BY_LOCATION;?>
			</button>
			<div class="clearfix"></div>
			<div class="collapse cat-collapse text-left">
			<div class="container">
			
				<br/>
<?php
if(!defined('IN_SCRIPT')) die("");
$NUMBER_OF_CATEGORIES_PER_ROW = $this->GetParam("NUMBER_OF_CATEGORIES_PER_ROW");
$b_first_sub_category = true;
$i_sub_counter=0;
$i_category_counter=0;
	
if(!isset($loc))
{	
	include_once("locations/locations_array.php");
}
asort($loc);
foreach($loc as $key=>$value)
{
	if(!is_string($value)) continue;
	
	if($this->GetParam("SEO_URLS")==1)
	{
		$strLink = ($MULTI_LANGUAGE_SITE?$M_SEO_LOCATION:"location")."-".$this->format_str($value)."-".str_replace(".","-",$key).".html";
	}
	else
	{
		$strLink = "index.php?mod=search&location=".str_replace(".","-",$key).($MULTI_LANGUAGE_SITE?"&lang=".$this->lang:"");
	}
	
	$b_first_sub_category = true;
	$i_sub_counter=0;
	
	echo "\n<div class=\"col-md-4 no-left-padding margin-bottom-10\">\n";
		
	
	if($this->GetParam("SEO_URLS")==1)
	{
		$strLink = ($MULTI_LANGUAGE_SITE?$M_SEO_LOCATION:"location")."-".$this->format_str($value)."-".str_replace(".","-",$key).".html";
	}
	else
	{
		$strLink = "index.php?mod=search&location=".str_replace(".","-",$key).($MULTI_LANGUAGE_SITE?"&lang=".$this->lang:"");
	}
	 
	echo "\n<a href=\"".$strLink."\" class=\"category_link\">".trim($value)."</a>";
	
	if(isset($loc1[$key]))
	{
		foreach($loc1[$key] as $sub_key=>$sub_location)
		{
			if(!is_string($sub_location)) continue;
	
			if($this->GetParam("SEO_URLS")==1)
			{
				$strLink = ($MULTI_LANGUAGE_SITE?$M_SEO_LOCATION:"location")."-".$this->format_str($sub_location)."-".str_replace(".","-",$key."-".$sub_key).".html";
			}
			else
			{
				$strLink = "index.php?mod=search&location=".str_replace(".","-",$key."-".$sub_key).($MULTI_LANGUAGE_SITE?"&lang=".$this->lang:"");
			}
	
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



?>
<div class="clear"></div>	

<hr/>
		</div>
	</div>
</div>	