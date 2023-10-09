<?php
function show_job($job)
{
	global $website,$M_SAVE,$M_SAVED,$M_JOB_DETAILS,$M_APPLICATIONS,$M_POSTED_ON;
	global $M_DELETE,$is_saved_page,$M_SALARY,$APPLY_THIS_JOB_OFFER,$MULTI_LANGUAGE_SITE,$M_COMPANY_DETAILS,$M_MORE_JOBS_FROM;
	
	
	
	$strLink=$website->job_link($job["id"],$job["title"]);
	
	echo '<div class="job-wrap">
		<div class="row">
		<div class="col-sm-8">';
	
	
	
	echo '<a class="results-job-title-link" href="'.$strLink.'"><h4 class="no-margin results-job-title">'.stripslashes(strip_tags($job["title"])).'</h4></a>';

	echo '<ul class="results-job-details">';
	if($job["salary"]!=""&&$job["salary"]!="0")
	{
		echo '<li>'.$M_SALARY.': <strong>'.stripslashes($job["salary"]).'</strong></li>';
	}
	if($job["region"]!="")
	{
		$job_location=$website->show_full_location($job["region"]);
		
		if($job_location!="")
		{
			echo '<li><strong>'.$job_location.'</strong></li>';
		}
	}
	echo '<li>'.$M_POSTED_ON.': <strong>'.date($website->GetParam("DATE_HOUR_FORMAT"),strip_tags($job["date"])).'</strong></li>';
	echo '<li><strong>'.$job["applications"].'</strong> '.$M_APPLICATIONS.'</li>';
	echo '</ul>';
	
	echo '<div class="results-job-description">'.$website->text_words(stripslashes(strip_tags($job["message"])),30).'</div>';
	echo '<div class="clearfix"></div><br/>';
	
	echo '<a href="index.php?mod=apply&posting_id='.$job["id"].($MULTI_LANGUAGE_SITE?'&lang='.$website->lang:'').'" class="job-details-link underline-link r-margin-15">'.$APPLY_THIS_JOB_OFFER.'</a>';
	echo '<a href="'.$strLink.'" class="job-details-link underline-link">'.$M_JOB_DETAILS.'</a>';
	echo '<div class="clearfix"></div><br/>';
	echo '</div>
		<div class="col-sm-4">';
		
		echo '<div  class="save-job-link pull-right">';
	
			
			if(isset($_COOKIE["saved_listings"]) && strpos($_COOKIE["saved_listings"], $job["id"].",") !== false)
			{
				if(isset($_REQUEST["mod"])&&$_REQUEST["mod"]=="saved")
				{
					echo '<a href="javascript:DeleteSavedListing('.$job["id"].')" id="save_'.$job["id"].'">'.$M_DELETE.'</a>';
				}
			}
			else
			{
			
				echo '<a href="javascript:SaveListing('.$job["id"].')" id="save_'.$job["id"].'">'.$M_SAVE.' <img height="13" src="images/save-small-icon.png" alt="'.$M_SAVE.'"/></a>';
		
			}
					
						
		echo '</div>';
		echo '<a href="'.$strLink.'">';
		if($job["logo"]!=""&&file_exists('thumbnails/'.$job["logo"].'.jpg'))
		{
			echo '<img class="img-responsive logo-results" src="thumbnails/'.$job["logo"].'.jpg" alt="'.$job["company"].'"/>';
		
		}
		else
		{
			echo '<div class="company-wrap">'.$job["company"].'</div>';
		}
		echo '</a>';
	
	echo '</div>
	</div>
	</div>';

}



function show_course($job)
{
	global $website,$M_SAVE,$M_SAVED,$M_COURSE_DETAILS,$M_APPLICATIONS,$M_POSTED_ON;
	global $M_DELETE,$is_saved_page;
	$strLink=$website->course_link($job["id"],$job["title"]);
	
	echo '<div class="job-wrap">
		<div class="row">
		<div class="col-md-9">';
	
	
	
	echo '<a class="results-job-title-link" href="'.$strLink.'"><h4 class="no-margin results-job-title">'.stripslashes($job["title"]).'</h4></a>';

	echo '<ul class="results-job-details">';

	if($job["region"]!="")
	{
		$job_location=$website->show_full_location($job["region"]);
		
		if($job_location!="")
		{
			echo '<li>'.$job_location.'</li>';
		}
	}
	echo '<li>'.$M_POSTED_ON.': '.date($website->GetParam("DATE_HOUR_FORMAT"),$job["date"]).'</li>';
	
	echo '</ul>';
	
	echo '<div class="results-job-description">'.$website->text_words(stripslashes($job["message"]),30).'</div>';
	echo '<div class="clearfix"></div>';
	echo '<a href="'.$strLink.'" class="job-details-link">'.$M_COURSE_DETAILS.'</a>';
	echo '<div class="clearfix"></div>';
	echo '</div>
		<div class="col-md-3 text-right">';
		
		if($job["logo"]!=""&&file_exists('thumbnails/'.$job["logo"].'.jpg'))
		{
			echo '<img class="img-responsive logo-results" src="thumbnails/'.$job["logo"].'.jpg" alt="'.$job["company"].'"/>';
		
		}
		else
		{
			echo '<div class="company-wrap">'.$job["company"].'</div>';
		}		
		
	echo '</div>
	</div>
	</div>';

}


function show_feed_job($job)
{
	global $website,$M_JOB_DETAILS,$M_POSTED_ON,$M_POSTED_BY;
	
	$strLink=$website->job_feed_link($job["id"],$job["title"],$job["type"],$job["url"]);
	
	echo '<div class="job-wrap">
		<div class="row">
		<div class="col-md-9">';
	
	
	
	echo '<a '.($job["type"]!="indeed"?"target=\"_blank\"":"").' href="'.$strLink.'"><h4 class="no-margin results-job-title">'.stripslashes($job["title"]).'</h4></a>';

	echo '<ul class="results-job-details">';
	if(isset($job["salary"])&&$job["salary"]!="")
	{
		echo '<li>'.stripslashes($job["salary"]).'</li>';
	}
	if($job["location"]!="")
	{
		echo '<li>'.$job["location"].'</li>';
	}
	echo '<li>'.$M_POSTED_ON.': '.$job["date"].'</li>';
	
	echo '</ul>';
	
	echo '<div class="results-job-description">'.$website->text_words(stripslashes($job["description"]),30).'</div>';
	echo '<div class="clearfix"></div>';
	echo '<a '.($job["type"]!="indeed"?"target=\"_blank\"":"").' href="'.$strLink.'" class="job-details-link">'.$M_JOB_DETAILS.'</a>';
	echo '<div class="clearfix"></div>';
	echo '</div>
	<div class="col-md-3 text-center">';
	if(trim($job["company"])!="")
	{
		echo '<div  class="save-job-link">'.$M_POSTED_BY.'</div>';
		
		echo '<span class="feed-company">'.$job["company"].'</span>';
	}
	echo '</div>
	</div>
	</div>';

}



