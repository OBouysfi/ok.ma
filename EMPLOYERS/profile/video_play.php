<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="fright">

	<?php
		
	echo LinkTile
		 (
			"profile",
			"video",
			$M_GO_BACK,
			"",
			"red"
		 );
	
	?>

</div>
<div class="clear"></div>
<br/><br/>
<center>

<?php
if($arrUser["video_id"]=="") die("");


$video_id=$arrUser["video_id"];
$video_id=str_replace("http://www.youtube.com/watch?v=","",$video_id);
$video_id=str_replace("https://www.youtube.com/watch?v=","",$video_id);
$video_id=str_replace("http://youtu.be/","",$video_id);
$video_id=str_replace("https://youtu.be/","",$video_id);
?>
<iframe width="560" height="315" src="http://www.youtube.com/embed/<?php echo $video_id;?>" frameborder="0" allowfullscreen></iframe>



</center>
<br/>
