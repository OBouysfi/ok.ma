<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><div class="fright">

		
	<?php
	
	echo LinkTile
		 (
			"templates",
			"home_slider_images",
			"Slider Images",
			"",
			
			"yellow"
		 );
		 
		 
		echo LinkTile
			 (
				"templates",
				"home_slider_slides",
				"Own Slides",
				"",
				
				"lila"
			 );
		?>
		
	
</div>
<div class="clear"></div>

<?php

if(isset($_REQUEST["save_params"]))
{
	$website->ms_i($_REQUEST["slider_content"]);
	$website->ms_i($_REQUEST["slider_type"]);
	
	$database->SetParameter
	(
		169,
		$_REQUEST["animation_speed"]
	);
	
	$database->SetParameter
	(
		170,
		$_REQUEST["slider_content"]
	);
	
	$database->SetParameter
	(
		171,
		$_REQUEST["slider_type"]
	);
}
$animation_speed=$database->GetParameter(169);
$slider_content=$database->GetParameter(170);
$slider_type=$database->GetParameter(171);
?>
<form action="index.php" method="post">
<input type="hidden" name="category" value="templates"/>
<input type="hidden" name="action" value="home_slider"/>
<input type="hidden" name="save_params" value="1"/>
<h3>Slider Content</h3>
<hr/>

<input type="radio" name="slider_content" style="position:relative;top:8px" value="1" <?php if($slider_content==1) echo "checked";?>/>
Featured Jobs

<input type="radio" name="slider_content" style="position:relative;top:8px;margin-left:15px" value="2" <?php if($slider_content==2) echo "checked";?>/>
Latest Jobs

<input type="radio" name="slider_content" style="position:relative;top:8px;margin-left:15px" value="3" <?php if($slider_content==3) echo "checked";?>/>
<a class="underline-link" href="index.php?category=templates&action=home_slider_slides">Own Slides</a>


<br/><br/>

<h3>Slider Type and Background</h3>
<hr/>

<input type="radio" name="slider_type" value="1" <?php if($slider_type==1) echo "checked";?> style="position:relative;top:8px;"/>
Gradient / <a class="underline-link" href="index.php?category=templates&action=layout">Accent Color</a> with Scrolling text

<input type="radio" name="slider_type" value="2" <?php if($slider_type==2) echo "checked";?> style="position:relative;top:8px;margin-left:15px"/>
<a class="underline-link" href="index.php?category=templates&action=home_slider_images">Background Image</a> with Scrolling text

<input type="radio" name="slider_type" value="3" <?php if($slider_type==3) echo "checked";?> style="position:relative;top:8px;margin-left:15px"/>
<a class="underline-link" href="index.php?category=templates&action=home_slider_images">Background Image</a> with Fading text

<input type="radio" name="slider_type" value="4" <?php if($slider_type==4) echo "checked";?> style="position:relative;top:8px;margin-left:15px"/>
Scrolling <a class="underline-link" href="index.php?category=templates&action=home_slider_images">Background Images</a>
<div class="clearfix"></div>
<br/><br/>
Animation Speed: 
<select name="animation_speed">
<option <?php if($animation_speed==2000) echo "selected";?> value="2000">2s</option>
<option <?php if($animation_speed==3000) echo "selected";?> value="3000">3s</option>
<option <?php if($animation_speed==4000) echo "selected";?> value="4000">4s</option>
<option <?php if($animation_speed==5000) echo "selected";?> value="5000">5s</option>
<option <?php if($animation_speed==6000) echo "selected";?> value="6000">6s</option>
<option <?php if($animation_speed==7000) echo "selected";?> value="7000">7s</option>
<option <?php if($animation_speed==8000) echo "selected";?> value="8000">8s</option>
<option <?php if($animation_speed==9000) echo "selected";?> value="9000">9s</option>
<option <?php if($animation_speed==10000) echo "selected";?> value="10000">10s</option>
<option <?php if($animation_speed==11000) echo "selected";?> value="11000">11s</option>
<option <?php if($animation_speed==12000) echo "selected";?> value="12000">12s</option>
<option <?php if($animation_speed==13000) echo "selected";?> value="13000">13s</option>
<option <?php if($animation_speed==14000) echo "selected";?> value="14000">14s</option>
</select>
<br/><br/>
<input type="submit" class="btn btn-primary" value="<?php echo $M_SAVE;?>"/>

</form>






