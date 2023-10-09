<?php
function AddNewForm
	(
		$arrTexts,
		$arrNames,
		$arrTypes,
		$strSubmitText,
		$strTable,
		$strSuccessMessage,
		$ajax_call = false,
		$arrExamples = array(),
		$jsValidation ="",
		$arrSkip = array(),
		$append_html =""
	)
	{
	global $_REQUEST,$lang,$database,$MessageTDLength;
	global $strSpecialHiddenFieldsToAdd;
	global $arrOtherValues,$website;
	$ajax_call = false;
	$i_inserted_id = null;
	$success_insert=false;
	if(isset($_REQUEST["SpecialProcessAddForm"]))
	{

		$arrValues=array();
		$arrInsertName=array();

		for($i=0;$i<sizeof($arrNames);$i++)
		{
			if(trim($arrTexts[$i])=="") continue;

			$strName=$arrNames[$i];

			if($arrTypes[$i]=="file")
			{
			
				if($strName == "file_id")
				{
					$iFileId=SQLInsertFile2($strName);
					
					array_push($arrValues,$iFileId);
				}
				else
				{
			
					$iFileId=insert_image($strName);
					array_push($arrInsertName,"image_id");
					
					array_push($arrValues,$iFileId);
				
				}
				
			}
			else
			{

				$tempValue = "";
				
				if(isset($_REQUEST[$strName]))
				{
					$tempValue = $_REQUEST[$strName];
				}
				else
				if(isset($_REQUEST["post_".$strName]))
				{
					$tempValue = $_REQUEST["post_".$strName];
				}

				
				if(is_array($tempValue))
				{
					$tempValue=implode(",",$tempValue);
				}
				
				if(trim($tempValue)!="")
				{
					
					array_push($arrInsertName,$strName);
					array_push($arrValues,$tempValue);
				}
			}
		}

		
		if(isset($_REQUEST["arrNames2"]))
		{
			
			for($i=0;$i<sizeof($_REQUEST["arrNames2"]);$i++)
			{
				array_push($arrInsertName,$_REQUEST["arrNames2"][$i]);
				array_push($arrValues,$_REQUEST["arrValues2"][$i]);
			}
		}
		
		
		if(!isset($DoNotInsert))
		{
			$i_inserted_id = $database->SQLInsert($strTable,$arrInsertName,$arrValues);
		}
		
	
		echo "<span class=\"medium-font\">";
	
		if(!isset($DoNotInsert)  && $i_inserted_id==0)
		{
			
			echo "Error while inserting the new data.</b>";
		}
		else
		{
			$success_insert=true;
			echo $strSuccessMessage;
		}
		
		echo "</span><br/><br/>";
		
	}
	
	
	if($success_insert&&isset($_REQUEST["hide_form"]))
	{
	
	}
	else
	{
		echo "<table>";

		echo "<form id=\"add-form\" ".($ajax_call?"target=\"ajax-ifr\"":"")." ".(isset($jsValidation)&&$jsValidation!=""?"onsubmit='return $jsValidation(this)'":"")." action=\"".($ajax_call?"admin_page":"index").".php\" method=\"post\" enctype=\"multipart/form-data\">";
		
		if(isset($ajax_call)&&$ajax_call)
		{
			echo "<input type=\"hidden\" name=\"ajax_call\" value=\"1\"/>";
		}
		
		if(isset($_REQUEST["FieldsToAdd"]))
		{
			echo $_REQUEST["FieldsToAdd"];
		}
				
		if(isset($_REQUEST["folder"]))
		{
			echo "<input type=\"hidden\" name=\"category\" value=\"".$_REQUEST["category"]."\"/>";
			echo "<input type=\"hidden\" name=\"page\" value=\"".$_REQUEST["page"]."\"/>";
			echo "<input type=\"hidden\" name=\"folder\" value=\"".$_REQUEST["folder"]."\"/>";
		}
		else
		{
			echo "<input type=\"hidden\" name=\"category\" value=\"".$_REQUEST["category"]."\"/>";
			echo "<input type=\"hidden\" name=\"action\" value=\"".$_REQUEST["action"]."\"/>";
		}

		echo "<input type=\"hidden\" name=\"SpecialProcessAddForm\" value=\"1\"/>";
			
		

		for($i=0;$i<sizeof($arrTexts);$i++)
		{
			if(trim($arrTexts[$i])=="") continue;
			if(isset($arrSkip[$i])&&$arrSkip[$i]=="1") continue;
		
			echo "<tr height=\"42\">";

			echo "
				<td width=\"".(isset($_REQUEST["message-column-width"])?$_REQUEST["message-column-width"]:"80")."\">
				".$arrTexts[$i]."
				</td>
			";

			echo "<td valign=\"top\">";
			
			if(strstr($arrTypes[$i],"combobox_table")){
				
				list($strType,$strTableName,$strFieldValue,$strFieldName)=explode("~",$arrTypes[$i]);
				
				$oTable=$database->DataTable($strTableName,"");
								
				echo "<select ".(isset($_REQUEST["select-width"])?"style=\"width:".$_REQUEST["select-width"]."px\"":"")." id=\"".$arrNames[$i]."\" name=\"".$arrNames[$i]."\">";
				
				while($oRow=$database->fetch_array($oTable)){
						echo "<option value=\"".$oRow[$strFieldValue]."\">".$oRow[$strFieldName]."</option>";
				}
				
				echo "</select>";
			}
			else
			if(strstr($arrTypes[$i],"file")){

				$strSize=30;
					echo "<input type=\"file\" name=\"".$arrNames[$i]."\" size=\"".$strSize."\"/>";
			}
			else
			if(strstr($arrTypes[$i],"multi_images"))
			{
				global $M_PLEASE_SELECT,$M_SELECT_UP_TO;
				//echo '<input type="file" name="images[]" id="images"  multiple="multiple"/>';
					echo '<script src="../js/jquery.uploadfile.js"></script>

					
					<div id="mulitplefileuploader">'.$M_PLEASE_SELECT.'</div>
					
					
					<div id="status"><i style="color:#aaaaaa">'.$M_SELECT_UP_TO.': 10</i></div>
					<script>
					var uploaded_files="";
					$(document).ready(function()
					{
					var settings = {
						url: "../upload.php",
						dragDrop:true,
						fileName: "myfile",
						maxFileCount:10,
						allowedTypes:"jpg,png,gif",	
						returnType:"json",
						 onSuccess:function(files,data,xhr)
						{
							if(uploaded_files!="") uploaded_files+=",";
							uploaded_files+=data;
							
						},
						afterUploadAll:function()
						{
							var preview_code="";
							var imgs = uploaded_files.split(",")
							for (var i = 0; i < imgs.length; i++)
							{
								preview_code+=\'<div class="img-wrap"><img width="120" src="../uploads/\'+imgs[i]+\'"/></div>\';
							}
							
							document.getElementById("status").innerHTML=preview_code;
							document.getElementById("list_images").value=uploaded_files;
						},
						showDelete:false,
						
						showProgress:true,
						showFileCounter:false,
						showDone:false
					}
					
					

					var uploadObj = $("#mulitplefileuploader").uploadFile(settings);


					});
					</script>
					
					<input type="hidden" name="list_images" id="list_images"/>
				<div class="clear"></div>';
			}
			else
			if(strstr($arrTypes[$i],"textbox"))
			{

				list($strType,$strSize)=explode("_",$arrTypes[$i]);
				
				if(false&&$arrNames[$i]=="date_available")
				{
				?>

				
				<input type="text" name="date_available" value="<?php echo date("m/d/Y",time()+14*86400);?>" id="dp-expires" >
				<script>
				$(function(){
					
					$('#dp-expires').datepicker({
						format: 'mm/dd/yyyy'
					});
					
					});
				</script>
	
<?php				
					
				}
				else
				{
					echo "<input type=\"text\" id=\"".$arrNames[$i]."\" name=\"".$arrNames[$i]."\" size=\"".$strSize."\" ".(isset($_REQUEST["select-width"])?"style=\"width:".$_REQUEST["select-width"]."px\"":"")."/>";
					if(isset($arrExamples[$i])&&$arrExamples[$i]!="") echo "<br/><span class=\"small-font\"><i>".$arrExamples[$i]."</i><br/><br/></span>";
				}
			}
			else
			if(strstr($arrTypes[$i],"password")){

				list($strType,$strSize)=explode("_",$arrTypes[$i]);
					echo "<input type=password id=\"".$arrNames[$i]."\" name=\"".$arrNames[$i]."\" size=$strSize />";
			}
			else
			if(strstr($arrTypes[$i],"textarea"))
			{
				list($strType,$strCols,$strRows)=explode("_",$arrTypes[$i]);

				echo "<input type=\"hidden\" id=\"post_".$arrNames[$i]."\" name=\"post_".$arrNames[$i]."\"/>
				<textarea id=\"".$arrNames[$i]."\" name=\"".$arrNames[$i]."\" cols=\"".$strCols."\" rows=\"".$strRows."\"></textarea>";
			}
			else
			if(strstr($arrTypes[$i],"javascript~combobox")){

				echo "<select ".(isset($_REQUEST["select-width"])?"style=\"width:".$_REQUEST["select-width"]."px\"":"")." id=\"".$arrNames[$i]."\" name=\"".$arrNames[$i]."\" onChange=javascript:SelectChanged(this)>";

				foreach(explode("_",$arrTypes[$i]) as $strOption){

					if($strOption=="javascript~combobox"){
						continue;
					}

					echo "<option>".str_replace("~"," ",$strOption)."</option>";
				}

			}
			
			if(strstr($arrTypes[$i],"combobox_special"))
			{
				
				
					
				if($arrNames[$i]=="zone_id")
				{
					echo "<select ".(isset($_REQUEST["select-width"])?"style=\"width:".$_REQUEST["select-width"]."px\"":"")." name=\"zone_id\">";
				
					global $AuthUserName;
					$tableZones = $database->DataTable("shipping_zones", "WHERE user='".$AuthUserName."'");
				
					while($arrZone = $database->fetch_array($tableZones))
					{
						echo "<option value=\"".$arrZone["id"]."\">".$arrZone["name"]."</option>";
					}
				
					echo "</select>";
				
				}
				else
				if($arrNames[$i]=="region")
				{
						include('../locations/locations_array.php');

						echo "<select ".(isset($_REQUEST["select-width"])?"style=\"width:".$_REQUEST["select-width"]."px\"":"")." name=\"region\">";
						foreach ($l as $key=>$value) 
						{
							if(!is_string($value)) continue;
							echo "<option value=\"".$key."\">".$value."</option>\n";
						}
						echo "</select>";
				}
				else
				if($arrNames[$i]=="job_category")
				{
				
					
						global $AuthUserName;
						
					
					
						echo "<select ".(isset($_REQUEST["select-width"])?"style=\"width:".$_REQUEST["select-width"]."px\"":"")." name=\"job_category\">";
						echo "<option  value=\"0\">All</option>";
						$pr_categories = $database->DataTable("product_categories","WHERE username='".$AuthUserName."' ");
						
					 	while($pr_category=$database->fetch_array($pr_categories))
						{
							echo "<option  value=".$pr_category["id"].">".$pr_category["name_en"]."</option>";
						}
						
						echo "</select>";
						
				}
				else				
				if($arrNames[$i]=="country")
				{
					echo "<select name=\"country[]\" size=8 multiple >";
					global $M_PLEASE_SELECT;
					echo "<option value=\"\">--- ".$M_PLEASE_SELECT." ---</option>";
					$lines = file("../include/countries.php");
			
					foreach ($lines as $line_num => $line) 
					{
						if(trim($line) != "")
						{
							echo "<option value=\"".$line."\">".$line."</option> ";
						}
						
					}
					
					echo "</select>";
				
				}
				else		
				if($arrNames[$i]=="states")
				{
					echo "<select name='states[]' size=8 multiple style='width:263px'>";
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
					
					echo "</select>";
				
				}
				else		
				
				if($arrNames[$i]=="region")
				{
						include('../locations/locations_array.php');

						echo "<select ".(isset($_REQUEST["select-width"])?"style=\"width:".$_REQUEST["select-width"]."px\"":"")." name=\"region\">";
						foreach ($l as $key=>$value) 
						{
							echo "<option value=\"".$key."\">" . trim($value) . "</option>\n";
						}
						echo "</select>";
				}
				
				
			}
			else
			if($arrTypes[$i]=="global_category_one")
			{
				
					global $LANGUAGE2;
					
					echo "<select ".(isset($_REQUEST["select-width"])?"style=\"width:".$_REQUEST["select-width"]."px\"":"")." name=\"".$arrNames[$i]."\">";
					global $lines;
					if(file_exists('../categories/categories_'.strtolower($LANGUAGE2).'.php'))
					{
						$lines = file('../categories/categories_'.strtolower($LANGUAGE2).'.php');
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
					global $M_PLEASE_SELECT;
				echo "<option value=\"\">".(isset($_REQUEST["M_ALL_TEST"])?$_REQUEST["M_ALL_TEST"]:$M_PLEASE_SELECT)."</option>";
				while (list($key, $val) = each($arrCategories)) 
				{
					echo "<option value=\"".trim($key)."\">".trim($val)."</option>";
					
				}
				
				echo "</select>";
					
			}
			else
			
			if($arrTypes[$i]=="global_location")
			{
				$field_name=$arrNames[$i];
				global $M_PLEASE_SELECT;
			
			?>
				<input type="hidden" id="<?php echo $field_name;?>" name="<?php echo $field_name;?>" value=""/>
					<script>var loc_type="main";var m_all="<?php echo $M_PLEASE_SELECT;?>";</script>
				<?php
				
				$_REQUEST["M_ALL"]=$M_PLEASE_SELECT;
				
					echo '<select '.(isset($_REQUEST["select-width"])?"style=\"width:".$_REQUEST["select-width"]."px\"":"").' onChange="sub_loc_select(this.value,\''.$field_name.'\',\''.$M_PLEASE_SELECT.'\',\'../include/suggest_location\')" type="text" id="'.$field_name.'_0" name="'.$field_name.'_0">';
					echo '<option value="">'.$_REQUEST["M_ALL"].'</option>';
					include("../locations/locations_array.php");
				
					
					foreach($loc as $key=>$value)
					{
						if(!is_string($value)) continue;
						echo "<option  value=\"".$key."\" ".(isset($_REQUEST[$field_name])&&$_REQUEST[$field_name]==$key?"selected":"").">".$value."</option>";
					}
					echo '</select>';
					echo '<div class="margin-top-5" id="s_'.$field_name.'_0"></div>';
					echo '<div class="margin-top-5" id="s_'.$field_name.'_1"></div>';
					echo '<div id="s_'.$field_name.'_2"></div>';
					echo '<div id="s_'.$field_name.'_3"></div>';
					echo '<div id="s_'.$field_name.'_4"></div>';
				
			}
			else
			if($arrTypes[$i]=="global_category")
			{
				$field_name="category_1";
				global $M_PLEASE_SELECT;
				
				if(isset($_REQUEST["select-width"]))
				{
				?>
				<input type="hidden" id="<?php echo $arrNames[$i];?>" name="<?php echo $arrNames[$i];?>" value=""/>
				
				<style>
					.sub-loc-select
					{
						width:<?php echo $_REQUEST["select-width"];?>px !important;
					}
				</style>
				<?php
				}
			?>
					<script>var loc_type="main";var m_all="<?php echo $M_PLEASE_SELECT;?>";</script>
				<?php
				
				$_REQUEST["M_ALL"]=$M_PLEASE_SELECT;
				
					echo '<select '.(isset($_REQUEST["select-width"])?"style=\"width:".$_REQUEST["select-width"]."px\"":"").' '.($field_name=="category_1"?'required':'').' onChange="sub_loc_select(this.value,\''.$field_name.'\',\''.$M_PLEASE_SELECT.'\',\'../include/suggest'.(isset($_REQUEST["action"])&&$_REQUEST["action"]=="add_course"?'_course':'').'_category\')" type="text" class="sub-loc-select" id="'.$field_name.'_0" name="'.$field_name.'_0">';
					echo '<option value="">'.$_REQUEST["M_ALL"].'</option>';
					
					if(isset($_REQUEST["action"])&&$_REQUEST["action"]=="add_course")
					{
						if(file_exists('../categories/course_categories_array_'.strtolower($website->lang).'.php'))
						{
							include("../categories/course_categories_array_".strtolower($website->lang).".php");
						}
						else
						{
							include("../categories/course_categories_array_en.php");
						}
					}
					else
					{
						if(file_exists('../categories/categories_array_'.strtolower($website->lang).'.php'))
						{
							include("../categories/categories_array_".strtolower($website->lang).".php");
						}
						else
						{
							include("../categories/categories_array_en.php");
						}
						
					}
					
					foreach($l as $key=>$value)
					{
						if(!is_string($value)) continue;
						echo "<option  value=\"".$key."\" ".(isset($_REQUEST[$field_name])&&$_REQUEST[$field_name]==$key?"selected":"").">".$value."</option>";
					}
					echo '</select>';
					echo '<div class="margin-top-5" id="s_'.$field_name.'_0"></div>';
					echo '<div class="margin-top-5" id="s_'.$field_name.'_1"></div>';
					echo '<div id="s_'.$field_name.'_2"></div>';
					echo '<div id="s_'.$field_name.'_3"></div>';
					echo '<div id="s_'.$field_name.'_4"></div>';
				
			}
			else
			if(strstr($arrTypes[$i],"combobox")){

					echo "<select ".(isset($_REQUEST["select-width"])?"style=\"width:".$_REQUEST["select-width"]."px\"":"")." id=\"".$arrNames[$i]."\" name=\"".$arrNames[$i]."\">";

				foreach(explode("_",$arrTypes[$i]) as $strOption){

					if($strOption=="combobox")
					{
						continue;
					}

					$arrOptions = explode("^", $strOption);
					
					if(sizeof($arrOptions) > 1)
					{
						echo "<option value=\"".$arrOptions[1]."\">".str_replace("~"," ",$arrOptions[0])."</option>";
					}
					else
					{
						echo "<option >".str_replace("~"," ",$strOption)."</option>";
					}

				}

				echo "</select>";

			}
			

			echo "</td>";

			echo "</tr>";
		}
		
		if(isset($_REQUEST["strSpecialHiddenFieldsToAdd"]))
		{
			echo $_REQUEST["strSpecialHiddenFieldsToAdd"];
		}

		if(isset($append_html)&&$append_html!="")
		{
			echo $append_html;
		}
		
		echo "</table>";

		echo "<br><br>
		
		<input ".($ajax_call?"onmousedown=\"javascript:ShowLoading()\"":"")." id=\"submit-button\" type=\"".($ajax_call?"button":"submit")."\" value=\"".$strSubmitText."\" class=\"btn btn-primary\"/>
		</form>";

	}
	
	return $i_inserted_id;
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
	
	$mysql_fields = $database->GetFieldsInTable($table_name_p[0]);
			
	$iRTables++;
		
	if(!isset($_REQUEST["hide_refine_search"])&&sizeof(array_intersect( $oCol,$mysql_fields)) > 0)
	{
	
		echo "<div class=\"pull-right\" style=\"position:relative;top:-10px\">";
		echo "
		<form ".(isset($ajax_call)&&$ajax_call?"target=\"ajax-ifr\" onsubmit=\"LoadingIcon()\"":"")." action=\"".(isset($ajax_call)&&$ajax_call?"admin_page.php":"index.php")."\" method=\"post\">
		
		
		<input type=\"hidden\" name=\"category\" value=\"".$_REQUEST["category"]."\"/>";
		if(isset($_REQUEST["strSpecialHiddenFieldsToAdd"]))
		{
			echo $_REQUEST["strSpecialHiddenFieldsToAdd"];
		}
		if($ajax_call)
		{
			echo "<input type=\"hidden\" name=\"ajax_load\" value=\"1\"/>";
		}
		
		if(isset($_REQUEST["action"]))
		{
			echo "<input type=\"hidden\" name=\"action\" value=\"".$_REQUEST["action"]."\"/>";
		}
		if(isset($_REQUEST["folder"]))
		{
			echo "<input type=\"hidden\" name=\"folder\" value=\"".$_REQUEST["folder"]."\"/>";
		}
		if(isset($_REQUEST["page"]))
		{
			echo "<input type=\"hidden\" name=\"page\" value=\"".$_REQUEST["page"]."\"/>";
		}
		
		
		
		echo "
		".$SEARCH_IN." <select name=\"comboSearch\">";
		
		
		for($k=0;$k<sizeof($oNames);$k++)
		{
			if(in_array($oCol[$k], $mysql_fields)) 
			{
				if($oCol[$k]=="image_id") continue;
			
				echo "<option value=\"".$oCol[$k]."\" ".(isset($_REQUEST["comboSearch"])&&$_REQUEST["comboSearch"]==$oCol[$k]?"selected":"").">".$oNames[$k]."</option>";
			}
			
		}
		
		echo "</select> 
		&nbsp; 
		<input value=\"".(isset($_REQUEST["textSearch"])?$_REQUEST["textSearch"]:"")."\" type=\"text\" required name=\"textSearch\"/> 
		<input type=\"submit\" class=\"btn btn-default btn-gradient\" value=\" Search \">
		</form>
		</div>
		<div class=\"clear\"></div>
	
		";
	}
	
	echo "
	<script>
	function SubmitForm()
	{
		
		document.getElementById('table-form').submit();
	}
	</script>
	
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
	if(isset($_REQUEST["strSpecialHiddenFieldsToAdd"]))
	{
		echo $_REQUEST["strSpecialHiddenFieldsToAdd"];
	}		
	if(isset($_REQUEST["folder"]))
	{
		echo "<input type=\"hidden\" name=\"category\" value=\"".$_REQUEST["category"]."\"/>";
		echo "<input type=\"hidden\" name=\"page\" value=\"".$_REQUEST["page"]."\"/>";
		echo "<input type=\"hidden\" name=\"folder\" value=\"".$_REQUEST["folder"]."\"/>";
	}
	else
	{
		echo "<input type=\"hidden\" name=\"category\" value=\"".$_REQUEST["category"]."\"/>";
		echo "<input type=\"hidden\" name=\"action\" value=\"".$_REQUEST["action"]."\"/>";
	}
	
	if(isset($_REQUEST["hidden_fields"]))
	{
		foreach($_REQUEST["hidden_fields"] as $key=>$value)
		{
			echo "\n<input type=\"hidden\" name=\"".$key."\" value=\"".$value."\"/>";
		}
	}
	
	echo "<div class=\"table-responsive\">
			<table class=\"table table-hover admin-table\">
				<thead>
				<tr class=\"table-tr\">";
			
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
		echo "<th  width=\"40\">
		<input type=\"checkbox\" class=\"th-check\" title=\"".$strCheckColumnName." All\" onClick=\"CheckAll(this)\" />
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
	
	foreach ($_POST as $key=>$value) 
	{ 
		if($key != "order"&&$key!="order_type")
		{
			$str_submit_url .= $key."=".$value."&";
		}
	}
	
	foreach ($oNames as $columnName) 
	{
			echo "<th  width=".$arrTDSizes[$iTDHeaderCounter].">
			
			".(in_array($oCol[$iTDHeaderCounter],$arrFields)?("<a class=\"header-td\" href=\"".$str_submit_url."order=".$oCol[$iTDHeaderCounter]."&order_type=".$order_type."".(isset($URLToAdd)?$URLToAdd:"")."\">"):"<span class=\"header-td\">")."
			".$columnName."
			".(in_array($oCol[$iTDHeaderCounter],$arrFields)?"</a>":"</span>")."
			
			".((isset($_REQUEST["order"])&&$_REQUEST["order"]==$oCol[$iTDHeaderCounter]&&$strImgName!="")?"<img src=\"images/".$strImgName."\" width=\"14\" height=\"14\" style=\"position:relative;top:1px;left:5px\"/>":"")."
			
			</th>";
			$iTDHeaderCounter++;
  	}

	echo "</tr>
	</thead>
	<tbody>";

	$boolColor=true;


	
	while ($myArray = $database->fetch_array($oDataTable))
	{
	
		if(isset($arrHighlightIds) && isset($strHighlightIdName) && in_array($myArray[$strHighlightIdName],$arrHighlightIds,false)){
				echo "<tr bgcolor=\"#ffcf00\">";
			}
			else{
				echo "<tr bgcolor=\"".($boolColor?"#ffffff":"#f9f9f9")."\">";
			}


			
			if(strpos($strCheckColumnName,"#") !== false)
			{
			
			}
			else
			if(trim($strCheckColumnName)!="")
			{
			
				$cVal=$myArray[$strCheckValue];
				echo "<td>";
				
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
						echo "<td>".date("d/m/y G:i",$myArray[$columnName])."</td>";
					}
					else
					{
						echo "<td>&nbsp;</td>";
					}
				}
				else{
						$val="";

						if(isset($myArray[$columnName]))
						{
							$val=stripslashes($myArray[$columnName]);
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

			echo "</tr>
			";

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
	global $website,$_REQUEST,$category,$action,$ID,$EDIT_PICTURE,$iN,$AuthGroup,$lang,$arrFrmPages;

	
	if($columnName=="ApproveReject1") 
	{  
		global $id,$M_REJECT,$M_APPROVE;   
		return "<td class=oMain valign=middle> 
		
		<a href='index.php?category=".$_REQUEST["category"]."&folder=list&page=reply&Proceed=approve&id=".$myArray["id2"]."&posting_id=".$myArray["posting_id"]."' style=\"color:green;text-decoration:underline\"><b>".$M_APPROVE."</b></a>    </td>"; 
		
	} 
	else 
	if($columnName=="ApproveReject2") 
	{  
		global $id,$M_REJECT,$M_APPROVE;   
		
		return "<td class=oMain valign=middle>    <a href='index.php?category=".$_REQUEST["category"]."&folder=list&page=reply2&Proceed=reject&id=".$myArray["id2"]."&posting_id=".$myArray["posting_id"]."' style=\"color:red;text-decoration:underline\"><b>".$M_REJECT."</b></a>    </td>"; 
	} 
	else 
	if($columnName=="ApproveReject") 
	{  
		global $id,$M_REJECT,$M_APPROVE;   
		return "<td class=oMain valign=middle>    
		<a href='index.php?category=".$_REQUEST["category"]."&folder=".$_REQUEST["action"]."&page=reply&Proceed=approve&id=".$myArray["id2"]."&posting_id=".$myArray["posting_id"]."' style=\"color:green;text-decoration:underline\"><b>".$M_APPROVE."</b></a>  &nbsp;&nbsp;  
		<a href='index.php?category=".$_REQUEST["category"]."&folder=".$_REQUEST["action"]."&page=reply2&Proceed=reject&id=".$myArray["id2"]."&posting_id=".$myArray["posting_id"]."' style=\"color:red;text-decoration:underline\"><b>".$M_REJECT."</b></a>    </td>"; } else 
		
		if($columnName=="MessageReply"){  return "<td class=oMain valign=middle><a href='index.php?category=$category&folder=$action&page=reply&id=".$myArray['id']."' ><img src='../images/arrow.png' border=0></a></td>"; 
	}
	else 

	if($columnName=="JobseekerDetails")
	{
		return 
		"<td valign=middle>
			<a href='index.php?category=".$_REQUEST["category"]."&folder=my&page=details&posting_id=".$myArray['posting_id']."&apply_id=".$myArray['id2']."' ><img src=\"../images/job-details.png\" border=\"0\"/></a>
		</td>"; 
	
	} 
	else
	if($columnName=="show_answers")
	{
	
		return "
		<td>
			".nl2br($myArray["answers"])."
		</td>";
	}
	else
	if($columnName=="_featured")
	{
		return "<td align=\"center\"><a href=\"index.php?category=".$_REQUEST["category"]."&action=".$_REQUEST["action"]."_featured&featured=".($myArray['featured']=="0"?"1":"0")."&id=".$myArray['id']."\"><img border=\"0\" src=\"../images/active_".$myArray['featured'].".gif\"></a></td>";
	}
	else
	if($columnName=="job_info")
	{
		global $M_QUESTIONNAIRE,$M_STATISTICS;
		return "
		<td>
			<a href=\"index.php?category=jobs&action=questionnaire&id=".$myArray["id"]."\">".$M_QUESTIONNAIRE."</a>
			&nbsp;&nbsp;
			<a href=\"index.php?category=jobs&action=my_stat&id=".$myArray["id"]."\">".$M_STATISTICS."</a>
		</td>";
	}
	else
	if($columnName=="shipping_zone")
	{
		
		return "<td>".(isset($_REQUEST["arrZones"][$myArray["zone_id"]])?$_REQUEST["arrZones"][$myArray["zone_id"]]:"")."</td>";
	}
	else
	if($columnName=="show_location")
	{
		return "<td>".$website->show_full_location(isset($myArray["region"])?$myArray["region"]:$myArray["location"])."</td>";
	}
	else
	if($columnName=="_featured")
	{
		return "<td ><a href=\"index.php?category=".$_REQUEST["category"]."&action=".$_REQUEST["action"]."&f_act=".($myArray['featured']=="0"?"1":"0")."&mid=".$myArray['id']."\"><img border=\"0\" src=\"images/active_".$myArray['featured'].".gif\"></a></td>";
	}
	else
	if($columnName=="ShowCV")
	{  
		return "<td><a href='index.php?category=".$_REQUEST["category"]."&folder=search&page=cv&id=".$myArray['id']."' ><img width=\"30\" src=\"images/cv.gif\" alt=\"\"/></a></td>"; 
	}  
	else

	if($columnName=="show_subscription")
	{
		if($myArray['new_subscription']==0||$myArray['new_subscription']==$myArray['subscription'])
		{
			return "<td>
				".$_REQUEST["subscriptions"][$myArray['subscription']]."
			</td>";
		}
		else
		{
			return "<td>
				<img src=\"images/warning.png\"/> 
				<b>".$_REQUEST["subscriptions"][$myArray['new_subscription']]."</b>
				<br/>
				<a href='index.php?category=".$_REQUEST["category"]."&action=".$_REQUEST["action"]."&appr_sub=".$myArray['id']."' >Approve</a>
			</td>";
		}
	}
	else	
	if($columnName=="manage_features")
	{
		return "<td><a href='index.php?category=".$_REQUEST["category"]."&folder=listing_types&page=features&id=".$myArray['id']."' ><img src='../images/arrow.png' border=0></a></td>";
	}
	else	
	if($columnName=="show_category_name")
	{
		
		return "<td >".$website->show_category($myArray['job_category'])."</td>";
	
	}
	else
	
	if($columnName=="listing_fields")
	{
		return "<td><a href='index.php?category=".$_REQUEST["category"]."&folder=listing_types&page=fields&id=".$myArray['id']."' ><img src='../images/arrow.png' border=0></a></td>";
	}
	else
	if($columnName=="show_images")
	{
		
		global $MODIFY;
		$html_content = "<td>";
		
		if($myArray['images']!="")
		{
			$image_ids = explode(",",$myArray['images']);
			
			foreach($image_ids as $image_id)
			{
				if(file_exists("../thumbnails/".$image_id.".jpg"))
				{
					$html_content .= "<a href=\"../uploaded_images/".$image_id.".jpg\" class=\"hover\"><img src=\"../thumbnails/".$image_id.".jpg\" class=\"admin-preview-thumbnail\"/></a>";
				}
				elseif(preg_match("#http#is", $image_id))
				{
					$html_content .= "<a href=\"".$image_id."\" class=\"hover\"><img src=\"".$image_id."\" class=\"admin-preview-thumbnail\"/></a>";
				}
			}
			
			$html_content .= '<div class="clear"><a class="underline-link" href="index.php?category=products_manager&action=images&id='.$myArray['id'].'">'.$MODIFY.'</a></div>';
			
		}
		else
		{
			$html_content .= "<img src=\"../images/no_pic.gif\" width=\"50\" style=\"float:left;margin-right:10px;margin-bottom:10px\"/>";
		}
		
		$html_content .= "</td>";
		
		return $html_content;
	}
	else
	if($columnName=="url")
	{
		return "<td><b><a target=\"_blank\" href=\"http://".$myArray['url']."\">".$myArray['url']."</a></b>
		
		</td>";
	}
	
	else
	
	if($columnName=="html_limit"){
		
		$strToDisplay = "";
		
		if(strlen($myArray["html"])<=100)
		{
			$strToDisplay = $myArray["html"];
		}
		else
		{
			$strToDisplay = substr($myArray["html"],0,100)." <a href='index.php?category=".$_REQUEST["category"]."&folder=$action&page=view&id=".$myArray['id']."'>...</a>";
		}
		
		
				return "<td>".$strToDisplay."</td>";
	}
	
	else
	if($columnName=="image_id")
	{
		
		return "<td><a href='../uploaded_images/".$myArray['image_id'].".jpg' target=_blank><img src='../thumbnails/".$myArray['image_id'].".jpg' border=\"0\" width=\"150\"/></a></td>";
	}
	
	else
	if($columnName=="file_id")
	{
		global $mod,$OPEN_FILE;
				return "<td><a href='../file.php?id=".$myArray['file_id']."' target=_blank>file.php?id=".$myArray['file_id']."</a></td>";
	}
	

	else
	if($columnName=="EditProductItems")
	{
				return "<td><a href='index.php?category=".$_REQUEST["category"]."&folder=products&page=items&id=".$myArray['id']."' ><img src='images/icons/options_add.png' height=\"23\" alt=\"Manage the product options\" border=0></a></td>";
	}
	else
	if($columnName=="ShowComments"){
				return "<td><a href='index.php?category=".$_REQUEST["category"]."&folder=$action&page=comments&id=".$myArray['id']."' ><img src='images/preview.gif' width=23 height=22 border=0></a></td>";
	}
	else
	if($columnName=="EditNote")
	{
				
		return "<td width=\"20\"><a href='index.php?category=".$_REQUEST["category"]."&folder=".$_REQUEST["action"]."&page=edit&id=".$myArray['id']."' ><img src=\"images/edit-icon.gif\"  border=\"0\"/></a></td>";
	}
	else
	if($columnName=="ShowExportReport"){
				return "<td><a href='index.php?category=".$_REQUEST["category"]."&folder=history&page=report&id=".$myArray['id']."' ><img src='images/preview.gif' width=23 height=22 border=0></a></td>";
	}
	else
	if($columnName=="ShowFormData"){
				return "<td><a href='index.php?category=".$_REQUEST["category"]."&folder=manage&page=data&id=".$myArray['id']."' ><img src='images/preview.gif' width=23 height=22 border=0></a></td>";
	}
	else	
	if($columnName=="ShowFlag"){
				return "<td><img src=\"../images/flags/".$myArray["code"].".gif\" /></td>";
	}
	else	
	if($columnName=="ShowSpecialLanguage"){
				return "<td><input type=radio name=\"default_language[]\" onclick=\"javascript:RadioClick(".$myArray["id"].")\" value=\"".$myArray["id"]."\" ".($myArray["default_language"]==1?"checked":"")."></td>";
	}
	else	
	if($columnName=="active"){
				return "<td>".($myArray["active"]==1?"YES":"NO")."</td>";
	}
	else
	if($columnName=="ChangeLanguage"){
				return "<td><a href='index.php?category=".$_REQUEST["category"]."&folder=".$_REQUEST["action"]."&page=edit&id=".$myArray['id']."' ><img src=\"images/icons/icon_arrow.png\"  border=\"0\"/></a></td>";
	}
	else
	if($columnName=="ShowPageLink"){
				return "<td><a href='../index.php?page=".$myArray['id']."' target=_blank><img src='images/preview.gif' width=23 height=22 border=0></a></td>";
	}
	else
	
	if($columnName=="ShowDeleteLink"){
				return "<td><a href='javascript:DeletePage(".$myArray['id'].")'' ><img src='images/cut.gif' width=23 height=22 border=0></a></td>";
	}
	
else
	
	

	if($columnName=="ShowModifierUtilisateur"){
	
		if($myArray['username']=="administrator")
		{
			return "<td>[n/a]</td>";
		}
		else
		{
				return "<td>
						<a href='index.php?category=".$_REQUEST["category"]."&folder=admin&page=edit&id=".$myArray['id']."' >
						<img src='../images/arrow.png' border=0>
						</a></td>";
		}
	}
	else
	if($columnName=="EditCommonAccount"){
				return "<td><a href='index.php?category=".$_REQUEST["category"]."&folder=accounts&page=editcommon&UserName=".$myArray['UserName']."' ><img src=\"../images/edit-icon.gif\" width=\"24\" height=\"20\" border=\"0\"/></a></td>";
	}
	else
	
	if($columnName=="ShowFormDelete"){
				return "<td><a href='index.php?category=".$_REQUEST["category"]."&action=".$_REQUEST["action"]."&ProceedDelete=yes&id=".$myArray['id']."' ><img src='images/cut.gif' border=0></a></td>";
	}
	else
	if($columnName=="GoogleQuery"){
	
		$strQuery="";
		
			$arrInfo2=explode("?",$myArray["referer"],2);
			
			if(sizeof($arrInfo2)>1)
			{
				$arrInfo = explode("&",$arrInfo2[1]);
		
			
				
				foreach($arrInfo as $strInfo)
				{
					if(substr($strInfo,0,2) == "q=")
					{
					
						$strQuery = str_replace("q=","",$strInfo);
						
						break;
					}
					}
					
				}
			
				return "<td><a href=\"".$myArray["referer"]."\" target=_blank>".(strtoupper(urldecode($strQuery)))."</a></td>";
	}
	else
	if($columnName=="EditAdminUser"){
				return "<td><a href='index.php?category=".$_REQUEST["category"]."&folder=admin&page=editadmin&id=".$myArray['id']."' ><img src=\"../images/edit-icon.gif\" width=\"24\" height=\"20\" border=\"0\" /></a></td>";
	}
	else
	if($columnName=="EditCommonUser"){
				return "<td><a href='index.php?category=".$_REQUEST["category"]."&folder=accounts&page=editcommon&id=".$myArray['id']."' ><img src=\"../images/edit-icon.gif\" width=\"24\" height=\"20\" border=\"0\" /></a></td>";
	}
	
	else
	if($columnName=="DeleteLanguage"){
				return "<td><a href='javascript:DeleteLanguage(".$myArray['id'].",\"".$myArray['code']."\")' ><img src='images/cancel.gif' width=21 height=20 border=0></a></td>";
	}
	else
	if($columnName=="DeleteTemplate"){
				return "<td><a href='javascript:DeleteTemplate(".$myArray['id'].")' ><img src='images/cancel.gif' width=21 height=20 border=0></a></td>";
	}
	else
	if($columnName=="ModifyTemplate"){
	
				return "<td><a href='index.php?category=".$_REQUEST["category"]."&folder=modify&page=edit&id=".$myArray['id']."' ><img src='../images/arrow.png' border=0></a></td>";
	}
	else
	if($columnName=="EditPosting"){
				return "<td><a href='index.php?category=".$_REQUEST["category"]."&folder=".$_REQUEST["action"]."&page=edit&id=".$myArray['id'].(isset($_REQUEST["id"])?"&job_id=".$_REQUEST["id"]:"")."' ><img src=\"../images/edit-icon.gif\" width=\"24\" height=\"20\" border=\"0\"/></a></td>";
	}
	
	if($columnName=="ShowDeleteLink"){
				return "<td><a href='javascript:DeletePage(".$myArray['id'].")'' ><img src=\"../images/cut.gif\" border=\"0\" /></a></td>";
	}
	
	else
	if($columnName=="BackupForm"){
				return "<td><a href='index.php?category=".$_REQUEST["category"]."&action=".$_REQUEST["action"]."&SpecialProcessAddForm=".$myArray['id']."' ><img src='images/copy.gif'  border=0></a></td>";
	}
	else
	if($columnName=="ShowFormEdit")
	{
				return "<td><a href='index.php?category=".$_REQUEST["category"]."&folder=".$_REQUEST["action"]."&page=edit&id=".$myArray['id']."' ><img src='../images/arrow.png' border=0></a></td>";
	}
	else
	if($columnName=="ShowFormPreview"){
				return "<td><a href='index.php?category=".$_REQUEST["category"]."&folder=manage&page=preview&id=".$myArray['id']."' ><img src='../images/arrow.png' border=0></a></td>";
	}
	else
	if($columnName=="date_string"){
				return "<td>".$myArray['date']."</td>";
	}
	else
	if($columnName=="ShowAssignForm")
	{
	
				$oResult= "<td>";
				
				$oResult.="<select style=\"width:160px\" name=\"pg_".$myArray['id']."\">";
				$oResult.="<option>Please Select</option>";
				
				if(isset($_REQUEST["frm-pages"]))
				{
					foreach($_REQUEST["frm-pages"]  as $pg)
					{
						list($lng,$page)=explode("_",$pg);
						$oResult.="<option value=\"".$pg."\" ".($myArray['page']==urldecode($pg)?"selected":"").">".urldecode($page)." [".strtoupper($lng)."] </option>";				
					}
				}
				
				

			
				$oResult.="</select>";
				
				$oResult.= "</td>";
				
				return $oResult;
	}
	
	

	return "";
}

function EditParams
	(
		$strListOfParamIds,
		$arrTypes,
		$strSubmitText,
		$strSuccessMessage
	){

	global $EditColumns,$FirstTDAlign,$SelectWidth,$TextboxWidth,$TableWidth;
	global $DBprefix;
	global $SpecialProcessEditParams,$AuthUserName;
	global $firstTDLength;
	global $database,$_REQUEST;

	if(!isset($FirstTDAlign))
	{
		$FirstTDAlign = "right";
	}
	
	if(isset($_REQUEST["SpecialProcessEditParams"])){

		
		foreach(explode(",",$strListOfParamIds) as $i)
		{
			$sql="UPDATE ".$DBprefix.""."settings SET value='".$_REQUEST["val".$i]."' WHERE id=".$i;

			$database->Query($sql);
		}

		echo "
			<span class=\"medium-font\">".$strSuccessMessage."</span><br/><br/>";
	}
	
	echo "<form action=\"index.php\" method=\"post\">";
	echo "<input type=\"hidden\" name=\"category\" value=\"".$_REQUEST["category"]."\" />";
	echo "<input type=\"hidden\" name=\"SpecialProcessEditParams\" value=\"1\" />";
		
	if(isset($_REQUEST["action"]))
	{
		echo "<input type=\"hidden\" name=\"action\" value=\"".$_REQUEST["action"]."\"/>";
	}
	else
	{
		echo "<input type=\"hidden\" name=\"folder\" value=\"".$_REQUEST["folder"]."\"/>";
		echo "<input type=\"hidden\" name=\"page\" value=\"".$_REQUEST["page"]."\"/>";
	}

	$oTable=$database->DataTable("settings"," WHERE id in (".$strListOfParamIds.") ORDER BY id");

	$i=0;
	
	echo "<table>";

	while($row=$database->fetch_array($oTable))	
	{

		if(isset($EditColumns))
		{
			if(($i % $EditColumns) == 0)
			{
				echo "<tr height=25>";			
			}
		}
		else
		{
			echo "<tr height=25>";
		}
	

		echo "<td width=".(isset($_REQUEST["message-column-width"])?$_REQUEST["message-column-width"]:"150")." align=".$FirstTDAlign." >".(strpos(strtolower($row['description']),"color")?"<a href=\"javascript:ShowColorMenu('val".$row['id']."')\">":"")."".$row['description'].":".(strpos(strtolower($row['description']),"color")?"</a>":"")." </td>";
		echo "<td>";

		if(strstr($arrTypes[$i],"file")){

				echo "<input type=file value=\"".$row['value']."\" name=\"val".$row['id']."\" size=30>";
		}
		else
		if(strstr($arrTypes[$i],"textbox"))
		{
			list($strType,$strSize)=explode("_",$arrTypes[$i]);
			
				echo "<input type=text value=\"".$row['value']."\" name=\"val".$row['id']."\" id=\"val".$row['id']."\" size=$strSize ".(isset($TextboxWidth)?"style='width:".$TextboxWidth."'":"").">";
		}
		else
		if(strstr($arrTypes[$i],"textarea"))
		{
			list($strType,$strCols,$strRows)=explode("_",$arrTypes[$i]);

			echo "<textarea  name=\"val".$row['id']."\" cols=$strCols rows=$strRows>".$row['value']."</textarea>";
		}
		else
		if(strstr($arrTypes[$i],"javascript~combobox")){

			echo "<select  name=\"val".$row['id']."\" onChange=javascript:SelectChanged(this)>";

			foreach(explode("_",$arrTypes[$i]) as $strOption){

				if($strOption=="javascript~combobox"){
					continue;
				}

				echo "<option>".str_replace("~"," ",$strOption)."</option>";
			}

		}
		else
		if(strstr($arrTypes[$i],"combobox"))
		{
			
			echo "<select ".(isset($_REQUEST["select-width"])?"style=\"width:".$_REQUEST["select-width"]."px\"":"")." name=\"val".$row['id']."\">";

			foreach(explode("_",$arrTypes[$i]) as $strOption)
			{

				if($strOption=="combobox")
				{
					continue;
				}

				$arrOptions = explode("^", $strOption);

				if(sizeof($arrOptions)>1)
				{
					echo "<option value=\"".$arrOptions[1]."\"";
					if($arrOptions[1]==$row["value"])
					{
						echo " selected";
					}
					echo">".$arrOptions[0]."</option>";
				}
				else
				{
					echo "<option ";
					if($strOption==$row["value"])
					{
						echo " selected";
					}
					echo">".$strOption."</option>";
				
				}

			}

			echo "</select>";

		}
		else
		{
			echo "This type is not supported.";
		}

		$i++;

		echo "</td><td width=30>&nbsp;</td>";
		
		
		if(isset($EditColumns))
		{
			if(($i % $EditColumns) == 0)
			{
				echo "</tr>";
			}
		}
		else
		{
			echo "</tr>";
		}
		
	}



	echo "</table>
		<br>
		
		<input type=\"submit\" class=\"btn btn-default btn-gradient\" value=\"".$strSubmitText."\"/>
	
	</form>";

}

function LinkTile
		(
			$category,
			$action,
			$text,
			$small_text,
			$color="blue",
			$type="small",
			$no_ajax = false,
			$js_function = ""
		)
{
	global $lang,$currentPage,$currentUser,$DEBUG_MODE,$is_mobile;
	
	$has_param = strpos($action,"=");
	
	if($has_param !== false)
	{
		$no_ajax = true;
		$action = str_replace("-","&",$action);
	}
	
	if(!$currentPage->CheckPermissions($category, $action))
	{
		return "";
	}
	if(strpos($action,"_")!==false||strpos($action,"-")!==false)
	{
		$no_ajax = true;
	}
	
	if($action == "add"||$action == "new_user"||$action == "newsletter2")
	{
		$no_ajax = true;
	}
	if($js_function!="")
	{
		$tileLink = "javascript:".$js_function."()";
	}
	else
	if($no_ajax || (isset($is_mobile)&&$is_mobile) || (isset($DEBUG_MODE)&&$DEBUG_MODE)||true)
	{
		$tileLink = "index.php?category=".$category."&action=".$action;
	}
	else
	{
		$tileLink = "#".$category."-".$action;
	}
	
	
	$result =	"<a class=\"".$type."-tile ".$color."-back\" href=\"".$tileLink."\">";
	
	global $SEND_MESSAGE,$M_SAVE_RESUME_AS_PDF;
	
	if($text==$SEND_MESSAGE)
	{
		$str_icon_file = "images/icons/messages.png";
	}
	else
	if($text==$M_SAVE_RESUME_AS_PDF)
	{
		$str_icon_file = "images/icons/documents.png";
	}
	else
	if(file_exists("images/icons/".$action.".png"))
	{
		$str_icon_file = "images/icons/".$action.".png";
	}
	else
	{
		$str_icon_file = "images/icons/default.png";
	}
	
	global $M_GO_BACK;
	
	if($text==$M_GO_BACK)
	{
		$str_icon_file = "images/icons/back.png";
	}
		
	
	$result .= "<img class=\"pull-right\" ".($type=="small"?"width=\"32\"":"")." src=\"".$str_icon_file."\"/>";
			
	$result .="<h3 class=\"h3-tile\">".$text."</h3>
	</a>";
	return $result;		
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
	global $category,$folder,$page,$action;
	global $SpecialProcessEditForm,$SubmitButtonText;

	global $database,$website,$_REQUEST;

	if($strUniqueKey=="username")
	{
		$str_key_query=$strUniqueKey."='".$strCurrentUniqueKeyValue."'";
	}
	else
	{
		$str_key_query=$strUniqueKey."=".$strCurrentUniqueKeyValue;
	}
	
	$oArray=$database->DataArray($strTableName,$str_key_query);

	
		
	if(isset($_REQUEST["SpecialProcessEditForm"]))
	{

		$arrValues=array();
		$arrEditNames=array();
		
		
		if(isset($_REQUEST["arrNames2"]))
		{
			
			for($i=0;$i<sizeof($_REQUEST["arrNames2"]);$i++)
			{
				array_push($arrEditNames,$_REQUEST["arrNames2"][$i]);
				array_push($arrValues,$_REQUEST["arrValues2"][$i]);
			}
		}

		for($i=0;$i<sizeof($arrEditFields);$i++)
		{
			if(trim($arrTexts[$i])=="") continue;
			$strName=$arrEditFields[$i];

			if(in_array($strName,$arrMissedFields))
			{
				continue;
			}

			
			if($arrTypes[$i]=="file")
			{
			
				$tempValue = get_param($strName);

				if($strName == "image_id"||$strName == "logo")
				{

					$path="../";
					///images processing
					$str_images_list = "";
					$input_field=$strName;	
					include("../include/images_processing.php");
					///end images processing
					
					array_push($arrEditNames,$strName);
					array_push($arrValues,$str_images_list);
				}
				else
				if(trim($tempValue)!="")
				{
					array_push($arrEditNames,$strName);
					$database->SQLDelete("files","file_id",array($oArray["file_id"]));

					$iFileId=$database->SQLInsertFile($strName);

					array_push($arrValues,$iFileId);
				}
			}
			else
			{
				if($strName=="images") continue;
				if($strName=="country_multi") $strName="country";
				array_push($arrEditNames,$strName);

				$tempValue = "";
				
				if(isset($_REQUEST[$strName]))
				{
					$tempValue = $_REQUEST[$strName];
				}
				else
				if(isset($_REQUEST["post_".$strName]))
				{
					$tempValue = $_REQUEST["post_".$strName];
				}

				if($tempValue=="")
				{
					$arr_decim=array("price","old_price","points","price_points","weight","shipping_cost","experience_level");
					if(in_array($strName,$arr_decim)) $tempValue="NULL";
				}
				
				array_push($arrValues,$tempValue);
			}
		}

		
		$database->SQLUpdate($strTableName,$arrEditNames,$arrValues,$str_key_query);

		echo "<br/><span class=\"medium-font\">".$strSuccessMessage."</span><br/><br/><br/>";
		
		$oArray=$database->DataArray($strTableName,$str_key_query);

	}
	
	if(true)
	{

		echo "<table>";

		echo "<form id=\"EditForm\" ".(isset($jsValidation)&&$jsValidation!=""?"onsubmit='return $jsValidation(this)'":"")." action=\"index.php\" method=\"post\" enctype=\"multipart/form-data\">";
		echo "<input type=\"hidden\" name=\"category\" value=\"".$_REQUEST["category"]."\">";
		
		if(isset($_REQUEST["folder"])&&isset($_REQUEST["page"]))
		{
			echo "<input type=\"hidden\" name=\"folder\" value=\"".$_REQUEST["folder"]."\"/>";
			echo "<input type=\"hidden\" name=\"page\" value=\"".$_REQUEST["page"]."\"/>";
		}
		else
		{
			echo "<input type=\"hidden\" name=\"action\" value=\"".$_REQUEST["action"]."\"/>";
		}
		echo "<input type=\"hidden\" name=\"".$strUniqueKey."\" value=\"".$strCurrentUniqueKeyValue."\"/>";
		echo "<input type=\"hidden\" name=\"SpecialProcessEditForm\" value=\"1\"/>";

		if(isset($_REQUEST["strSpecialHiddenFieldsToAdd"]))
		{
			echo $_REQUEST["strSpecialHiddenFieldsToAdd"];
		}

		for($i=0;$i<sizeof($arrTexts);$i++)
		{
			if(trim($arrTexts[$i])=="") continue;
			echo "<tr height=\"38\">";

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
				global $website;
				if($arrEditFields[$i]=="job_category")
				{
					echo "<b>".$website->show_category($oArray[$arrEditFields[$i]])."</b>";
				}
				else
				if($arrEditFields[$i]=="region")
				{
				
					echo "<b>".$website->show_full_location($oArray[$arrEditFields[$i]])."</b>";
				}
				else
				if($arrEditFields[$i]=="job_type")
				{
				
					$arr_j_types=$website->GetParam("arrJobTypes");
					if(isset($arr_j_types[$oArray[$arrEditFields[$i]]]))
					echo "<b>".$arr_j_types[$oArray[$arrEditFields[$i]]]."</b>";
					else echo "";
				}
				else
				if($arrEditFields[$i]=="logo")
				{
				
					if(file_exists("../thumbnails/".$oArray[$arrEditFields[$i]].".jpg"))
					{
						echo "<img src=\"../thumbnails/".$oArray[$arrEditFields[$i]].".jpg\"/>";
					}
					else
					{
						echo "";
					}
											
				}
				else
				if($arrEditFields[$i]=="gender")
				{
					if($oArray[$arrEditFields[$i]]==1)
					{
						global $M_MALE;
						echo "<b>".$M_MALE."</b>";
					}
					if($oArray[$arrEditFields[$i]]==2)
					{
						global $M_FEMALE;
						echo "<b>".$M_FEMALE."</b>";
					}
						
				}
				else
				{
					echo "<b>".$oArray[$arrEditFields[$i]]."</b>";
				}
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
					
				echo "<select ".(isset($_REQUEST["select-width"])?"style=\"width:".$_REQUEST["select-width"]."px\"":"")." name=\"".$arrEditFields[$i]."\">";
				
				while($oRow=$database->fetch_array($oTable)){
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
					echo "<input type=\"text\" value=\"".($strVal=="0.00"?"":stripslashes($strVal))."\" name=\"".$arrEditFields[$i]."\" id=\"".$arrEditFields[$i]."\" size=\"".$strSize."\" ".(isset($_REQUEST["select-width"])?"style=\"width:".$_REQUEST["select-width"]."px\"":"")."/>";
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
						elseif(strpos($image_id, "http"))
						{
							echo "<a href=\"".$image_id."\" class=\"hover\"><img src=\"".$image_id."\" class=\"admin-preview-thumbnail\"/></a>";
						}
						
					}
					
				}
				else
				{
					echo "<img src=\"../images/no_pic.gif\" width=\"100\" height=\"100\" style=\"float:left;margin-right:10px;margin-bottom:10px\"/>";
				}
				global $MODIFY;
				echo "<span class=\"lfloat\"><a class=\"underline-link\" href=\"index.php?category=products_manager&action=images&id=".$strCurrentUniqueKeyValue."\">".$MODIFY."</a></span>";
			}
			else
			if(strstr($arrTypes[$i],"combobox_region"))
			{
				$strVal="";
			
				if(isset($oArray[$arrEditFields[$i]])){
					$strVal=$oArray[$arrEditFields[$i]];
				}
				
				echo "<select id=\"region\" name=\"region\">";
				global $M_PLEASE_SELECT;
				echo "<option value=\"\">".$M_PLEASE_SELECT."</option>";
				
				$categories_content = file_get_contents('../locations/locations.php');
				

				$arrCategories = explode("\n", trim($categories_content));

				$categories=array();
				
				foreach($arrCategories as $str_category)
				{
					$cat_items=explode(". ",$str_category);
					if(sizeof($cat_items)==2)
					{
						$key=$cat_items[0];
						$value=$cat_items[1];
						$categories[trim($key)]=trim($value);
					
						$i_level = substr_count($key, ".");
					
						echo "<option  value=\"".trim($key)."\" ".(strcmp($strVal,trim($key))==0?"selected":"").">".str_repeat("|&nbsp;&nbsp;&nbsp;&nbsp;", $i_level)."|__".trim($value)."</option>";
					}
				}
				
				echo "</select>";

			}
			else
			if(strstr($arrTypes[$i],"combobox_special"))
			{
				
				
				if($arrEditFields[$i]=="job_category")
				{
					   global $LANGUAGE2;
					   
					   if(isset($oArray[$arrEditFields[$i]]))
						{
							$strVal = $oArray[$arrEditFields[$i]];
						}
						global $lines;
						
						echo "<select ".(isset($_REQUEST["select-width"])?"style=\"width:".$_REQUEST["select-width"]."px\"":"")." name=job_category>";
	
	
						if(isset($_REQUEST["folder"])&&$_REQUEST["folder"]=="courses")
						{
							if(file_exists('../categories/course_categories_'.strtolower($website->lang).'.php'))
							{
								$lines = file('../categories/course_categories_'.strtolower($website->lang).'.php');
							}
							else
							{
								$lines = file('../categories/course_categories_en.php');
							}

						}
						else
						{
							global $website;
							if(file_exists('../categories/categories_'.strtolower($website->lang).'.php'))
							{
								$lines = file('../categories/categories_'.strtolower($website->lang).'.php');
							}
							else
							{
								$lines = file('../categories/categories_en.php');
							}
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
						echo "<option value=\"".trim($key)."\" ".(isset($strVal)&&(strcmp($strVal,trim($key))==0)?"selected":"")." >".trim($val)."</option>";
						$arr_sub_cats = get_sub_cats($key,$lines);
						
						if(sizeof($arr_sub_cats)>0)
						{
							while (list($s_key, $s_val) = each($arr_sub_cats)) 
							{
								echo "<option value=\"".trim($s_key)."\" ".(isset($strVal)&&$strVal==trim($s_key)?"selected":"")." style=\"font-size:10px\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".trim($s_val)."</option>";
							}
						}
					}
					
					echo "</select>";
				}
				else
				if($arrEditFields[$i]=="job_category")
				{
						global $AuthUserName;
						
						if(isset($oArray[$arrEditFields[$i]]))
						{
							$strVal = $oArray[$arrEditFields[$i]];
						}
					
						echo "<select name='job_category'>";
					
						$pr_categories = $database->DataTable("product_categories","WHERE username='".$AuthUserName."' ");
						
					 	while($pr_category=$database->fetch_array($pr_categories))
						{
							echo "<option ".($strVal==$pr_category["id"]?"selected":"")." value=".$pr_category["id"].">".$pr_category["name_en"]."</option>";
						}
						
						echo "</select>";
				}
				else
				if($arrEditFields[$i]=="country_multi")
				{
					$strVal = $oArray["country"];
					
					echo "<select ".(isset($_REQUEST["select-width"])?"style=\"width:".$_REQUEST["select-width"]."px\"":"")." name='country[]' size=8 multiple >";
					
					
					if(trim($strVal) != "")
					{
						
						$lines = file("../include/countries.php");
				
						foreach ($lines as $line_num => $line) 
						{
							$line = trim($line);
							if(trim($line) != "")
							{
								echo "<option value=\"".$line."\" ".(strpos($strVal,$line)!==false?"selected":"").">".$line."</option> ";
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
					
					echo "<select ".(isset($_REQUEST["select-width"])?"style=\"width:".$_REQUEST["select-width"]."px\"":"")." name='states[]' size=\"8\" multiple>";
					
					
					if(trim($strVal) != "")
					{
						$lines = file("../include/states.php");
				
						foreach ($lines as $line_num => $line) 
						{
							$line = trim($line);
							if(trim($line) != "")
							{
								echo "<option value=\"".$line."\" ".(strpos($strVal,$line)!==false?"selected":"").">".$line."</option> ";
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
					
						echo "<select ".(isset($_REQUEST["select-width"])?"style=\"width:".$_REQUEST["select-width"]."px\"":"")." name=\"".$arrEditFields[$i]."\">";

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
					
					echo "<select ".(isset($_REQUEST["select-width"])?"style=\"width:".$_REQUEST["select-width"]."px\"":"")." name=\"region\">";

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
								
					echo "<select ".(isset($_REQUEST["select-width"])?"style=\"width:".$_REQUEST["select-width"]."px\"":"")." name=\"".$arrEditFields[$i]."\">";
					
					$oCatTable=DataTable("frontstore_category","");
					
					while($oCatRow=$database->fetch_array($oCatTable)){
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

		echo "<br>";
			
		if(isset($_REQUEST["HideSubmit"]))
		{
		
		}
		else
		{
				echo "<input class=\"btn btn-primary\" type=\"submit\" value=\"".(isset($SubmitButtonText)?$SubmitButtonText:"Save")."\"/>";
		}
		echo "</form>";
		
	}
}


function generateBackLink($pageAction,$evLinkTexts,$evLinkActions)
{
		global $_REQUEST,$GO_BACK_TO;
		
		echo "<br/><br/>";
		
		echo "<a href=\"index.php?category=".$_REQUEST["category"]."&action=".$pageAction."\">".$GO_BACK_TO." \"".$evLinkTexts[array_search($pageAction,$evLinkActions,false)]."\"</a>";
	
}

function Parameter($i)
{
	global $website;
	
	return $website->params[$i];
}

function aParameter($i)
{
	global $website;
	
	return $website->params[$i];
}

function CreateLink($category,$action)
{
	global $is_mobile,$DEBUG_MODE;
	
	if($is_mobile||$DEBUG_MODE||true)
	{
		return "index.php?category=".$category."&action=".$action;
	}
	else
	{
		return "#".$category."-".$action;
	}
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
		return $strResult;
	}

	echo $strResult;
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





function RenderCompositeTable
	(
		$strQuery,
		$barFields,
		$barNames,
		$barCheckBoxes,
		$PrimaryField,
		$arrTypes,
		$arrTitles,
		$arraysFields,
		$arraysNames

	)
	{

	global $website,$database,$AuthUserName,$_REQUEST;
	global $action,$category,$ProceedCompositeTable,$Approve,$Reject,$Delivered,$Approve_Payment;
	global $RefundsDonePage,$RefundPage,$showReceptLink,$PageSize,$isDoctorApprovePage,$PageNumber,$doNotGeneratePDFExportLink,$RejectedPage,$ApprovedPage;
	global $formActionURL;

	
	if(!isset($PageSize)){
		$PageSize=10;
	}
	
	if(!isset($PageNumber)){
		$PageNumber=1;
	}
	
	echo "
		<script>

		function PrintOrder(x)
		{
			var content=document.getElementById(\"CompositeTR\"+x).innerHTML;
			var pwin=window.open('','print_content','width=940,height=500');
			pwin.document.open();
			pwin.document.write('<html><body onload=\"window.print()\">'+content+'</body></html>');
			pwin.document.close();
			setTimeout(function(){pwin.close();},1000);

		}
		
		var strCompositeMode='Frame'; 

				function CompositeTROver(x,trobject){
					
					if(strCompositeMode=='Frame')
					{
					
						
						trobject.style.background='#efefef';
											
						document.getElementById('CompositeContainerTR').innerHTML='<table width=\"100%\" ><tr>'+document.getElementById('CompositeTR'+x).innerHTML.replace(\"'none'\",\"'block'\")+'</tr></table>';
	
					}
				}
				
				function CompositeTROut(x,trobject,trcolor){
					
					if(strCompositeMode=='Frame')
					{
						
						trobject.style.background=trcolor;
						
					}
				}
				
				function ManageCompositeTR(x){
					
					

					

						document.getElementById('CompositeContainerTR').innerHTML='';

						if(document.getElementById('CompositeTR'+x).style.display=='none')
						{
							document.getElementById('CompositeTR'+x).style.display='block';
						}
						else
						{
							document.getElementById('CompositeTR'+x).style.display='none';
						}

					
				}

				function ChangeDisplayMode(x){

					if(x==1){
						document.getElementById('divDisplayMode').innerHTML=\"Display Mode: <a href='javascript:ChangeDisplayMode(2)' style='color:red !important;text-decoration:underline'>Expand</a>\";
						strCompositeMode='Expand';
					}
					else{
						document.getElementById('divDisplayMode').innerHTML=\"Display Mode: <a href='javascript:ChangeDisplayMode(1)' style='color:red !important;text-decoration:underline'>Frame</a>\";
						strCompositeMode='Frame';
					}
				}

				
				
				function ChangePageSize(x)
				{
					var category='".$_REQUEST["category"]."';
					var action='".$_REQUEST["action"]."';
					var newSize=10;
					
					if(x==0){
						newSize=5;
					}
					else
					if(x==1){
						newSize=10;
					}
					else
					if(x==2){
						newSize=20;
					}
					else
					if(x==3){
						newSize=50;
					}
					else
					if(x==4){
						newSize=100;
					}
					";
					
					if(isset($formActionURL))
					{
						echo "document.location.href='".$formActionURL."&PageSize='+newSize+'';";
					}
					else
					{
						echo "document.location.href='index.php?category=".$_REQUEST["category"]."&action=".$_REQUEST["action"]."&PageSize='+newSize+'';";
					}
					
					
		echo "		}
		</script>
	";


	$arr_pids=array();
	
	$oDataTable=$database->Query($strQuery." LIMIT ".(($PageNumber-1)*$PageSize).",".($PageSize)."");
	$iTotalResults=$database->num_rows($oDataTable);
	
	if($iTotalResults==""||$iTotalResults==0)
	{
		global $M_NO_ENTRIES;	
		echo "<br><br><i>".$M_NO_ENTRIES."</i>";
		return;
	}
	
	
	
	echo "<form action=\"index.php\" method=\"post\">";
	echo "<input type=\"hidden\" name=\"action\" value=\"".$_REQUEST["action"]."\"/>";
	echo "<input type=\"hidden\" name=\"category\" value=\"".$_REQUEST["category"]."\"/>";
	echo "<input type=\"hidden\" name=\"ProceedCompositeTable\" value=\"\">";

	global $PAGE_SIZE;
	
	echo "<table width=\"100%\">
				<tr>
					<td class=basictext>
							<table>
							<tr>
							<td class=basicText>
							<b>
							".$PAGE_SIZE.": 
							</b>
							</td>
							<td class=basicText>
								<select onchange='javascript:ChangePageSize(this.selectedIndex)'>
									<option ".($PageSize==5?"selected":"").">5</option>
									<option ".($PageSize==10?"selected":"").">10</option>
									<option ".($PageSize==20?"selected":"").">20</option>
									<option ".($PageSize==50?"selected":"").">50</option>
									<option ".($PageSize==100?"selected":"").">100</option>
								</select>
								
							 </td>
							 <td class=basictext>
							 	&nbsp;&nbsp;&nbsp;&nbsp;
								<b>";
								
								if($PageNumber > 1)
								{
									if(isset($formActionURL))
									{
										echo "<a href='".$formActionURL."&PageSize=$PageSize&PageNumber=".(intval($PageNumber)-1)."'> << </a>";
									}
									else
									{
										echo "<a href='index.php?category=".$_REQUEST["category"]."&action=$action&PageSize=$PageSize&PageNumber=".(intval($PageNumber)-1)."'> << </a>";
									}
									
									
									echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
								}
								
								if($iTotalResults == $PageSize)
								{
								
									if(isset($formActionURL))
									{
										echo "<a href='".$formActionURL."&PageSize=$PageSize&PageNumber=".(intval($PageNumber)+1)."'> >> </a>";
									}
									else
									{
										echo "<a href='index.php?category=".$_REQUEST["category"]."&action=$action&PageSize=$PageSize&PageNumber=".(intval($PageNumber)+1)."'> >> </a>";
									}
									
								}
								
								
						global $M_DISPLAY_MODE;			
					echo "	 </b>
								
							 </td>
							 </tr>
							 </table>
							 
							 
					</td>
					<td class=basictext align=right>
						<b>
						<div id=divDisplayMode>
								".$M_DISPLAY_MODE.": <a href='javascript:ChangeDisplayMode(1)' style='color:red !important;text-decoration:underline'>Frame</a>
						</div>
						</b>
					</td>
				</tr>
			</table><br>";

	


	$iRowsCounter=0;

	while($oRow=$database->fetch_array($oDataTable))
	{
	
		if($PrimaryField!="")
		{
			if(in_array($oRow[$PrimaryField], $arr_pids)) continue;
			array_push($arr_pids,$oRow[$PrimaryField]);
		}
	
echo "<table celpading=5 cellspacing=5 width=\"100%\" style='border-color:#cecfce;border-width:1px 1px 1px 1px;border-style:solid'>";

		$strOutputHTML="";

		$iRowsCounter++;

		echo "<tr height=\"42\" id=\"CompositeHeadTR".$iRowsCounter."\" bgcolor=".($iRowsCounter%2==1?"#cecfce":"#ffffff")." height=20 nowrap onmouseover=\"javascript:CompositeTROver(".$iRowsCounter.",this)\" onmouseout=\"javascript:CompositeTROut(".$iRowsCounter.",this,'".($iRowsCounter%2==1?"#cecfce":"#ffffff")."')\" onclick=\"javascript:ManageCompositeTR(".$iRowsCounter.")\">";

		echo "<td>";

			
		
			
		
		for($q=0;$q<sizeof($barFields);$q++)
		{
			echo '<div class="col-md-2">';
			if(strtolower($barNames[$q]) == "date")
			{
				echo $barNames[$q].": <span class=\"blue_text\">".date($website->GetParam("DATE_FORMAT"), $oRow[$barFields[$q]])."</span>";
			}
			else
			{
				echo $barNames[$q].": <span class=\"blue_text\">".$oRow[$barFields[$q]]."</span>";
			}
			echo '</div>';
		}
		
		global $M_CUSTOMER;
		
		echo '<div class="col-md-3">';
		echo $M_CUSTOMER.": <span class=\"blue_text\">".$oRow["UserName"]."</span>";
		echo '</div>';
		
			global $CURRENCY_CODE,$M_TOT_VALUE,$M_TAXES;
		echo '<div class="col-md-3">';
			echo  $M_TOT_VALUE.": <span class=\"blue_text\">".$website->GetParam("WEBSITE_CURRENCY")."".number_format($oRow["OrderTotal"], 2, '.', ' ')."</span>  ";
		echo '</div>';	
			
			if($oRow["tax"]!=0)
			{
				echo '<div class="col-md-2">';
				echo $M_TAXES.": <span class=\"blue_text\">".$website->GetParam("WEBSITE_CURRENCY")."".number_format($oRow["tax"], 2, '.', ' ')."</span>  ";
				echo '</div>';
			}
		
		echo "</b></td>";

		echo "<td align=right valign=top>&nbsp;<b>";
		
		global $RUNNING_MODE,$AuthUserName,$InfoPage;	
		
		
		if($_REQUEST["action"]=="rejected")
		{
	
			if($website->running_mode==2)	
			{
					
			
			}
			else
			{
				global $M_APPROVE;
							echo "
						
							<a class=\"underline-link\" style='color:#0eb701 !important' href=\"index.php?category=".$_REQUEST["category"]."&folder=approve&page=order&OrderNumber=".$oRow["OrderNumber"]."\">".$M_APPROVE."</a>
						
							&nbsp;&nbsp;
						
							";
			}
		}
		
		else
		if($_REQUEST["action"]=="approved")
		{
		
			if($RUNNING_MODE==2&&$AuthUserName!="administrator")	
			{
					
			
			}
			else
			{
					global $M_INVOICE,$M_REJECT;
						echo "
						
								<a class=\"underline-link\" style='color:red !important' href=\"index.php?category=".$_REQUEST["category"]."&folder=approve&page=reject&OrderNumber=".$oRow["OrderNumber"]."\">".$M_REJECT."</a>&nbsp;&nbsp;
      							";
			}
		}
		else
		{		
			if($RUNNING_MODE==2&&$AuthUserName!="administrator")	
			{
					
			
			}
			else
			{
		
					global $M_APPROVE,$M_REJECT,$M_PRO_FORMA_INVOICE;
		
						echo "
						<div class=\"col-md-3 pull-right\">
						
						<a  class=\"underline-link\" style='position:relative;top:2px;color:#0eb701 !important' href=\"index.php?category=".$_REQUEST["category"]."&folder=approve&page=order&OrderNumber=".$oRow["OrderNumber"]."\">".$M_APPROVE."</a>
						
						</div>
						<div class=\"col-md-3 pull-right\">
							
						<a class=\"underline-link\" style='position:relative;top:2px;color:red !important' href=\"index.php?category=".$_REQUEST["category"]."&folder=approve&page=reject&OrderNumber=".$oRow["OrderNumber"]."\">".$M_REJECT."</a>
						
						</div>
						
					
						";
				}
		
		}
		
	
		echo '<a href="javascript:PrintOrder('.$iRowsCounter.')"><img style="float:right" src="images/print.gif" border="0" width="20" height="20" alt="" ></a>';			
		

		echo "</b></td>
		
		
		
		";

		echo "</tr>";

		echo "</table>";

		echo "<table id=CompositeTR".$iRowsCounter." style='display:none'>";

		echo "<tr >";

		echo "<td colspan=2  class=basictext >";
		
		for($i=0;$i<sizeof($arrTitles);$i++)
		{


				if($arrTypes[$i]=="fieldset"||$arrTypes[$i]=="sql"||$arrTypes[$i]=="sql2"){

					echo "<table width=\"100%\"><tr><td class=basictext>";
					echo "<fieldset style=\"width:100%\"><legend><b><span class=basictext ><br/>".$arrTitles[$i]."</span></b></legend>
						 <div id=\"div".$iRowsCounter."".$i."\" >";

					if($arrTypes[$i]=="fieldset"){

						$arrFields=$arraysFields[$i];
						$arrNames=$arraysNames[$i];

						
						

						for($j=0;$j<sizeof($arrFields);$j++){

								if($arrFields[$j]!=""){
									
									$strValueToDisplay=$oRow[$arrFields[$j]];
									
									$strValueToDisplay=str_replace("payment_rejected~","",$strValueToDisplay);
									
									if(isset($oRow[$arrFields[$j]]))
									{
										echo $arrNames[$j].": <b>".$strValueToDisplay."</b>";
										
									
											echo "<br/>";
										
									}
									
									
									if(isset($oRow[$arrFields[$j]])){
										
									}

								}
						}

					
					}
					else
					if($arrTypes[$i]=="sql2"){

							$strSubQuery=$arraysFields[$i];
							ereg( "@@@([A-Za-z]+)@@@", $strSubQuery, $regs );

							$strSubQuery=str_replace(
											"@@@".$regs[1]."@@@",
											$oRow[$regs[1]],
											$strSubQuery);

							
							
							
	
	
							$arrSubRow=$database->Query($strSubQuery);

							
							$iSubRowsCounter=0;
							$strBGColor="";

							while($oSubRow=$database->fetch_array($arrSubRow)){

								$iSubRowsCounter++;

								
								if(true){
									if($iSubRowsCounter%2==0){
										$strBGColor="#ffffff";
									}
									else{
										$strBGColor="#fff7ef";
									}
								}
								else{
									if($iSubRowsCounter%2==0){
										$strBGColor="#efefef";
									}
									else{
										$strBGColor="#ecdfef";
									}
								}

								echo "<div class=\"row\" style=\"background:".$strBGColor."\">";


								foreach($arraysNames[$i] as $strSubName){
								
								list($z1,$z2)=explode("~",$strSubName);
									echo "<div class=\"col-md-2\">";
									
									if(trim($z1)!="")
									{
										echo $z1.": ";
									}
									echo "<b>".$oSubRow[$z2]."</b>";
									echo "</div>";

									$strOutputHTML.=$oSubRow[$z2]."<br>";
								}


								echo "</div>";

							}

						
					}
					else
					if($arrTypes[$i]=="sql"){

							$strSubQuery=$arraysFields[$i];
							ereg( "@@@([A-Za-z]+)@@@", $strSubQuery, $regs );

							$strSubQuery=str_replace(
											"@@@".$regs[1]."@@@",
											$oRow[$regs[1]],
											$strSubQuery);


							$arrSubRow=$database->Query($strSubQuery);

							echo "<table width=\"100%\" cellspacing=0>";

							$iSubRowsCounter=0;
							$strBGColor="";

							while($oSubRow=$database->fetch_array($arrSubRow)){

								$iSubRowsCounter++;

								
								if(true){
									if($iSubRowsCounter%2==0){
										$strBGColor="#ffffff";
									}
									else{
										$strBGColor="#fff7ef";
									}
								}
								else{
									if($iSubRowsCounter%2==0){
										$strBGColor="#efefef";
									}
									else{
										$strBGColor="#ecdfef";
									}
								}

								echo "<tr bgcolor=$strBGColor height=20>";


								foreach($arraysNames[$i] as $strSubName){
									echo "<td>";
									echo $oSubRow[$strSubName];
									echo "</td>";

									$strOutputHTML.=$oSubRow[$strSubName];
								}


								echo "</tr>";

							}

							echo "</table>";


					}


					echo "</div>
					</fieldset>";
					echo "</td></tr></table>";

				}

		}


		echo "</td>";

		echo "</tr>";

		
		echo "</table>";
	}




	if(sizeof($barCheckBoxes)>0){
		

	}

	echo "</form>";

	
	echo "<div id=CompositeContainerTR></div>";

	
	echo "<form id=PDF_FORM target=_blank action=pdf/generate.php method=post><input type=hidden id=html name=html value=''></form>";
	


}


function get_sub_cats($main_cat,$lines)
{
	
	reset($lines);
	$arrCategories = array();
	foreach ($lines as $line_num => $line) 
	{
		if(trim($line) != "")
		{
			$arrLine = explode(".",$line);
			
			if(sizeof($arrLine) == 3)
			{
				if(trim($arrLine[0]) == $main_cat)
				{
					$arrCategories[trim($arrLine[0]).".".trim($arrLine[1])] = trim($arrLine[2]);
				}				
			}
		}
	}
	asort($arrCategories);
	return $arrCategories;
}


function insert_image($strName)
{
	$path="../";
	$input_field=$strName;
	$str_images_list = "";
	include("../include/images_processing.php");
	
	if($str_images_list=="")
	{
		return 0;
	}
	else
	{
		return $str_images_list;
	}
}
?>