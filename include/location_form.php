<?php

	if(isset($level_location)&&$level_location=="1")
	{
		if(isset($location2)) unset($location2);
		if(isset($location3)) unset($location3);
	}
	else
	if(isset($level_location)&&$level_location=="2")
	{
		if(isset($location3)) unset($location3);
	}
	
	if(isset($location3)&&$location3!="-1")
	{
		$level = 4;
	}
	else
	if(isset($location2)&&$location2!="-1")
	{
		$level = 3;
	}
	else
	if(isset($location1)&&$location1!="-1")
	{
		$level = 2;
	}
	else
	{
		$level = 1;
	}
	

?>
			
		<script>
		
		function SubmitForm<?php if(isset($submit_form_suffix)) echo $submit_form_suffix;?>(x,obj)
		{

			document.getElementById('level_location').value=x;
			document.getElementById('region').value=obj.options[obj.selectedIndex].value.replace("~",".");
			<?php
			if(isset($additional_validation))
			{
				echo $additional_validation;
			}
			?>
			document.getElementById('<?php echo $form_name;?>')["SpecialProcessAddForm"].value="";
			
			document.getElementById('<?php echo $form_name;?>').submit();
		
		}
		
		</script>
		
		<?php

		
		for($v=1;$v<=$level;$v++)
		{
		
			$hasAnItem=false;
			if($v!=1) echo "<span id=\"v".$v."\" style=\"float:left;margin-right:8px\"> > </span>";
		?>
		
			
		
						<select id="selectform<?php echo $v;?>" onChange="SubmitForm<?php if(isset($submit_form_suffix)) echo $submit_form_suffix;?>(<?php echo $v;?>,this)" name="location<?php echo $v;?>"  <?php if(isset($form_select_width)&&$form_select_width!="") echo "style=\"float:left;margin-right:8px;width:".$form_select_width."px\"";?> <?php if(isset($form_select_class)&&$form_select_class!="") echo "class=\"".$form_select_class."\"";?> >
						<option value="-1"><?php echo $M_PLEASE_SELECT;?></option>
						<?php
						reset($arrLines);
						foreach($arrLines as $strLoc)
						{
					
							if(trim($strLoc) == "")
							{
								continue;
							}
							$strLoc=str_replace("\t"," ",$strLoc);
								
							$arrLoc = explode(". ",$strLoc,2);
							
							$arrLocItems = explode(".",$arrLoc[0]);
							
							if($v==2)
							{
								if(!isset($arrLocItems[0])||isset($arrL3[0])) {}
								elseif($arrLocItems[0]!=$location1)
								{
									continue;
								}
							}
							
							if($v==3)
							{
								$arrL3 = explode("~",$location2);
								
								if(!isset($arrLocItems[0])||isset($arrL3[0])) {}
								elseif($arrLocItems[0]!=$arrL3[0])
								{
									continue;
								}
								
								if(!isset($arrLocItems[1])||isset($arrL3[1])) {}
								elseif($arrLocItems[1]!=$arrL3[1])
								{
									continue;
								}
							}
							
							if($v==4)
							{
								$arrL4 = explode("~",$location3);
								
								if(!isset($arrLocItems[0])||isset($arrL3[0])) {}
								elseif($arrLocItems[0]!=$arrL4[0])
								{
									continue;
								}
								
								if(!isset($arrLocItems[1])||isset($arrL3[1])) {}
								elseif($arrLocItems[1]!=$arrL4[1])
								{
									continue;
								}
								
							
								if(!isset($arrLocItems[2])||isset($arrL3[2])) {}
								elseif($arrLocItems[2]!=$arrL4[2])
								{
									continue;
								}
							}
							
							
							if(sizeof($arrLocItems) == $v && isset($arrLoc[1]))
							{
									$strVal = str_replace(".","~",$arrLoc[0]);
									
									echo "<option value=\"".$strVal."\" ".($strVal==get_param("location".$v)?"selected":"").">".$arrLoc[1]."</option>";
									$hasAnItem=true;
							}
							
							
						}
						?>
						</select> 
						
		<?php
		}
		
		
		
		if($v>1&&!$hasAnItem)
		{
		?>
			<script>
			if(document.getElementById("v<?php echo ($v-1);?>"))
				document.getElementById("v<?php echo ($v-1);?>").style.display="none";
				
				if(document.getElementById("selectform<?php echo ($v-1);?>"))
				document.getElementById("selectform<?php echo ($v-1);?>").style.display="none";
			</script>
		<?php 
		}
		
		
		?>
		<input type="hidden" name="level_location" id="level_location" value="">
		<input type="hidden" name="region" id="region" value="<?php echo (isset($region)?str_replace("~",".",$region):"");?>">
		
		