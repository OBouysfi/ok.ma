<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<br><br>

<center>

<?php
$website->ms_i($video_id);

include("../include/video.php");


	$video_file="";
	$video_file_type="";

	foreach($video_types as $c_file_type)
	{
			if(file_exists("../user_videos/".$video_id.".".$c_file_type[1]))
			{
					$video_file="../user_videos/".$video_id.".".$c_file_type[1];
			}
	}


	if($video_file!="")
	{
 		echo "<script>ShowVideo('".$video_file_type."','".$video_file."',320,240,'center');</script>";
	}
	
	
?>

</center>
<br><br>