function get_param($param_name)
{ 
	global $_POST; global $_GET; 
	$param_value = ""; 
	if(isset($_POST[$param_name])) $param_value = $_POST[$param_name]; 
	else if(isset($_GET[$param_name])) $param_value = $_GET[$param_name]; 
	
	if(is_array($param_value)) 
		return $param_value;
	else 
		return str_escape(stripslashes($param_value));
}

function str_escape($value)
{
    $search = array("\x00", "\\", "'", "\"", "\x1a");
    $replace = array("\\x00", "\\\\" ,"\'", "\\\"", "\\\x1a");

    return str_replace($search, $replace, $value);
}

function CreateUrl($strUrl, $merchant = "")
{
	global $website;
	
	$strUrlPrefix  = "";
	
	if(get_param("p") != "")
	{
		$strUrlPrefix = get_param("p")."-";
	}
	else
	{
		if($merchant!="")
		{
			$strUrlPrefix = $merchant."-";
		}
	}
	
	if(true)	
	{
		$strUrlPrefix = "http://".$website->domain."/".$strUrlPrefix;
	}
	
	if(!$website->GetParam("SEO_URLS"))	
	{
		if($merchant!="")
		{
			return $strUrl."&p=".$merchant;
		}
		else
		if(get_param("p") != "")	
		{
			return $strUrl."&p=".get_param("p");
		}
		else
		{
			return $strUrl;
		}
	}
	else
	{
		if(strstr($strUrl,"index.php?mod=products&cat="))
		{
			$arrItems = explode("cat=",$strUrl);
			global $products_category_name;
			return $strUrlPrefix."category/".$arrItems[1]."/".urlencode(str_replace("/","-",$products_category_name)).".html";
		}
		else
		if(strstr($strUrl,"index.php?mod=products&id="))
		{
			$arrItems = explode("id=",$strUrl);
			global $product_name;
			$display_product_name = preg_replace('/[^[ a-zA-Z0-9]]*/','',$product_name);
			$display_product_name = str_replace("  "," ",$display_product_name);
			$display_product_name = str_replace(" ","-",$display_product_name);
			return $strUrlPrefix."product/".$arrItems[1]."/".urlencode(str_replace("/","-",$display_product_name)).".html";
		}
		else
		if(strstr($strUrl,"index.php?mod=cart&quantity=1&action=add&id="))
		{
			$arrItems = explode("id=",$strUrl);
			
			return $strUrlPrefix."cart_".$arrItems[1].".html";
		}
	
		
	}
	
	return "";
	
}


function text_words($string, $wordsreturned)
{
      $retval = $string;    
	$array = explode(" ", $string);
  
       if (count($array)<=$wordsreturned)
	{
		$retval = $string;
	}
	else
	{
		array_splice($array, $wordsreturned);
		$retval = implode(" ", $array)." ...";
	}
		return $retval;
 }
 
 
function show_stars($vote)
{
	global $website;
	
	$result = "<div>";
	
	for($x=0;$x<floor($vote);$x++)
	{
		$result .= "<img src=\"".($website->GetParam("USE_ABSOLUTE_URLS")?"http://www.".$DOMAIN_NAME."/":"")."images/full-star.gif\" width=\"13\" height=\"12\" style=\"float:left\">";
	}
	
	for($c=0;$c<ceil(fmod($vote, 1) );$c++)
	{
		$result .= "<img src=\"".($website->GetParam("USE_ABSOLUTE_URLS")?"http://www.".$DOMAIN_NAME."/":"")."images/half-star.gif\" width=\"13\" height=\"12\" style=\"float:left\">";
	}
	
	for($v=($c+$x);$v<5;$v++)
	{
		$result .= "<img src=\"".($website->GetParam("USE_ABSOLUTE_URLS")?"http://www.".$DOMAIN_NAME."/":"")."images/empty-star.gif\" width=\"13\" height=\"12\" style=\"float:left\">";
	}

	$result .= "</div>";
	
	return $result;
}



function format_str($strTitle)
{
		$strSEPage = "";
		$strTitle=strtolower(trim($strTitle));
		$arrSigns = array("~", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "+", "-", ",",".","/", "?", ":","<",">","[","]","{","}","|");
		$strTitle = str_replace($arrSigns, "", $strTitle);
		
		$arrWords = explode(" ",$strTitle);
		
		$iWCounter = 1;
		
		foreach($arrWords as $strWord)
		{
			if($strWord == "")
			{
				continue;
			}
			
			if($iWCounter == 7)
			{
				break;
			}
			
			if($iWCounter != 1)
			{
				$strSEPage .= "-";
			}
			
			$strSEPage .= $strWord;
			
			$iWCounter++;	
		}
		
		return $strSEPage;
}


function LinkFormat($strUrl)
{
	global $website;
	
	if($website->vendor == "")
	{
		if(!$website->GetParam("USE_ABSOLUTE_URLS"))
		{
			return $strUrl;
		}
		else
		{
			return "http://www.".$DOMAIN_NAME."/".$strUrl;
		}
	}
	else
	{
		if(!$website->GetParam("USE_ABSOLUTE_URLS"))
		{
			if($website->GetParam("SEO_URLS"))
			{
				return $website->vendor."/".$strUrl;
			}
			else
			{
				if(substr($strUrl, strlen($strUrl)-3, 3) == "php")
				{
					return $strUrl."?p=".$website->vendor;
				}
				else
				{
					return $strUrl."&p=".$website->vendor;
				}
			}
		}
		else
		{
		
				if(substr($strUrl, strlen($strUrl)-3, 3) == "php")
				{
					return "http://www.".$DOMAIN_NAME."/".$strUrl."?p=".$website->vendor;
				}
				else
				{
					return "http://www.".$DOMAIN_NAME."/".$strUrl."&p=".$website->vendor;
				}
			
		}
	}
}


	

