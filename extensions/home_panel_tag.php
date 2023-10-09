<?php

if(!defined('IN_SCRIPT')) die("");

// var_dump($_REQUEST);

if(isset($_REQUEST["page"])	&& 	($_REQUEST["page"]=="en_Derniers Emplois" || $_REQUEST["page"]=="en_Offres Emploi"))

{

?>

	<style>

	#ban_derniers_emplois

	{

		background-image:url('../images/ban/listing.JPG');

		background-size:cover;

		min-height:156px;

	}

	#home_form {

		background: rgba(0, 0, 0, 0.3);

		padding: 5px 0 10px;

	}



	.title_h1 {

		margin-bottom: 0;

		margin-top: 0;

		color: white;

	}
	</style>

	<div id="ban_derniers_emplois">

			

			<div class="container">

			<div class="container text-center" style="font-size: 2.4em; color: #fff; padding: 100px 0px 50px 0px; font-family: sans-serif; font-weight: 700;">

		            Emploi / Offres emploi

	        </div>

			</div>

			<form name="home_form" id="home_form" action="index.php"  style="margin-top:0;margin-bottom:0px;margin-left:0px;margin-right:0px" method="post"> 

			<div class="container">

			<input type="hidden" name="mod" value="search">

			<input type="hidden" name="search" value="1">

			<input type="hidden" name="advanced" id="advanced_s" value="0">

				

				<?php /*<div class="col-md-2 form-group group-1 text-center" style="padding-top:15px"> <h4 class="white-font bottom-margin-5">Trouver un emploi</h4></div>*/ ?>

				

				<div class="col-md-4 col-xs-12 form-group group-1">

					<span class="main-search-label"><br/></span>

					

					<input type="text" name="job_title" class="input-job" placeholder="<?php echo $M_KEYWORD;?>">

				</div>

				<div class="col-md-3 col-xs-12 form-group group-2">

					<span id="label_category" class="main-search-label"><br/></span>

					

					<input type="hidden" name="field_category" id="field_category" value=""/>

					<select name="category" id="category" onchange="dropDownChange(this,'category')" class="input-job">

						<option value="-1"><?php echo $M_CATEGORY;?></option>

						<option value="-1">Tous les métiers</option>

						<?php

						

						if(!isset($l))

						{

							include("categories/categories_array_".$this->lang.".php");

						}

							foreach($l as $key=>$value)

							{

								

								echo "<option value=\"".$key."@".$value."\">".$value."</option>";

							}

						?>

					</select>

				</div>

				

				<div class="col-md-3 col-xs-12 form-group group-3">

					<span id="label_location" class="main-search-label"><br/></span>

					

					<input type="hidden" name="field_location" id="field_location" value=""/>

					<select class="input-location" name="location" id="location"  onchange="dropDownChange(this,'location')">

						<option value=""><?php echo $M_REGION;?></option>

						<option value="-1">Toutes les villes</option>

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

				<div class="col-md-1 col-xs-12 no-padding">

					<span class="main-search-label"><br/></span>

					<button type="submit" style="padding: 10px 12px; width: 100%;" class="btn custom-gradient-2 btn-default btn-green no-margin"><i class="fa fa-search fa-lg" aria-hidden="true"></i></button>

				

				</div>

						

				<div class="clearfix"></div>

				</div>	

			</form><?php // finish search ?>

		 

	</div>

<?php 

}



elseif(isset($_REQUEST["mod"])	&& 	($_REQUEST["mod"]=="advanced_search"))

{

?>

	<style>

	#ban_search

	{

		background-image:url('../images/ban/recherche1.jpg');

		background-size:cover;

		height:156px;

	}

	</style>

	<div id="ban_search"></div>

<?php 

}

elseif(isset($_REQUEST["mod"])	&& 	($_REQUEST["mod"]=="email_alerts"))

{

?>

	<style>

	#ban_email_alerts

	{

		background-image:url('../images/ban/alertemail.jpg');

		background-size:cover;

		height:156px;

	}

	</style>

	<div id="ban_email_alerts"></div>

<?php 

}



elseif(isset($_REQUEST["page"])	&& 	($_REQUEST["page"]=="en_Espace Recruteurs"))

