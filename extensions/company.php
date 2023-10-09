<?php

if(!defined('IN_SCRIPT')) die("");

?>

<div class="page-wrap">

<?php

$id=$_REQUEST["id"];



$website->ms_i($id);



$company = $database->DataArray("employers","id=".$id);

$process_error="";

$str_jobs_link=$website->company_jobs_link($company["id"],$company["company"]);

$strLink = $website->company_link($company["id"],$company["company"]);

$total_jobs_number=$database->SQLCount("jobs","WHERE employer='".$company["username"]."'");

if(isset($_POST["SendOfferFriend"]))

{

	if

	(

		$website->GetParam("USE_CAPTCHA_IMAGES")==1

		&& ( (strtoupper($_POST['code2']) != $_SESSION['code2'])|| trim($_POST['code2']) == "" )

	)

	{

		$process_error=$M_WRONG_CODE;

	}

	else

	{

		if($_POST["sender_name"]!=""&&$_POST["email_address"]!="")

		{

			$SYSTEM_EMAIL_FROM=$website->GetParam("SYSTEM_EMAIL_FROM");

			$SYSTEM_EMAIL_ADDRESS=$website->GetParam("SYSTEM_EMAIL_ADDRESS");

		

			$headers  = "From: \"".$website->GetParam("SYSTEM_EMAIL_FROM")."\"<".$website->GetParam("SYSTEM_EMAIL_ADDRESS").">\n";

						

			mail

			(

			

				strip_tags($_POST["email_address"]),

				$M_LISTING_BY." ".strip_tags(stripslashes($_POST["sender_name"])),

				strip_tags(stripslashes($_POST["sender_name"]))."\n\n".$strLink."\n\n".strip_tags(stripslashes($_POST["friend_description"])), 

				$headers

			);

			

			

			echo "<h3>".$M_EMAIL_SENT_SUCCESS.": ".strip_tags($_POST["email_address"])."</h3><br/>";

		}

	}



}

else

if(isset($_POST["ContactAdvertiser"]))

{

	if

	(

		$website->GetParam("USE_CAPTCHA_IMAGES")==1

		&& ( (md5(strtoupper($_POST['code'])) != $_SESSION['code'])|| trim($_POST['code']) == "" )

	)

	{

		$process_error=$M_WRONG_CODE;

	}

	else

	{

		if($_POST["name"]!=""&&$_POST["description"]!=""&&$_POST["email"]!="")

		{

			$headers  = "From: \"".stripslashes($_POST["name"])."\"<".$_POST["email"].">\n";

					

			$email_subject = $website->domain." ".$M_QUESTION;

			

			$email_text = $M_SENT_BY.": ".stripslashes($_POST["name"]).

			", ".$M_EMAIL.": ".$_POST["email"];

			if($_POST["name"]!="")

			{

				$email_text .= ", ".$M_PHONE.": ".$_POST["phone"];

			}

			

			$msg_subject = $email_text." (".$email_subject.")";

			

			$email_text .= "\n\n".stripslashes($_POST["description"]);



			mail

			(

				$company["username"],

				$email_subject,

				$email_text, 

				$headers

			);

			

			if(trim($company["username"]) != "")

			{

				$database->SQLInsert

				(

					"user_messages",

					array

					(

						"date",

						"subject",

						"message",

						"user_to"

					),

					array

					(

						time(),

						$msg_subject,

						stripslashes($_POST["description"]),

						$company["username"]

					)

				);

			

			}

		}

	}



}

else

{



}

	

$website->Title(stripslashes($company["company"]));

$website->MetaDescription($website->text_words(stripslashes(strip_tags($company["company_description"])),30));

$website->MetaKeywords($website->format_keywords($website->text_words(stripslashes(strip_tags($company["company_description"])),20)));

?>



<h2 class="lfloat"><?php echo stripslashes(strip_tags($company["company"]));?></h2>



<div class="clear"></div>

<?php







$reviews = $database->DataArray_Query("SELECT count(id) as number,avg(vote) as vote FROM ".$DBprefix."company_reviews WHERE company_id=".$id);

echo $website->show_stars($reviews["vote"]);