function RenderTable
	(
		$strTable,
		$oCol,
		$oNames,
		$iWidth,
		$sqlClause,
		$strCheckColumnName,
		$strCheckValue,
		$strFormAction,
		$ajax_call = false,
		$PageSize = 20,
		$IS_RADIO = false,
		$RADIO_VALUE = -1,
		$ORDER_QUERY = "",
		$QUERY_TO_EXECUTE = ""
	)
{
	global $database,$website,$_REQUEST,$_GET,$_POST;
	global $arrHighlightIds;
	global $strHighlightIdName;
	
	global $DBprefix, $action,$category;
	global $URLToAdd;
	global $strExplanationTitle,$PageNumber,$iRTables;
	
	global $SEARCH,$TOTAL_NUMBER_OF_RESULTS,$QUERY_EXECUTED_FOR,$PAGE_SIZE,$customFormEnd,$order,$order_type;
		
	global $DEBUG_MODE,$SEARCH_IN;
	
	$textSearch = "";
	
	if($DEBUG_MODE||true)
	{
		$ajax_call = false;
	}
	
	if(!isset($_REQUEST["PageNumber"]))
	{
		$PageNumber=1;
	}
	else
	{
		$PageNumber=intval($_REQUEST["PageNumber"]);
	}
	
	if(isset($_REQUEST["order"]))
	{
		$order = $_REQUEST["order"];
		$order_type = $_REQUEST["order_type"];
		$arrSQLClause = explode("ORDER BY",$sqlClause);
		$strQuery="SELECT * FROM ".$DBprefix.$strTable." ".$arrSQLClause[0]." ORDER BY ".$order." ".$order_type;
	}
	else
	if(isset($_REQUEST["textSearch"]))
	{
		$textSearch = $_REQUEST["textSearch"];
		$website->ms_ew($textSearch);
		$website->ms_ew($_REQUEST["comboSearch"]);
		
		if(trim($sqlClause)!="")
		{
			$strQuery="SELECT * FROM ".$DBprefix.$strTable." ".$sqlClause." AND ".$_REQUEST["comboSearch"]." LIKE '%".$textSearch."%'  ".(isset($ORDER_QUERY)&&$ORDER_QUERY!=""?$ORDER_QUERY:"");
		}
		else
		{
			$strQuery="SELECT * FROM ".$DBprefix.$strTable." WHERE ".$_REQUEST["comboSearch"]." LIKE '%".$textSearch."%'  ".(isset($ORDER_QUERY)&&$ORDER_QUERY!=""?$ORDER_QUERY:"");
		}
	}
	else
	{
		
		$strQuery="SELECT * FROM ".$DBprefix.$strTable." ".$sqlClause." ".(isset($ORDER_QUERY)&&$ORDER_QUERY!=""?$ORDER_QUERY:"");
		
	}
	
	if(isset($QUERY_TO_EXECUTE)&&$QUERY_TO_EXECUTE!="")
	{
		$strQuery=$QUERY_TO_EXECUTE;
	}
	
	$iTotalResults=$database->SQLCount_Query($strQuery);

	
	$oDataTable = $database->Query($strQuery." LIMIT ".(($PageNumber-1)*$PageSize).",".($PageSize)."");
		
	$table_name_p = explode(",", $strTable);
	
	$mysqli_fields = $database->GetFieldsInTable($table_name_p[0]);
			
	$iRTables++;
	
	echo "
	
	<script>
		function CheckAll(source) 
		{
		  checkboxes = document.getElementsByName('CheckList[]');
		  for(var i=0, n=checkboxes.length;i<n;i++) {
			checkboxes[i].checked = source.checked;
			}
		}
	</script>
	";
	
	
	echo "<form ".(isset($ajax_call)&&$ajax_call?"target=\"ajax-ifr\" onsubmit=\"LoadingIcon()\"":"")." action=\"".(isset($ajax_call)&&$ajax_call?"admin_page.php":"index.php")."\" id=\"table-form\" method=\"post\" enctype=\"multipart/form-data\">";
	echo "<input type=\"hidden\" name=\"FormSubmitted\" value=\"1\"/>";
	if(isset($ajax_call)&&$ajax_call)
	{
		echo "<input type=\"hidden\" name=\"ajax_load\" value=\"1\"/>";
	}
			
	if(isset($_REQUEST["mod"]))
	{
		echo "<input type=\"hidden\" name=\"mod\" value=\"".$_REQUEST["mod"]."\"/>";
	}
	
	if(isset($_REQUEST["page"]))
	{
		echo "<input type=\"hidden\" name=\"page\" value=\"".$_REQUEST["page"]."\"/>";
	}
	
	if(isset($_REQUEST["hidden_fields"]))
	{
		foreach($_REQUEST["hidden_fields"] as $key=>$value)
		{
			echo "\n<input type=\"hidden\" name=\"".$key."\" value=\"".$value."\"/>";
		}
	}
	
	echo "
	
	
	<div class=\"table-responsive\">
		<table class=\"table table-hover\">
			<thead>
				<tr>";
	
	
	$iTDWidth=0;
	$iDefaultTDWidth=0;
	
	$iTDTotalNumber=sizeof($oCol);
	
	
	if(!isset($_REQUEST["arrTDSizes"]))
	{
		
		$iTDWidth=round(($iWidth-30)/$iTDTotalNumber);
		$arrTDSizes=array_fill(0, sizeof($oCol), $iTDWidth);
		
	}
	else
	{
		$iOccupied=0;
		$arrTDSizes=$_REQUEST["arrTDSizes"];
		$iTDHaveValues=0;	
				
		foreach($_REQUEST["arrTDSizes"] as $strTDSize){
		
			if($strTDSize!="*"){
				$iOccupied+=intval($strTDSize);		
				$iTDHaveValues++;
			}
			
		}	
		
		if(($iTDTotalNumber-$iTDHaveValues)==0){
		
			$iDefaultTDWidth=round((($iWidth-30)-$iOccupied)/($iTDHaveValues));	
		
		}
		else{
			$iDefaultTDWidth=round((($iWidth-30)-$iOccupied)/($iTDTotalNumber-$iTDHaveValues));	
		}
		
		for($k=0;$k<sizeof($arrTDSizes);$k++)
		{
		
				if($arrTDSizes[$k]!="*"){
					$arrTDSizes[$k]=intval($arrTDSizes[$k]);									
				}
				else{
					$arrTDSizes[$k]=$iDefaultTDWidth;
				}	
							
		}
			
	}

	if(strpos($strCheckColumnName,"#") !== false)
	{
	
	}
	else
	if(trim($strCheckColumnName)!="")
	{
		echo "<th  width=\"40\" >
		<input type=\"checkbox\" title=\"".$strCheckColumnName." All\" onClick=\"CheckAll(this)\" />
		</th>";
	}

	$iTDHeaderCounter=0;
	
	
	
	
	if(!isset($order_type)){
		$order_type="desc";
		$strImgName="";
	}
	else
	if($order_type=="asc")
	{
		$order_type="desc";
		$strImgName="up.png";
	}
	else{
		$order_type="asc";
		$strImgName="down.png";
	}
	
	$arrFields=$database->GetFieldsInTable($strTable);
	

	$str_submit_url = "index.php?";
				
	foreach ($_GET as $key=>$value) 
	{ 
		if($key != "order"&&$key!="order_type")
		{
			$str_submit_url .= $key."=".$value."&";
		}
	}
	
	foreach ($oNames as $columnName) 
	{
			echo "<th width=\"".$arrTDSizes[$iTDHeaderCounter]."\" nowrap>
			
			".(in_array($oCol[$iTDHeaderCounter],$arrFields)?("<a  class=\"header-td\" href=\"".$str_submit_url."order=".$oCol[$iTDHeaderCounter]."&order_type=".$order_type."".(isset($URLToAdd)?$URLToAdd:"")."\">"):"")."
			".$columnName."
			</a>
			
			".((isset($_REQUEST["order"])&&$_REQUEST["order"]==$oCol[$iTDHeaderCounter]&&$strImgName!="")?"<img src=\"images/".$strImgName."\" width=\"14\" height=\"14\" style=\"position:relative;top:1px;left:5px\"/>":"")."
			
			</th>";
			$iTDHeaderCounter++;
  	}

	echo "</tr>
		</thead>
	<tbody>";

	$boolColor=true;


	
	while ($myArray = mysqli_fetch_array($oDataTable))
	{
	
		echo "<tr>";
		/*
			if(isset($arrHighlightIds) && isset($strHighlightIdName) && in_array($myArray[$strHighlightIdName],$arrHighlightIds,false)){
				echo "<tr bgcolor=\"#ffcf00\"  height=20>";
			}
			else{
				echo "<tr bgcolor=\"".($boolColor?"#ffffff":"#f0f1f4")."\"  height=\"30\">";
			}
			*/

			
			if(strpos($strCheckColumnName,"#") !== false)
			{
			
			}
			else
			if(trim($strCheckColumnName)!="")
			{
			
				$cVal=$myArray[$strCheckValue];
				echo "<td nowrap>";
				
				if($IS_RADIO)
				{
					echo "<input title=\"".$strCheckColumnName."\" type=\"radio\" name=\"CheckList\" value=\"".$cVal."\" ".($cVal==$RADIO_VALUE?"checked":"")."/>";
				}
				else
				{
					echo "<input title=\"".$strCheckColumnName."\" type=\"checkbox\" name=\"CheckList[]\" value=\"".$cVal."\">";
				}
			
				echo "</td>";
			}


			foreach ($oCol as $columnName) 
			{



				$strParticularCases=particularCases($columnName,$myArray);

				if($strParticularCases!="")
				{
						echo $strParticularCases;
				}
				else
				if($columnName == "date"||$columnName == "timestamp"||$columnName == "date_start")
				{
					if(isset($myArray[$columnName]) && $myArray[$columnName] != "")
					{
						echo "<td class=oMain>".date("d/m/y G:i",$myArray[$columnName])."</td>";
					}
					else
					{
						echo "<td class=oMain>&nbsp;</td>";
					}
				}
				else{
						$val="";

						if(isset($myArray[$columnName]))
						{

									$val=$myArray[$columnName];
						}
						
						if($textSearch!=""&&(isset($_REQUEST["comboSearch"])&&$_REQUEST["comboSearch"]==$columnName))
						{
							
							$val=str_ireplace($textSearch,"<span class=\"yellow-back-text\">".$textSearch."</span>",$val);
							echo "<td>".$val."</td>";
						}
						else
						{
							if(substr($val,0,4) == "http")
							{
								echo "<td><a href=\"".$val."\">".$val."</a></td>";
							}
							else
							{
   								echo "<td>".$val."</td>";
							}
						}
				}
  			}

			echo "</tr>";

			$boolColor=$boolColor?false:true;

	}

	echo "</tbody></table></div>";

	if(strpos($strCheckColumnName,"#") !== false)
	{
		echo "
			<br>
			
			<div class=\"fleft\">
			<input type=\"submit\" value=\" ".str_replace("#","",$strCheckColumnName)." \" class=\"btn btn-default btn-gradient\"/>
			</div>
		";	
	}
	else
	if(trim($strCheckColumnName)!="")
	{
		echo "
			<br>
			<input type=\"hidden\" name=\"Delete\" value=\"1\"/>
			
			<div class=\"fleft\">
			<input type=\"submit\" value=\" ".$strCheckColumnName." \" class=\"btn btn-default btn-gradient\"/>
			</div>
		";	
	}
	
	
	
	
	echo "</form>";
	
	
	//table pagination
	
	$strSearchString = "";
			
	foreach ($_GET as $key=>$value) 
	{ 
		if($key != "PageNumber")
		{
			$strSearchString .= $key."=".$value."&";
		}
	}
	
	foreach ($_POST as $key=>$value) 
	{ 
		if($key != "PageNumber")
		{
			$strSearchString .= $key."=".$value."&";
		}
	}
	
	if(ceil($iTotalResults/$PageSize) > 1)
	{

		echo "<br/>";
		
		$inCounter = 0;
		
		if($PageNumber != 1)
		{
			echo "&nbsp; <a ".($ajax_call?"target=\"ajax-ifr\" onmousedown=\"javascript:LoadingIcon()\"":"")." class=\"small-nav-link\" href=\"".(isset($ajax_call)&&$ajax_call?"admin_page.php?ajax_load=1&":"index.php?").$strSearchString."PageNumber=1\"><b><<</b></a> ";
			
			echo "&nbsp; <a ".($ajax_call?"target=\"ajax-ifr\" onmousedown=\"javascript:LoadingIcon()\"":"")." class=\"small-nav-link\" href=\"".(isset($ajax_call)&&$ajax_call?"admin_page.php?ajax_load=1&":"index.php?").$strSearchString."PageNumber=".($PageNumber)."\"><b><</b></a> &nbsp;";
		}
		
		$iStartNumber = $PageNumber;
		
		if($iStartNumber > (ceil($iTotalResults/$PageSize) - 4))
		{
			$iStartNumber = (ceil($iTotalResults/$PageSize) - 4);
		}
		
		if($iStartNumber>3&&$PageNumber<(ceil($iTotalResults/$PageSize) - 2))
		{
			$iStartNumber=$iStartNumber-2;
		}
		
		if($iStartNumber < 1)
		{
			$iStartNumber = 1;
		}
		
		for($i= $iStartNumber ;$i<=ceil($iTotalResults/$PageSize);$i++)
		{
			if($inCounter>=5)
			{
				break;
			}
			
			if($i == $PageNumber)
			{
				echo "<b>".$i."</b> ";
			}
			else
			{
				echo "<a ".($ajax_call?"target=\"ajax-ifr\" onmousedown=\"javascript:LoadingIcon()\"":"")." class=\"small-nav-link\" href=\"".(isset($ajax_call)&&$ajax_call?"admin_page.php?ajax_load=1&":"index.php?").$strSearchString."PageNumber=".$i."\"><b>".$i."</b></a> ";
			}
							
			
			$inCounter++;
		}
		
		if($PageNumber<ceil($iTotalResults/$PageSize))
		{
			echo "&nbsp; <a ".($ajax_call?"target=\"ajax-ifr\" onmousedown=\"javascript:LoadingIcon()\"":"")." class=\"small-nav-link\" href=\"".(isset($ajax_call)&&$ajax_call?"admin_page.php?ajax_load=1&":"index.php?").$strSearchString."PageNumber=".($PageNumber+1)."\"><b>></b></a> ";
			
			echo "&nbsp; <a ".($ajax_call?"target=\"ajax-ifr\" onmousedown=\"javascript:LoadingIcon()\"":"")." class=\"small-nav-link\" href=\"".(isset($ajax_call)&&$ajax_call?"admin_page.php?ajax_load=1&":"index.php?").$strSearchString."PageNumber=".(ceil($iTotalResults/$PageSize))."\"><b>>></b></a> ";
		}
		
		
	}

	//end table pagination
}