{

?>

	<style>

	#ban_recruteur 

	{

		background-image:url('../images/ban/recruteurs.jpg');

		background-size:cover;

		height:156px;

	}

	</style>

	<div id="ban_recruteur"></div>

<?php 

}

elseif(isset($_REQUEST["page"])	&& 	($_REQUEST["page"]=="en_CVthèque"))

{

?>

	<style>

	#ban_cvtheque 

	{

		background-image:url('../images/ban/cvtheque.JPG');

		background-size:cover;

		height:326px;

	}

	</style>

	<div id="ban_cvtheque"></div>

<?php 

}



elseif(isset($_REQUEST["mod"])	&& 	($_REQUEST["mod"]=="employers_registration"))

{

?>

	<style>

	#ban_recruteur 

	{

		background-image:url('../images/ban/recruteur.jpg');

		background-size:cover;

		height:326px;

	}

	</style>

	<div id="ban_recruteur"></div>

<?php 

}



elseif(isset($_REQUEST["page"])	&& 	($_REQUEST["page"]=="en_Contact"))

{

?>

	<style>

	#ban_contact

	{

		background-image:url('../images/ban/contact.jpg');

		background-size:cover;

		height:326px;

	}

	</style>

	<div id="ban_contact"></div>

<?php 

}



elseif(isset($_REQUEST["page"])	&& 	($_REQUEST["page"]=="en_Espace Candidats"))

{

?>

	<style>

	#ban_candidat

	{

		background-image:url('../images/ban/candidat3.JPG');

		background-size:cover;

		height:156px;

	}

	</style>

	<div id="ban_candidat"></div>

<?php 

}

elseif(isset($_REQUEST["page"])	&& 	($_REQUEST["page"]=="en_Conseils Emploi"))

{

?>

	<style>

	#ban_conseils

	{

		background-image:url('../images/ban/conseilemploi.jpg');

		background-size:cover;

		height:156px;

	}

	</style>

	<div id="ban_conseils"></div>

<?php 

}

elseif(isset($_REQUEST["mod"])	&& 	($_REQUEST["mod"]=="jobseekers"))

{

?>

	<style>

	#ban_candidat

	{

		background-image:url('../images/ban/cand.jpg');

		background-size:cover;

		height:326px;

	}

	</style>

	<div id="ban_candidat"></div>

<?php 

}

elseif(isset($_REQUEST["mod"])	&& 	($_REQUEST["mod"]=="forgotten_password"))

{

?>

	<style>

	#ban_forgot

	{

		background-image:url('../images/ban/forgot.jpg');

		background-size:cover;

		height:326px;

	}

	</style>

	<div id="ban_forgot"></div>

<?php 

}

elseif(isset($_REQUEST["mod"])	&& 	($_REQUEST["mod"]=="search") && isset($_REQUEST["category"]))

{

?>

	<style>

	#ban_category

	{

		background-image:url('../images/ban/categories.jpg');

		background-size:cover;

		height:156px;

	}

	</style>

	<div id="ban_category"></div>

<?php 

}

elseif(isset($_REQUEST["mod"])	&& 	($_REQUEST["mod"]=="search") && isset($_REQUEST["latest"]))

{

?>

	<style>

	#ban_category

	{

		background-image:url('../images/ban/categories.jpg');

		background-size:cover;

		height:156px;

	}

	</style>

	<div id="ban_category"></div>

<?php 

}

elseif(isset($_REQUEST["mod"])	&& 	($_REQUEST["mod"]=="apply"))

{

?>

	<style>

	#ban_apply

	{

		background-image:url('../images/ban/postuler1.jpg');

		background-size:cover;

		height:156px;

	}

	</style>

	<div id="ban_apply"></div>

<?php 

}

elseif(isset($_REQUEST["mod"])	&& 	($_REQUEST["mod"]=="details"))

{

?>

	<style>

	#ban_apply

	{

		background-image:url('../images/ban/description.jpg');

		background-size:cover;

		height:156px;

	}

	</style>

	<div id="ban_apply"></div>

<?php 

}

elseif(

	!isset($_REQUEST["mod"])&&!isset($_REQUEST["page"])

	||

	(

		isset($_REQUEST["page"])

		&&

		(

			$_REQUEST["page"]=="en_Home"

			||

			$_REQUEST["page"]=="en_Accueil"

			||

			$_REQUEST["page"]=="es_Inicio"

			||

			$_REQUEST["page"]=="fr_Accueil"

			||

			$_REQUEST["page"]=="pt_Inicio"

			||

			$_REQUEST["page"]=="de_Startseite"

			||

			strcmp($_REQUEST["page"], "ar_الصفحة الرئيسية") === 0

		)

	)

)

