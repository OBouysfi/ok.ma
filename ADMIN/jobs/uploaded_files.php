<?php
// Jobs Portal All Rights Reserved
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
			"users",
			"jobseekers",
			$M_JOBSEEKERS,
			"",
			
			"yellow"
		 );
?>
</div>
<div class="clear"></div>

<h3>
	<?php echo $M_LIST_UPLOADED_FILES;?>
</h3>

<?php

if(isset($_REQUEST["Delete"])&&isset($_REQUEST["CheckList"])&&sizeof($_REQUEST["CheckList"])>0)
{
	$website->ms_ia($_REQUEST["CheckList"]);
	$database->SQLDelete("files","file_id",$_REQUEST["CheckList"]);
	
	if(!$USER_FILES_IN_DB)
	{
		foreach($_REQUEST["CheckList"] as $CheckID)
		{
			foreach($file_types as $c_file_type)
			{	
				
				if(file_exists("../user_files/".$CheckID.".".$c_file_type[1]))
				{
					
					unlink("../user_files/".$CheckID.".".$c_file_type[1]);
					break;
				}
			}
		}
	}
}
?>


			
		<?php
		
		
$ORDER_QUERY="ORDER BY file_id DESC";	
		
 RenderTable
 (
	"files",
	array("JobFileType","user","file_date","file_size","file_name","description","is_resume"),
	array($M_DOWNLOAD,$M_JOBSEEKER,$DATE_MESSAGE,$SIZE,$NOM,$DESCRIPTION,$M_CV),
	"100%",
	"",
	$EFFACER,
	"file_id",
	"index.php?category=$category&action=$action"
);
		

?>