function particularCases($columnName,$myArray)
{
	if($columnName=="ShowOrderDetailsLink")
	{
		return "<td><a href=\"index.php?mod=orders&OrderNumber=".$myArray['OrderNumber']."".(get_param("p")!=""?"&p=".get_param("p"):"").(get_param("lang")!=""?"&lang=".get_param("lang"):"")."\"><img src=\"images/details.png\" width=\"24\" height=\"24\"/></a></td>";
	}
}



function AddEditForm
	(
		$arrTexts,
		$arrEditFields,
		$arrMissedFields,
		$arrTypes,
		$strTableName,
		$strUniqueKey,
		$strCurrentUniqueKeyValue,
		$strSuccessMessage,
		$jsValidation ="",
		$MessageTDLength = 120,
		$HideSubmit = false
	)
	{

	global $DBprefix,$lang;

	global $SpecialProcessEditForm,$SubmitButtonText;

	global $database,$_REQUEST;

	if($strUniqueKey=="UserName")
	{
		$str_where_query=$strUniqueKey."='".$strCurrentUniqueKeyValue."'";
	}
	else
	{
		$str_where_query=$str_where_query;
	}
		
	$oArray=$database->DataArray($strTableName,$str_where_query);

	if(isset($_REQUEST["SpecialProcessEditForm"]))
	{

		$arrValues=array();
		$arrEditNames=array();

		for($i=0;$i<sizeof($arrEditFields);$i++)
		{
		
			$strName=$arrEditFields[$i];

			if(in_array($strName,$arrMissedFields))
			{
				continue;
			}

				
			array_push($arrEditNames,$strName);

			if(isset($_REQUEST[$strName]))
			{
				$tempValue = $_REQUEST[$strName];
			}
			else
			{
				$tempValue = $_REQUEST["post_".$strName];
			}

			array_push($arrValues,$tempValue);
					
			
		}
		
		
		
		$database->SQLUpdate($strTableName,$arrEditNames,$arrValues,$str_where_query);

		echo "<h3>".$strSuccessMessage."</h3>";
		
		$oArray=$database->DataArray($strTableName,$str_where_query);

	}
	
	if(true)
	{

		echo "<table>";

		echo "<form id=\"EditForm\" ".(isset($jsValidation)&&$jsValidation!=""?"onsubmit='return $jsValidation(this)'":"")." action=\"index.php\" method=\"post\" enctype=\"multipart/form-data\">";
		
		echo "<input type=\"hidden\" name=\"mod\" value=\"".$_REQUEST["mod"]."\"/>";
		
		echo "<input type=\"hidden\" name=\"".$strUniqueKey."\" value=\"".$strCurrentUniqueKeyValue."\"/>";
		echo "<input type=\"hidden\" name=\"SpecialProcessEditForm\" value=\"1\"/>";

		
		if(isset($_REQUEST["strHiddenFields"]))
		{
			echo $_REQUEST["strHiddenFields"];
		}

		for($i=0;$i<sizeof($arrTexts);$i++)
		{
			echo "<tr height=\"24\">";

			if($arrTexts[$i]!="")
			{
				echo 
				"
					<td valign=\"middle\" width=\"".(isset($MessageTDLength)?$MessageTDLength:"100")."\"/>
					".$arrTexts[$i]."
					</td>
				";
			}

			echo "<td valign=\"middle\">";

			if($arrEditFields[$i]!="images"&&in_array($arrEditFields[$i],$arrMissedFields))
			{
				echo $oArray[$arrEditFields[$i]];
			}
			else
			if(strstr($arrTypes[$i],"combobox_table")){
				
				$strVal="";
				if(isset($oArray[$arrEditFields[$i]]))
				{
					$strVal=$oArray[$arrEditFields[$i]];
				}
							
				list($strType,$strTableName,$strFieldValue,$strFieldName)=explode("~",$arrTypes[$i]);
				
				$oTable=$database->DataTable($strTableName,"");
					
				echo "<select class=\"form-control\" ".(isset($_REQUEST["select-width"])?"style=\"width:".$_REQUEST["select-width"]."px\"":"")." name=\"".$arrEditFields[$i]."\">";
				
				while($oRow=mysqli_fetch_array($oTable)){
						echo "<option ".($oRow[$strFieldValue]==$strVal?"selected":"")." value=\"".$oRow[$strFieldValue]."\">".$oRow[$strFieldName]."</option>";
				}
				
				echo "</select>";
			}
			else
			if(strstr($arrTypes[$i],"file")){

				
					$strVal="";
					if(isset($oArray[$arrEditFields[$i]])){
						$strVal=$oArray[$arrEditFields[$i]];
					}
					echo "<input type=\"file\"  name=\"".$arrEditFields[$i]."\" id=\"".$arrEditFields[$i]."\"/>";
			}
			else
			if(strstr($arrTypes[$i],"textbox")){

				list($strType,$strSize)=explode("_",$arrTypes[$i]);
				
					$strVal="";
					if(isset($oArray[$arrEditFields[$i]])){
						$strVal=$oArray[$arrEditFields[$i]];
					}
					echo "<input type=\"text\" class=\"form-control\" value=\"".stripslashes($strVal)."\" name=\"".$arrEditFields[$i]."\" id=\"".$arrEditFields[$i]."\" size=$strSize>";
			}
			else
			if(strstr($arrTypes[$i],"textarea")){
				list($strType,$strCols,$strRows)=explode("_",$arrTypes[$i]);
				
				$strVal="";
				if(isset($oArray[$arrEditFields[$i]]))
				{
					$strVal=$oArray[$arrEditFields[$i]];
				}
					
				echo "
				<input type=\"hidden\" id=\"post_".$arrEditFields[$i]."\" name=\"post_".$arrEditFields[$i]."\"/>
				<textarea name=\"".$arrEditFields[$i]."\" id=\"".$arrEditFields[$i]."\" cols=\"".($strCols=="100%"?"20":$strCols)."\" rows=\"".$strRows."\" ".($strCols=="100%"?"style=\"width:100% !important\"":"").">".stripslashes($strVal)."</textarea>";
			}
			else
			if(strstr($arrTypes[$i],"images"))
			{
				$strVal="";
			
				if(isset($oArray[$arrEditFields[$i]]))
				{
					$strVal=trim($oArray[$arrEditFields[$i]]);
				}
				
				if($strVal!="")
				{
					$image_ids = explode(",",$strVal);
					
					foreach($image_ids as $image_id)
					{
						if(file_exists("../thumbnails/".$image_id.".jpg"))
						{
							echo "<a href=\"../uploaded_images/".$image_id.".jpg\" class=\"hover\"><img src=\"../thumbnails/".$image_id.".jpg\" class=\"admin-preview-thumbnail\"/></a>";
						}
						
					}
					
				}
				else
				{
					echo "<img src=\"../images/no_pic.gif\" width=\"100\" height=\"100\" style=\"float:left;margin-right:10px;margin-bottom:10px\"/>";
				}
				global $MODIFY;
				echo "<span class=\"lfloat\"><a href=\"index.php?category=products_manager&action=images&id=".$strCurrentUniqueKeyValue."\">".$MODIFY."</a></span>";
			}
			else
		
			if(strstr($arrTypes[$i],"combobox_special"))
			{
				
				
				if($arrEditFields[$i]=="shop_category")
				{
					   global $LANGUAGE2;
					   
					   if(isset($oArray[$arrEditFields[$i]]))
						{
							$strVal = $oArray[$arrEditFields[$i]];
						}
						global $lines;
						
						echo "<select name=shop_category>";
	
						if(file_exists('../include/categories_'.strtolower($LANGUAGE2).'.php'))
						{
							$lines = file('../include/categories_'.strtolower($LANGUAGE2).'.php');
						}
						else
						{
							$lines = file('../include/categories_en.php');
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
						echo "<option value=\"".trim($key)."\" ".($strVal==trim($key)?"selected":"")." >".trim($val)."</option>";
						$arr_sub_cats = get_sub_cats($key);
						
						if(sizeof($arr_sub_cats)>0)
						{
							while (list($s_key, $s_val) = each($arr_sub_cats)) 
							{
								echo "<option value=\"".trim($s_key)."\" ".($strVal==trim($s_key)?"selected":"")." style=\"font-size:10px\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".trim($s_val)."</option>";
							}
						}
					}
					
					echo "</select>";
				}
				else
				if($arrEditFields[$i]=="cat_id")
				{
						global $AuthUserName;
						
						if(isset($oArray[$arrEditFields[$i]]))
						{
							$strVal = $oArray[$arrEditFields[$i]];
						}
					
						echo "<select name='cat_id'>";
					
						$pr_categories = $database->DataTable("product_categories","WHERE username='".$AuthUserName."' ");
						
					 	while($pr_category=mysqli_fetch_array($pr_categories))
						{
							echo "<option ".($strVal==$pr_category["id"]?"selected":"")." value=".$pr_category["id"].">".$pr_category["name_en"]."</option>";
						}
						
						echo "</select>";
				}
				else
				if($arrEditFields[$i]=="country_multi")
				{
					if(isset($oArray[$arrEditFields[$i]]))
					{
						$strVal = $oArray[$arrEditFields[$i]];
					}
					
					echo "<select name='country[]' size=8 multiple >";
					
					
					if(trim($strVal) != "")
					{
					
						$lines = file("../include/countries.php");
				
						foreach ($lines as $line_num => $line) 
						{
							$line = trim($line);
							if(trim($line) != "")
							{
								echo "<option value=\"".$line."\" ".(trim($line)==trim($strVal)?"selected":"").">".$line."</option> ";
							}
							
						}
						
					
					}
					else
					{
						global $M_PLEASE_SELECT;
						echo "<option value=\"\">--- ".(isset($M_PLEASE_SELECT)?$M_PLEASE_SELECT:"Please Select")." ---</option>";
						$lines = file("../include/countries.php");
				
						foreach ($lines as $line_num => $line) 
						{
							if(trim($line) != "")
							{
								echo "<option value=\"".$line."\">".$line."</option> ";
							}
							
						}
					}
					
					
				
					echo "</select>";
				
				}
				else		
				if($arrEditFields[$i]=="states")
				{
					
					if(isset($oArray[$arrEditFields[$i]]))
					{
						$strVal = $oArray[$arrEditFields[$i]];
					}
					
					echo "<select name='states[]' size=8 multiple>";
					
					
					if(trim($strVal) != "")
					{
						$lines = file("../include/states.php");
				
						foreach ($lines as $line_num => $line) 
						{
							$line = trim($line);
							if(trim($line) != "")
							{
								echo "<option value=\"".$line."\" ".(trim($line)==trim($strVal)?"selected":"").">".$line."</option> ";
							}
							
						}
						
						
					}
					else
					{
						global $M_PLEASE_SELECT;
						echo "<option value=\"\">--- ".(isset($M_PLEASE_SELECT)?$M_PLEASE_SELECT:"Please Select")." ---</option>";
						$lines = file("../include/states.php");
				
						foreach ($lines as $line_num => $line) 
						{
							if(trim($line) != "")
							{
								echo "<option value=\"".$line."\">".$line."</option> ";
							}
							
						}
						
					}
					
					
				
					echo "</select>";
				}
				else	
				
				if($arrEditFields[$i]=="country"||$arrEditFields[$i]=="Country"){
				
					$strVal="";
					if(isset($oArray[$arrEditFields[$i]])){
						$strVal=$oArray[$arrEditFields[$i]];
					}
					
						echo "<select class=\"form-control\" name=\"".$arrEditFields[$i]."\">";

						if(file_exists('include/countries.php'))
						{
							$f_name = 'include/countries.php';
						}
						else
						{
							$f_name = '../include/countries.php';
						}
					
						$lines = file($f_name);
				
						foreach ($lines as $line_num => $line) 
						{
							$line = trim($line);
							if(trim($line) != "")
							{
								echo "<option value=\"".$line."\" ".(trim($line)==trim($strVal)?"selected":"").">".$line."</option> ";
							}
							
						}

					echo "</select>";
								
								
			
				}
				else
				if($arrEditFields[$i]=="region"){
				
					$strVal="";
					if(isset($oArray[$arrEditFields[$i]])){
						$strVal=$oArray[$arrEditFields[$i]];
					}
					
					echo "<select name=\"region\">";

					$arrRegions = explode("\n", Parameter(802));
					
					foreach($arrRegions as $strRegion)
					{
						$arrRegionItems = explode(".", $strRegion, 2);
						
						echo "<option ".($strVal==$arrRegionItems[0]?"selected":"")." value=\"".$arrRegionItems[0]."\">".$arrRegionItems[1]."</option>";
					}

					echo "</select>";
								
			
				}
				
				if($arrEditFields[$i]=="category_1"||$arrEditFields[$i]=="category_2"){
					
					$strVal="";
					if(isset($oArray[$arrEditFields[$i]])){
						$strVal=$oArray[$arrEditFields[$i]];
					}
								
					echo "<select name=\"".$arrEditFields[$i]."\">";
					
					$oCatTable=DataTable("frontstore_category","");
					
					while($oCatRow=mysqli_fetch_array($oCatTable)){
							echo "<option ".($strVal==$oCatRow["Marketing_Category_1"]?"selected":"")." value=\"".$oCatRow["Marketing_Category_1"]."\">".$oCatRow["Marketing_Cat_EN"]."</option>";				
					}
								
					echo "</select>";			
				}
				
			}
			else
			if(strstr($arrTypes[$i],"combobox")){

			echo "<select ".(isset($_REQUEST["select-width"])?"style=\"width:".$_REQUEST["select-width"]."px\"":"")." name=\"".$arrEditFields[$i]."\">";

				foreach(explode("_",$arrTypes[$i]) as $strOption){

					if($strOption=="combobox"){
						continue;
					}

					$arrOptions = explode("^", $strOption);

					if(sizeof($arrOptions)>1)
					{
						echo "<option value=\"".$arrOptions[1]."\"";
						if($arrOptions[1]==$oArray[$arrEditFields[$i]]){
							echo " selected";
						}
						echo">".$arrOptions[0]."</option>";
					}
					else
					{
						echo "<option ";
						if($strOption==$oArray[$arrEditFields[$i]]){
							echo " selected";
						}
						echo">".$strOption."</option>";
					
					}

				}

				echo "</select>";

			}

			echo "</td>";

			echo "</tr>";
		}

		echo "</table>";

		echo "<br/>";
			
		if(!isset($_REQUEST["HideSubmit"]))
		{
				echo "<input class=\"btn btn-default btn-gradient\" type=\"submit\" value=\"".(isset($SubmitButtonText)?$SubmitButtonText:"Save")."\"/>";
		}
		echo "</form>";
		
	}
}