{

?>



<?php

$animation_speed=$this->GetParam("ANIMATION_SPEED");

if($this->GetParam("SLIDER_TYPE")==4)

{

	?>

	<div>

		<div>

	<?php

}

else

if($this->GetParam("SLIDER_TYPE")==1)

{

	?>

	<div>

		<div class="slider-back custom-gradient">

	<?php

}

else

{



	if($this->GetParam("SLIDER_TYPE")==2||$this->GetParam("SLIDER_TYPE")==3)

	{

		$slide_images=explode(",",$this->params[172]);

		

		$background_url=$this->get_image_file("backgrounds",$slide_images[0]);

	?>

	

	<style>

	#home_panel_wrap

	{

		background-image:url('<?php echo $background_url;?>');

	}

	</style>

	<div id="home_panel_wrap">

		<div>

	<?php

	}

}

?>



<?php



$inner_code = "";

$indicator_code = "";



if($this->GetParam("SLIDER_CONTENT")==3)

{

	$first_slide=true;

	for($i=173;$i<=185;$i=$i+3)

	{

		if(trim($this->params[$i])=="") continue;

		

		$inner_code .= '<div class="item '.($first_slide?"active":"").' slide-back">

			<div class="container">

				<div class="xcarousel-caption">';

				

				$inner_code .= "

				<a class=\"carousel-link\" href=\"".$this->params[$i+2]."\">";

				

				

				 $inner_code .= '<h1 class="no-top-margin carousel-link'.($this->GetParam("SLIDER_TYPE")==1?'':' add-shadow').'">'.stripslashes(strip_tags($this->params[$i])).'</h1>

				  <p class="hide-sm'.($this->GetParam("SLIDER_TYPE")==1?'':' add-shadow').'">'.stripslashes(strip_tags($this->params[$i+1])).'</p>';

				  

				

				 $inner_code .= '

					</a>

				 <br/>

				</div>

			</div>

		</div>';

		$first_slide=false;

	}

}

else

{

	if($this->GetParam("SLIDER_CONTENT")==1)

	{

		$add_query=" AND ".$DBprefix."jobs.featured=1 ORDER BY RAND() ";

	}

	else

	{

		$add_query=" ORDER BY ".$DBprefix."jobs.id ";

	}



	$SearchTable = $this->db->Query

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

		AND expires>".time()." 

		

		".$add_query." 

		LIMIT 0,".$this->GetParam("NUMBER_OF_FEATURED_LISTINGS")."

	");



	$i_carousel_counter = 1;



	if($this->db->num_rows($SearchTable)==0)

	{

	?>

	<style>.slider-back{display:none}</style>

	<?php

	}



		

	if($this->GetParam("SLIDER_TYPE")==4)

	{

		$slide_images=explode(",",$this->params[172]);

	}

		

	$i_slide_counter=0;

	

	while($listing = $this->db->fetch_array($SearchTable))

	{

		

		$headline=str_replace("\"","",strip_tags(stripslashes($listing["title"])));

		

		if(strlen($headline)>50)

		{

			$headline=substr($headline,0,50)."...";

		}

		

		

		$strLink = $this->job_link($listing["id"],$listing["title"]);



		$images=array("","");



		$indicator_code .= '<li data-target="#myCarousel" data-slide-to="'.($i_carousel_counter-1).'" '.($i_carousel_counter == 1?'class="active"':'').'><img src="'.($listing["logo"]==""?'images/no_pic.gif':'thumbnails/'.$listing["logo"].'.jpg').'"  class="img-shadow indicator-image" alt=""/></li>';

			

		

		

		$background_url="";

		

		if($this->GetParam("SLIDER_TYPE")==4)

		{

			

			if(!isset($slide_images[$i_slide_counter]))

			{

				$i_slide_counter=0;

			}

		

			if(isset($slide_images[$i_slide_counter]))

			{

				$background_url=$this->get_image_file("backgrounds",$slide_images[$i_slide_counter]);

			}

			else

			{

				$background_url="";

			}

			

		}

			

		$inner_code .= '<div '.($background_url!=""?' style="background:url('.$background_url.');background-size: cover;min-height:300px"':'').' class="'.($background_url!=""?'fill-back ':'').'item '.($i_carousel_counter==1?"active":"").' slide-back">

			<div class="container">

				<div class="xcarousel-caption">';

				

				$inner_code .= "

				<a class=\"carousel-link\" href=\"".$strLink."\">";

				

				if(trim($listing["logo"])!="")

				{

					$inner_code .= "<img class=\"slide-product-image img-responsive right-margin-40\" src=\"".($listing["logo"]==""?'images/no_pic.gif':'thumbnails/'.$listing["logo"].'.jpg')."\" alt=\"".stripslashes(strip_tags($listing["company"]))."\" align=\"left\"/>";

				}

				 $inner_code .= '<h1 class="no-top-margin carousel-link'.($this->GetParam("SLIDER_TYPE")==1?'':' add-shadow').'">'.stripslashes(strip_tags($headline)).'</h1>

				  <p class="hide-sm'.($this->GetParam("SLIDER_TYPE")==1?'':' add-shadow').'">'.$this->text_words(stripslashes(strip_tags($listing["message"])),35).'</p>';

				  

				

				 $inner_code .= '

					</a>

				 <br/>

				</div>

			</div>

		</div>';



		$i_carousel_counter++;

		$i_slide_counter++;

	}

}

?>		

	

<?php





if($this->GetParam("SLIDER_CONTENT")==3 || $this->db->num_rows($SearchTable) > 0)

{

?>

<div id="myCarousel" class="carousel slide">



	<div class="container text-center" style="font-size:2em; color: #fff; padding: 100px 0 0 0;">

		Trouvez votre futur job parmi +15.000 offres d'emploi

	</div>

	<div id="slider_container" class="carousel-inner">

	 	<?php

			echo $inner_code;

		?>

	</div>

	

	<?php

	if($this->GetParam("SLIDER_TYPE")==3)

	{

		

	}

	else

	if($this->GetParam("SLIDER_TYPE")==1||$this->GetParam("SLIDER_TYPE")==4)

	{

	?>

	  <a class="left carousel-control" href="#myCarousel" data-slide="prev"><img src="images/carousel-arrow-left-white.png" alt="" class="carousel-icon-<?php if($this->GetParam("SLIDER_TYPE")==4) echo "slide";else echo "solid";?>"/></a>

	  <a class="right carousel-control" href="#myCarousel" data-slide="next"><img src="images/carousel-arrow-right-white.png" alt="" class="carousel-icon-<?php if($this->GetParam("SLIDER_TYPE")==4) echo "slide";else echo "solid";?>"/></a>

	<?php	

	}

	else

	{

	?>

	  <a class="left carousel-control" href="#myCarousel" data-slide="prev"><img src="images/carousel-arrow-left.png" alt="" class="carousel-icon"/></a>

	  <a class="right carousel-control" href="#myCarousel" data-slide="next"><img src="images/carousel-arrow-right.png" alt="" class="carousel-icon"/></a>

	<?php

	}

	?>

</div>

<?php

}



if

(

	(

		$this->GetParam("SLIDER_CONTENT")==1 

		|| 

		$this->GetParam("SLIDER_CONTENT")==2

	)

	&&

	$this->db->num_rows($SearchTable) == 0)

{

	

}

else

if($this->GetParam("SLIDER_TYPE")==1||$this->GetParam("SLIDER_TYPE")==4||$this->GetParam("SLIDER_TYPE")==2)

{

?>

<script type="text/javascript">





if(document.getElementById("myCarousel"))

{

	$(document).ready(function() 

	{

		$('.carousel').carousel({

		  interval: <?php echo $animation_speed;?>

		})

	

	});

}

</script>

<?php



}

else

{

	?>



	<script>



	setInterval(function() { 

	  $('#slider_container > div:first')

		.hide()

		.next()

		.fadeIn(1000)

		.end()

		.appendTo('#slider_container');

	},  <?php echo $animation_speed;?>);



	</script>

	<?php

}

?>







</div>



<?php

if($this->GetParam("SLIDER_TYPE")==1||$this->GetParam("SLIDER_TYPE")==4)

{

?>

<div class="solid-search-form-wrap">

<?php

}

else

{

?>

<div class="search-form-wrap">

<?php	

}

?>



<div class="container">

	<!--<div class="text-center">

	<h4 class="<?php if($this->GetParam("SLIDER_TYPE")==2||$this->GetParam("SLIDER_TYPE")==3) echo "white-font ";?>bottom-margin-5"><?php echo $M_SEARCH_FOR_JOBS;?></h4>

	</div>-->

	<form name="home_form" id="home_form" action="index.php"  style="margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px" method="post"> 

			<input type="hidden" name="mod" value="search">

			<input type="hidden" name="search" value="1">

			<input type="hidden" name="advanced" id="advanced_s" value="0">

				

				<?php /*<div class="col-md-2 form-group group-1 text-center" style="padding-top:15px"> <h4 class="white-font bottom-margin-5">Trouver un emploi</h4></div>*/ ?>

				

				<div class="col-md-4 col-xs-12 form-group group-1">

					<span class="main-search-label"><br/></span>

					

					<input type="text" name="job_title" class="input-job" placeholder="<?php echo $M_KEYWORD;?>">

				</div>

				<div class="col-md-4 col-xs-12 form-group group-2">

					<span id="label_category" class="main-search-label"><br/></span>

					

					<input type="hidden" name="field_category" id="field_category" value=""/>

					<select name="category" id="category" onchange="dropDownChange(this,'category')" class="input-job">

						<option value="-1"><?php echo $M_CATEGORY;?></option>

						<option value="-1">Tous les métiers</option>

						<?php

						

						if(!isset($l))

						{

							include("categories/categories_array_".$this->lang.".php");

						}

							foreach($l as $key=>$value)

							{

								

								echo "<option value=\"".$key."@".$value."\">".$value."</option>";

							}

						?>

					</select>

				</div>

				

				<div class="col-md-3 col-xs-12 form-group group-3">

					<span id="label_location" class="main-search-label"><br/></span>

					

					<input type="hidden" name="field_location" id="field_location" value=""/>

					<select class="input-location" name="location" id="location"  onchange="dropDownChange(this,'location')">

						<option value=""><?php echo $M_REGION;?></option>

						<option value="-1">Toutes les villes</option>

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

				<div class="col-md-1 col-xs-12 no-padding">

					<span class="main-search-label"><br/></span>

					<button type="submit" style="font-size: 1em;" class="btn custom-gradient-2 btn-default btn-green pull-right no-margin"><i class="fa fa-search fa-lg" aria-hidden="true"></i>

</button>

				</div>

				

		<div class="clearfix"></div>

		

	</form>

</div>

</div>







<?php

if($this->GetParam("SLIDER_TYPE")==1||$this->GetParam("SLIDER_TYPE")==4)

{

?>

	<div class="solid-search-bottom-wrap">

<?php

}

else

{

	?>

	<div class="search-bottom-wrap" <?php if($this->admin_settings["custom_color"]!="") echo 'style="background-color: rgba('.$this->hex2rgb($this->admin_settings["custom_color"]) .', 0.8);"';?> >

	<?php

}

?>





	<div class="col-md-2 text-center col-md-offset-3">

			<a class="search-bottom-link underline-link" href="<?php echo $this->mod_link("advanced_search");?>"><?php echo $M_ADVANCED_SEARCH;?></a>

	</div>

	<div class="col-md-2 text-center">

		<a class="search-bottom-link underline-link" href="<?php echo $this->mod_link("email_alerts");?>"><?php echo $M_CREATE_EMAIL_ALERT;?></a>

	

	</div>

	<div class="col-md-2 text-center">

		<!--<a class="search-bottom-link underline-link" href="<?php //if(isset($_COOKIE["AuthE"])) echo "EMPLOYERS/index.php?category=jobs&action=add";else echo $this->mod_link("employers_registration");?>"><?php echo $M_POST_A_JOB;?></a>-->

		<a class="search-bottom-link underline-link" href="http://www.ok.ma/index.php?page=en_Espace+Recruteurs"><?php echo $M_POST_A_JOB;?></a>

	</div>

	<div class="clearfix"></div>

</div>



</div>

<?php

}

else

{

	?>

	<div class="top-line"></div>

	

	<?php

	

}

?>