$write_review_link = $website->get_file_prefix()."index.php?write=1&mod=reviews&id=".$id.($MULTI_LANGUAGE_SITE?"&lang=".$website->lang:"");





$review_link=$website->company_reviews_link($id,$company["company"]);

echo " <span style=\"position:relative;left:10px\">(<a href=\"".$review_link."\">".$reviews["number"]. " ".$M_REVIEWS."</a>)</span>";

?>







<div class="clear"></div>

<br/>

	

	<?php

	$images=explode(",",$company["logo"]);

	

	

	if($process_error!="")

	{

	

	?>

		<br/><h3 class="red-font"><?php echo $process_error;?></h3><br/><br/>

	<?php

	}

				

	if(isset($_POST["ContactAdvertiser"])&&$process_error=="")

	{

	?>

		<br/><h3><?php echo $MESSAGE_SENT;?></h3><br/><br/>

	<?php

	}

			

	?>	

		

	<div class="tabbable">

          <ul class="nav nav-tabs">

            <li class="active">

				<a href="#tab-details" data-toggle="tab"><?php echo $M_DETAILS;?></a>

			</li>

			

			<?php

			if($total_jobs_number>0)

			{

			?>

			<li><a href="<?php echo $str_jobs_link;?>"><?php echo $M_JOBS;?></a></li>

			<?php

			}

			?>	

			

			<?php

			if($company["latitude"]!=""&&$company["longitude"]!="")

			{

			?>

            <li><a href="#tab-contact" onclick="javascript:show_map()" data-toggle="tab"><?php echo $M_MAP_LOCATION;?></a></li>

			<?php

			}

			?>

			<li><a href="#tab-share" data-toggle="tab"><?php echo $M_CONTACT;?></a></li>

			

			

		

			<li><a href="<?php echo $write_review_link;?>"><?php echo $M_WRITE_A_REVIEW;?></a></li>

		

          

          </ul>

          <div class="tab-content">

		  <br/>

            <div class="tab-pane active" id="tab-details">

			

				<div class="row">

				

					<div class="col-md-<?php if(trim($company["logo"])!=""&&$company["logo"]!="0") echo "8";else echo "12";?>">

					

					

					<?php echo nl2br(stripslashes(strip_tags($company["company_description"])));?>

				

				

					

		

					<br/><br/>

					

					

					<?php

					

					if($company["show_information"]==1)

					{

						if(trim($company["address"])!="")

						{

						?>

							<?php echo $M_ADDRESS;?>:

							<br/>

							<b>

							<?php

							echo strip_tags(stripslashes($company["address"]));

							?>

							</b>



						<br/><br/>

						<?php

						}

						

						if(trim($company["website"])!="")

						{

						?>

						<?php echo $M_WEBSITE;?>: <b><a class="underline-link" rel="nofollow" title="<?php echo $company["website"];?>" href="http://<?php echo $company["website"];?>" target="_blank"><?php echo $company["website"];?></a></b>



						<br/><br/>

						<?php

						}

						

						if(trim($company["phone"])!="")

						{

						?>

						<?php echo $M_PHONE;?>: &nbsp;  <b><?php echo strip_tags($company["phone"]);?></b>

						<br/>

						<?php

						}

						

						

						if(trim($company["employer_fields"]) != "")

						{

							$arrJobFields = array();



							if(is_array(unserialize($company["employer_fields"])))

							{

								$arrJobFields = unserialize($company["employer_fields"]);

							}



							$bFirst = true;

							while (list($key, $val) = each($arrJobFields)) 

							{

								echo "<br/><br/>";

								echo "<b>";

								str_show($key);

								echo ":</b>"; 

								echo "<br/> ";

								str_show(stripslashes(stripslashes(strip_tags($val))));

							}

						}

						

					

					}

					?>

					<br/>

					</div>

				<?php



				if(trim($company["logo"])!=""&&trim($company["logo"])!="0")

				{

				?>

				

					<div class="col-md-4">

						<div class="final-result-image">

						<?php

							

						echo $website->show_pic($company["logo"],"big",stripslashes(strip_tags($company["company"])));

						

						?>

						</div>

					</div>

				<?php

				}

				?>					

				</div>	

				

				<div class="clear"></div>

				

				<?php

				if(trim($company["video_id"])!="")

				{

				

					$video_id=$company["video_id"];

					$video_id=str_replace("http://www.youtube.com/watch?v=","",$video_id);

					$video_id=str_replace("https://www.youtube.com/watch?v=","",$video_id);

					$video_id=str_replace("http://youtu.be/","",$video_id);

					$video_id=str_replace("https://youtu.be/","",$video_id);

					?>

					<iframe width="560" height="315" src="http://www.youtube.com/embed/<?php echo $video_id;?>" frameborder="0" allowfullscreen></iframe>

					<br/><br/>

					<?php

				}

				?>

				<?php 

				echo $M_TOTAL_JOBS;?>: 

				<strong><a class="underline-link" href="<?php echo $str_jobs_link;?>"><?php echo $total_jobs_number;?></a></strong>

				<br/><br/>

				<?php	

					$latest_jobs=$database->DataTable("jobs","WHERE employer='".$company["username"]."' ORDER BY id DESC LIMIT 0,100");

					$i_latest_counter=0;

					while($latest_job = $database->fetch_array($latest_jobs))

					{

						if($i_latest_counter>=50)

						{

							break;

						}

						$headline = stripslashes(strip_tags($latest_job["title"]));



						$strLink = $website->job_link($latest_job["id"],$latest_job["title"]);

						



					?>

						<a class="underline-link" title="<?php echo stripslashes($headline);?>" href="<?php echo $strLink;?>">

						

							<?php echo stripslashes($latest_job["title"]);?>

						</a>

						<br/>

					<?php

						$i_latest_counter++;

					}

					

					if($i_latest_counter>0)

					{

						?>

						<br/>

						<a class="small-font underline-link" href="<?php echo $str_jobs_link;?>"><?php echo $M_SEE_ALL;?></a>

						<?php

					}

					

				?>

				

				<br/>

				

			</div>

	

	

            <div class="tab-pane" id="tab-images">

			

		

			<link rel="stylesheet" href="<?php echo $website->get_file_prefix();?>css/prettyPhoto.css" type="text/css" media="screen" charset="utf-8" />

			<script src="<?php echo $website->get_file_prefix();?>js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>

			<script type="text/javascript" charset="utf-8">

			$(document).ready(function()

			{

				$("a[rel='prettyPhoto[ad_gal]']").prettyPhoto({



				});

			});

			</script>

			

					<?php

					

					for($i=(sizeof($images)-1);$i>=0;$i--)

					{

						if(trim($images[$i])=="") continue;

						

						if($i!=0)

						{

							echo "<a href=\"uploaded_images/".$images[$i].".jpg\" rel=\"prettyPhoto[ad_gal]\">";

						}

						echo "<img src=\"thumbnails/".$images[$i].".jpg\" width=\"200\" alt=\"".stripslashes(strip_tags($company["company"]))."\" class=\"img-shadow img-details-margin\" />";

						if($i!=0)

						{

							echo "</a>";

						}

					}

					

					?>

					

			

			

			</div>

			

			

            <div class="tab-pane" id="tab-contact">

			

				<?php

				if(trim($company["location"])!="")

				{

				?>

				<br/><br/>

				<?php echo $M_LOCATION;?>: <b><?php echo $website->show_full_location($company["location"]);?></b>

				<?php

				}

				?>

				

				<br/>

				

				

				  <?php

				if($company["latitude"]!=""&&$company["latitude"]!="0"&&$company["latitude"]!="0.00"&&$company["longitude"]!=""&&$company["longitude"]!="0"&&$company["longitude"]!="0.00")

				{

				?>

								

				<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false">

				</script>

				<script type="text/javascript">

				

				function show_map()

				{



					var Latlng = new google.maps.LatLng(<?php echo $company["latitude"];?>,<?php echo $company["longitude"];?>);



					var Options = {

						zoom: 15,

						center: Latlng,

						mapTypeId: google.maps.MapTypeId.ROADMAP

					};



					var Map = new google.maps.Map(document.getElementById("map"), Options);



					var Marker = new google.maps.Marker({

						position: Latlng,

						map:Map,

						title:"The Map"

					});



					Marker.setMap(Map);

					

					Map.setCenter(new google.maps.LatLng(<?php echo $company["latitude"];?>,<?php echo $company["longitude"];?>));

					

					

				  }



				</script>

				

				<br/>

				<div id="map" style="width: 500px; height: 300px"></div>

				<br/>

				<?php

				}

				?>

				

		

				<?php

				if($company["address"]!="")

				{

					echo $company["address"];

				}

				?>

				<br/><br/>

				

							

			</div>

			

			

			<div class="tab-pane" id="tab-share" >



			<script>

			var contact_advertiser = false;

			function ShowContactForm()

			{

				if(!contact_advertiser)

				{

					document.getElementById("contact-advertiser").style.display="block";

					contact_advertiser = true;

				}

				else

				{

					document.getElementById("contact-advertiser").style.display="none";

					contact_advertiser = false;

				}

			}

			</script>

			

			<div class="clear"></div>

		

				<h3>

				<?php 

				if($process_error=="")

				{

				?>

					<?php echo $M_CONTACT;?> "<?php echo stripslashes(strip_tags($company["company"]));?>"

					<?php

					if($company["show_information"]==1&&$company["phone"]!="")

					{

					?>

						 <img src="images/phone_icon.png" alt="phone icon"/> <?php echo strip_tags($company["phone"]);?>

					<?php

					}

					?>

					

				<?php

				}

				?>

				</h3>

				

				<form id="main" action="<?php echo $website->get_file_prefix();?>index.php" method="post"  enctype="multipart/form-data">

				<?php

				if(isset($_REQUEST["mod"]))

				{

				?>

				<input type="hidden" name="mod" value="<?php echo $_REQUEST["mod"];?>"/>

				<?php

				}

				else

				{

				?>

				<input type="hidden" name="page" value="<?php echo $_REQUEST["page"];?>"/>

				<?php

				}

				?>

				<input type="hidden" name="id" value="<?php echo $id;?>"/>

				

				<input type="hidden" name="ContactAdvertiser" value="1"/>

				<fieldset>

					<legend><?php echo $M_ENTER_MESSAGE_OR_QUESTIONS;?></legend>

					<ol>

						<li>

							<label for="description"><?php echo $M_MESSAGE_TEXT;?>(*)

							<br>

							

							</label>

							<textarea id="description" name="description" rows="8"> <?php if(isset($_REQUEST["description"])) echo stripslashes($_REQUEST["description"]);?></textarea>

						</li>

				</ol>

				</fieldset>

				<fieldset>

					<legend><?php echo $M_YOUR_DETAILS;?></legend>

					<ol>

						

						<li>

							<label for="name"><?php echo $M_NAME;?>(*)</label>

							<input id="name" <?php if(isset($_REQUEST["name"])) echo "value=\"".$_REQUEST["name"]."\"";?> name="name" placeholder="<?php echo $M_FIRST_AND_LAST;?>" type="text" required/>

						</li>

						<li>

							<label for="email"><?php echo $M_YOUR_EMAIL;?>(*)</label>

							<input id="email" <?php if(isset($_REQUEST["email"])) echo "value=\"".$_REQUEST["email"]."\"";?> name="email" placeholder="example@domain.com" type="email" required/>

							

						</li>

						<li>

							<label for="phone"><?php echo $M_PHONE;?></label>

							<input id="phone" <?php if(isset($_REQUEST["phone"])) echo "value=\"".$_REQUEST["phone"]."\"";?> name="phone" placeholder="" type="text"/>

						</li>

						<?php

						if($website->GetParam("USE_CAPTCHA_IMAGES")==1)

						{

						?>

						<li>

							<label for="code">

							<img src="include/sec_image.php" width="100" height="30"/>

							</label>

							<input id="code" name="code" placeholder="<?php echo $M_PLEASE_ENTER_CODE;?>" type="text" required/>

						</li>

						<?php

						}

						?>

					</ol>

				</fieldset>

				<fieldset>

					<button type="submit"><?php echo $M_SEND;?></button>

				</fieldset>

			</form>



			<br/><br/>

			</div>

			

		</div>

	</div>

	



<div class="clear"></div>

<br/>

</div>