function get_feeds($query,$location,$country,$i_page,$page_size,$zip="",$zip_radius="")
{
	global $website;
	$results = array();
	
	if(trim($website->GetParam("TEXT_EMPTY_QUERIES"))!="")
	{
		if($query==""||$query==".") $query=stripslashes($website->GetParam("TEXT_EMPTY_QUERIES"));
	}
	$i_start_1=$i_start_2=$i_start_3=0;
	$i_page_1=$i_page_2=$i_page_3=0;
	$limit_results_1=$limit_results_2=$limit_results_3=0;
	
	$load_indeed=false;
	$load_simplyhired=false;
	$load_careerjet=false;
	$indeed_weight=0;
	$simplyhired_weight=0;
	$careerjet_weight=0;
	
	$client_ip=$_SERVER["REMOTE_ADDR"];
	
	if($client_ip=="::1")
	{
		$client_ip="192.168.1.1";
	}
	
	if($website->GetParam("FEEDS_USAGE")==1)
	{
		if($website->GetParam("MAIN_FEED")==1)
		{
			$load_indeed=true;
			$i_start_1=$i_page*$page_size;
			$limit_results_1=$page_size;
		}
		else
		if($website->GetParam("MAIN_FEED")==2)
		{
			$load_simplyhired=true;
			$i_start_2=$i_page*$page_size;
			$limit_results_2=$page_size;
		}
		else
		if($website->GetParam("MAIN_FEED")==3)
		{
			$load_careerjet=true;
			$i_start_3=$i_page*$page_size;
			$limit_results_3=$page_size;
		}
		
		
	}
	
	if($website->GetParam("FEEDS_USAGE")==2)
	{
		
		if($website->GetParam("MAIN_FEED")==1||$website->GetParam("ADD_FEED_1")==1||$website->GetParam("ADD_FEED_2")==1)
		{
			$load_indeed=true;
		}
		
		if($website->GetParam("MAIN_FEED")==2||$website->GetParam("ADD_FEED_1")==2||$website->GetParam("ADD_FEED_2")==2)
		{
			$load_simplyhired=true;
		}
		
		if($website->GetParam("MAIN_FEED")==3||$website->GetParam("ADD_FEED_1")==3||$website->GetParam("ADD_FEED_2")==3)
		{
			$load_careerjet=true;
		}
		
		$lim_res_var1="limit_results_".$website->GetParam("MAIN_FEED");
		$$lim_res_var1=ceil(($website->GetParam("MAIN_FEED_WEIGHT")/10)*$page_size);
		
		$lim_res_var2="limit_results_".$website->GetParam("ADD_FEED_1");
		$$lim_res_var2=ceil(($website->GetParam("ADD_FEED_1_WEIGHT")/10)*$page_size);
		
		$lim_res_var3="limit_results_".$website->GetParam("ADD_FEED_2");
		$$lim_res_var3=ceil(($website->GetParam("ADD_FEED_2_WEIGHT")/10)*$page_size);
	}

	if($location!="")
	{
		
		$loc_items=explode(",",$location);
		$country=get_indeed_country($location);

		if($country!=""&&sizeof($loc_items)==1)
		{
			$location="";
		}
		
		if($country!=""&&$country!=$website->GetParam("FEED_DEFAULT_COUNTRY"))
		{
			if(sizeof($loc_items)==2)
			{
				$location = trim($loc_items[0]);
				
			}
			
		}
	}
	
	if($country=="")
	{
		$country=$website->GetParam("FEED_DEFAULT_COUNTRY");
	}
	
	if($load_indeed)
	{
		if($zip!=""&&$zip_radius!="")
		{
			$indeed_url = "http://api.indeed.com/ads/apisearch?v=2&publisher=".$website->GetParam("INDEED_PUBLISHER_ID")."&q=".urlencode($query)."&l=".$zip."&sort=date&radius=".$zip_radius."&st=&jt=&start=".$i_start_1."&limit=".$limit_results_1."&fromage=%20&filter=&latlong=1&co=".$country."&chnl=&userip=".$client_ip."&useragent=".urlencode($_SERVER['HTTP_USER_AGENT']);
		}
		else
		{
			$indeed_url = "http://api.indeed.com/ads/apisearch?v=2&publisher=".$website->GetParam("INDEED_PUBLISHER_ID")."&q=".urlencode($query)."&l=".urlencode($location)."&sort=date&radius=&st=&jt=&start=".$i_start_1."&limit=".$limit_results_1."&fromage=%20&filter=&latlong=1&co=".$country."&chnl=&userip=".$client_ip."&useragent=".urlencode($_SERVER['HTTP_USER_AGENT']);
		}
	
		$xml = simplexml_load_file($indeed_url);
		foreach ($xml->results->result as $r) 
		{
			$line=array();
			$line["type"]="indeed";
			$line["company"]=$r->company;
			$line["location"]=$r->formattedLocation;
			$line["title"]=$r->jobtitle;
			$line["date"]=$r->date;
			$line["id"]=$r->jobkey;
			$line["url"]="";
			$line["description"]=$r->snippet;
			
			array_push($results,$line);
		}
	}
	
	if($load_simplyhired)
	{
	
		$simplyhired_url = "http://api.simplyhired.com/a/jobs-api/xml-v2/q-".urlencode($query)."/pn-".$i_page."/ws-".$limit_results_2."/?pshid=".$website->GetParam("SIMPLYHIRED_PUBLISHER_ID")."&ssty=2&cflg=r&jbd=".($website->GetParam("SIMPLYHIRED_API_DOMAIN"))."&clip=".$client_ip;
	
		$xml = simplexml_load_file($simplyhired_url);
		foreach ($xml->rs->r as $value)
		{ 
			$line=array();
			$line["type"]="simplyhired";
			$line["company"]=$value->cn;
			$line["location"]=$value->loc;
			$line["title"]=$value->jt;
			$line["date"]=$value->dp;
			$line["id"]="";
			$line["url"]=$value->src->attributes()->url;
			$line["description"]=rtrim(strip_tags($value->e),">");
			
			array_push($results,$line);
		}
	}
	
	
	if($load_careerjet)
	{
		include("include/Careerjet_API.php");

		$api = new Careerjet_API('en_US') ;

		$result = $api->search
		(
			array
			( 
				'keywords' => $query,
                'location' => $location,
				'page' => $i_page,
				'pagesize' => $limit_results_3,
				'affid' => $website->GetParam("CAREERJET_AFF_ID")
			)
			
        ) ;

		if($result->type == 'JOBS')
		{
		
			$jobs = $result->jobs ;
			
			foreach($jobs as $job)
			{ 
				$line=array();
				$line["type"]="careerjet";
				$line["company"]=$job->company;
				$line["location"]=$job->locations;
				$line["title"]=$job->title;
				$line["date"]=$job->date;
				$line["url"]=$job->url;
				$line["id"]="";
				$line["description"]=strip_tags($job->description);
				
				array_push($results,$line);
			}
		}
	}
	
	if($website->GetParam("FEEDS_USAGE")==2)
	{
		return shuffle_assoc($results);
	}
	else
	{
		return $results;
	}
}

