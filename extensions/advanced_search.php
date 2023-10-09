<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><h2><?php echo $M_ADVANCED_SEARCH;?></h2>
<hr/>

	<form name="home_form" id="home_form" action="index.php"  style="margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px" method="post"> 
	<input type="hidden" name="mod" value="search">
	<input type="hidden" name="search" value="1">
	<input type="hidden" name="advanced" id="advanced_s" value="0">

		<div class="row">
			<div class="col-md-6">
				<?php echo $M_KEYWORD;?>
				<br/>
				<input type="text" name="job_title" class="form-control"/>
			</div>
			
			
			<div class="col-md-6">
				<?php echo $M_JOB_TYPE;?>
				<br/>
				<select name="job_type" class="form-control">
					<option value="-1"><?php echo $M_ALL;?></option>
					<?php
					foreach($website->GetParam("arrJobTypes") as $key=>$value)
					{
						echo '<option value="'.$key.'">'.$value.'</option>';
					}
					?>
				</select>
			</div>
		</div>	
		
		<div class="clearfix"></div>
		<br/>
		
		<div class="row">	
		
			<div class="col-md-6">
				
				<input type="hidden" name="field_category" id="field_category" value=""/>
				<script>var cancel_category="<?php echo $M_CATEGORY;?>";</script>
				<span id="label_category"><?php echo $M_CATEGORY;?></span>
				
				<br/>
				<select name="category" id="category" onchange="dropDownChange(this,'category')" class="form-control">
					<option value="-1"><?php echo $M_ALL;?></option>
					<?php
					
					if(!isset($l))
					{
						include("categories/categories_array_".$website->lang.".php");
					}
						foreach($l as $key=>$value)
						{
							
							echo "<option value=\"".$key."@".$value."\">".$value."</option>";
						}
					?>
				</select>
			</div>
		
			<div class="col-md-6">
			
				<input type="hidden" name="field_location" id="field_location" value=""/>
				
				<script>var cancel_location="<?php echo $M_REGION;?>";</script>
				<span id="label_location"><?php echo $M_REGION;?></span>
				<br/>
				<select class="form-control" name="location" id="location"  onchange="dropDownChange(this,'location')">
					<option value=""><?php echo $M_ALL;?></option>
					<?php
					
						if(!isset($loc))
						{
							include("locations/locations_array.php");
						}
						
						if(isset($loc))
						{
							foreach($loc as $key=>$value)
							{
								if(!is_string($value)) continue;
								echo "\n<option value=\"".$key."@".$value."\">".$value."</option>";
							}
						}
						
						?>
				</select>
			</div>
		
			
		</div>
		<div class="clearfix"></div>
		<br/>
		
		<div class="row">
	
			
			<div class="col-md-6">
				
				<?php echo $COMPANY_NAME;?>
				<br/>
				<input type="text" name="company_name" class="form-control" placeholder="">
			</div>
		
			
			<div class="col-md-6">
				<?php echo $M_POSTING_DATE;?>
				<br/>
				<select class="form-control" name="posting_date">
					<option value=""><?php echo $M_ANY_DATE;?></option>
					<option value="1"><?php echo $M_TODAY;?></option>
					<option value="2"><?php echo $M_YESTERDAY;?></option>
					<option value="3"><?php echo $M_LAST_3;?></option>
					<option value="7"><?php echo $M_LAST_7;?></option>
					<option value="30"><?php echo $M_LAST_30;?></option>
				</select>
			</div>
		</div>
		
		<div class="clearfix"></div>
		<br/><br/>
			
			
			<?php	
			if($website->GetParam("ENABLE_ZIP_SEARCH"))
			{
			?>
				
				<div class="row">
					
					<div class="col-md-3">
						<input type="checkbox" name="zip_radius" value="1">
						<?php echo $ONLY_ADS_IN_RADIUS;?>
					</div>
					<div class="col-md-2">
						
			
						<input type="text" name="zip_distance" size="3" class="form-control small-input-field"/> 
					</div>
					<div class="col-md-2">
						<select name="zip_type" class="form-control">
							<option value="2"><?php echo $M_MI;?></option>
							<option value="1"><?php echo $M_KM;?></option>
						</select>
					</div>
					<div class="col-md-1 no-padding">
						<?php echo $FROM_MY_ZIP;?>:
					</div>
					<div class="col-md-2">
						<input  class="form-control small-input-field" type="text" name="zip" size="10"/>	
					</div>
				</div>
			<?php			
			}
			?>
		
		
		<div class="clearfix"></div>
		
		
		<button type="submit" class="btn custom-back-color btn-md btn-green pull-right"><?php echo $M_SEARCH;?></button>
		
	
	</form>
	<div class="clearfix"></div>
	<br/>
	<br/>
<?php
$website->Title($M_ADVANCED_SEARCH);
$website->MetaDescription("");
$website->MetaKeywords("");


?>