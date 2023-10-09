<?php
// Jobs Portal All Rights Reserved

// A software product of NetArt Media, All Rights Reserved

// Find out more about our products and services on:

// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");

function startsWith($haystack,$needle,$case=false) 

{

    if($case){return (strcmp(substr($haystack, 0, strlen($needle)),$needle)===0);}

    return (strcasecmp(substr($haystack, 0, strlen($needle)),$needle)===0);

}



if($database->SQLCount("lm_categories","") == 0)

{

?>



<br>



<?php

$linksTable = $database->DataTable("linksmanager","ORDER BY rank DESC");



$iCounter = 0;



while($arrLink = $database->fetch_array($linksTable))

{

	

	$iCounter++;

	

	if(startsWith($link_url,"http://"))

	{

		$link_url=$arrLink["url"];

	}

	else

	{

		$link_url="http://".$arrLink["url"];

	}

	

	echo $iCounter.") <a href=\"".$link_url."\" target=_blank><b>".$arrLink["title"]."</b></a> (".str_replace("</p>","",str_replace("<br>","",str_replace("<p>","",$arrLink["short_description"]))).")

	<br>

	<center><hr width=100%></center>



	".str_replace("<br>","",str_replace("</p>","",str_replace("<p>","",$arrLink["long_description"])))."

	<br><br><br>

	";

}



?>



<?php

}

else

{

				

				if(isset($cat))

				{

					$website->ms_i($cat);

					$arrCategory = $database->DataArray("lm_categories","id=".$cat);

				

					echo "<br><b>".$arrCategory["name_en"].":</b><br><br><br>";

				

					$linksTable = $database->DataTable("linksmanager","WHERE cat=".$cat." ORDER BY rank DESC");

					

					$iCounter = 0;

					

					while($arrLink = $database->fetch_array($linksTable))

								{

									

									$iCounter++;

								

									if(startsWith($link_url,"http://"))

									{

										$link_url=$arrLink["url"];

									}

									else

									{

										$link_url="http://".$arrLink["url"];

									}

									echo $iCounter.") <a href=\"".$link_url."\" target=_blank><b>".$arrLink["title"]."</b></a> (".str_replace("</p>","",str_replace("<br>","",str_replace("<p>","",$arrLink["short_description"]))).")

									<br>

									<center><hr width=100%></center>

								

									".str_replace("<br>","",str_replace("</p>","",str_replace("<p>","",$arrLink["long_description"])))."

									<br><br><br>

									";

								}

					

					echo "<a href=\"index.php?mod=links\">Back to Categories</a>";

					

				}

				else

				{

				

					echo "<br><br>";

					

					$tableCategories = $database->DataTable("lm_categories","");

					

					$iCounter = 0;

					

					while($arrCategory = $database->fetch_array($tableCategories))

					{

						$iCounter++;

						

						echo $iCounter.") <b><a href=\"index.php?mod=links&cat=".$arrCategory["id"]."\">".$arrCategory["name_en"]."</a></b>";

						echo "<hr width=100%>";

						

						echo str_replace("</p>","",str_replace("<p>","",$arrCategory["description_en"]));

							

						echo "<br><br><br>";

							

					}

				}

}

?>