function get_indeed_country($location)
{
	global $website;
	
	$lines=explode("\n",$website->GetParam("INDEED_DEFAULT_COUNTRIES"));
	
	$loc_items=explode(",",trim($location));
	foreach($lines as $line)
	{
		if(trim($line)=="") continue;
		$items=explode("-",$line);
		if(sizeof($items)==2&&sizeof($loc_items)==2)
		{
			if(trim($items[0])==trim($loc_items[1])) 
			{
			
				return strtolower(trim($items[1]));
			}
		}
		
		
		if(sizeof($items)==2&&sizeof($loc_items)==1)
		{
			if(trim($items[0])==trim($loc_items[0])) 
			{
			
				return strtolower(trim($items[1]));
			}
		}
	}

	return "";
}

function shuffle_assoc($list) 
{ 
  if (!is_array($list)) return $list; 

  $keys = array_keys($list); 
  shuffle($keys); 
  $random = array(); 
  foreach ($keys as $key) 
    $random[$key] = $list[$key]; 

  return $random; 
} 

function str_show($str, $bret = false)
{
	$str = trim($str);
	global $$str;
		
	$strResult = "";
	
	if(strstr($str,"{"))
	{
		$strVName = substr($str,1,strlen($str)-2);
		global $$strVName;
		$strResult = $$strVName;
	}
	else
	if(isset($$str))
	{
		$strResult = $$str;
	}
	else
	{
		$strResult = $str;
	}

	if($bret)
	{
		return stripslashes($strResult);
	}

	echo stripslashes($strResult);
}

?>